<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'tahun_penerbit',
        'deskripsi',
        'stok',
        'cover_image',
    ];

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function getCoverUrlAttribute(): ?string
    {
        if (! $this->cover_image) {
            return null;
        }

        $coverImage = ltrim($this->cover_image, '/');

        if (Str::startsWith($coverImage, ['http://', 'https://'])) {
            return $coverImage;
        }

        if (Str::startsWith($coverImage, 'public/')) {
            $coverImage = Str::after($coverImage, 'public/');
        }

        if (file_exists(public_path($coverImage))) {
            return asset($coverImage);
        }

        if (Storage::disk('public')->exists($coverImage)) {
            return Route::has('books.cover')
                ? route('books.cover', $this)
                : Storage::disk('public')->url($coverImage);
        }

        if (Str::startsWith($coverImage, 'storage/')) {
            return asset($coverImage);
        }

        return Route::has('books.cover')
            ? route('books.cover', $this)
            : null;
    }

    public function resolveCoverPath(): ?string
    {
        if (! $this->cover_image) {
            return null;
        }

        $coverImage = ltrim($this->cover_image, '/');

        if (Str::startsWith($coverImage, ['http://', 'https://'])) {
            return null;
        }

        if (Str::startsWith($coverImage, 'public/')) {
            $coverImage = Str::after($coverImage, 'public/');
        }

        if (file_exists(public_path($coverImage))) {
            return public_path($coverImage);
        }

        if (Storage::disk('public')->exists($coverImage)) {
            return Storage::disk('public')->path($coverImage);
        }

        return null;
    }
}
