<?php

namespace Database\Seeders;

use App\Enums\InvitationGroupType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@kaddah.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('123456789'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]
        );

        $groupTypes = InvitationGroupType::cases();
        for ($i = 0; $i < 8; $i++) {
            User::factory()->create([
                'group_type' => $groupTypes[array_rand($groupTypes)],
            ]);
        }
    }
}
