<?php

namespace App\Http\Controllers\Proyecto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\ProyectoActividad;
use App\Models\UsuarioProyecto;
Use App\Models\ProyectoActividadComentario;
use App\Models\UsuarioProyectoActividad;

class ProyectoActividadComentarioController extends Controller
{
    public function index($id){
        $actividad = ProyectoActividad::where('id', $id)->first();

        if(!empty($actividad))
        {
            
            $usuarioProyecto = UsuarioProyecto::where('proyecto_id', $actividad->proyecto_id)
                ->where('usuario_id', auth()->user()->id)
                ->first();
            
            if(!empty($usuarioProyecto))
            {
                $comentarioActividad = ProyectoActividadComentario::with('usuario')
                    ->where('proyecto_actividad_id', $actividad->id)
                    ->get();
                
                if(!empty($comentarioActividad))
                {
                    return response([
                        "ok" => true,
                        "msg" => "Se han encontrado los comentarios de la actividad",
                        "comentarios" => $comentarioActividad
                    ], 200);
                }
                else
                {
                    return response([
                        "ok" => false,
                        "msg" => "error, la actividad actualmente no tiene comentarios",
                        "comentarios" => ''
                    ], 200);
                }
            }
            else
            {
                return response([
                    "ok" => false,
                    "msg" => "error, el usuario no pertenece al proyecto",
                    "comentarios" => ''
                ], 422);
            }
        }
        
        return response([
            "ok" => false,
            "msg" => "error, no se ha encontrado la actividad",
            "comentarios" => ''
        ], 422);
        // UsuarioProyectoActividad::where('proyecto_actividad_id', $id)
        //     ->where('usuario_id', auth()->user()->id)
        //     ->get();
        
        

    }

    public function store(Request $request, $id){
        try{
            $rules = [
                'comentario' => 'required'
            ];

            $messages = [
                'comentario' => 'Es necesario que agregues un comentario'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if($validator->fails())
            {
                return response([
                    "ok" => false,
                    "msg" => $validator
                ], 422);
            }

            DB::beginTransaction();
            $actividad = ProyectoActividad::whereHas('usuario_proyecto_actividad', function ($query){
                $query->where('usuario_id', auth()->user()->id);
            })->findorFail($id);

            if($actividad)
            {
                $proyectoActividadComentario = new ProyectoActividadComentario;
                $proyectoActividadComentario->comentario = $request->comentario;
                $proyectoActividadComentario->proyecto_actividad_id = $actividad->id;
                $proyectoActividadComentario->usuario_id = auth()->user()->id;
                $proyectoActividadComentario->created_at = now();
                $proyectoActividadComentario->updated_at = now();
                $proyectoActividadComentario->save();
                DB::commit();

                return response([
                    "ok" => true,
                    "msg" => "Se ha agregado el comentario a la actividad con exito"
                ], 200);

                DB::rollBack();

                return response([
                    "ok" => false,
                    "msg" => "error"
                ], 422);
            }
        }catch(Exception $e){
            report($e);
            DB::rollBack();

            return response([
                "ok" => false,
                "msg" => "error"
            ], 422);
        }
        DB::rollBack();

        return response([
            "ok" =>false,
            "msg" => "error"
        ],422);
    }
}
