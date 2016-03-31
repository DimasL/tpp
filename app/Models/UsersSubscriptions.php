<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersSubscriptions extends Model
{
    /**
     * Define the table
     * @var string
     */
    protected $table = 'users_subscriptions';

    /**
     * Guarded fields
     * @var array
     */
    protected $guarded = ['id', 'created_at'];

    /**
     * many-to-many relationship method.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * many-to-many relationship method.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function status()
    {
        if ($this->item_type !== 'timeline' || $this->finish > date('Y-m-d H:i:s')) {
            return 'active';
        } else {
            $Subscriptions = self::where('subscription_id', $this->subscription_id)->get();
            foreach($Subscriptions as $Subscription) {
                if ($Subscription->finish > date('Y-m-d H:i:s')) {
                    return 'active_other';
                }
            }
        }
        return 'inactive';
    }

    public function getSubscriptionItem()
    {
        switch ($this->item_type) {
            case 'categories':
                return Category::find($this->item_id);
                break;
            case 'products':
                return Product::find($this->item_id);
                break;
            default:
                break;
        }
    }

    /**
     * @return mixed
     */
    public function map()
    {
        return Schema::getColumnListing('users_subscriptions');
    }
}
