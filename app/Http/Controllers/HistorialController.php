<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ValidacionFamiliar;
use App\Models\Historial;
use App\Models\Medicamento;
use App\Persona;
use DateTime;
use Illuminate\Support\Facades\Auth;

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

        $medicamentos = Medicamento::orderBy('nombre', 'asc')->distinct()->pluck('nombre');

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

        if($request->alergias){
            $historia->alergias = json_encode($request->alergias);
            $historia->save();
        }

        return view("formularios.opciones.index")
        ->with('persona', $persona);
    }

    public function form_familiares($id){
        //carga el formulario para agregar un nueva persona

        // if(\Auth::user()->isRole('registrador')==false && \Auth::user()->isRole('admin')==false && \Auth::user()->isRole('responsable_circunscripcion')==false){
        //     return view("mensajes.mensaje_error")->with("msj",'<div class="box box-danger col-xs-12"><div class="rechazado" style="margin-top:70px; text-align: center">    <span class="label label-success">#!<i class="fa fa-check"></i></span><br/>  <label style="color:#177F6B">  Acceso restringido </label>   </div></div> ') ;
        // }
        
        $personas = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_parent', $id)
        ->get();

        return view("formularios.historial.form_familiares")
        ->with('personas', $personas);
    }

    public function guardar_familiares(ValidacionFamiliar $request){
        $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));

        $familiar=new Persona;
                                
        $familiar->nombre=ucwords(strtolower($request->input("nombre")));
        $familiar->paterno=ucwords(strtolower($request->input("paterno")));
        $familiar->materno=ucwords(strtolower($request->input("materno")));
        $familiar->telefono_celular=$request->input("telefono_celular");
        $familiar->cedula_identidad=$tiempo_actual->getTimestamp();
        $familiar->id_parent=Auth::user()->id_persona;
        $familiar->parentesco=ucwords(strtolower($request->input("parentesco")));

        $familiar->save();

        $persona = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_persona', Auth::user()->id_persona)
        ->get();


        return view("formularios.opciones.index")
        ->with('persona', $persona);
    }

    public function form_recetas($id){
        //carga el formulario para agregar un nueva persona

        // if(\Auth::user()->isRole('registrador')==false && \Auth::user()->isRole('admin')==false && \Auth::user()->isRole('responsable_circunscripcion')==false){
        //     return view("mensajes.mensaje_error")->with("msj",'<div class="box box-danger col-xs-12"><div class="rechazado" style="margin-top:70px; text-align: center">    <span class="label label-success">#!<i class="fa fa-check"></i></span><br/>  <label style="color:#177F6B">  Acceso restringido </label>   </div></div> ') ;
        // }
        
        $historia = Historial::where('id_persona', $id)->first();

        $recetas  = json_decode($historia->recetas);

        $persona = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_persona', $id)
        ->get();

        $medicamentos = Medicamento::orderBy('nombre', 'asc')->distinct()->pluck('nombre');

        return view("formularios.historial.form_recetas")
        ->with('persona', $persona)
        ->with('historia', $historia)
        ->with('recetas', $recetas)
        ->with('medicamentos', $medicamentos);
    }

    public function guardar_recetas(Request $request){
        $historia = Historial::find($request->id_historial);

        $persona = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_persona', $historia->id_persona)
        ->get();

        if($request->recetas){
            $historia->recetas = json_encode($request->recetas);
            $historia->save();
        }

        return view("formularios.opciones.index")
        ->with('persona', $persona);
    }

}
