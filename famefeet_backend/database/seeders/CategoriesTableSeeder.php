<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Celebrity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Factories\CategoryFactory;
use Config;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

         $categories = [
            [
                'text' => 'Arab',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => ' Ass',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Asian',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Adult',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'African',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Big Butt',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => ' Bikini',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => ' Bulge',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Bisexual',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Brazilian Boots',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Babysitter',
                //'category_type' => Config::get('famefeet.category_type.new'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'In Bed',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'file_path' => 'storage/static/categories/inBed.jpeg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Big Boobs',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Blonde',
                //'category_type' => Config::get('famefeet.category_type.new'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'College',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Chubby Feet',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Cougar',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Cheerleader',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Czech',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Cowgirl',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Cowboy',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Domination',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Dirty',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'file_path' => 'storage/static/categories/Dirty.jpeg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Dildo',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Daddy',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Dancer',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Exotic',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Ebony',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'file_path' => 'storage/static/categories/Ebony.jpeg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Easy',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'European',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Father',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'French',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Fun',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Flexible',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Football',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Fingers',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Gay',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Gym',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Gymnast',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Hunk',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Husband',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Horny',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'High Heels',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'file_path' => 'storage/static/categories/heighheels.jpeg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Holiday',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Hispanic',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Italian',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Indian',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Ice Cream',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Interracial',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Japanese',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Korean',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => ' Kinky',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'text' => 'Lingerie',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Lick',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Lesbian',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Lipstick',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Latino',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Latex',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Long toes',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Large feet',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],


            [
                'text' => 'Mature',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Maid',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Mask',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Mexican',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Mommy',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'MILF',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Muscle',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Oil',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Older',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Outside',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Pedicure',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Princess',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Portuguese',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Porn Star',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Pool',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Panties',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'text' => 'Redhead',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Russian',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Romantic',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Rubber',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Swedish',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Student',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Stripping',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Stockings',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Skirt',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Shorts',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'text' => 'Shemale',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Show face',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Sole',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'file_path' => 'storage/static/categories/sole.jpeg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Tall',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Teacher',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Tean',
              // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Transsexual',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'text' => 'Twerking',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'text' => 'Workout',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'text' => 'Virgin',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'United Kingdom',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Underwear',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'University',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Lotion',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'file_path' => 'storage/static/categories/lotion.jpeg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Socks',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'file_path' => 'storage/static/categories/socks.jpeg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Arched',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'file_path' => 'storage/static/categories/Arched.jpeg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Sandals',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'file_path' => 'storage/static/categories/sandals.jpeg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Tattoo',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'file_path' => 'storage/static/categories/Tattoo.jpeg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Couples',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'file_path' => 'storage/static/categories/couples.jpeg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Nailpolish',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'file_path' => 'storage/static/categories/Nailpolish.jpeg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'text' => 'Male',
                // 'category_type' => Config::get('famefeet.category_type.old'),
                'file_path' => 'storage/static/categories/male.jpeg',
                'created_at' => now(),
                'updated_at' => now()
            ],

         ];
        //Cattegories Table seeds
        foreach ($categories as $key => $value) {
            Category::create($value);
        }
    }
}
