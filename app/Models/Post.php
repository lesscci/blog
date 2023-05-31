<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'image'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->user_id = Auth::id();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
