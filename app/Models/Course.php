<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'description', 'user_id', 'instructor_name'];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}