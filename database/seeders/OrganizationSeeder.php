<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $org = Organization::firstOrCreate(
            ['slug' => 'default'],
            [
                'name' => 'Default Organization',
                'settings' => [
                    'timezone' => 'Asia/Jakarta',
                ],
                'is_active' => true,
            ]
        );

        // Update admin user to belong to this organization
        User::where('email', 'admin@test.com')->update([
            'organization_id' => $org->id,
            'role' => 'owner',
        ]);
    }
}
