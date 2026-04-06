<?php

namespace App\Models;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author_id',
        'read_time',
        'summary',
        'content',
        'tags',
        'status',
        'category_id',
        'image',
    ];

    protected $casts = [
        'tags' => 'array', // automatically converts JSON tags to an array
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class,'author_id');
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function scopeFeatured($query)
    {
        return $query->latest()->first();
    }

    public static function statuses()
    {

        return array_column(PostStatus::cases(), 'value');
    }
}
