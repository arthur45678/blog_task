<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'News',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Health',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Electronics',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Computers',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Travels',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

       Tag::insert($data);

    }
}
