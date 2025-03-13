<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NovaAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('email', 'admin@evm.com')->exists()) {
            $user=User::create(
                [
                    'email' => 'admin@evm.com',
                    'name' => 'Admin User',
                    'password' => Hash::make('admin@evm.com'),
                ]
            );
            $user->assignRole('admin');
        }
    }
}
