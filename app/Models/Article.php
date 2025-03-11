<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    
    protected $table = 'articles';

    protected $fillable = [
        'id',
        'title',
        'content',
        'slug',
        'status',
        'module_id',
        'order',
        'created_by',
        'updated_by'
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
