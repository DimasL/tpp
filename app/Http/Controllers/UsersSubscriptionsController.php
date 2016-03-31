<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\UsersSubscriptions;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class UsersSubscriptionsController extends Controller
{

    /**
     * Show UsersSubscriptions info
     * @param $id
     * @return $this
     */
    public function index($id)
    {
        $UsersSubscription = UsersSubscriptions::find($id);
        return view('mysubscriptions.index')
            ->with(['UsersSubscription' => $UsersSubscription]);
    }

    /**
     * Show Subscription List
     * @return $this
     */
    public function mySubscriptionsList()
    {
        $UsersSubscriptions = Auth::user()
            ->usersSubscriptions()
            ->get();
        return view('mysubscriptions.list')
            ->with(['UsersSubscriptions' => $UsersSubscriptions]);
    }

    public function categorySubscribe($id)
    {
        $Category = Category::find($id);
        if (!$Category) {
            abort(404);
        }
        UsersSubscriptions::create([
            'user_id' => Auth::user()->id,
            'item_type' => 'categories',
            'item_id' => $id,
        ]);
        return back();
    }

    public function categoryUnsubscribe($id)
    {
        $UsersSubscriptions = UsersSubscriptions::where('user_id', Auth::user()->id)
            ->where('item_type', 'categories')
            ->where('item_id', $id)->get();
        if (!$UsersSubscriptions) {
            abort(404);
        }
        foreach ($UsersSubscriptions as $UsersSubscription) {
            try {
                $UsersSubscription->delete();
            } catch (\Exception $e) {
                return $e;
            }
        }
        return back();
    }

    public function productSubscribe($id)
    {
        $Product = Product::find($id);
        if (!$Product) {
            abort(404);
        }
        UsersSubscriptions::create([
            'user_id' => Auth::user()->id,
            'item_type' => 'products',
            'item_id' => $id,
        ]);
        return back();
    }

    public function productUnsubscribe($id)
    {
        $UsersSubscriptions = UsersSubscriptions::where('user_id', Auth::user()->id)
            ->where('item_type', 'products')
            ->where('item_id', $id)->get();
        if (!$UsersSubscriptions) {
            abort(404);
        }
        foreach ($UsersSubscriptions as $UsersSubscription) {
            try {
                $UsersSubscription->delete();
            } catch (\Exception $e) {
                return $e;
            }
        }
        return back();
    }

    public function subscribe($id)
    {
        $Subscription = Subscription::find($id);
        if (!$Subscription) {
            abort(404);
        }
        $currentTime = time();
        $UsersSubscription = UsersSubscriptions::create([
            'user_id' => Auth::user()->id,
            'item_type' => 'timeline',
            'subscription_id' => $id,
            'start' => date('Y-m-d H:i:s', $currentTime),
            'finish' => date('Y-m-d H:i:s', $currentTime + $Subscription->duration * 86400)
        ]);
        return redirect('mysubscriptions/view/' . $UsersSubscription->id);
    }

    public function unsubscribe($id)
    {
//todo:
//        $UsersSubscription = Auth::user()->usersSubscriptions()->where('id', $id)->first();
        $UsersSubscription = UsersSubscriptions::find($id);
        try {
            $UsersSubscription->delete();
        } catch (\Exception $e) {
            return $e;
        }
        return redirect('mysubscriptions');
    }

    public function resume($id)
    {
        $UsersSubscription = UsersSubscriptions::find($id);
        try {
            $UsersSubscription->delete();
        } catch (\Exception $e) {
            return $e;
        }
        return redirect('mysubscriptions');
    }
}
