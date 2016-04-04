<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class UsersSubscriptions extends Model
{
    /**
     * The database table used by the model
     *
     * @var string
     */
    protected $table = 'users_subscriptions';

    /**
     * The attributes that are not assignable
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at'];

    /**
     * Get UsersSubscriptions status
     *
     * @return bool
     */
    public function status()
    {
        if ($this->item_type !== 'subscriptions' || $this->finish > date('Y-m-d H:i:s')) {
            return true;
        }/* else {
            $Subscriptions = self::where('item_id', $this->item_id)->get();
            foreach($Subscriptions as $Subscription) {
                if ($Subscription->finish > date('Y-m-d H:i:s')) {
                    return true;
                }
            }
        }*/
        return false;
    }

    /**
     * Get UsersSubscriptions status title
     *
     * @return string
     */
    public function getStatusTitle()
    {
        if ($this->status()) {
            return 'active';
        }
        return 'inactive';
    }

    /**
     * Get Subscription item
     *
     * @return mixed
     */
    public function getSubscriptionItem()
    {
        switch ($this->item_type) {
            case 'categories':
                return Category::find($this->item_id);
                break;
            case 'products':
                return Product::find($this->item_id);
                break;
            case 'subscriptions':
                return Subscription::find($this->item_id);
                break;
            default:
                return null;
                break;
        }
    }

    /**
     * One-To-One Relationship Method for accessing the UsersSubscriptions->user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * One-To-One Relationship Method for accessing the UsersSubscriptions->subscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'item_id');
    }

    /**
     * Get schema columns
     *
     * @return mixed
     */
    public function map()
    {
        return Schema::getColumnListing('users_subscriptions');
    }
}
