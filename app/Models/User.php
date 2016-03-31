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
     * Many-To-Many Relationship Method for accessing the User->roles
     *
     * @return QueryBuilder Object
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    /**
     * many-to-many relationship method
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function usersSubscriptions()
    {
        return $this->hasMany(UsersSubscriptions::class);
    }

    /**
     * @return mixed
     */
    public function map()
    {
        return Schema::getColumnListing('users');
    }

    /**
     * Check for subscription
     * @param $id
     * @return bool
     */
    public function subscribed($item_type, $id)
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
}
