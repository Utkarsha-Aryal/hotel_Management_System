<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('site_settings')->insert([
            'name' => 'Hotel',
            'email' => 'Hotel@gmail.com',
            'phone_number' => '9800000000',
            'address' => 'Kathmandu',
            'link_facebook' => 'https://www.facebook.com/',
            'link_instagram' => 'https://www.instagram.com/',
            'link_twitter' => 'https://www.twitter.com/',
            'link_map' => null,
            'img_logo' => null,
            'img_favicon' => null,
            'created_at' => Carbon::now()
        ]);
    }
}
