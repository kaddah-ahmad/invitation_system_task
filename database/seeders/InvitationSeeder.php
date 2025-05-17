<?php

namespace Database\Seeders;

use App\Enums\InvitationGroupType;
use App\Enums\InvitationStatus;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InvitationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::where('email', 'admin@kaddah.com')->first();
        $faker = \Faker\Factory::create();

        $groupTypes = InvitationGroupType::cases();
        $statuses = InvitationStatus::cases();

        for ($i = 0; $i < 10; $i++) {
            Invitation::create([
                'email' => $faker->unique()->safeEmail,
                'group_type' => $groupTypes[array_rand($groupTypes)],
                'status' => $statuses[array_rand($statuses)],
                'token' => Str::random(32),
                'sent_at' => now()->subDays(rand(1, 30)),
                'send_count' => rand(0, 3),
                'invited_by' => $adminUser?->id,
                'accepted_at' => (rand(0, 1) ? now()->subDays(rand(0, 5)) : null),
            ]);
        }
    }
}
