<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateTabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // $file_n = storage_path('static/state.csv');
		// $file = fopen($file_n, "r");
		// while (($data = fgetcsv($file, 100, ",")) !== FALSE) {
		// 	if (!in_array(null, $data)) {
		// 		$state = new State();
		// 		$state->text = $data[0];
		// 		// $state->postal_code = $data[1];
		// 		// $state->country_id = 1;
		// 		$state->save();
		// 	}
		// }
		// fclose($file);
        $states = [
            [
                "text" => "Alabama",
                "short_name" => "AL",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                "text" => "Alaska",
                "short_name" => "AK",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                "text" => "Arizona",
                "short_name" => "AZ",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Arkansas",
                "short_name" => "AR",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "California",
                "short_name" => "CA",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Colorado",
                "short_name" => "CO",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Connecticut",
                "short_name" => "CT",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Delaware",
                "short_name" => "DE",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "District of Columbia",
                "short_name" => "DC",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Florida",
                "short_name" => "FL",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Georgia",
                "short_name" => "GA",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Hawaii",
                "short_name" => "HI",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Idaho",
                "short_name" => "ID",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Illinois",
                "short_name" => "IL",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Indiana",
                "short_name" => "IN",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Iowa",
                "short_name" => "IA",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Kansas",
                "short_name" => "KS",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Kentucky",
                "short_name" => "KY",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Louisiana",
                "short_name" => "LA",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Maine",
                "short_name" => "ME",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Montana",
                "short_name" => "MT",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Maryland",
                "short_name" => "MD",
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                "text" => "Massachusetts",
                "short_name" => "MA",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Michigan",
                "short_name" => "MI",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Minnesota",
                "short_name" => "MN",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Mississippi",
                "short_name" => "MS",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Missouri",
                "short_name" => "MO",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Nebraska",
                "short_name" => "NE",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Nevada",
                "short_name" => "NV",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "New Hampshire",
                "short_name" => "NH",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "New Jersey",
                "short_name" => "NJ",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "New Mexico",
                "short_name" => "NM",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "New York",
                "short_name" => "NY",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "North Carolina",
                "short_name" => "NC",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "North Dakota",
                "short_name" => "ND",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Ohio",
                "short_name" => "OH",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Oklahoma",
                "short_name" => "OK",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Oregon",
                "short_name" => "OR",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Pennsylvania",
                "short_name" => "PA",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Rhode Island",
                "short_name" => "RI",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "South Carolina",
                "short_name" => "SC",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "South Dakota",
                "short_name" => "SD",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Tennessee",
                "short_name" => "TN",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Texas",
                "short_name" => "TX",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Utah",
                "short_name" => "UT",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Vermont",
                "short_name" => "VT",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Virginia",
                "short_name" => "VA",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Washington",
                "short_name" => "WA",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "West Virginia",
                "short_name" => "WV",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Wisconsin",
                "short_name" => "WI",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "text" => "Wyoming",
                "short_name" => "WY",
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];


        foreach ($states as $key => $value) {
            State::create($value);
        }

    }
}
