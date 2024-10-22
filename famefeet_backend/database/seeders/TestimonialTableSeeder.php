<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestimonialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('testimonials')->insert([
            'name' => 'Alex Carry',
            'avatar' => 'storage/static/avatar-leha-manesa.jpg',
            'rating' => 5,
            'review' => 'This platform is best for content and items buy and sell',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
