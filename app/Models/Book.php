<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'isbn',
        'publication_year',
        'price',
        'stock',
        'author_id'
        
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
    public function scopeAvailable($query)
{
    return $query->where('stock', '>', 0);
}

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
}