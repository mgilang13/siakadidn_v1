<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Core
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // cek akses di route sekarang
        $current_route = Route::current()->getAction()['as'];
        if(!Auth::user()->roles()->first()->routes()->where('name', $current_route)->first()) {
            abort(403, 'Unauthorized action.');
        }

        // share variable to view
        view()->share( 'APPS_MENU', self::formatMenu(Auth::user()->roles()->first()->routes()->where('menu', 'yes')->get()) );
        return $next($request);
    }

    public function formatMenu($all_menu, $parent_id = NULL)
    {
        $html = '';
        $all_parent = $parent_id ? $all_menu->where('parent', $parent_id) : $all_menu->whereNull('parent');
        $current_route = Route::current()->getAction()['as'];
        // format
        foreach ($all_parent as $parent) {
            $active = stripos($parent->name, $current_route) !== false || stripos($current_route, $parent->name) !== false ? 'active' : '';
            $link = Route::has($parent->name) ? route($parent->name) : '#'. $parent->name;
            $icon = $parent->icon ? '<i width="18" data-feather="' . $parent->icon . '" class="mr-15"></i>' : '';
            
            $html .= '<a class="' .$active. '" href="' .$link. '">' .$icon. ' ' .$parent->title. '</a>';
            // cek child
            if ($child = self::formatMenu($all_menu, $parent->id)) {
                $html .= '<div class="sidebar-child">' .$child. '</div>';
            }
        }
        // return 
        return $html;
    }
}
