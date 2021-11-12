<?php

namespace App\Http\Controllers\Proyecto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Proyecto;
use App\Models\ProyectoComentario;
use App\Models\UsuarioProyecto;

class ProyectoComentarioController extends Controller
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
            $proyectoComentario = ProyectoComentario::with('usuario')->where('proyecto_id',$id)->get();
            if(!$proyectoComentario->isEmpty()){
                return response([
                    "ok" =>true,
                    "msg" =>"Se han encontrado comentarios del proyecto",
                    "comentarios" => $proyectoComentario
                ],200);
            }else{
                return response([
                    "ok" =>false,
                    "msg" =>"error, no se han encontrado comentarios del proyecto",
                    "comentarios" => $proyectoComentario
                ],200);
            }
        }
        return response([
            "ok" =>false,
            "msg" =>"error, no se han encontrado comentarios del proyecto",
            "comentarios" => ''
        ],200);
        
    }

    public function store(Request $request, $id)
    {
        //
        try {
            // Validate the value...

            $rules = [
                'comentario' => 'required',
            ];
        
            $messages = [
                'comentario' => 'Es necesario agregar el comentario',
            ];

            $validator = Validator::make($request->all(),$rules, $messages);
    
            if ($validator->fails()) {
                return response([
                    "ok" =>false,
                    "msg" => $validator,
                ],422);
            }

            DB::beginTransaction();
            $proyecto = Proyecto::whereHas('usuarios_proyecto', function ($query){
                $query->where('usuario_id',auth()->user()->id);
            })->findorFail($id);
            if($proyecto){
                $proyectoComentario = new ProyectoComentario;
                $proyectoComentario->proyecto_id = $proyecto->id;
                $proyectoComentario->usuario_id = auth()->user()->id;
                $proyectoComentario->comentario = $request->comentario;
                $proyectoComentario->created_at = now();
                $proyectoComentario->updated_at = now();
                $proyectoComentario->save();
                DB::commit();
                return response([
                    "ok" =>true,
                    "msg" =>"Se ha agregado el usuario con exito"
                ],200);  
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
