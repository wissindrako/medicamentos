<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Historial;
use App\Models\Medicamento;
use App\Persona;

class ExpertoController extends Controller
{
    public function index($id){
        //carga el formulario para agregar un nueva persona

        // if(\Auth::user()->isRole('registrador')==false && \Auth::user()->isRole('admin')==false && \Auth::user()->isRole('responsable_circunscripcion')==false){
        //     return view("mensajes.mensaje_error")->with("msj",'<div class="box box-danger col-xs-12"><div class="rechazado" style="margin-top:70px; text-align: center">    <span class="label label-success">#!<i class="fa fa-check"></i></span><br/>  <label style="color:#177F6B">  Acceso restringido </label>   </div></div> ') ;
        // }
        
        
        $paciente = Persona::findOrFail($id);
        $historia = Historial::where('id_persona', $paciente->id_persona)->first();
        $antecedentes = [];
        $enfermedades = [];
        $alergias = [];
        $recetas = [];
        $familiares = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_parent', $id)
        ->get();

        if($historia){
            if ($historia->antecedentes) {$antecedentes = json_decode($historia->antecedentes);}
            if ($historia->enfermedades) {$enfermedades = json_decode($historia->enfermedades);}
            if ($historia->alergias) {$alergias = json_decode($historia->alergias);}
            if ($historia->recetas) {$recetas = json_decode($historia->recetas);}
        }
        // return view('admin.user.editar', compact('data', 'roles'));
        return view('formularios.sistema_experto.index', compact('paciente', 'antecedentes', 'enfermedades', 'alergias', 'recetas', 'familiares'));
    }
    
    public function form_opciones($id){
        //carga el formulario para agregar un nueva persona

        // if(\Auth::user()->isRole('registrador')==false && \Auth::user()->isRole('admin')==false && \Auth::user()->isRole('responsable_circunscripcion')==false){
        //     return view("mensajes.mensaje_error")->with("msj",'<div class="box box-danger col-xs-12"><div class="rechazado" style="margin-top:70px; text-align: center">    <span class="label label-success">#!<i class="fa fa-check"></i></span><br/>  <label style="color:#177F6B">  Acceso restringido </label>   </div></div> ') ;
        // }
        
        $persona = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_persona', $id)
        ->get();

        return view("formularios.opciones.index")
        ->with('persona', $persona);
    }

