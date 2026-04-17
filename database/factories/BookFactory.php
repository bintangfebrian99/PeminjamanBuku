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
            'judul' => $this->faker->words(4, true),
            'penulis' => $this->faker->name(),
            'penerbit' => $this->faker->company(),
            'tahun_penerbit' => $this->faker->numberBetween(1980, 2024),
            'deskripsi' => $this->faker->paragraph(),
            'stok' => $this->faker->numberBetween(1, 10),
            'cover_image' => $this->faker->randomElement($coverImages),
        ];
    }
}
