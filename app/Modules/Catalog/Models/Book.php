<?php

namespace Modules\Catalog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Author;

class Book extends Model
{
    protected $table = 'books';

    public function scopeSearch($query, $keyword)
{
    return $query->where(function ($q) use ($keyword) {
        $q->where('title', 'like', "%{$keyword}%")
          ->orWhere('isbn', 'like', "%{$keyword}%");
    });
}

public function scopeInCategory($query, $categoryId)
{
    return $query->whereHas('categories', function ($q) use ($categoryId) {
        $q->where('categories.id', $categoryId);
    });
}

    public function author(): BelongsTo
{
    return $this->belongsTo(Author::class);
}

    public function scopeAvailable($query)
{
    return $query->where('stock', '>', 0);
}

    public function scopeWithRelations($query)
    {
    return $query->with([
        'author',
        'publisher',
        'categories'
    ]);
    }

    protected $fillable = [
        'title',
        'isbn',
        'publication_year',
        'price',
        'stock',
        'author_id',
        'publisher_id'
    ];

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)
            ->withPivot('added_at');
    }
}