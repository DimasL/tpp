<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

class Subscription extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subscriptions';

    /**
     * The attributes that are not assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at'];

    /**
     * Send mails for expired subscriptions.
     * status: 0 - unsent subscribe, 1 already has been sent.
     *
     * @return \Exception
     */
    static function remind()
    {
        $UsersSubscriptions = UsersSubscriptions::where('item_type', 'subscriptions')
            ->where('status', 0)
            ->where('finish', '<', date("Y-m-d H:i:s"))
            ->get();

        foreach ($UsersSubscriptions as $UsersSubscription) {
            $email = $UsersSubscription->user->email;
            $Subscription = $UsersSubscription->subscription;
            Mail::send('emails.subscriptionexpired', ['Subscription' => $Subscription], function ($message) use ($email) {
                $message->to($email)->subject('Subscription expired!');
            });
            $UsersSubscription->status = 1;
            try {
                $UsersSubscription->save();
            } catch (\Exception $e) {
                return $e;
            }
        }
    }

    /**
     * Build item url
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getUrl()
    {
        return url('subscriptions/view/' . $this->id);
    }

    /**
     * One-To-Many Relationship Method for accessing the Subscription->usersSubscriptions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function usersSubscriptions()
    {
        return $this->hasMany(UsersSubscriptions::class);
    }

    /**
     * Get schema columns
     *
     * @return mixed
     */
    public function map()
    {
        return Schema::getColumnListing('subscriptions');
    }
}
