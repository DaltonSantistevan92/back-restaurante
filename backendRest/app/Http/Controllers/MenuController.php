<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function verMenu(String $rol_id, $padreSesion = 0){

        $menus = Menu::where('rol_id', $rol_id)->where('id_seccion', $padreSesion)->orderBy('posicion', 'asc')->get();
        $response = [];

        if($menus->count() > 0){
            $response = [
                'cantidad' => $menus->count(),
                'data' => $menus
            ];
        }else{
            $response = [
                'cantidad' => 0,
                'data' => []
            ];
        }
        return response()->json($response);
    }
}
