<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        \DB::table('posts')->delete();
        \DB::table('post_tag')->delete(); // Clear the pivot table

        $faker = FakerFactory::create();

        $tags = Tag::all(); // Get all available tags

        for ($i = 0; $i < 10; $i++) {
            $post = Post::create([
                'name' => $faker->sentence,
                'description' => $faker->paragraph,
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Attach random tags to the post
            $randomTags = $tags->random(mt_rand(1, 5)); // Attach 1 to 5 random tags
            $post->tags()->attach($randomTags);
        }
    }
}
