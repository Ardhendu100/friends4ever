<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title','description','user_id','category_id'];

    public function user(){
        return $this->belongsTo((User::class));
    }
    public function comment(){
        return $this->hasMany(Comments::class);
    }
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
