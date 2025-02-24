<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = [
        'knowledge_base_id',
        'name',
        'theme_type',
        'theme'
    ];


    public function knowledgeBase()
    {
        return $this->belongsTo(KnowledgeBase::class);
    }
} 