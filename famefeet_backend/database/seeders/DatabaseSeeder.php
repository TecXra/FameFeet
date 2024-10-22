<?php
namespace Database\Seeders;

use App\Models\Profession;
use App\Models\ServiceCharges;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
                UsersTableSeeder::class,
                CategoriesTableSeeder::class,
                FootSizeTableSeeder::class,
                ProfessionSeeder::class,
                SocksSizeTableSeeder::class,
                ServiceChargesSeeder::class,
                StateTabelSeeder::class,
                TestimonialTableSeeder::class,
        ]);

    }
}
