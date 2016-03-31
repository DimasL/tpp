<?php

namespace App\Providers;

use App\Models\Log;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        /*User listeners*/
        User::updated(function ($user) {
            Log::create([
                'user_id' => Auth::user()->id,
                'text' => 'User info has been updated for id="' . $user->id . '"',
                'type' => 'update',
                'status' => 'success',
            ]);
        });
        User::created(function ($user) {
            Log::create([
                'user_id' => $user->id,
                'text' => 'User with id="' . $user->id . '" has been created.',
                'type' => 'create',
                'status' => 'success',
            ]);
        });
        User::deleted(function ($user) {
            Log::create([
                'user_id' => Auth::user()->id,
                'text' => 'User with id="' . $user->id . '" has been deleted.',
                'type' => 'delete',
                'status' => 'success',
            ]);
        });

        /*Product listeners*/
        Product::updated(function ($product) {
            Log::create([
                'user_id' => Auth::user()->id,
                'text' => 'Product info has been updated for id="' . $product->id . '"',
                'type' => 'update',
                'status' => 'success',
            ]);
        });
        Product::created(function ($product) {
            Log::create([
                'user_id' => Auth::user()->id,
                'text' => 'Product with id="' . $product->id . '" has been created.',
                'type' => 'create',
                'status' => 'success',
            ]);
        });
        Product::deleted(function ($product) {
            Log::create([
                'user_id' => Auth::user()->id,
                'text' => 'Product with id="' . $product->id . '" has been deleted.',
                'type' => 'delete',
                'status' => 'success',
            ]);
        });

        /*Subscription listeners*/
        Subscription::updated(function ($subscription) {
            Log::create([
                'user_id' => Auth::user()->id,
                'text' => 'Subscription info has been updated for id="' . $subscription->id . '"',
                'type' => 'update',
                'status' => 'success',
            ]);
        });
        Subscription::created(function ($subscription) {
            Log::create([
                'user_id' => Auth::user()->id,
                'text' => 'Subscription with id="' . $subscription->id . '" has been created.',
                'type' => 'create',
                'status' => 'success',
            ]);
        });
        Subscription::deleted(function ($subscription) {
            Log::create([
                'user_id' => Auth::user()->id,
                'text' => 'Subscription with id="' . $subscription->id . '" has been deleted.',
                'type' => 'delete',
                'status' => 'success',
            ]);
        });
    }
}
