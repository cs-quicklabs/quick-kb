<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules';

    protected $fillable = [
        'title',
        'slug',
        'description',  
        'workspace_id',
        'order',
        'status',
        'created_by',
        'updated_by'
    ];


    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }
}
