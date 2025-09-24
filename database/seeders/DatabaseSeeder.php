<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\CourtList;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create an Admin user
        User::create([
            'name' => 'Admin User',
            'mobile' => '01700000001',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'approved' => true,
        ]);

        // Create a default chamber
        $chamber = \App\Models\Chamber::create([
            'name' => 'Default Chamber',
            'address' => 'Dhaka, Bangladesh',
        ]);
        
        // Create a Lawyer for testing
        User::create([
            'name' => 'Test Lawyer',
            'mobile' => '01700000002',
            'password' => Hash::make('password'),
            'role' => 'lawyer',
            'chamber_id' => $chamber->id,
            'bar_number' => '12345',
            'approved' => true,
        ]);

        // Create a Staff for testing
        User::create([
            'name' => 'Test Staff',
            'mobile' => '01700000003',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'chamber_id' => $chamber->id,
            'approved' => true,
        ]);

        // Court lists
        $courts = [
            'Supreme Court',
            'High Court',
            'Civil Court',
            'Magistrate Court',
            'Family Court',
            'Labour Court',
            'Nari-O-Shishu Nirjaton Damon Tribunal'
        ];

        foreach ($courts as $court) {
            CourtList::create(['name' => $court]);
        }
    }
}