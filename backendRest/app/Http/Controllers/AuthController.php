<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function guardarUsuario(Request $request)
    {
        $usuarioRequest = (object) $request->usuario;

        $response = [];
        
        if(!isset($usuarioRequest) || $usuarioRequest == null){
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para procesar',
                'usuario' => null
            ];
        }else{
            $name = ucfirst($usuarioRequest->name);
            $email = $usuarioRequest->email;
            $password = $usuarioRequest->password;
            
            $passwordEncriptado = Hash::make($password); //para encriptar password
            
            $nuevoUsuario = new User();
            $nuevoUsuario->rol_id = intval($usuarioRequest->rol_id);
            $nuevoUsuario->name = $name;
            $nuevoUsuario->email = $email;
            $nuevoUsuario->password = $passwordEncriptado;
            
            $existeUsuario = User::where('email', $email)->get()->first();

            if($existeUsuario){
                $response = [
                    'estado' => false,
                    'mensaje' => 'El correo ya existe'
                ];
            }else{
                if($nuevoUsuario->save()){
                    //crear Token
                    //$token = $nuevoUsuario->createToken('myapptoken')->plainTextToken;
                    //var_dump($token); die();
                    $response = [
                        'estado' => true,
                        'mensaje' => 'Se registro correctamente',
                        'usuario' => $nuevoUsuario,
                        //'token' => $token
                    ];
                }else{
                    $response = [
                        'estado' => false,
                        'mensaje' => 'No se puede guardar el usuario',
                        'usuario' => null
                    ];
                }
            }
        }
        return response()->json($response);
    }

    public function cerrarSesion(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        //$request->user()->token()->revoke();

        $response = [
            'estado' => true,
            'mensaje' => 'ha cerrado la sesion'
        ];
        return response()->json($response);
    }

    public function iniciarSesion(Request $request)
    {
        $usuarioRequest = (object)$request->usuario;
        $response = [];

        if($usuarioRequest){
            $usuario = User::where('email', $usuarioRequest->email)->first();

            if($usuario){
                if (Hash::check($usuarioRequest->password, $usuario->password)) {
                    //token
                    $token = $usuario->createToken('myapptoken')->plainTextToken;

                    $cargo = $usuario->rol->cargo;
                    
                    $response = [
                        'estado' => true,
                        'mensaje' => 'Bienvenido '. $usuario->name,
                        'usuario' => $usuario,
                        'rol' => $cargo,
                        'token' => $token
                    ];
                }else{
                    $response = [
                        'estado' => false,
                        'mensaje' => 'Contraseña Incorrecta'
                    ];
                }
            }else{
                $response = [
                    'estado' => false,
                    'mensaje' => 'El correo no existe !!'
                ];
            }
        }else{
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para procesar'
            ];
        }
        return response()->json($response);
    }

    /* public function cerrarSesion2()
    {
        // eliminar todos los tokens...
        auth()->user()->tokens()->delete();

        $response = [
            'status' => true,
            'mensaje' => 'ha cerrado la sesion'
        ];

        return response()->json($response);
        // Eliminar un token especifico...
        //$user->tokens()->where('id', $tokenId)->delete();
    } */


    

}
