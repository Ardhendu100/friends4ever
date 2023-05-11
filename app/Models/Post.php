<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'user_id'];

    public function user()
    {
        return $this->belongsTo((User::class));
    }
    public function comment()
    {
        return $this->hasMany(Comments::class);
    }
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public static function boot()
    {
        parent::boot();
        static::saving(function ($post) {
            $post->title = request('title');
            $post->description = request('description');
            $post->user_id = Auth::user()->id;
        });
        static::saved(function ($post) {
            $image = new Image();
            $image->image = request('image')->store('allImages');
            $post->images()->save($image);
        });
    }
}
