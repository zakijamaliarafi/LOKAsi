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
            'password' => bcrypt('12345678'),
        ]);
        $admin->assignRole('admin');

        // $coordinator = User::create([
        //     'name' => 'Coordinator',
        //     'email' => 'coordinator@gmail.com',
        //     'address' => 'Head Office',
        //     'password' => bcrypt('12345678'),
        // ]);
        // $coordinator->assignRole('coordinator');

        // $contributor = User::create([
        //     'name' => 'Contributor',
        //     'email' => 'contributor@gmail.com',
        //     'address' => 'Pabuaran, Purwokerto Utara',
        //     'password' => bcrypt('12345678'),
        // ]);
        // $contributor->assignRole('contributor');

        $user = User::create([
            'name' => 'Zaki Jamali Arafi',
            'email' => 'zakijamaliarafi@gmail.com',
            'address' => 'Desa Melung RT 02 RW 02',
            'password' => bcrypt('12345678'),
        ]);
        $user->assignRole('user');
    }
}
