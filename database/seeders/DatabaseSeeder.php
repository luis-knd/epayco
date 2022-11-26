<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $userQuantity = (int)env('FAKER_USERS_QUANTITY') ?: 10;
        User::factory($userQuantity)->create();
    }
}
