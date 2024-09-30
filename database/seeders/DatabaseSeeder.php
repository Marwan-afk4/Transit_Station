<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Driver;
use App\Models\Expence;
use App\Models\Location;
use App\Models\Offer;
use App\Models\Parking;
use App\Models\Request;
use App\Models\Revenue;
use App\Models\Subscription;
use App\Models\TypeRevenue;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Driver::factory()->count(10)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
