<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocksSizeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('socks_sizes')->insert([
            'socks_size_name' => '4-6',
            'status' => true,
            'gender' => 'female',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('socks_sizes')->insert([
            'socks_size_name' => '6-8',
            'status' => true,
            'gender' => 'female',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('socks_sizes')->insert([
            'socks_size_name' => '7-9',
            'status' => true,
            'gender' => 'female',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('socks_sizes')->insert([
            'socks_size_name' => '8-10',
            'status' => true,
            'gender' => 'female',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('socks_sizes')->insert([
            'socks_size_name' => '9-11',
            'status' => true,
            'gender' => 'female',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('socks_sizes')->insert([
            'socks_size_name' => 'Small',
            'status' => true,
            'gender' => 'female',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('socks_sizes')->insert([
            'socks_size_name' => 'Medium',
            'status' => true,
            'gender' => 'female',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('socks_sizes')->insert([
            'socks_size_name' => 'Large',
            'status' => true,
            'gender' => 'female',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('socks_sizes')->insert([
            'socks_size_name' => 'X-Large',
            'status' => true,
            'gender' => 'female',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('socks_sizes')->insert([
            'socks_size_name' => 'One size fits most',
            'status' => true,
            'gender' => 'female',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('socks_sizes')->insert([
            'socks_size_name' => '5',
            'status' => true,
            'gender' => 'male',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('socks_sizes')->insert([
            'socks_size_name' => '6-9',
            'status' => true,
            'gender' => 'male',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('socks_sizes')->insert([
            'socks_size_name' => '6-12',
            'status' => true,
            'gender' => 'male',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('socks_sizes')->insert([
            'socks_size_name' => '12-15',
            'status' => true,
            'gender' => 'male',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('socks_sizes')->insert([
            'socks_size_name' => 'Small',
            'status' => true,
            'gender' => 'male',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('socks_sizes')->insert([
            'socks_size_name' => 'Medium',
            'status' => true,
            'gender' => 'male',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('socks_sizes')->insert([
            'socks_size_name' => 'Large',
            'status' => true,
            'gender' => 'male',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('socks_sizes')->insert([
            'socks_size_name' => 'X-Large',
            'status' => true,
            'gender' => 'male',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('socks_sizes')->insert([
            'socks_size_name' => 'One size fits most',
            'status' => true,
            'gender' => 'male',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
