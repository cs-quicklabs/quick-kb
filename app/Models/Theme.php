<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $table = 'themes';
    protected $appends = ['theme'];

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
    public function getThemeAttribute()
    {
        return is_array($this->attributes['theme']) ? $this->attributes['theme'] : json_decode($this->attributes['theme'] ?? '{}', true);
    }

    // Mutator: Ensures theme is always stored as a JSON string
    public function setThemeAttribute($value)
    {
        $this->attributes['theme'] = json_encode($value);
    }
}