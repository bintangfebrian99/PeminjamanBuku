<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Book::class;

    public function definition(): array
    {
        $coverImages = [
            'images/joko.webp',
            'images/KELUARGA.webp',
            'images/NOVEL.webp',
        ];

        return [
            'judul' => fake()->words(4, true),
            'penulis' => fake()->name(),
            'penerbit' => fake()->company(),
            'tahun_penerbit' => fake()->year('1980', '2024'),
            'deskripsi' => fake()->paragraph(),
            'stok' => fake()->numberBetween(1, 10),
            'cover_image' => fake()->randomElement($coverImages),
        ];
    }
}
