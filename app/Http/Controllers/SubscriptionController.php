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
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    /**
     * Subscription Validate array
     *
     * @var array
     */
    public $rules = [
        'title' => 'required',
        'duration' => 'required',
    ];

    /**
     * Show Subscription Info
     *
     * @param $id
     * @return $this
     */
    public function index($id)
    {
        $Subscription = Subscription::find($id);
        if (!$Subscription) {
            Log::create([
                'user_id' => Auth::user()->id,
                'text' => 'Show subscription info by id="' . $id . '"',
                'type' => 'read',
                'status' => 'failed',
            ]);
            abort(404);
        }
        Log::create([
            'user_id' => Auth::user()->id,
            'text' => 'Show subscription info by id="' . $id . '"',
            'type' => 'read',
            'status' => 'success',
        ]);
        $Statistics = Statistics::orderBy('created_at', 'desc')
            ->where('user_id', Auth::user()->id)
            ->where('event_type', 'view')
            ->where('item_type', 'subscriptions')
            ->where('item_id', $id)
            ->first();
        if (!$Statistics || strtotime($Statistics->created_at) + 86400 <= time()) {
            Statistics::create([
                'user_id' => Auth::user()->id,
                'event_type' => 'view',
                'item_type' => 'subscriptions',
                'item_id' => $id,
            ]);
        }
        return view('subscriptions.index')
            ->with(['Subscription' => $Subscription]);
    }

    /**
     * Create subscription action
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
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

            Log::create([
                'user_id' => Auth::user()->id,
                'text' => 'Create subscription, id="' . $result['Subscription']->id . '"',
                'type' => 'create',
                'status' => 'success',
            ]);
            return redirect('subscriptions/view/' . $result['Subscription']->id)
                ->with('success_message', 'Subscription has been created.');
        }
        $Categories = Category::all();
        return view('subscriptions.create')
            ->with(['Categories' => $Categories]);
    }

    /**
     * Update Subscription action
     *
     * @param $id
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $Subscription = Subscription::find($id);
        if (!$Subscription) {
            Log::create([
                'user_id' => Auth::user()->id,
                'text' => 'Update subscription, id="' . $result['Subscription']->id . '"',
                'type' => 'update',
                'status' => 'failed',
            ]);
            abort(404);
        }

        if ($request->isMethod('post') && $Subscription) {
            $result = $this->saveSubscription($request, $Subscription);

            if (!$result['status']) {
                return redirect('subscriptions/update/' . $Subscription->id)
                    ->with(['Subscription' => $Subscription])
                    ->withInput()
                    ->withErrors($result['validator']);
            }

            Log::create([
                'user_id' => Auth::user()->id,
                'text' => 'Update subscription, id="' . $result['Subscription']->id . '"',
                'type' => 'update',
                'status' => 'success',
            ]);
            return redirect('subscriptions')
                ->with('success_message', 'Subscription has been updated.');
        }

        return view('subscriptions.update')
            ->with(['Subscription' => $Subscription, 'Categories' => Category::all()]);
    }

    /**
     * Delete subscription action
     *
     * @param $id
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        try {
            $Subscription = Subscription::find($id);
            $Subscription->delete();
        } catch (\Exception $e) {
            return $e;
        }
        Log::create([
            'user_id' => Auth::user()->id,
            'text' => 'Delete subscription, id="' . $id . '"',
            'type' => 'delete',
            'status' => 'success',
        ]);
        return redirect('subscriptions')
            ->with('success_message', 'Subscription has been deleted.');
    }

    /**
     * Show Subscription List view
     *
     * @return $this
     */
    public function subscriptionList()
    {
        return view('subscriptions.list')
            ->with(['Subscriptions' => Subscription::paginate()]);
    }

    /**
     * Save Subscription action
     *
     * @param Request $request
     * @param Subscription|null $Subscription
     * @return array|\Exception
     */
    public function saveSubscription(Request $request, Subscription $Subscription = null)
    {
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            return ['status' => false, 'validator' => $validator];
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

        return ['status' => true, 'Subscription' => $Subscription];
    }
}