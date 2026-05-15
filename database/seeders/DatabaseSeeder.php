<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * IMPORTANT : Changez les identifiants admin avant de lancer en production !
     */
    public function run(): void
    {
        // Compte Administrateur par défaut
        User::firstOrCreate(
            ['email' => 'admin@opendoor.ma'],
            [
                'name'      => 'Admin OpenDoor',
                'password'  => Hash::make('Admin@OpenDoor2026!'),
                'is_admin'  => 1,
                'is_active' => 1,
            ]
        );
    }
}
