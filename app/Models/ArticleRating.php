<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleRating extends Model
{
    protected $table = 'article_ratings';
    
    protected $fillable = [
        'article_id',
        'user_id',
        'rating',
        'comment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }  
}
