<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        // Seed violation rules
        $this->call([
            ViolationRulesSeeder::class,
        ]);
    }
}
