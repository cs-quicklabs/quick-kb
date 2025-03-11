<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $table = 'themes';
    protected $appends = ['theme_data'];

    protected $fillable = [
        'knowledge_base_id',
        'name',
        'theme_type',
        'theme'
    ];

    protected function casts(): array 
    { 
        return [ 
            'theme' => 'array', 
        ]; 
    }

    public function knowledgeBase()
    {
        return $this->belongsTo(KnowledgeBase::class);
    }


    // Accessor: Ensures theme is always an array
    public function getThemeDataAttribute()
    {
        return is_array($this->theme) ? $this->theme : json_decode($this->theme ?? '{}', true);
    }

    // Mutator: Ensures theme is always stored as a JSON string
    public function setThemeAttribute($value)
    {
        $this->attributes['theme'] = json_encode($value);
    }
} 