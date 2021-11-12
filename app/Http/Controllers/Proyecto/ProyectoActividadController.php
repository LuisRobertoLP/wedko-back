<?php

namespace App\Http\Controllers\Proyecto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProyectoActividad;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Proyecto;
use App\Models\UsuarioProyectoActividad;
use App\Models\UsuarioProyecto;

class ProyectoActividadController extends Controller
{
    public function index($id)
    {
        //
        $usuarioProyecto = UsuarioProyecto::where('proyecto_id',$id)
        ->where('usuario_id',auth()->user()->id)
        ->Where('role_proyecto_id',1)
        ->get();
        if(!$usuarioProyecto->isEmpty()){
            $proyectoActividad = ProyectoActividad::where('proyecto_id',$id)->get();
            if(!$proyectoActividad->isEmpty()){
                return response([
                    "ok" =>true,
                    "msg" =>"Se han encontrado las actividades del proyecto",
                    "proyectoActividad" => $proyectoActividad
                ],200);
            }else{
                return response([
                    "ok" =>false,
                    "msg" =>"error, no se han encontrado actividades del proyecto",
                    "proyectoActividad" => $proyectoActividad
                ],200);
            }
        }
        return response([
            "ok" =>false,
            "msg" =>"error, no se han encontrado actividades del proyecto",
            "proyectoActividad" => ''
        ],200);
        
    }

    public function store(Request $request,$id)
    {
        //

        try {
            // Validate the value...

            $rules = [
                'nombre' => 'required',
                'descripcion' => 'required',
                'fecha' => 'required',
            ];
        
            $messages = [
                'nombre' => 'Es necesario escribir el nombre de la actividad',
                'descripcion' => 'Es necesario escribir la descripción de la actividad',
                'fecha' => 'Es necesario escribir la fecha de entrega de la actividad',

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
                    $query->where('usuario_id',auth()->user()->id)
                    ->Where('role_proyecto_id',1);
                })->findorFail($id);
                if($proyecto){
                    $proyectoActividad = new ProyectoActividad;
                    $proyectoActividad->nombre = $request->nombre;
                    $proyectoActividad->descripcion = $request->descripcion;
                    $proyectoActividad->fecha = $request->fecha;
                    $proyectoActividad->proyecto_id = $proyecto->id;
                    $proyectoActividad->estatus_proyecto_actividad_id = 1;
                    $proyectoActividad->created_at = now();
                    $proyectoActividad->updated_at = now();
                    $proyectoActividad->save();
    
                    if($proyectoActividad){
                        DB::commit();
                        return response([
                            "ok" =>true,
                            "msg" =>"Se ha creado el la actividad del proyecto con exito"
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

    public function update(Request $request,$id,$proyecto_actividad_id)
    {
        //

        try {
            // Validate the value...

            $rules = [
                'nombre' => 'required',
                'descripcion' => 'required',
                'estatus_proyecto_actividad_id' => 'required',
                'fecha' => 'required',

            ];
        
            $messages = [
                'nombre' => 'Es necesario escribir el nombre de la actividad',
                'descripcion' => 'Es necesario escribir la descripción de la actividad',
                'estatus_proyecto_actividad_id' => 'Es necesario seleccionar el estatus de la actividad',
                'fecha' => 'Es necesario escribir la fecha de la actividad',
            ];

            $validator = Validator::make($request->all(),$rules, $messages);
    
            if ($validator->fails()) {
                return response([
                    "ok" =>false,
                    "msg" => $validator,
                ],422);
            }

                DB::beginTransaction();
                $proyectoActividad = ProyectoActividad::whereHas('proyecto', function ($query){
                    $query->whereHas('usuarios_proyecto', function ($query2){
                        $query2->where('usuario_id',auth()->user()->id)
                        ->Where('role_proyecto_id',1);
                    });
                })->where('proyecto_id',$id)->findorFail($proyecto_actividad_id);

                if($proyectoActividad){
                    $proyectoActividad->nombre = $request->nombre;
                    $proyectoActividad->descripcion = $request->descripcion;
                    $proyectoActividad->proyecto_id = $proyectoActividad->proyecto_id;
                    $proyectoActividad->fecha = $request->fecha;
                    $proyectoActividad->estatus_proyecto_actividad_id = $request->estatus_proyecto_actividad_id;
                    $proyectoActividad->created_at = now();
                    $proyectoActividad->updated_at = now();
                    $proyectoActividad->save();
    
                    if($proyectoActividad){
                        DB::commit();
                        return response([
                            "ok" =>true,
                            "msg" =>"Se ha actualizado la actividad del proyecto con exito"
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
