<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        Service::query()
            ->updateOrCreate(
                ['driver' => 'github'],
                [
                    'name' => 'GitHub',
                    'description' => 'GitHub is a web-based hosting service for version control.',
                    'scopes' => ['read:user', 'notifications', 'user:email'],
                ]
            );

        Service::query()
            ->updateOrCreate(
                ['driver' => 'google'],
                [
                    'name' => 'Google',
                    'description' => 'Connect your Google account to your account on this website.',
                    'scopes' => ['profile', 'email', 'calendar.readonly'],
                ]
            );
    }
}
