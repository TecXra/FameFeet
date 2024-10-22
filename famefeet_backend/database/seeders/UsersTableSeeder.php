<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
//use Config;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Services\CelebrityService;
use Illuminate\Support\Str;
use Services\FanService;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $celebrity_data_array =[
            [
              // 'id' => 1,
              'username' => 'celebrity12',
              'full_name' => 'Celebrity 12',
              'slug' => createSlug('Celebrity12',1),
              'avatar' => 'storage/static/profileLogo.png',
              'email' => 'celebrity@famefeet.com',
              'email_verified_at' => now(),
              'phone_number' => '0300-1245789',
              'date_of_birth' => Carbon::parse('1995-06-02'),
              'password' => 'secret12',
              'used_referral_code' => '1234',
              'user_type' => Config::get('famefeet.user_type.celebrity'),
              'state' => 'california',
              'zipcode' =>"90001",
              'is_online' => true,
              'account_status'=> config('famefeet.account_status.active'),
            //   'front_id_pic' => '',
            //   'back_id_pic' => '',
            ],
            [
                // 'id' => 1,
                'username' => 'HeatherGrey',
                'full_name' => 'Heather Grey',
                'slug' => createSlug('HeatherGrey',2),
                'avatar' => 'storage/static/avatar-heather-grey.jpg',
                'email' => 'heathergrey@famefeet.com',
                'email_verified_at' => now(),
                'phone_number' => '0300-1245789',
                'date_of_birth' => Carbon::parse('1995-06-02'),
                'password' => 'secret12',
                'used_referral_code' => '1234',
                'user_type' => Config::get('famefeet.user_type.celebrity'),
                'state' => 'california',
                'zipcode' => "35004",
                'is_online' => true,
                'account_status'=> config('famefeet.account_status.active'),
              //   'front_id_pic' => '',
              //   'back_id_pic' => '',
              ],
              [
                // 'id' => 1,
                'username' => 'JasmineJones',
                'full_name' => 'Jasmine Jones',
                'slug' => createSlug('JasmineJones',3),
                'avatar' => 'storage/static/avatar-jasmine-jones.jpg',
                'email' => 'jasminejones@famefeet.com',
                'email_verified_at' => now(),
                'phone_number' => '0300-1245789',
                'date_of_birth' => Carbon::parse('1995-06-02'),
                'password' => 'secret12',
                'used_referral_code' => '1234',
                'user_type' => Config::get('famefeet.user_type.celebrity'),
                'state' => 'california',
                'zipcode' => "99501",
                'is_online' => true,
                'account_status'=> config('famefeet.account_status.active'),
              //   'front_id_pic' => '',
              //   'back_id_pic' => '',
              ],
              [
                // 'id' => 1,
                'username' => 'LehaManesa',
                'full_name' => 'Leha Manesa',
                'slug' => createSlug('JasmineJones',4),
                'avatar' => 'storage/static/avatar-leha-manesa.jpg',
                'email' => 'lehamanesa@famefeet.com',
                'email_verified_at' => now(),
                'phone_number' => '0300-1245789',
                'date_of_birth' => Carbon::parse('1995-06-02'),
                'password' => 'secret12',
                'used_referral_code' => '1234',
                'user_type' => Config::get('famefeet.user_type.celebrity'),
                'state' => 'california',
                'zipcode' => "85001",
                'is_online' => true,
                'account_status'=> config('famefeet.account_status.active'),
              //   'front_id_pic' => '',
              //   'back_id_pic' => '',
              ],
              [
                // 'id' => 1,
                'username' => 'GloriaAgudelo',
                'full_name' => 'Gloria Agudelo',
                'slug' => createSlug('GloriaAgudelo',5),
                'avatar' => 'storage/static/avatar-gloria-agudelo.jpg',
                'email' => 'gloriaagudelo@famefeet.com',
                'email_verified_at' => now(),
                'phone_number' => '0300-1245789',
                'date_of_birth' => Carbon::parse('1995-06-02'),
                'password' => 'secret12',
                'used_referral_code' => '1234',
                'user_type' => Config::get('famefeet.user_type.celebrity'),
                'state' => 'california',
                'zipcode' => "71601",
                'is_online' => true,
                'account_status'=> config('famefeet.account_status.active'),
              //   'front_id_pic' => '',
              //   'back_id_pic' => '',
              ],
              [
                // 'id' => 1,
                'username' => 'EstefaniaVelez',
                'full_name' => 'Estefania Velez',
                'slug' => createSlug('EstefaniaVelez',6),

                'avatar' => 'storage/static/avatar-estefania-velez.jpg',
                'email' => 'estefaniavelez@famefeet.com',
                'email_verified_at' => now(),
                'phone_number' => '0300-1245789',
                'date_of_birth' => Carbon::parse('1995-06-02'),
                'password' => 'secret12',
                'used_referral_code' => '1234',
                'user_type' => Config::get('famefeet.user_type.celebrity'),
                'state' => 'california',
                'zipcode' => "06001",
                'is_online' => true,
                'account_status'=> config('famefeet.account_status.active'),
              //   'front_id_pic' => '',
              //   'back_id_pic' => '',
              ],
              [
                // 'id' => 1,
                'username' => 'JohnSmith',
                'full_name' => 'John Smith',
                'slug' => createSlug('JohnSmith',7),
                'avatar' => 'storage/static/avatar-john-smith.jpg',
                'email' => 'johnsmith@famefeet.com',
                'email_verified_at' => now(),
                'phone_number' => '0300-1245789',
                'date_of_birth' => Carbon::parse('1995-06-02'),
                'password' => 'secret12',
                'used_referral_code' => '1234',
                'user_type' => Config::get('famefeet.user_type.celebrity'),
                'state' => 'california',
                'zipcode' => "19701",
                'is_online' => true,
                'account_status'=> config('famefeet.account_status.active'),
              //   'front_id_pic' => '',
              //   'back_id_pic' => '',
              ],
              [
                // 'id' => 1,
                'username' => 'MaitenPetruf',
                'full_name' => 'Maiten Petruf',
                'slug' => createSlug('MaitenPetruf',8),
                'avatar' => 'storage/static/avatar-maiten-petruf.jpg',
                'email' => 'maitenpetruf@famefeet.com',
                'email_verified_at' => now(),
                'phone_number' => '0300-1245789',
                'date_of_birth' => Carbon::parse('1995-06-02'),
                'password' => 'secret12',
                'used_referral_code' => '1234',
                'user_type' => Config::get('famefeet.user_type.celebrity'),
                'state' => 'california',
                'zipcode' => "32003",
                'is_online' => true,
                'account_status'=> config('famefeet.account_status.active'),
              //   'front_id_pic' => '',
              //   'back_id_pic' => '',
              ],
              [
                // 'id' => 1,
                'username' => 'EliPaty',
                'full_name' => 'Eli Paty',
                'slug' => createSlug('EliPaty',9),
                'avatar' => 'storage/static/avatar-eli-paty.jpg',
                'email' => 'elipaty@famefeet.com',
                'email_verified_at' => now(),
                'phone_number' => '0300-1245789',
                'date_of_birth' => Carbon::parse('1995-06-02'),
                'password' => 'secret12',
                'used_referral_code' => '1234',
                'user_type' => Config::get('famefeet.user_type.celebrity'),
                'state' => 'california',
                'zipcode' => "97001",
                'is_online' => true,
                'account_status'=> config('famefeet.account_status.active'),
              //   'front_id_pic' => '',
              //   'back_id_pic' => '',
              ],
              [
                // 'id' => 1,
                'username' => 'AntonellaLopez',
                'full_name' => 'Antonella Lopez',
                'slug' => createSlug('AntonellaLopez',10),
                'avatar' => 'storage/static/avatar-antonella-lopez.jpg',
                'email' => 'antonellalopez@famefeet.com',
                'email_verified_at' => now(),
                'phone_number' => '0300-1245789',
                'date_of_birth' => Carbon::parse('1995-06-02'),
                'password' => 'secret12',
                'used_referral_code' => '1234',
                'user_type' => Config::get('famefeet.user_type.celebrity'),
                'state' => 'california',
                'zipcode' => "83201",
                'is_online' => true,
                'account_status'=> config('famefeet.account_status.active'),
              //   'front_id_pic' => '',
              //   'back_id_pic' => '',
              ]
        ];

        foreach ($celebrity_data_array as $key => $value) {
            $celebrity = CelebrityService::createCelebrityUser($value);
            $celebrity->used_referral_code = $value['used_referral_code'];
            $celebrity->email_verified_at = $value['email_verified_at'];
            $celebrity->avatar = $value['avatar'];
            $celebrity->slug = $value ['slug'];
            $celebrity->save();

        }


        $fan_data_array = [
            [
                //'id' => 2,
                'username' => 'fan21',
                // 'full_name' => 'fan 21',
                'slug' => createSlug('fan21',11),
                'email' => 'fan@famefeet.com',
                'email_verified_at' => now(),
                'phone_number' => '0300-1245789',
                'date_of_birth' => Carbon::parse('1994-08-03'),
                'password' => 'secret12',
                'used_referral_code' => '1234',
                'user_type' => Config::get('famefeet.user_type.fan'),
                'is_online' => true,
                'account_status'=> config('famefeet.account_status.active'),
            ],
            [
                //'id' => 2,
                'username' => 'alexcarry',
                'slug' => createSlug('alexcarry',12),
                'email' => 'alexcarry@famefeet.com',
                'email_verified_at' => now(),
                'phone_number' => '0300-1245789',
                'date_of_birth' => Carbon::parse('1994-08-03'),
                'password' => 'secret12',
                'used_referral_code' => '1234',
                'user_type' => Config::get('famefeet.user_type.fan'),
                'is_online' => true,
                'account_status'=> config('famefeet.account_status.active'),
            ],
            [
                //'id' => 2,
                'username' => 'john',
                'slug' => createSlug('john',13),
                'email' => 'john@famefeet.com',
                'email_verified_at' => now(),
                'phone_number' => '0300-1245789',
                'date_of_birth' => Carbon::parse('1994-08-03'),
                'password' => 'secret12',
                'used_referral_code' => '1234',
                'user_type' => Config::get('famefeet.user_type.fan'),
                'is_online' => true,
                'account_status'=> config('famefeet.account_status.active'),
            ],


        ];
        foreach ($fan_data_array as $key => $value) {
            $fan = FanService::createFanUser($value);
            $fan->used_referral_code = $value['used_referral_code'];
            $fan->email_verified_at = $value['email_verified_at'];
            $fan->slug = $value['slug'];
            $fan->save();
        }


        DB::table('users')->insert([
            // 'id' => 3,
            'username' => 'Admin34',
            'slug' => createSlug('Admin34',14),
            'email' => 'famefeet.official@gmail.com',
            'phone_number' => '0300-1245789',
            'date_of_birth' => Carbon::parse('1997-08-03'),
            'email_verified_at' => now(),
            'password' => Hash::make('secret12'),
            'referral_code' => Str::random(6),
            'used_referral_code' => '1234',
            'user_type' => Config::get('famefeet.user_type.admin'),
            'is_online' => true,
            'account_status'=> config('famefeet.account_status.active'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}
