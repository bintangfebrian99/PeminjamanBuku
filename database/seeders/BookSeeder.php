<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Seed the books table with sample data.
     */
    public function run(): void
    {
        $books = [
            [
                'judul' => 'Laskar Pelangi',
                'penulis' => 'Andrea Hirata',
                'penerbit' => 'Bentang Pustaka',
                'tahun_penerbit' => 2005,
                'deskripsi' => 'Novel inspiratif tentang perjuangan anak-anak Belitung.',
                'stok' => 5,
                'cover_image' => 'images/KELUARGA.webp',
            ],
            [
                'judul' => 'Atomic Habits',
                'penulis' => 'James Clear',
                'penerbit' => 'Penguin Random House',
                'tahun_penerbit' => 2018,
                'deskripsi' => 'Buku pengembangan kebiasaan kecil yang berdampak besar.',
                'stok' => 3,
                'cover_image' => 'images/joko.webp',
            ],
            [
                'judul' => 'Bumi Manusia',
                'penulis' => 'Pramoedya Ananta Toer',
                'penerbit' => 'Lentera Dipantara',
                'tahun_penerbit' => 1980,
                'deskripsi' => 'Novel sejarah tentang Minke dan pergulatan pada masa kolonial.',
                'stok' => 4,
                'cover_image' => 'images/NOVEL.webp',
            ],
            [
                'judul' => 'Negeri 5 Menara',
                'penulis' => 'Ahmad Fuadi',
                'penerbit' => 'Gramedia Pustaka Utama',
                'tahun_penerbit' => 2009,
                'deskripsi' => 'Kisah persahabatan dan mimpi besar para santri dari berbagai daerah.',
                'stok' => 6,
                'cover_image' => 'images/KELUARGA.webp',
            ],
            [
                'judul' => 'Filosofi Teras',
                'penulis' => 'Henry Manampiring',
                'penerbit' => 'Kompas',
                'tahun_penerbit' => 2018,
                'deskripsi' => 'Pengenalan stoisisme untuk menghadapi tekanan hidup sehari-hari.',
                'stok' => 7,
                'cover_image' => 'images/joko.webp',
            ],
            [
                'judul' => 'Pulang',
                'penulis' => 'Tere Liye',
                'penerbit' => 'Republika Penerbit',
                'tahun_penerbit' => 2015,
                'deskripsi' => 'Novel petualangan tentang keluarga, kehormatan, dan perjalanan hidup.',
                'stok' => 5,
                'cover_image' => 'images/NOVEL.webp',
            ],
        ];

        foreach ($books as $book) {
            Book::query()->updateOrCreate(
                ['judul' => $book['judul']],
                $book
            );
        }

        Book::factory(5)->create();
    }
}
