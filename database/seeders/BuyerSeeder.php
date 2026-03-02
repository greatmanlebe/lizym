<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buyer;
use Illuminate\Support\Facades\Hash;

class BuyerSeeder extends Seeder
{
    public function run(): void
    {
       
      Buyer::create([
    'name' => 'Test Buyer44',
    'email' => 'buydder2@example.com',
    'password' => Hash::make('password'),
    'location' => 'USA',
]);
    }
}

