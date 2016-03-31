<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Category extends Model
{

    /**
     * Define a table
     * @var string
     */
    protected $table = 'categories';

    /**
     * Define guarded attributes
     * @var array
     */
    protected $guarded = ['id', 'created_at'];

    /**
     * Relation to products
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    /**
     * Get products count
     * @return int
     */
    public function getProductsCount()
    {
        return (int)$this->products()->count();
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_category_id');
    }

    public function getChildrenHtml($Category)
    {
        return view('categories.template')
            ->with('Category', $Category);
    }

    public function map()
    {
        return Schema::getColumnListing('categories');
    }

}
