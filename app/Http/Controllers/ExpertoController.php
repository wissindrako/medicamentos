<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Persona;

class ExpertoController extends Controller
{
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

}
