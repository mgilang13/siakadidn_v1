<?php

use Illuminate\Database\Seeder;
use App\Model\Core\RolesUsers as MRolesUsers;

class RolesUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MRolesUsers::create(['roles_id' => 1, 'users_id' => 1]);
    }
}
