<?php

namespace Modules\Membership\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use SoftDeletes;

    protected $table = 'members';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'status',
    ];

    public function borrowings(): HasMany
    {
        return $this->hasMany(
            \Modules\Circulation\Models\Borrowing::class
        );
    }
}