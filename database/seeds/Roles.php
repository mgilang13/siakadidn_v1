<?php

use Illuminate\Database\Seeder;
use App\Model\Core\Roles as MRoles;

class Roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MRoles::create([ 'id' => 1, 'name' => 'admin', 'description' => 'admin' ]);
        MRoles::create([ 'id' => 2, 'name' => 'operator', 'group' => 'admin', 'description' => 'operator' ]);
        MRoles::create([ 'id' => 3, 'name' => 'guru', 'group' => 'guru', 'description' => 'guru' ]);
        MRoles::create([ 'id' => 4, 'name' => 'murid', 'group' => 'murid', 'description' => 'murid' ]);
        MRoles::create([ 'id' => 5, 'name' => 'orang_tua', 'group' => 'orang_tua', 'description' => 'orang_tua' ]);
    }
}