    public function motorInferencia($id, $datos){
        // if(\Auth::user()->isRole('registrador')==false && \Auth::user()->isRole('admin')==false && \Auth::user()->isRole('responsable_circunscripcion')==false){
        //     return view("mensajes.mensaje_error")->with("msj",'<div class="box box-danger col-xs-12"><div class="rechazado" style="margin-top:70px; text-align: center">    <span class="label label-success">#!<i class="fa fa-check"></i></span><br/>  <label style="color:#177F6B">  Acceso restringido </label>   </div></div> ') ;
        // }
        $paciente = Persona::findOrFail($id);
        $historia = Historial::where('id_persona', $paciente->id_persona)->first();
        $antecedentes = [];
        $enfermedades = [];
        $alergias = [];
        $recetas = [];

        $resultados = array();

        //HISTORIA CLINICA

        if($historia){
            if ($historia->antecedentes) {$antecedentes = json_decode($historia->antecedentes, true);}
            else{
                $e = array();
                $e['premisa'] = 'Si: los antecedentes del paciente no están registrados';
                $e['conclusion'] = 'Se recomienda actualizar Hisoria Clínica, para obtener mejores resultados';
                array_push($resultados, $e);
            }
            if ($historia->enfermedades) {$enfermedades = array_keys(json_decode($historia->enfermedades, true));}
            else{
                $e = array();
                $e['premisa'] = 'Si: las enfermedades del paciente no están registradas';
                $e['conclusion'] = 'Se recomienda actualizar Hisoria Clínica, para obtener mejores resultados';
                array_push($resultados, $e);
            }
            if ($historia->alergias) {$alergias = json_decode($historia->alergias);}
            else{
                $e = array();
                $e['premisa'] = 'Si: las alergias del paciente no están registradas';
                $e['conclusion'] = 'Se recomienda actualizar Hisoria Clínica, para obtener mejores resultados';
                array_push($resultados, $e);
            }
            if ($historia->recetas) {$recetas = json_decode($historia->recetas);}
            else{$recetas = [];}

        }

        $arr_antecedentes = array_keys($antecedentes);
        $arr_enfermedades = $enfermedades;
        $arr_alergias = $alergias;
        $arr_recetas = $recetas;

        // dd($arr_antecedentes);

        // $medicamentos = Medicamento::orderBy('efectos', 'asc')->distinct()->pluck('efectos');
        $efectos = Medicamento::orderBy('efectos', 'asc')->distinct()->pluck('efectos');

        $medicamentos = Medicamento::where('nombre', $datos);

        // $medicamentos = $medicamentos->where('meta', 'like', '%leve%')->get();

        // dd($medicamentos->get());
        // dd($medicamentos);

        // $arr_antecedentes = [array('dolor','dolsdafaor','astenia')];
        
        if(count($medicamentos->get()) > 0){

            //ANTECEDENTES

            foreach ($arr_antecedentes as $value) {
                $medicamentos = Medicamento::where('nombre', $datos);
                // $data = $medicamentos->where('meta', 'like', '%dolor%')->first();
                $data = $medicamentos->where('meta', 'like', '%'.$value.'%')->first();
                // dd($data);
                if($data){
                    $e = array();
                    $e['premisa'] = 'El medicamento: '.$data->nombre.' presenta "'.$data->efectos.'"';
                    $e['conclusion'] = $data->conclusion.' por presencia de "'.$value.'" en sus antecedentes registrados en su Historia Clínica.';
                    array_push($resultados, $e);
                }
            }

            //ENFERMEDADES
            
            foreach ($arr_enfermedades as $value) {
                $medicamentos = Medicamento::where('nombre', $datos);
                // $data = $medicamentos->where('meta', 'like', '%dolor%')->first();
                $data = $medicamentos->where('meta', 'like', '%'.$value.'%')->first();
                // dd($data);
                if($data){
                    $e = array();
                    $e['premisa'] = 'El medicamento: '.$data->nombre.' presenta "'.$data->efectos.'"';
                    $e['conclusion'] = $data->conclusion.' por presencia de "'.$value.'" en sus falencias registradas en su Historia Clínica.';
                    array_push($resultados, $e);
                }
                
            }

            //ALERGIAS
            
            foreach ($arr_alergias as $value) {
                $medicamentos = Medicamento::where('nombre', $datos);
                // $data = $medicamentos->where('meta', 'like', '%dolor%')->first();
                $data = $medicamentos->where('nombre', 'like', '%'.$value.'%')->first();
                // dd($data);
                if($data){
                    $e = array();
                    $e['premisa'] = 'El medicamento: '.$data->nombre.' presenta "Interacciones"';
                    $e['conclusion'] = $data->conclusion.' por presencia de "'.$value.'" en sus alergias registradas en su Historia Clínica.';
                    array_push($resultados, $e);
                }
                
            }

            //RECETAS

            foreach ($arr_recetas as $value) {
                $medicamentos = Medicamento::where('nombre', $datos);
                // $data = $medicamentos->where('meta', 'like', '%dolor%')->first();
                $data = $medicamentos->where('nombre', 'like', '%'.$value.'%')->first();
                // dd($data);
                if($data){
                    $e = array();
                    $e['premisa'] = 'El medicamento: '.$data->nombre.' se encuentra en los medicamentos que consume';
                    $e['conclusion'] = 'Su administración podría causar "Sobredosis" si aumenta el tiempo y cantidad recomendada por su Médico.';
                    array_push($resultados, $e);
                }
                
            }
            // dd($arr_recetas);

            foreach ($arr_recetas as $value) {
                // $medicamentos = Medicamento::all();
                // $data = $medicamentos->where('meta', 'like', '%dolor%')->first();
                $meta = Medicamento::where('meta', 'like', '%'.$value.'%')->get();

                foreach ($meta as $key => $data) {
                    if($data){
                        $e = array();
                        $e['premisa'] = 'El medicamento: '.$data->nombre.' presenta "'.$data->efectos.'"';
                        $e['conclusion'] = $data->conclusion.' por presencia de "'.$value.'" en los medicamentos que consume según su Historia Clínica.';
                        array_push($resultados, $e);
                    }
                }
                
            }
            

        }

        // $antecedentes_medicamentos = Medicamento::where('meta', 'like', '%'.$datos.'%')->get();

        //CONTRAINDICACIONES

        // $contraindicaciones = Medicamento::where('nombre', $datos)
        // ->where('efectos', 'Contraindicaciones');

        // dd($contraindicaciones->get());

        // if(count($contraindicaciones->get()) > 0){

        //     foreach ($arr_antecedentes as $value) {
        //         $contraindicaciones = Medicamento::where('nombre', $datos)
        //         ->where('efectos', 'Efecto Secundario');
        //         // $data = $contraindicaciones->where('meta', 'like', '%dolor%')->first();
        //         $data = $contraindicaciones->where('meta', 'like', '%'.$value.'%')->first();
        //         // dd($data);
        //         if($data){
        //             $e = array();
        //             $e['premisa'] = 'El medicamento: '.$data->nombre.' presenta "'.$data->efectos.'".';
        //             $e['conclusion'] = $data->conclusion.' por presencia de '.$value.' en sus antecedentes';
        //             array_push($resultados, $e);
        //         }

        //     }
        // }

        // dd($arr_antecedentes);
        // $antecedentes_medicamentos = \DB::Table('medicamentos')
        //         ->select('nombre', 'efectos', 'conclusion', 'meta')                
        //         ->Where(function ($query) use($arr_antecedentes) {
        //             for ($i = 0; $i < count($arr_antecedentes); $i++){
        //                 $query->orwhere('meta', 'like',  '%' . $arr_antecedentes[$i] .'%');
        //             }      
        //         })->get();
        // $pacientes = array();

        // foreach ($paciente as $key => $value) {
            // $e = array();

            // $e['id'] = $paciente->id_persona;
            // $e['nombre'] = $paciente->nombre;
            // $e['materno'] = $paciente->paterno;
            // $e['paterno'] = $paciente->materno;
            // array_push($pacientes, $e);
        // }

        // dd($paciente);

        return json_encode($resultados);
    }

}
