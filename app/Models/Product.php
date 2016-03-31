<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Product extends Model
{

    /**
     * Define the table
     * @var string
     */
    protected $table = 'products';

    /**
     * Guarded fields
     * @var array
     */
    protected $guarded = ['id', 'created_at'];

    /**
     * @return int
     */
    public function getViewed()
    {
        return (int)$this->statistics()->where('event_type', 'view')->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statistics()
    {
        return $this->hasMany(Statistics::class, 'item_id')->where('item_type', 'product')->get();
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function category()
    {
        return $this->belongsTo(Category::class)->first();
    }

    public function getCategoryTitle()
    {
        if (!$this->category()) {
            return null;
        }
        return $this->category()->title;
    }

    public function map()
    {
        return Schema::getColumnListing('products');
    }

}
