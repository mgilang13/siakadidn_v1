<?php

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
        $this->call(Users::class);
        $this->call(Roles::class);
        $this->call(Routes::class);
        $this->call(RolesRoutes::class);
        $this->call(RolesUsers::class);
    }
}
