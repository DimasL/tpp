<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Schema;

class User extends Authenticatable
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Check for subscription
     *
     * @param $id
     * @return bool
     */
    public function isSubscribed($item_type, $id)
    {
        switch ($item_type) {
            case 'timeline':
                $usersSubscriptions = $this->usersSubscriptions()
                    ->where('item_type', $item_type)
                    ->where('subscription_id', $id)
                    ->get();
                foreach ($usersSubscriptions as $usersSubscription) {
                    if (strtotime($usersSubscription->finish) > time()) {
                        return true;
                    }
                }
                return false;
                break;
            default:
                $result = $this->usersSubscriptions()
                    ->where('item_type', $item_type)
                    ->where('item_id', $id)
                    ->get();
                return (bool)$result->count();
        }
    }

    /**
     * Check for expired of subscription
     *
     * @param $id
     * @return bool
     */
    public function isSubsribeEnd($id)
    {
        $usersSubscriptions = $this->usersSubscriptions()
            ->where('subscription_id', $id)
            ->get();
        foreach ($usersSubscriptions as $usersSubscription) {
            if (strtotime($usersSubscription->finish) > time()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check for permissions
     *
     * @param $permission
     * @return bool
     */
    public function isUserCan($permission)
    {
        $permissions = $this->roles->load('permissions')->toArray();
        $permission = explode('|', $permission);
        $permissions = array_map('strtolower', array_unique(array_flatten(array_map(function ($permission) {
            return array_pluck($permission['permissions'], 'slug');
        }, $permissions))));
        return (bool)count(array_intersect($permissions, $permission));
    }

    /**
     * Many-To-Many Relationship Method for accessing the User->roles
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * One-To-Many Relationship Method for accessing the User->logs
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    /**
     * One-To-Many Relationship Method for accessing the User->usersSubscriptions
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
     * @return array
     */
    public function map()
    {
        return Schema::getColumnListing('users');
    }
}
