<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        // Crea una suscripción FREE para cada usuario que no tenga una
        $users = DB::table('recycling_users')->pluck('id');

        foreach ($users as $userId) {
            $exists = DB::table('subscriptions')->where('user_id', $userId)->exists();

            if (!$exists) {
                DB::table('subscriptions')->insert([
                    'id'         => (string) Str::uuid(),
                    'user_id'    => $userId,
                    'plan'       => 'FREE',
                    'status'     => 'ACTIVE',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}