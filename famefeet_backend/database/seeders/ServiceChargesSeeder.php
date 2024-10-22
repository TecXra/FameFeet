<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceChargesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('service_charges')->insert([
            'service_charges' => config('famefeet.percentage_transfer_to_admin'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
