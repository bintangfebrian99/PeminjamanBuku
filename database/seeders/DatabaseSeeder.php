<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'bintangadmin@gmail.com'],
            [
                'name' => 'adminbintang',
                'password' => bcrypt('bintang123'),
                'role' => 'admin',
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'bintanguser@gmail.com'],
            [
                'name' => 'bintanguser',
                'password' => bcrypt('bintang123'),
                'role' => 'user',
            ]
        );

        $this->call(BookSeeder::class);
    }
}
