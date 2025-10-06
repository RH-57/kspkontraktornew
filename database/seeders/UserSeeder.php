<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('email', 'kukuhandriansah10@gmail.com')->exists()) {
            User::create([
                'name' => 'Kukuh Andriansah',
                'email' => 'kukuhandriansah10@gmail.com',
                'password' => Hash::make('Sartimah26.'), // Ganti sesuai keinginan
                'role' => 'superadmin', // Jika tabel user kamu punya kolom 'role'
            ]);
        }
    }
}
