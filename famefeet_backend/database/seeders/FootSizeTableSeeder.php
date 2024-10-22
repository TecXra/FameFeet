<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\PseudoTypes\True_;

class FootSizeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //\

        DB::table('feets')->insert([
            'size' => 'US-4',
            'status' => true,
            'gender' => 'female',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('feets')->insert([
            'size' => 'US-5',
            'status' => true,
            'gender' => 'female',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('feets')->insert([
            'size' => 'US-6',
            'status' => true,
            'gender' => 'female',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('feets')->insert([
            'size' => 'US-7',
            'status' => true,
            'gender' => 'female',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('feets')->insert([
            'size' => 'US-8',
            'status' => true,
            'gender' => 'female',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('feets')->insert([
            'size' => 'US-9',
            'status' => true,
            'gender' => 'female',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('feets')->insert([
            'size' => 'US-10',
            'status' => true,
            'gender' => 'female',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('feets')->insert([
            'size' => 'US-11',
            'status' => true,
            'gender' => 'female',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('feets')->insert([
            'size' => 'US-5',
            'status' => true,
            'gender' => 'male',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('feets')->insert([
            'size' => 'US-6',
            'status' => true,
            'gender' => 'male',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('feets')->insert([
            'size' => 'US-7',
            'status' => true,
            'gender' => 'male',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('feets')->insert([
            'size' => 'US-8',
            'status' => true,
            'gender' => 'male',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('feets')->insert([
            'size' => 'US-9',
            'status' => true,
            'gender' => 'male',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('feets')->insert([
            'size' => 'US-10',
            'status' => true,
            'gender' => 'male',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('feets')->insert([
            'size' => 'US-11',
            'status' => true,
            'gender' => 'male',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('feets')->insert([
            'size' => 'US-12',
            'status' => true,
            'gender' => 'male',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('feets')->insert([
            'size' => 'US-13',
            'status' => true,
            'gender' => 'male',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('feets')->insert([
            'size' => 'US-14',
            'status' => true,
            'gender' => 'male',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('feets')->insert([
            'size' => 'US-15',
            'status' => true,
            'gender' => 'male',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
