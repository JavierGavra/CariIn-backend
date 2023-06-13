<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;
use App\Models\Job;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
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

        Job::factory(5)->create();
    }
}
