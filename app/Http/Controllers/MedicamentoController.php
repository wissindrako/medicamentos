<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Medicamento;

class MedicamentoController extends Controller
{
    public function index(){
        // $medicamentos = Medicamento::orderBy('nombre', 'asc')->distinct()->pluck('nombre');
        $medicamentos = Medicamento::all();

         return view('formularios.medicamentos.index', compact('medicamentos'));
    }

    public function form_agregar_medicamento(){

        $medicamentos = Medicamento::all();
        $impactos = Medicamento::orderBy('efectos', 'asc')->distinct()->pluck('efectos');
        
         return view('formularios.medicamentos.form_agregar_medicamento', compact('medicamentos', 'impactos'));
    }

    public function guardar_medicamento (Request $request){

        $medicamento=new Medicamento;
                                
        $medicamento->nombre=ucwords(strtolower($request->input("nombre")));
        if($request->impacto == 'Efecto'){
            $medicamento->efectos='Efecto Secundario';
        }else{
            $medicamento->efectos=$request->input("impacto");
        }
        $medicamento->conclusion=$request->input("conclusion");
        $medicamento->meta=$request->input("meta");
        if($medicamento->save()){
            $medicamentos = Medicamento::all();

            return view('formularios.medicamentos.index', compact('medicamentos'));
        }else{
            return view("mensajes.mensaje_error")->with("msj","...Hubo un error al agregar ;...") ;
        }
    }

}
