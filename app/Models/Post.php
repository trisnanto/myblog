<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    //
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = ['title', 'author_id', 'category_id', 'slug', 'body'];
    protected $with = ['author', 'category'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        // if (request('keywords')) {
        //     $query->where('title', 'like', '%' . request('keywords') . '%');
        // }
        $query->when($filters['keywords'] ?? false, function ($query, $keywords) {
            return $query->where('title', 'like', '%' . $keywords . '%');
        });

        $query->when($filters['category'] ?? false, function ($query, $category) {
            return $query->whereHas('category', fn (Builder $query) => $query->where('slug', $category));
        });

        $query->when($filters['author'] ?? false, function ($query, $author) {
            return $query->whereHas('author', fn (Builder $query) => $query->where('username', $author));
        });
    }
}
