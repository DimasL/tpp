<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are not assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at'];

    /**
     * Get count of views
     *
     * @return int
     */
    public function getViewed()
    {
        return (int)$this->statistics()
            ->where('event_type', 'view')
            ->count();
    }

    /**
     * Build item url
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getUrl()
    {
        return url('products/view/' . $this->id);
    }

    /**
     * Get image action
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getImage()
    {
        if ($this->image && file_exists(public_path() . '/assets/images/products/' . $this->image)) {
            return url('/assets/images/products/' . $this->image);
        }
        return url('/assets/images/products/default.png');
    }

    /**
     * Delete image and subscriptions on deleting product
     *
     * @throws \Exception
     */
    public function delete()
    {
        if ($this->image && file_exists(public_path() . '/assets/images/products/' . $this->image)) {
            Storage::delete(public_path() . '/assets/images/products/' . $this->image);
        }
        $UsersSubscriptions = UsersSubscriptions::where('item_type', 'products')
            ->where('item_id', $this->id)
            ->get();
        foreach ($UsersSubscriptions as $UsersSubscription) {
            try {
                $UsersSubscription->delete();
            } catch (\Exception $e) {
                return $e;
            }
        }
        parent::delete();
    }

    /**
     * Get statistics info
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statistics()
    {
        return $this->hasMany(Statistics::class, 'item_id')
            ->where('item_type', 'product')
            ->get();
    }

    /**
     * One-To-One Relationship Method for accessing the Product->category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get schema columns
     *
     * @return array
     */
    public function map()
    {
        return Schema::getColumnListing('products');
    }

}
