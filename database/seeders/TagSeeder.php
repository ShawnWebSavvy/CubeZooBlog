<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::create(['name' => 'Laravel']);
        Tag::create(['name' => 'PHP']);
        Tag::create(['name' => 'JavaScript']);
        Tag::create(['name' => 'Web Development']);
        Tag::create(['name' => 'Testing']);
    }
}
