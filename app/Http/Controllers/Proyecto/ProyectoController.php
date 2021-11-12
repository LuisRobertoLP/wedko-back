<?php

namespace App\Http\Controllers\Proyecto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyecto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\UsuarioProyecto;
use App\Models\ProyectoComentario;

class ProyectoController extends Controller
{
    //
    public function index()
    {
        //
        $proyectos = Proyecto::whereHas('usuarios_proyecto', function ($query){
            $query->where('usuario_id',auth()->user()->id);
        })->get();
        if(!$proyectos->isEmpty()){
            return response([
                "ok" =>true,
                "msg" =>"Se han encontrado proyectos",
                "proyectos" => $proyectos
            ],200);
        }else{
            return response([
                "ok" =>false,
                "msg" =>"error, no se han encontrado proyectos",
                "proyectos" => $proyectos
            ],200);
        }
        
    }

    public function store(Request $request)
    {
        //

        try {
            // Validate the value...

            $rules = [
                'nombre' => 'required',
                'descripcion' => 'required',
            ];
        
            $messages = [
                'nombre' => 'Es necesario escribir el nombre del proyecto',
                'descripcion' => 'Es necesario escribir la descripción del proyecto',

            ];

            $validator = Validator::make($request->all(),$rules, $messages);
    
            if ($validator->fails()) {
                return response([
                    "ok" =>false,
                    "msg" => $validator,
                ],422);
            }

                DB::beginTransaction();
                $proyecto = new Proyecto;
                $proyecto->nombre = $request->nombre;
                $proyecto->descripcion = $request->descripcion;
                $proyecto->estatus_proyecto_id = 1;
                $proyecto->created_at = now();
                $proyecto->updated_at = now();
                $proyecto->save();

                if($proyecto){
                    $usuarioProyecto = new UsuarioProyecto;
                    $usuarioProyecto->proyecto_id = $proyecto->id;
                    $usuarioProyecto->usuario_id = auth()->user()->id;
                    $usuarioProyecto->role_proyecto_id = 1;
                    $usuarioProyecto->created_at = now();
                    $usuarioProyecto->updated_at = now();
                    $usuarioProyecto->save();
                    DB::commit();
                    return response([
                        "ok" =>true,
                        "msg" =>"Se ha creado el proyecto con exito"
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

    public function update(Request $request, $id)
    {
        //
        try {
            // Validate the value...

            $rules = [
                'nombre' => 'required',
                'descripcion' => 'required',
                'estatus_proyecto_id' => 'required',
            ];
        
            $messages = [
                'nombre' => 'Es necesario escribir el nombre del proyecto',
                'descripcion' => 'Es necesario escribir la descripción del proyecto',
                'estatus_proyecto_id' => 'Es necesario seleccionar el estatus del proyecto',
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
                $proyecto->nombre = $request->nombre;
                $proyecto->descripcion = $request->descripcion;
                $proyecto->estatus_proyecto_id = $request->estatus_proyecto_id;
                $proyecto->created_at = now();
                $proyecto->updated_at = now();
                $proyecto->save();

                DB::commit();
                return response([
                    "ok" =>true,
                    "msg" =>"Se ha actualizado el proyecto con exito"
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
