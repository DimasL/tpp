<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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
    public function subscriptions()
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
        //
    }

    /**
     * @return mixed
     */
    public function map()
    {
        return Schema::getColumnListing('subscriptions');
    }
}
