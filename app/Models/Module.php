<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Module extends Model
{
    use Searchable;
    
    protected $table = 'modules';

    protected $fillable = [
        'id',
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
    
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy() 
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
