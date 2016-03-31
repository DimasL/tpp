<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistics extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'statistics';

    /**
     * The attributes that are not assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at'];

    /**
     * One-To-One Relationship Method for accessing the Statistics->user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
