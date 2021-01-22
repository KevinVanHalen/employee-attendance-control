<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $password = Hash::make($request->password);

        $user_exist = User::where('username', $request->email)
                    ->where('password', $request->password)
                    ->exists();
        
        if ($user_exist) {
            $user = User::where('username', $request->email)
                        ->where('password', $request->password)
                        ->first();

            return response()->json([
                "status" => "ok",
                "message" => "Inicio de sesion correcta",
                "user" => $user
            ], 200);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Usuario no encontrado"
            ], 400);
        }
    }
}
