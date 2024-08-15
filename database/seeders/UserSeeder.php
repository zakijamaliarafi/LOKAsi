<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'address' => 'Head Office',
            'phone' => '081234567890',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        $coordinator = User::create([
            'name' => 'Coordinator',
            'email' => 'coordinator@gmail.com',
            'address' => 'Head Office',
            'phone' => '081234567890',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
        ]);
        $coordinator->assignRole('coordinator');

        $curator = User::create([
            'name' => 'Curator A',
            'email' => 'curatora@gmail.com',
            'address' => 'Pabuaran, Purwokerto Utara',
            'phone' => '081234567890',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
        ]);
        $curator->assignRole('curator');

        User::factory()->count(5)->create()->each(function ($user) {
            $user->assignRole('contributor');
        });

        $user = User::create([
            'name' => 'Zaki Jamali Arafi',
            'email' => 'zakijamaliarafi@gmail.com',
            'address' => 'Desa Melung RT 02 RW 02',
            'phone' => '081234567890',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
        ]);
        $user->assignRole('user');

        $curator = User::create([
            'name' => 'Curator B',
            'email' => 'curatorb@gmail.com',
            'address' => 'Pabuaran, Purwokerto Utara',
            'phone' => '081234567890',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
        ]);
        $curator->assignRole('curator');

        $curator = User::create([
            'name' => 'Curator C',
            'email' => 'curatorc@gmail.com',
            'address' => 'Pabuaran, Purwokerto Utara',
            'phone' => '081234567890',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
        ]);
        $curator->assignRole('curator');

        $curator = User::create([
            'name' => 'Curator D',
            'email' => 'curatord@gmail.com',
            'address' => 'Pabuaran, Purwokerto Utara',
            'phone' => '081234567890',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
        ]);
        $curator->assignRole('curator');

        $curator = User::create([
            'name' => 'Curator E',
            'email' => 'curatore@gmail.com',
            'address' => 'Pabuaran, Purwokerto Utara',
            'phone' => '081234567890',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
        ]);
        $curator->assignRole('curator');
    }
}
