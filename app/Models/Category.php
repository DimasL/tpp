<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{

    /**
     * The database table used by the model
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are not assignable
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at'];

    /**
     * Get products count
     *
     * @return int
     */
    public function getProductsCount()
    {
        return (int)$this->products()->count();
    }

    /**
     * View children category html
     *
     * @param $Category
     * @return $this
     */
    public function getChildrenHtml($Category)
    {
        return view('categories.template')
            ->with('Category', $Category);
    }

    /**
     * Build item url
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getUrl()
    {
        return url('categories/view/' . $this->id);
    }

    /**
     * Get image action
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getImage()
    {
        if ($this->image && file_exists(public_path() . '/assets/images/categories/' . $this->image)) {
            return url('/assets/images/categories/' . $this->image);
        }
        return url('/assets/images/categories/default.png');
    }

    /**
     * Delete image and subscriptions on deleting category
     *
     * @throws \Exception
     */
    public function delete()
    {
        if ($this->image && file_exists(public_path() . '/assets/images/categories/' . $this->image)) {
            Storage::delete(public_path() . '/assets/images/categories/' . $this->image);
        }
        foreach ($this->usersSubscriptions as $UsersSubscription) {
            try {
                $UsersSubscription->delete();
            } catch (\Exception $e) {
                return $e;
            }
        }
        parent::delete();
    }

    /**
     * One-To-Many Relationship Method for accessing the Category->usersSubscriptions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function usersSubscriptions()
    {
        return $this->hasMany(UsersSubscriptions::class, 'item_id')->where('item_type', 'categories');
    }

    /**
     * One-To-Many Relationship Method for accessing the Category->products
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    /**
     * One-To-One Relationship Method for accessing the Category->parent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

    /**
     * One-To-Many Relationship Method for accessing the Category->children
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_category_id');
    }

    /**
     * Get schema columns
     *
     * @return array
     */
    public function map()
    {
        return Schema::getColumnListing('categories');
    }

}
