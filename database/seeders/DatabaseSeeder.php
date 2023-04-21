<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organizations;
use App\Models\Users;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Users::factory(1)->create();
        Organizations::factory(10)->create();
    }
}
