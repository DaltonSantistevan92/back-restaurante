<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;


class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listar()
    {
        $empresa = Empresa::where('estado','A')->get();
        $response = [];
        if($empresa->count() > 0){
            $response = [
                'estado' => true,
                'mensaje' => 'existen datos',
                'empresa' => $empresa
            ];
        }else{
            $response = [
                'estado' => false,
                'mensaje' => 'no existen datos',
                'empresa' => []
            ];
        }
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $request)
    {
        $empresaRequest = (object)$request->empresa;
        $response = [];
 
        if($empresaRequest){
            if($empresaRequest->nombre == null){
                $response = [
                    'estado' => false,
                    'mensaje' => 'Ingrese un nombre',
                ];
            }else{
                $existeEmpresa = Empresa::where('nombre',$empresaRequest->nombre)->get()->first();
                if($existeEmpresa){
                    $response = [
                        'estado' => false,
                        'mensaje' => 'El nombre de la empresa ya existe',
                    ];
                }else{
                    $nuevaEmpresa = new Empresa();
                    $nuevaEmpresa->user_id = intval($empresaRequest->user_id);
                    $nuevaEmpresa->nombre = ucfirst($empresaRequest->nombre);
                    $nuevaEmpresa->descripcion = $empresaRequest->descripcion;
                    $nuevaEmpresa->img = $empresaRequest->img;
                
                    if($nuevaEmpresa->save()){
                        $response = [
                            'estado' => true,
                            'mensaje' => 'La empresa se guardo correctamente',
                            'empresa' =>  $nuevaEmpresa
                        ];
                    }else{
                        $response = [
                            'estado' => false,
                            'mensaje' => 'La empresa no se puede guardar',
                            'empresa' =>  null
                        ];
                    }
                }
            }
        }else{
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para procesar',
                'empresa' =>  null
            ];
        }
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verId($id)
    {
        $id = intval($id);
        $empresa = Empresa::find($id);

        if($empresa){
            $response = [
                'estado' => true,
                'mensaje' => 'Existen datos',
                'empresa' => $empresa
            ];
        }else{
            $response = [
                'estado' => false,
                'mensaje' => 'No existen datos',
                'empresa' => null
            ];
        }
        return response()->json($response); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request, $id)
    {

        $empresaRequest = (object)$request->empresa;
        $response = [];
       
        $id = intval($id);
        $empresa = Empresa::find($id);

        if($empresaRequest){
            if($empresa){
                $empresa->nombre = ucfirst($empresaRequest->nombre);
                $empresa->descripcion = $empresaRequest->descripcion;

                if($empresa->save()){
                    $response = [
                        'estado' => true,
                        'mensaje' => 'Se actualizó correctamente',
                        'empresa' =>  $empresa
                    ];
                }else{
                    $response = [
                        'estado' => false,
                        'mensaje' => 'No se puede actualizar',
                        'empresa' =>  null
                    ];
                }
            }
        }else{
            $response = [
                'estado' => false,
                'mensaje' => 'No hay datos para procesar',
                'empresa' =>  null
            ];
        }
        return response()->json($response);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eliminar($id)
    {
        $empresa = Empresa::find(intval($id));
        $response = [];

        if($empresa->delete()){
            $response = [
                'estado' => true,
                'mensaje' => 'La empresa se elimino correctamente'
            ];
        }else{
            $response = [
                'estado' => false,
                'mensaje' => 'La empresa no se puede eliminar',
            ];
        }
        return response()->json($response);
    }

    public function buscar($texto)
    {   
        $empresa = Empresa::where('nombre','like','%' . $texto . '%')->get();

        if($empresa->count() > 0){
            $response = [
                'estado' => true,
                'mensaje' => 'existen concidencias',
                'empresa' => $empresa
            ];
        }else{
            $response = [
                'estado' => false,
                'mensaje' => 'No existe',
                'empresa' => null
            ];
        }
        return response()->json($response);
    }

    public function reporte($fechaInicio, $fechaFin){

        $empresas = Empresa::whereDate('created_at','>=',$fechaInicio)
                            ->whereDate('updated_at','<=',$fechaFin)
                            ->where('estado','A')->get();
        $response = []; 

        if($empresas->count() > 0){
            $response = [
                'estado' => true,
                'mensaje' => 'existen datos',
                'empresa' => $empresas
            ];
        }else{
            $response = [
                'estado' => false,
                'mensaje' => 'No existen datos',
                'empresa' => []
            ];
        }
        return response()->json($response);
    }
}
