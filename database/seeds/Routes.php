<?php

use Illuminate\Database\Seeder;
use App\Model\Core\Routes as MRoutes;

class Routes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MRoutes::create([ 'id' => 1, 'icon' => 'home', 'name' => 'dashboard', 'title' => 'Dashboard', 'order' => 1, 'menu' => 'yes' ]);
        
        // Menu Tahfidz
        MRoutes::create([ 'id' => 11, 'icon' => 'book-open', 'name' => 'tahfidz.index', 'title' => 'Tahfidz', 'order' => 10, 'menu' => 'yes' ]);

        // Menu Referensi
        MRoutes::create([ 'id' => 6, 'icon' => 'list', 'name' => 'reference', 'title' => 'Referensi', 'order' => 20, 'menu' => 'yes' ]);
        MRoutes::create([ 'id' => 7, 'name' => 'ref.teacher.index', 'title' => 'Guru', 'order' => 1001, 'menu' => 'yes', 'parent' => 6 ]);
        MRoutes::create([ 'id' => 8, 'name' => 'ref.subject.index', 'title' => 'Mata Pelajaran', 'order' => 1002, 'menu' => 'yes', 'parent' => 6 ]);
        MRoutes::create([ 'id' => 9, 'name' => 'ref.halaqah.index', 'title' => 'Halaqah', 'order' => 1004, 'menu' => 'yes', 'parent' => 6 ]);
        MRoutes::create([ 'id' => 10, 'name' => 'ref.student.index', 'title' => 'Murid', 'order' => 1000, 'menu' => 'yes', 'parent' => 6 ]);
        MRoutes::create([ 'id' => 13, 'name' => 'ref.parent.index', 'title' => 'Orang Tua / Wali Murid', 'order' => 1005, 'menu' => 'yes', 'parent' => 6 ]);
        MRoutes::create([ 'id' => 14, 'name' => 'ref.schoolyear.index', 'title' => 'Tahun Ajaran', 'order' => 1006, 'menu' => 'yes', 'parent' => 6 ]);

        MRoutes::create([ 'id' => 2, 'icon' => 'settings', 'name' => 'core', 'title' => 'Pengaturan', 'order' => 10000, 'menu' => 'yes' ]);
        MRoutes::create([ 'id' => 3, 'name' => 'core.menu', 'title' => 'Menu', 'order' => 10001, 'menu' => 'yes', 'parent' => 2 ]);
        MRoutes::create([ 'id' => 4, 'name' => 'core.roles', 'title' => 'Hak Akses', 'order' => 10002, 'menu' => 'yes', 'parent' => 2 ]);
        MRoutes::create([ 'id' => 5, 'name' => 'core.users', 'title' => 'User', 'order' => 10003, 'menu' => 'yes', 'parent' => 2 ]);
        
        MRoutes::create([ 'id' => 18, 'name' => 'profile' ]);
        MRoutes::create([ 'id' => 19, 'name' => 'profile.update.process' ]);

        MRoutes::create([ 'id' => 20, 'name' => 'core.menu.add.process' ]);
        MRoutes::create([ 'id' => 21, 'name' => 'core.menu.edit.process' ]);
        MRoutes::create([ 'id' => 22, 'name' => 'core.menu.delete.process' ]);

        MRoutes::create([ 'id' => 23, 'name' => 'core.roles.add.process' ]);
        MRoutes::create([ 'id' => 24, 'name' => 'core.roles.edit.process' ]);
        MRoutes::create([ 'id' => 25, 'name' => 'core.roles.delete.process' ]);
        MRoutes::create([ 'id' => 26, 'name' => 'core.roles.routes' ]);
        MRoutes::create([ 'id' => 27, 'name' => 'core.roles.routes.update.process' ]);

        MRoutes::create(['id' => 28, 'name' => 'core.users.add']);
        MRoutes::create(['id' => 29, 'name' => 'core.users.add.process']);
        MRoutes::create(['id' => 30, 'name' => 'core.users.edit']);
        MRoutes::create(['id' => 31, 'name' => 'core.users.edit.process']);
        MRoutes::create(['id' => 32, 'name' => 'core.users.delete']);
        MRoutes::create(['id' => 33, 'name' => 'core.users.delete.process']);

        // MRoutes::create([ 'id' => 34, 'icon' => 'star', 'name' => 'template', 'title' => 'Theme Template', 'order' => 20000, 'menu' => 'yes' ]);
    }
}
