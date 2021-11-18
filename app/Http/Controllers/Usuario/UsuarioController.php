<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsuarioController extends Controller
{
    //
    public function index($nombre)
    {
        //
        $usuarios = User::where('name', 'like', '%' . $nombre . '%')
        
        ->get();
        if(!$usuarios->isEmpty()){
            return response([
                "ok" =>true,
                "msg" =>"Se han encontrado usuarios",
                "usuarios" => $usuarios
            ],200);
        }else{
            return response([
                "ok" =>true,
                "msg" =>"No hay usuarios con ese nombre",
                "usuarios" => $usuarios
            ],200);
        }
        
        
    }
}
