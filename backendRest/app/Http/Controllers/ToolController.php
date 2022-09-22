<?php

namespace App\Http\Controllers;

//use App\Models\Empresa;

use App\Models\Empresa;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class ToolController extends Controller
{
    public function verImagen($folder,$file){
        $existe = Storage::disk($folder)->exists($file);

        if($existe){
            $archivo = Storage::disk($folder)->get($file);
               return new Response($archivo, 200);
        }else{
            $data = [
                'estado' => false,
                'mensaje' => 'Imagen no existe',
                'error' => 404
            ];
        }
        return response()->json($data);
    }

    public function uploadFile(Request $request){

        $request->file('imgEmpresa')->store('empresas');

        $response = [
            'estado' => true,
            //'img' => $filenametostore,
            'mensaje' => 'La imagen se ha subido al servidor'
        ];
        return response()->json($response);

       /*  $request->file('imgEmpresa')->store('public');
        dd("subido y guardado"); */

        /* $this->validate($request,[
            'img' => 'required|image|mimes:jpg,png,jpeg|max:5000'
        ]); */

        /* if ($files = $request->file('imgEmpresa')) {
            // Define upload path
            $destinationPath = public_path('/public/'); // upload path
            // Upload Orginal Image           
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profileImage);

            $insert['image'] = "$profileImage";
        }
        return back()->with('success', 'Image Upload successfully'); */

        /* if($request->hasFile('imgEmpresa')){

            $imagen = $request->file('imgEmpresa');

            $filenamewithextension = $imagen->getClientOriginalName();   //Archivo con su extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);                //Sin extension
            $extension = $request->file('imgEmpresa')->getClientOriginalExtension();    //Obtener extesion de archivo
            $filenametostore = $filename.'_'.uniqid().'.'.$extension;

            Storage::disk('public')->put($filenametostore, fopen($request->file('imgEmpresa'), 'r+'));

            $response = [
                'estado' => true,
                'img' => $filenametostore,
                'mensaje' => 'La imagen se ha subido al servidor'
            ];
        }else{
            $response = [
                'estado' => false,
                'img' => '',
                'mensaje' => 'No hay un archivo para procesar'
            ];
        }

        return response()->json($response); */
    } 

}

