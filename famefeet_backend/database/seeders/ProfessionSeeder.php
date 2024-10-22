<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('professions')->insert([
            'title' => 'Influencer',
            'status' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('professions')->insert([
            'title' => 'Athlete',
            'status' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('professions')->insert([
            'title' => 'Reality TV',
            'status' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('professions')->insert([
            'title' => 'Model',
            'status' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('professions')->insert([
            'title' => 'Actor/Actress',
            'status' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('professions')->insert([
            'title' => 'Adult Star',
            'status' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('professions')->insert([
            'title' => 'TikTok Personality',
            'status' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
