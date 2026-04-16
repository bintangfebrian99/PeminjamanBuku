<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'status',
        'expected_return_date',
        'expected_return_time',
        'borrowed_at',
        'returned_at',
    ];

    protected function casts(): array
    {
        return [
            'borrowed_at' => 'datetime',
            'returned_at' => 'datetime',
            'expected_return_date' => 'date',
            'expected_return_time' => 'datetime:H:i',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
