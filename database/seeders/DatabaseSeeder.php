<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        # Company
        Company::create([
            'name' => 'Google',
            'email' => 'google@gmail.com',
            'password' => Hash::make('password'),
            'field' => 'Teknologi',
            'founding_date' => '2006-03-15',
            'user_type' => 'hrd',
            'location' => 'California, US',
            'description' => 'Google LLC adalah sebuah perusahaan multinasional Amerika Serikat yang berkekhususan pada jasa dan produk Internet.',
            'employees' => 0,
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
