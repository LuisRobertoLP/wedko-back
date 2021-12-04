<?php

namespace App\Http\Controllers\Proyecto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\UsuarioProyecto;
use App\Models\Proyecto;
use App\Models\User;

class ProyectoUsuariosController extends Controller
{
    //
    public function index($id)
    {
        //
        
        $usuarioProyecto = UsuarioProyecto::where('proyecto_id',$id)
        ->where('usuario_id',auth()->user()->id)
        ->Where('role_proyecto_id',1)
        ->get();

        if(!$usuarioProyecto->isEmpty()){
            $proyecto = Proyecto::with('estatus')->with(['usuarios_proyecto' => function($query) use ($id){
                $query->with('role_proyecto','usuario');
            }])->findorFail($id);
        
            return response([
                "ok" =>true,
                "msg" =>"Se han encontrado usuarios del proyecto",
                "proyecto" => $proyecto
            ],200);
        }
        return response([
            "ok" =>false,
            "msg" =>"error, no se han encontrado usuarios del proyecto",
            "usuarios" => ''
        ],200);
        
        
    }

    public function buscar_usuario($id,$nombre)
    {
        //
        $usuarioProyecto = UsuarioProyecto::where('proyecto_id',$id)
        ->where('usuario_id',auth()->user()->id)
        ->Where('role_proyecto_id',1)
        ->get();
        if(!$usuarioProyecto->isEmpty()){

            $usuarios = User::where('name', 'like', '%' . $nombre . '%')
            ->whereHas('proyectos_usuario', function ($query) use ($id){
                $query->where('proyecto_id',$id);
            })->get();

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
        
        
        return response([
            "ok" =>false,
            "msg" =>"error, no se han encontrado actividades del proyecto",
            "proyectoActividad" => ''
        ],200);
        
    }
    public function store(Request $request, $id)
    {
        //
        try {
            // Validate the value...

            $rules = [
                'usuario_id' => 'required',
                'role_proyecto_id' => 'required',
            ];
        
            $messages = [
                'usuario_id' => 'Es necesario seleccionar al usuario',
                'role_proyecto_id' => 'Es necesario seleccionar el role del usuario',
            ];

            $validator = Validator::make($request->all(),$rules, $messages);
    
            if ($validator->fails()) {
                return response([
                    "ok" =>false,
                    "msg" => $validator,
                ],422);
            }

            DB::beginTransaction();

            $usuarioProyecto = UsuarioProyecto::where('proyecto_id',$id)
            ->where('usuario_id',auth()->user()->id)
            ->Where('role_proyecto_id',1)
            ->get();
            if(!$usuarioProyecto->isEmpty()){
                $proyecto = Proyecto::findorFail($id);
                $usuario_id = $request->usuario_id;
                foreach($proyecto->usuarios_proyecto as $usuario){
                    if($usuario->usuario_id == $usuario_id){
                        return response([
                            "ok" =>false,
                            "msg" => "El usuario ya esta asignado al proyecto"
                        ],422);
                        break;
                    }
                }
                if($proyecto){
                    $usuarioProyecto = new UsuarioProyecto;
                    $usuarioProyecto->proyecto_id = $proyecto->id;
                    $usuarioProyecto->usuario_id = $request->usuario_id;
                    $usuarioProyecto->role_proyecto_id = $request->role_proyecto_id;
                    $usuarioProyecto->created_at = now();
                    $usuarioProyecto->updated_at = now();
                    $usuarioProyecto->save();
                    DB::commit();
                    return response([
                        "ok" =>true,
                        "msg" =>"Se ha agregado el usuario con exito"
                    ],200);  
                }

            }
            DB::rollBack();
            return response([
                "ok" =>false,
                "msg" => "error"
            ],422);  
        } catch (Exception $e) {
            report($e);
            DB::rollBack();
            return response([
                "ok" =>false,
                "msg" => "error"
            ],422);            
        }
        DB::rollBack();

        return response([
            "ok" =>false,
            "msg" => "error"
        ],422);
        
    }
}
