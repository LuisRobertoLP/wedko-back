<?php

namespace App\Http\Controllers\Proyecto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\UsuarioProyecto;
use App\Models\UsuarioProyectoActividad;
use App\Models\ProyectoActividad;
use App\Models\Proyecto;
use App\Models\User;

class ProyectoActividadUsuariosController extends Controller
{
    //
    public function index($id,$proyecto_actividad_id)
    {
        //
        $usuarioProyecto = UsuarioProyecto::where('proyecto_id',$id)
        ->where('usuario_id',auth()->user()->id)
        ->Where('role_proyecto_id',1)
        ->get();

        if(!$usuarioProyecto->isEmpty()){
            // $proyectoActividad = ProyectoActividad::where('proyecto_id',$id)->findorFail($proyecto_actividad_id);
            $usuarios = User::whereHas('proyectoActividad', function ($query) use ($proyecto_actividad_id){
                $query->where('proyecto_actividad_id',$proyecto_actividad_id);
            })->get();
            if(!$usuarios->isEmpty()){
                return response([
                    "ok" =>true,
                    "msg" =>"Se han encontrado usuarios de la actividad del proyecto",
                    "usuarios" => $usuarios
                ],200);
            }else{
                return response([
                    "ok" =>false,
                    "msg" =>"error, no se han encontrado usuarios de la actividad del proyecto",
                    "usuarios" => $usuarios
                ],200);
            }
        }
        return response([
            "ok" =>false,
            "msg" =>"error, no se han encontrado usuarios de la actividad del proyecto",
            "usuarios" => ''
        ],200);
    }

    public function store(Request $request, $id,$proyecto_actividad_id)
    {
        //
        try {
            // Validate the value...

            $rules = [
                'usuario_id' => 'required',
            ];
        
            $messages = [
                'usuario_id' => 'Es necesario seleccionar al usuario',
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
                $usuario_id = $request->usuario_id;

                $proyectoActividad = ProyectoActividad::where('proyecto_id',$id)->findorFail($proyecto_actividad_id);
                foreach($proyectoActividad->usuarios as $usuario){
                    if($usuario->id == $usuario_id){
                        return response([
                            "ok" =>false,
                            "msg" => "El usuario ya esta asignado a la actividad"
                        ],422);
                        break;
                    }
                }
    
                $proyecto = Proyecto::whereHas('usuarios_proyecto', function ($query) use ($usuario_id){
                    $query->where('usuario_id',$usuario_id);
                })->findorFail($id);
                if($proyecto->id == $proyectoActividad->proyecto_id){
                    if($proyectoActividad){
                        $usuarioProyectoActividad = new UsuarioProyectoActividad;
                        $usuarioProyectoActividad->usuario_id = $request->usuario_id;
                        $usuarioProyectoActividad->proyecto_actividad_id = $proyecto_actividad_id;
                        $usuarioProyectoActividad->created_at = now();
                        $usuarioProyectoActividad->updated_at = now();
                        $usuarioProyectoActividad->save();
        
                        DB::commit();
                        return response([
                            "ok" =>true,
                            "msg" =>"Se ha agregado el usuario a la actividad con exito"
                        ],200);  
                    }
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
