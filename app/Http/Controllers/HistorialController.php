<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Historial;
use App\Models\Medicamento;
use App\Persona;

class HistorialController extends Controller
{
    public function form_antecedentes($id){
        //carga el formulario para agregar un nueva persona

        // if(\Auth::user()->isRole('registrador')==false && \Auth::user()->isRole('admin')==false && \Auth::user()->isRole('responsable_circunscripcion')==false){
        //     return view("mensajes.mensaje_error")->with("msj",'<div class="box box-danger col-xs-12"><div class="rechazado" style="margin-top:70px; text-align: center">    <span class="label label-success">#!<i class="fa fa-check"></i></span><br/>  <label style="color:#177F6B">  Acceso restringido </label>   </div></div> ') ;
        // }
        
        $historia = Historial::where('id_persona', $id)->first();

        $antecedentes  = json_decode($historia->antecedentes);

        $persona = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_persona', $id)
        ->get();

        return view("formularios.historial.form_antecedente")
        ->with('persona', $persona)
        ->with('historia', $historia)
        ->with('antecedentes', $antecedentes);
    }

    public function guardar_antecedentes(Request $request){
        $historia = Historial::find($request->id_historial);

        $persona = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_persona', $historia->id_persona)
        ->get();

        $historia->antecedentes = json_encode($request->except(['_token', 'id_historial']));
        $historia->save();

        return view("formularios.opciones.index")
        ->with('persona', $persona);

    }

    public function form_enfermedades($id){
        //carga el formulario para agregar un nueva persona

        // if(\Auth::user()->isRole('registrador')==false && \Auth::user()->isRole('admin')==false && \Auth::user()->isRole('responsable_circunscripcion')==false){
        //     return view("mensajes.mensaje_error")->with("msj",'<div class="box box-danger col-xs-12"><div class="rechazado" style="margin-top:70px; text-align: center">    <span class="label label-success">#!<i class="fa fa-check"></i></span><br/>  <label style="color:#177F6B">  Acceso restringido </label>   </div></div> ') ;
        // }
        
        $historia = Historial::where('id_persona', $id)->first();

        $enfermedades  = json_decode($historia->enfermedades);

        $persona = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_persona', $id)
        ->get();

        return view("formularios.historial.form_enfermedades")
        ->with('persona', $persona)
        ->with('historia', $historia)
        ->with('enfermedades', $enfermedades);
    }

    public function guardar_enfermedades(Request $request){
        $historia = Historial::find($request->id_historial);

        $persona = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_persona', $historia->id_persona)
        ->get();

        $historia->enfermedades = json_encode($request->except(['_token', 'id_historial']));
        $historia->save();

        return view("formularios.opciones.index")
        ->with('persona', $persona);

    }

    public function form_alergias($id){
        //carga el formulario para agregar un nueva persona

        // if(\Auth::user()->isRole('registrador')==false && \Auth::user()->isRole('admin')==false && \Auth::user()->isRole('responsable_circunscripcion')==false){
        //     return view("mensajes.mensaje_error")->with("msj",'<div class="box box-danger col-xs-12"><div class="rechazado" style="margin-top:70px; text-align: center">    <span class="label label-success">#!<i class="fa fa-check"></i></span><br/>  <label style="color:#177F6B">  Acceso restringido </label>   </div></div> ') ;
        // }
        
        $historia = Historial::where('id_persona', $id)->first();

        $alergias  = json_decode($historia->alergias);

        $persona = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_persona', $id)
        ->get();

        $medicamentos = Medicamento::all();

        return view("formularios.historial.form_alergias")
        ->with('persona', $persona)
        ->with('historia', $historia)
        ->with('alergias', $alergias)
        ->with('medicamentos', $medicamentos);
    }

    public function guardar_alergias(Request $request){
        $historia = Historial::find($request->id_historial);

        $persona = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_persona', $historia->id_persona)
        ->get();

        $historia->alergias = json_encode($request->alergias);
        $historia->save();

        return view("formularios.opciones.index")
        ->with('persona', $persona);

    }

}
