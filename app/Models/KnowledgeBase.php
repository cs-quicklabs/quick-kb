<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgeBase extends Model
{
    protected $table = 'knowledge_bases';
    
    protected $fillable = [
        'knowledge_base_name',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }   

    public function theme()
    {
        return $this->hasOne(Theme::class);
    }
}
