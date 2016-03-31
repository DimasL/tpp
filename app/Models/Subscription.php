<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

class Subscription extends Model
{
    /**
     * Define the table
     * @var string
     */
    protected $table = 'subscriptions';

    /**
     * Guarded fields
     * @var array
     */
    protected $guarded = ['id', 'created_at'];

    /**
     * many-to-many relationship method
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function usersSubscriptions()
    {
        return $this->hasMany(UsersSubscriptions::class);
    }

    static function remindCheck()
    {
        $subscriptionReminder = DB::select('select `time` from subscription_reminder LIMIT 1');
        if (!$subscriptionReminder) {
            DB::insert('insert into subscription_reminder (time) values (?) ', [time()]);
            self::remind();
        } elseif (strtotime($subscriptionReminder[0]->time + 86400) < time()) {
            self::remind();
            DB::update('update subscription_reminder set time = ? where id = ?', [time(), 1]);
        }
    }

    static function remind()
    {
        $UsersSubscriptions = UsersSubscriptions::where('item_type', 'timeline')
            ->where('status', 0)
            ->get();

        foreach ($UsersSubscriptions as $UsersSubscription) {
            $email = $UsersSubscription->user->email;
            $Subscription = $UsersSubscription->subscription;
            Mail::send('emails.subscriptionexpired', ['Subscription' => $Subscription], function ($message) use ($email) {
                $message->to($email)->subject('Product is available!');
            });
            $UsersSubscription->status = 1;
            try {
                $UsersSubscription->save();
            } catch (\Exception $e) {
                return $e;
            }
        }
    }

    public function getUrl()
    {
        return url('subscriptions/view/' . $this->id);
    }

    /**
     * @return mixed
     */
    public function map()
    {
        return Schema::getColumnListing('subscriptions');
    }
}
