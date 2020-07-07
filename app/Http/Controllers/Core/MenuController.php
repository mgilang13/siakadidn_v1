<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Model\Core\Routes;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    private $no = 1;

    /**
     * tampilan index
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $menu = Routes::where('menu', 'yes')->orderBy('order', 'asc')->get();
        $rs_table = self::formatTable($menu);
        $rs_option = self::formatOption($menu);
        $rs_icon = self::allIcon();
        return view('core.menu.index', compact('rs_table', 'rs_option', 'rs_icon'));
    }

    /**
     * ajax proses tambah menu
     *
     * @return json
     */
    public function addProcess(Request $request)
    {
        // validasi
        $request->validate([
            'title' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'order' => 'required|int',
            'parent' => '',
            'icon' => Rule::in(self::allIcon()),
        ]);
        $params = $request->only(['parent', 'icon', 'title', 'order']);
        $params['parent'] = $params['parent'] ?: NULL;
        $params['menu'] = 'yes';
        Routes::updateOrCreate( $request->only(['name']), $params );
        $request->session()->flash('success', 'Tambah Menu Sukses');
    }

    /**
     * proses ubah menu
     *
     * @return json
     */
    public function editProcess(Request $request, Routes $routes)
    {
        // validasi
        $request->validate([
            'title' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'order' => 'required|int',
            'parent' => '',
            'icon' => Rule::in(self::allIcon()),
        ]);
        $params = $request->only(['name', 'parent', 'icon', 'title', 'order']);
        $params['parent'] = $params['parent'] ?: NULL;
        $params['menu'] = 'yes';
        $routes->update($params);
        $request->session()->flash('success', 'Ubah Menu Sukses');
    }

    /**
     * proses hapus menu
     *
     * @return json
     */
    public function deleteProcess(Request $request, Routes $routes)
    {
        $routes->delete();
        $request->session()->flash('success', 'Hapus Menu Sukses');
    }

    /**
     * format tampilan tabel
     *
     * @return String
     */
    private function formatTable($rs_menu, $parent_id = NULL, $prefix = "")
    {
        $html = '';
        $rs_parent = $parent_id ? $rs_menu->where('parent', $parent_id) : $rs_menu->whereNull('parent');
        // format
        foreach ($rs_parent as $parent) {
            $icon = $parent->icon ? '<i width="14" class="mr-2" data-feather="' .$parent->icon. '">' : '';
            $html .= '<tr>';
                $html .= '<td class="text-center">' .$this->no++. '</td>';
                $html .= '<td class="text-center">' .$icon. '</td>';
                $html .= '<td>' .$prefix.$parent->title. '</td>';
                $html .= '<td>' .$parent->name. '</td>';
                $html .= '<td class="text-center">' .$parent->order. '</td>';
                $html .= '<td>';
                    $html .= '<div class="btn-action">';
                        $html .= '<a href="' . route('core.menu.edit.process', $parent->id). '" data-toggle="modal" data-target="#modal" data-type="edit" data-method="put" data-title="Ubah Menu">';
                            $html .= '<i width="14" data-feather="edit"></i>';
                        $html .= '</a>';
                        $html .= '<a href="' . route('core.menu.delete.process', $parent->id). '" class="text-danger delete">';
                            $html .= '<i width="14" data-feather="trash"></i>';
                        $html .= '</a>';
                        $html .= '<textarea class="jsons d-none">' . json_encode($parent). '</textarea>';
                    $html .= '</div>';
                $html .= '</td>';
            $html .= '</tr>';
            // cek child
            if ($child = self::formatTable($rs_menu, $parent->id, $prefix."--- ")) {
                $html .= $child;
            }
        }
        // return 
        return $html;
    }

    /**
     * format option select
     *
     * @return String
     */
    private function formatOption($rs_menu, $parent_id = NULL, $prefix = "")
    {
        $html = '';
        $rs_parent = $parent_id ? $rs_menu->where('parent', $parent_id) : $rs_menu->whereNull('parent');
        // format
        foreach ($rs_parent as $parent) {
            $html .= '<option value="' .$parent->id. '">' .$prefix.$parent->title. '</option>';
            // cek child
            if ($child = self::formatOption($rs_menu, $parent->id, $prefix."--- ")) {
                $html .= $child;
            }
        }
        // return 
        return $html;
    }

    /**
     * semua feathersicon
     *
     * @return Array
     */
    private function allIcon()
    {
        // return 
        return ["activity", "airplay", "alert-circle", "alert-octagon", "alert-triangle", "align-center", "align-justify", "align-left", "align-right", "anchor", "archive", "at-sign", "award", "aperture", "bar-chart", "bar-chart-2", "battery", "battery-charging", "bell", "bell-off", "bluetooth", "book-open", "book", "bookmark", "box", "briefcase", "calendar", "camera", "cast", "circle", "clipboard", "clock", "cloud-drizzle", "cloud-lightning", "cloud-rain", "cloud-snow", "cloud", "codepen", "codesandbox", "code", "coffee", "columns", "command", "compass", "copy", "corner-down-left", "corner-down-right", "corner-left-down", "corner-left-up", "corner-right-down", "corner-right-up", "corner-up-left", "corner-up-right", "cpu", "credit-card", "crop", "crosshair", "database", "delete", "disc", "dollar-sign", "droplet", "edit", "edit-2", "edit-3", "eye", "eye-off", "external-link", "facebook", "fast-forward", "figma", "file-minus", "file-plus", "file-text", "film", "filter", "flag", "folder-minus", "folder-plus", "folder", "framer", "frown", "gift", "git-branch", "git-commit", "git-merge", "git-pull-request", "github", "gitlab", "globe", "hard-drive", "hash", "headphones", "heart", "help-circle", "hexagon", "home", "image", "inbox", "instagram", "key", "layers", "layout", "link", "link-2", "linkedin", "list", "lock", "log-in", "log-out", "mail", "map-pin", "map", "maximize", "maximize-2", "meh", "menu", "message-circle", "message-square", "mic-off", "mic", "minimize", "minimize-2", "minus", "monitor", "moon", "more-horizontal", "more-vertical", "mouse-pointer", "move", "music", "navigation", "navigation-2", "octagon", "package", "paperclip", "pause", "pause-circle", "pen-tool", "percent", "phone-call", "phone-forwarded", "phone-incoming", "phone-missed", "phone-off", "phone-outgoing", "phone", "play", "pie-chart", "play-circle", "plus", "plus-circle", "plus-square", "pocket", "power", "printer", "radio", "refresh-cw", "refresh-ccw", "repeat", "rewind", "rotate-ccw", "rotate-cw", "rss", "save", "scissors", "search", "send", "settings", "share-2", "shield", "shield-off", "shopping-bag", "shopping-cart", "shuffle", "skip-back", "skip-forward", "slack", "slash", "sliders", "smartphone", "smile", "speaker", "star", "stop-circle", "sun", "sunrise", "sunset", "tablet", "tag", "target", "terminal", "thermometer", "thumbs-down", "thumbs-up", "toggle-left", "toggle-right", "tool", "trash", "trash-2", "triangle", "truck", "tv", "twitch", "twitter", "type", "umbrella", "unlock", "user-check", "user-minus", "user-plus", "user-x", "user", "users", "video-off", "video", "voicemail", "volume", "volume-1", "volume-2", "volume-x", "watch", "wifi-off", "wifi", "wind", "x-circle", "x-octagon", "x-square", "x", "youtube", "zap-off", "zap", "zoom-in", "zoom-out", ""];
    }

}
