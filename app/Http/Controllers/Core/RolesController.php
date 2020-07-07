<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Model\Core\Roles;
use App\Model\Core\RolesRoutes;
use App\Model\Core\Routes;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    public function index()
    {
        $all_role = Roles::all();
        return view('core.roles.index', compact('all_role'));
    }

    public function addProcess(Request $request)
    {
        // validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'group' => '',
            'description' => '',
        ]);
        Roles::create($request->only(['name', 'description', 'group']));
        $request->session()->flash('success', 'Tambah Hak Akses Sukses');
    }

    public function editProcess(Request $request, Roles $roles)
    {
        // validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'group' => '',
            'description' => '',
        ]);
        $roles->update($request->only(['name', 'description', 'group']));
        $request->session()->flash('success', 'Ubah Hak Akses Sukses');
    }

    public function deleteProcess(Request $request, Roles $roles)
    {
        $roles->delete();
        $request->session()->flash('success', 'Hapus Hak Akses Sukses');
    }

    public function routes(Request $request, Roles $roles)
    {
        $appRoutes = [];
        foreach (Route::getRoutes() as $value) {
            if( $value->getName()
            && $value->getName() != 'login'
            && $value->getName() != 'logout'
            && $value->getName() != 'index'
            && stripos($value->getName(), 'ignition.') === false
            && stripos($value->getName(), 'password.') === false 
            ) {
                $appRoutes[] = $value->getName();
            }
        }
        $databaseRoutes = Routes::select('name', 'routes_id')
            ->leftJoin('roles_routes', function ($join) use ($roles) {
                $join->on('id', '=', 'routes_id');
                $join->on('roles_id', '=', DB::raw($roles->id));
            })
            ->orderBy('order', 'asc')
            ->get();
        $rs_routes = [];
        foreach ($databaseRoutes as $route) {
            $index_route = array_search($route->name, $appRoutes);
            if ($index_route !== false) {
                unset($appRoutes[$index_route]);
            }
            $rs_routes[] = [ 'name' => $route['name'], 'access' => $route['routes_id']?true:false ];
        }
        foreach ($appRoutes as $sys) {
            $rs_routes[] = ['name' => $sys, 'access' => false];
        }
        // sorting
        usort($rs_routes, function($a, $b) {
            return $a['name'] > $b['name'];
        });

        return view('core.roles.routes', compact('roles', 'rs_routes'));
    }

    public function routesUpdateProcess(Request $request, Roles $roles)
    {
        RolesRoutes::where('roles_id', $roles->id)->delete();
        // create
        foreach ($request->input('name') as $index => $name) {
            // master routes
            $routes = Routes::updateOrCreate( ['name' => $name], [] );
            // create roles routes
            if (isset($request->input('access')[$index])) {
                RolesRoutes::create([ 'roles_id' => $roles->id, 'routes_id' => $routes->id ]);
            }
        }
        return redirect()->back()->with('success', 'Update akses routes disimpan');
    }
}
