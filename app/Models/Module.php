<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Module extends Model
{
    use Searchable;
    
    protected $table = 'modules';
    protected $appends = ['formatted_data'];


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


    /**
     * Searches for modules given a search query.
     * 
     * This function searches for modules based on the provided query string.
     * 
     * @param string $search The search string to search for.
     * @return \Illuminate\Support\Collection The list of modules which match the query.
     */
    public static function searchModules($search)
    {
        return self::search($search)
            ->query(function ($query) {
                $query->with('workspace:id,title,slug')
                    ->where('status', 1)
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
            'link' => route('articles.articles', [$this->workspace->slug ?? null, $this->slug]),
            'parent' => $this->workspace ?? null,
        ];
    }
}
