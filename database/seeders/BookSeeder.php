<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            Book::create(['title' => 'Laskar Pelangi', 'author' => 'Andrea Hirata', 'year' => 2005]);
            Book::create(['title' => 'Bumi Manusia', 'author' => 'Pramoedya Ananta Toer', 'year' => 1980]);
            Book::create(['title' => 'Cantik Itu Luka', 'author' => 'Eka Kurniawan', 'year' => 2002]);
            Book::create(['title' => 'Negeri 5 Menara', 'author' => 'Ahmad Fuadi', 'year' => 2009]);
        }
    }
}
