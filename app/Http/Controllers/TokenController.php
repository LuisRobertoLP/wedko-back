<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class TokenController extends Controller
{
    //
    public function invalidToken(){
        return response([
            "ok" =>false,
            "msg" => "Token no valido"
        ],401);
    }
    public function renew(){
        DB::beginTransaction();

        $user = Auth::user();
        if($user){

            $token = $user->createToken('authTestToken')->accessToken;
            DB::commit();
            
            return response([
                "id" => $user->id,
                "name" => $user->name,
                "role_id" => $user->roles[0]->id,
                "ok" =>true,
                "token" =>$token
            ],200);
        }else{
            DB::rollBack();

            return response([
                "ok" =>false,
                "msg" => "Token no valido"
            ],401);
        }
        DB::rollBack();

    }
}
