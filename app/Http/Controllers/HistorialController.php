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
        // Mostrar el formulario para llenar antecedentes
        
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
        // Guardando los datos del formulario antecedentes
        $historia = Historial::find($request->id_historial);

        $persona = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_persona', $historia->id_persona)
        ->get();

        $historia->antecedentes = json_encode($request->except(['_token', 'id_historial']));
        $historia->save();

        $paciente = Persona::findOrFail($historia->id_persona);
        $antecedentes = [];
        $enfermedades = [];
        $alergias = [];
        $recetas = [];
        $familiares = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_parent', $historia->id_persona)
        ->get();
        if ($historia->antecedentes) {$antecedentes = json_decode($historia->antecedentes);}
        if ($historia->enfermedades) {$enfermedades = json_decode($historia->enfermedades);}
        if ($historia->alergias) {$alergias = json_decode($historia->alergias);}
        if ($historia->recetas) {$recetas = json_decode($historia->recetas);}

        return view("formularios.opciones.index")
        ->with('persona', $persona)
        ->with('paciente', $paciente)
        ->with('familiares', $familiares)
        ->with('antecedentes', $antecedentes)
        ->with('enfermedades', $enfermedades)
        ->with('alergias', $alergias)
        ->with('recetas', $recetas);

    }

    public function form_enfermedades($id){
        // Mostrar el formulario para llenar enfermedades
        
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
        // Guardando los datos del formulario enfermedades
        $historia = Historial::find($request->id_historial);

        $persona = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_persona', $historia->id_persona)
        ->get();

        $historia->enfermedades = json_encode($request->except(['_token', 'id_historial']));
        $historia->save();

        $paciente = Persona::findOrFail($historia->id_persona);
        $antecedentes = [];
        $enfermedades = [];
        $alergias = [];
        $recetas = [];
        $familiares = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_parent', $historia->id_persona)
        ->get();
        if ($historia->antecedentes) {$antecedentes = json_decode($historia->antecedentes);}
        if ($historia->enfermedades) {$enfermedades = json_decode($historia->enfermedades);}
        if ($historia->alergias) {$alergias = json_decode($historia->alergias);}
        if ($historia->recetas) {$recetas = json_decode($historia->recetas);}

        return view("formularios.opciones.index")
        ->with('persona', $persona)
        ->with('paciente', $paciente)
        ->with('familiares', $familiares)
        ->with('antecedentes', $antecedentes)
        ->with('enfermedades', $enfermedades)
        ->with('alergias', $alergias)
        ->with('recetas', $recetas);

    }

    public function form_alergias($id){
        // Mostrar el formulario para llenar alergias
        
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
        // Guardando los datos del formulario alergias
        $historia = Historial::find($request->id_historial);

        $persona = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_persona', $historia->id_persona)
        ->get();

        if($request->alergias){
            $historia->alergias = json_encode($request->alergias);
            $historia->save();
        }else{
            $historia->alergias = NULL;
            $historia->save();
        }

        $paciente = Persona::findOrFail($historia->id_persona);
        $antecedentes = [];
        $enfermedades = [];
        $alergias = [];
        $recetas = [];
        $familiares = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_parent', $historia->id_persona)
        ->get();
        if ($historia->antecedentes) {$antecedentes = json_decode($historia->antecedentes);}
        if ($historia->enfermedades) {$enfermedades = json_decode($historia->enfermedades);}
        if ($historia->alergias) {$alergias = json_decode($historia->alergias);}
        if ($historia->recetas) {$recetas = json_decode($historia->recetas);}

        return view("formularios.opciones.index")
        ->with('persona', $persona)
        ->with('paciente', $paciente)
        ->with('familiares', $familiares)
        ->with('antecedentes', $antecedentes)
        ->with('enfermedades', $enfermedades)
        ->with('alergias', $alergias)
        ->with('recetas', $recetas);

    }

    public function form_familiares($id){
        // Mostrar el formulario para llenar familiares
        
        $personas = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_parent', $id)
        ->get();
        
        $id_paciente = $id;

        return view("formularios.historial.form_familiares")
        ->with('personas', $personas)
        ->with('id_paciente', $id_paciente);
    }

    public function guardar_familiares(ValidacionFamiliar $request){
        // Guardando los datos del formulario familiares
        $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));

        $familiar=new Persona;
                                
        $familiar->nombre=ucwords(strtolower($request->input("nombre")));
        $familiar->paterno=ucwords(strtolower($request->input("paterno")));
        $familiar->materno=ucwords(strtolower($request->input("materno")));
        $familiar->telefono_celular=$request->input("telefono_celular");
        $familiar->cedula_identidad=$tiempo_actual->getTimestamp();
        $familiar->id_parent=$request->id_paciente;
        $familiar->parentesco=ucwords(strtolower($request->input("parentesco")));

        $familiar->save();

        $historia = Historial::where('id_persona', $request->id_paciente)->first();

        $persona = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_persona', $request->id_paciente)
        ->get();

        $paciente = Persona::findOrFail($historia->id_persona);
        $antecedentes = [];
        $enfermedades = [];
        $alergias = [];
        $recetas = [];
        $familiares = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_parent', $historia->id_persona)
        ->get();
        if ($historia->antecedentes) {$antecedentes = json_decode($historia->antecedentes);}
        if ($historia->enfermedades) {$enfermedades = json_decode($historia->enfermedades);}
        if ($historia->alergias) {$alergias = json_decode($historia->alergias);}
        if ($historia->recetas) {$recetas = json_decode($historia->recetas);}

        return view("formularios.opciones.index")
        ->with('persona', $persona)
        ->with('paciente', $paciente)
        ->with('familiares', $familiares)
        ->with('antecedentes', $antecedentes)
        ->with('enfermedades', $enfermedades)
        ->with('alergias', $alergias)
        ->with('recetas', $recetas);

    }

    public function form_recetas($id){
        // Mostrar el formulario para llenar los medicamentos que consume el paciente
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
        // Guardando los datos del formulario recetas
        $historia = Historial::find($request->id_historial);

        $persona = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_persona', $historia->id_persona)
        ->get();

        if($request->recetas){
            $historia->recetas = json_encode($request->recetas);
            $historia->save();
        }

        $paciente = Persona::findOrFail($historia->id_persona);
        $antecedentes = [];
        $enfermedades = [];
        $alergias = [];
        $recetas = [];
        $familiares = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_parent', $historia->id_persona)
        ->get();
        if ($historia->antecedentes) {$antecedentes = json_decode($historia->antecedentes);}
        if ($historia->enfermedades) {$enfermedades = json_decode($historia->enfermedades);}
        if ($historia->alergias) {$alergias = json_decode($historia->alergias);}
        if ($historia->recetas) {$recetas = json_decode($historia->recetas);}

        return view("formularios.opciones.index")
        ->with('persona', $persona)
        ->with('paciente', $paciente)
        ->with('familiares', $familiares)
        ->with('antecedentes', $antecedentes)
        ->with('enfermedades', $enfermedades)
        ->with('alergias', $alergias)
        ->with('recetas', $recetas);

    }

    public function form_borrado_medico_cabecera($id){
        // Mostrar el formulario para quitar el medico asignado a un paciente determinado
        $paciente = Persona::where('id_persona', $id)->first();

        return view("confirmaciones.form_borrado_medico_cabecera")
        ->with('paciente', $paciente);
    }

    public function borrar_medico_cabecera(Request $request){
        // Quitar el medico asignado a un determinado paciente
        $id_paciente=$request->input("id_persona");
        $paciente=Persona::findOrFail($id_paciente);
        $paciente->id_medico = 0;
    
        if($paciente->save()){
             return view("mensajes.msj_medico_asignado_borrado")->with("msj","Medico de paciente actualizado Correctamente") ;
        }
        else
        {
            return view("mensajes.mensaje_error")->with("msj","..Hubo un error al agregar ; intentarlo nuevamente..");
        }

    }

}
