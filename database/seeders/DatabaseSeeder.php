<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;
use App\Models\Job;
use App\Models\Tag;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        # Admin
        Admin::create([
            "username"=> "Jaraganaya",
            "email"=> "gavra@gmail.com",
            "password"=> Hash::make("gavra12345"),
            "gender"=> "pria",
            "phone_number"=> "0987654321",
            "born_date"=> "2006-09-19",
            "role"=> "worker",
        ]);
        Admin::create([
            "username"=> "Spacehooman_",
            "email"=> "vitto@gmail.com",
            "password"=> Hash::make("vitto12345"),
            "gender"=> "pria",
            "phone_number"=> "099988887777",
            "born_date"=> "2006-01-28",
            "role"=> "worker",
        ]);
        Admin::create([
            "username"=> "Firdan.Az_",
            "email"=> "firdan@gmail.com",
            "password"=> Hash::make("firdan12345"),
            "gender"=> "pria",
            "phone_number"=> "088877776666",
            "born_date"=> "2006-02-26",
            "role"=> "worker",
        ]);
        Admin::create([
            "username"=> "Ndhf.arq_",
            "email"=> "nadhif@gmail.com",
            "password"=> Hash::make("nadhif12345"),
            "gender"=> "pria",
            "phone_number"=> "077766665555",
            "born_date"=> "2006-03-31",
            "role"=> "worker",
        ]);

        # Company
        Company::create([
            'name' => 'Google',
            'email' => 'google@gmail.com',
            'password' => Hash::make('password'),
            'profile_image' => 'images/company/profile/google.png',
            'field' => 'Teknologi',
            'founding_date' => '2006-03-15',
            'user_type' => 'hrd',
            'location' => 'California, US',
            'description' => 'Google LLC adalah sebuah perusahaan multinasional Amerika Serikat yang berkekhususan pada jasa dan produk Internet.',
            'inside_image' => 'images/company/inside/google.png',
            'outside_image' => 'images/company/outside/google.jpg',
            'employees' => 0,
            'confirmed_status' => 'menunggu',
            'role' => 'company'
        ]);
        Company::create([
            'name' => 'Facebook',
            'email' => 'facebook@gmail.com',
            'password' => Hash::make('password'),
            'profile_image' => 'images/company/profile/facebook.png',
            'field' => 'Teknologi',
            'founding_date' => '2006-03-15',
            'user_type' => 'hrd',
            'location' => 'California, US',
            'description' => 'Facebook Inc. adalah sebuah layanan jejaring sosial berkantor pusat di Menlo Park, California, Amerika Serikat yang diluncurkan pada bulan Februari 2004.',
            'inside_image' => 'images/company/inside/facebook.png',
            'outside_image' => 'images/company/outside/facebook.jpg',
            'employees' => 0,
            'confirmed_status' => 'menunggu',
            'role' => 'company'
        ]);

        # Job
        Job::factory(5)->create();

        # Tag
        Tag::create(['name' => 'Front End']);
        Tag::create(['name' => 'Back End']);
        Tag::create(['name' => 'Full Stack']);
        Tag::create(['name' => 'API']);
        Tag::create(['name' => 'Database']);
        Tag::create(['name' => 'UI/UX Designer']);
        Tag::create(['name' => 'Cyber Sequrity']);
        Tag::create(['name' => 'Marketing']);

        # Job_Tag
        $tag = Tag::all();
        Job::all()->each(function ($job) use ($tag) {
            $job->tags()->attach($tag->random(rand(1,7)));
        });
    }
}
