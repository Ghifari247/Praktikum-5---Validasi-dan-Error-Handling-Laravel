<?php

namespace Modules\Circulation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Membership\Models\Member;

class Borrowing extends Model
{
    use SoftDeletes;

    protected $table = 'borrowings';

    protected $fillable = [
        'member_id',
        'borrowed_at',
        'due_date',
        'status',
        'fine_amount',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_date' => 'date',
        'fine_amount' => 'decimal:2',
    ];

    public function details(): HasMany
    {
        return $this->hasMany(BorrowingDetail::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function scopeWithRelations($query)
    {
        return $query->with(['member', 'details']);
    }
}
