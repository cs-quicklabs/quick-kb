<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Workspace extends Model
{
    use Searchable;

    protected $table = 'workspaces';
    protected $appends = ['formatted_data'];

    protected $fillable = [
        'id',
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


    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }


    public static function searchWorkspaces($search)
    {
        return self::search($search)
            ->query(function ($query) {
                $query->where('status', 1)
                    ->orderBy('order', 'asc');
            })
            ->get();
    }


    public function getFormattedDataAttribute()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'shortTitle' => getShortTitle($this->title, 50, '...'),
            'link' => route('modules.modules', [$this->slug]),
            'parent' => null
        ];
    }
}
