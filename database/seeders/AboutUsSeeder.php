<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('about_us')->insert([
            'introduction' => 'Smart School is a registered and authorized manpower agency in Nepal for foreign employment services.',
            'img_introduction' => '',
            'founder_name' => 'Ram Bahadur',
            'founder_message' => 'Smart School is a registered and authorized manpower agency in Nepal for foreign employment services.',
            'founder_image' => '',
            'awards_number' => '33',
            'teacher_number' => '33',
            'scholarship_number' => '33',
            'student_number_each_year' => '33',
            'vision' => 'vision',
            'mission' => 'mission',
            'video_title' => 'video',
            'video_url' => 'this is video url',
            'created_at' => Carbon::now()
        ]);
    }
}
