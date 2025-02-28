<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    protected $table = 'workspaces';

    protected $fillable = [
        'title',
        'description',
        'slug',
        'order',
        'status',
        'created_by',
        'updated_by'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function modules()   
    {
        return $this->hasMany(Module::class);
    }
}
