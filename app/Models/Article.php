<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Carbon\Carbon;

class Article extends Model
{
    use Searchable;
    
    protected $table = 'articles';

    protected $appends = ['formatted_data', 'archived_at', 'created_at', 'clean_content'];

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


    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
        ];
    }


    public static function searchArticles($search)
    {
        return self::search($search)
            ->query(function ($query) {
                $query->with('module.workspace:id,title,slug')
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
            'description' => $this->content,
            'shortTitle' => getShortTitle($this->title, 50, '...'),
            //'link' => route('articles.articles', [$this->workspace->slug ?? null, $this->slug]),
            'link' => route('articles.articleDetails', [$this->module->workspace->slug ?? null, $this->module->slug ?? null, $this->slug]),
            'parent' => $this->module->workspace ?? null,
        ];
    }


    public function getArchivedAtAttribute()
    {
        if ($this->status == 0) {
            return Carbon::parse($this->updated_at)->format('F d, Y');
        } else {
            return $this->updated_at;
        }
    }


    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('F d, Y');
    }


    public function getCleanContentAttribute()
    {
        return getCleanContent($this->attributes['content']);
    }
    
}
