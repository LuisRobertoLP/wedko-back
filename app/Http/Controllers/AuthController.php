<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Session;
use Str;
class AuthController extends Controller
{
    //
    public function login(Request $request){

        try {
            $rules = [
                'email' => 'required',
                'password' => 'required',
            ];
        
            $messages = [
                'email.required' => 'Es necesario escribir el correo',
                'password.required' => 'Es necesario escribir la clave',
            ];

            $validator = Validator::make($request->all(),$rules, $messages);
        
            if ($validator->fails()) {

                return response([
                    "ok" =>false,
                    "msg" => $validator
                ],422);
            }
            DB::beginTransaction();

            $credentials = $request->only('email','password');
            if(!Auth::attempt($credentials)){
                DB::rollBack();

                return response([
                    "ok" =>false,
                    "msg" => "Usuario y/o contraseña es invalido."
                ],422);
            }
            $user = Auth::user();
            $token = $user->createToken('authTestToken')->accessToken;
            DB::commit();

            return response([
                "id" => $user->id,
                "name" => $user->name,
                "role_id" => $user->roles[0]->id,
                "ok" =>true,
                "token" =>$token
            ],200);

        } catch (Exception $e) {
            report($e);
            DB::rollBack();
            return response([
                "ok" =>false,
                "msg" => "error"
            ],422);
        }
    }
    public function register(Request $request)
    {
        try {
            $rules = [
                'name' => 'required',
                'email' => [
                    'required',
                    'email',
                    function ($attribute, $value, $fail) {
                        if (User::whereEmail($value)->count() > 0) {
                            $fail('Correo actualmente en uso.');
                        }
                    },
                ],
                'password' => 'required',
            ];
        
            $messages = [
                'name.required' => 'Es necesario escribir el nombre',
                'email.required' => 'Es necesario escribir el correo',
                'password.required' => 'Es necesario escribir la clave',
            ];

            $validator = Validator::make($request->all(),$rules, $messages);
        
            if ($validator->fails()) {
                DB::rollBack();

                return response([
                    "ok" =>false,
                    "msg" => $validator
                ],422);
            }
            DB::beginTransaction();

            $role = "Administrador";

            $user =  User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);
            if($request->has('password')){
                $user->password = Hash::make($request->password);
            } 
            $user->save();
            $user->assignRole($role);
            DB::commit();
            
            $token = $user->createToken('LaravelAuthApp')->accessToken;

            return response([
                "id" => $user->id,
                "name" => $user->name,
                "role_id" => $user->roles[0]->id,
                "ok" =>true,
                "token" =>$token
            ],200);
        } catch (Exception $e) {
            report($e);
            DB::rollBack();
            return response([
                "ok" =>false,
                "msg" => "error"
            ],422);
        }

       
        
    }
}
