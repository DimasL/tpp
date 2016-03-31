<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Log;
use App\Models\Statistics;
use App\Models\Subscription;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    /**
     * Subscription Validate array
     * @var array
     */
    public $rules = [
        'title' => 'required',
        'duration' => 'required',
    ];

    /**
     * Show Subscription Info
     * @param $id
     * @return $this
     */
    public function index($id)
    {
        $Subscription = Subscription::find($id);
        if(!$Subscription) {
            abort(404);
        }
        $status = $Subscription ? 'sucess' : 'fail';
        Log::create([
            'user_id' => Auth::user()->id,
            'text' => 'Show pruduct info by id="' . $id . '"',
            'type' => 'read',
            'status' => $status,
        ]);
        $Statistics = Statistics::orderBy('created_at', 'desc')
            ->where('user_id', Auth::user()->id)
            ->where('event_type', 'view')
            ->where('item_type', 'subscription')
            ->where('item_id', $id)
            ->first();
        if (!$Statistics || strtotime($Statistics->created_at) + 86400 <= time()) {
            Statistics::create([
                'user_id' => Auth::user()->id,
                'event_type' => 'view',
                'item_type' => 'subscription',
                'item_id' => $id,
            ]);
        }
        return view('subscriptions.index')
            ->with(['Subscription' => $Subscription]);
    }

    /**
     * Create subscription
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $result = $this->saveSubscription($request);

            if (!$result['status']) {
                return redirect('subscriptions/create')
                    ->withInput()
                    ->withErrors($result['validator']);
            }

            return redirect('subscriptions/view/' . $result['Subscription']->id)
                ->with('success_message', 'Subscription has been created.');
        }
        $Categories = Category::all();
        return view('subscriptions.create')
            ->with(['Categories' => $Categories]);
    }

    /**
     * Update Subscription Action
     * @param $id
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $Subscription = Subscription::find($id);
        if(!$Subscription) {
            abort(404);
        }
        $Categories = Category::all();

        if ($request->isMethod('post') && $Subscription) {
            $result = $this->saveSubscription($request, $Subscription);

            if (!$result['status']) {
                return redirect('subscriptions/update/' . $Subscription->id)
                    ->with(['Subscription' => $Subscription])
                    ->withInput()
                    ->withErrors($result['validator']);
            }

            return redirect('subscriptions')
                ->with('success_message', 'Subscription has been updated.');
        }

        return view('subscriptions.update')
            ->with(['Subscription' => $Subscription, 'Categories' => $Categories]);
    }

    /**
     * Show Subscription Info
     * @param $id
     * @return $this
     */
    public function delete($id)
    {
        $Subscription = Subscription::find($id);
        try {
            $Subscription->delete();
        } catch (\Exception $e) {
            return $e;
        }
        return redirect('subscriptions')
            ->with('success_message', 'Subscription has been deleted.');
    }

    /**
     * Show Subscription List
     * @return $this
     */
    public function subscriptionList()
    {
        $Subscriptions = Subscription::all();
        return view('subscriptions.list')
            ->with(['Subscriptions' => $Subscriptions]);
    }

    /**
     * Save Subscription
     * @param Request $request
     * @param Subscription|null $Subscription
     * @return Subscription
     */
    public function saveSubscription(Request $request, Subscription $Subscription = null)
    {
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            return [
                'status' => false,
                'validator' => $validator,
            ];
        }

        if (!$Subscription) {
            $Subscription = Subscription::create();
        }

        foreach ($request->all() as $key => $value) {
            if (in_array($key, $Subscription->map())) {
                $Subscription->{$key} = $value;
            }
        }

        try {
            $Subscription->save();
        } catch (\Exception $e) {
            return $e;
        }

        return [
            'status' => true,
            'Subscription' => $Subscription
        ];
    }
}
