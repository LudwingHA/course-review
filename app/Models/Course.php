<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'instructor_name',
        'user_id',
        'category',
        'image',
        'tags',
        'content_table',
        'youtube_urls',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'date',
    ];

    // 🔹 Relación con el instructor
    public function instructor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 🔹 Accesor para tags en array
    public function getTagsArrayAttribute()
    {
        return $this->tags ? explode(',', $this->tags) : [];
    }

    // 🔹 Accesor para URLs de YouTube en array
    public function getYoutubeUrlsArrayAttribute()
    {
        return $this->youtube_urls ? explode(',', $this->youtube_urls) : [];
    }

    // 🔹 Helper para fecha formateada
    public function getPublishedAtFormattedAttribute()
    {
        return $this->published_at
            ? Carbon::parse($this->published_at)->format('d M Y')
            : 'Sin publicar';
    }
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function getRouteKeyName()
{
    return 'slug';
}

}
