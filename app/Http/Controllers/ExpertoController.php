<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Historial;
use App\Models\Medicamento;
use App\Persona;
use Illuminate\Support\Arr;

class ExpertoController extends Controller
{

    public function index($id){
        //Carga el formulario de consulta del Sistema Experto
        // Datos Personales 
        // Historia Clínica
        // Experto
                
        $persona = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_persona', $id)
        ->get();
       
        $paciente = Persona::findOrFail($id);
        $medico = Persona::findOrFail($paciente->id_medico);
        $historia = Historial::where('id_persona', $paciente->id_persona)->first();
        $antecedentes = [];
        $enfermedades = [];
        $alergias = [];
        $recetas = [];
        $familiares = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_parent', $id)
        ->get();

        $medicamentos = Medicamento::orderBy('nombre', 'asc')->distinct()->pluck('nombre');

        if($historia){
            if ($historia->antecedentes) {$antecedentes = json_decode($historia->antecedentes);}
            if ($historia->enfermedades) {$enfermedades = json_decode($historia->enfermedades);}
            if ($historia->alergias) {$alergias = json_decode($historia->alergias);}
            if ($historia->recetas) {$recetas = json_decode($historia->recetas);}
        }

        return view('formularios.sistema_experto.index', 
        compact(
            'persona', 'paciente', 'medico', 'antecedentes', 'enfermedades', 'alergias', 'recetas', 'familiares', 'medicamentos'
        ));
    }
    
    public function form_opciones($id){
        //Carga el formulario para el llenado de Opciones de la Historia Clínica
        
        $persona = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_persona', $id)
        ->get();

        $paciente = Persona::findOrFail($id);
        $medico = Persona::find($paciente->id_medico);
        $historia = Historial::where('id_persona', $paciente->id_persona)->first();
        $antecedentes = [];
        $enfermedades = [];
        $alergias = [];
        $recetas = [];
        $familiares = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_parent', $id)
        ->get();

        $medicamentos = Medicamento::orderBy('nombre', 'asc')->distinct()->pluck('nombre');

        if($historia){
            if ($historia->antecedentes) {$antecedentes = json_decode($historia->antecedentes);}
            if ($historia->enfermedades) {$enfermedades = json_decode($historia->enfermedades);}
            if ($historia->alergias) {$alergias = json_decode($historia->alergias);}
            if ($historia->recetas) {$recetas = json_decode($historia->recetas);}
        }

        return view("formularios.opciones.index", 
        compact(
            'persona', 'paciente', 'medico', 'antecedentes', 'enfermedades', 'alergias', 'recetas', 'familiares', 'medicamentos'
        ));
    }

    public function motorInferencia($id, $datos){

        //RESULTADOS DEL MOTOR DE INFERENCIA

        // Definiendo grado de respuesta al medicamento
        $grado_alto = 2;
        $grado_medio = 1;
        $grado_bajo = 0;

        //Premisas Antecedentes
        $p_antecedentes_1 = 'El registro de antecedentes permite buscar, efectos secundarios, contraindicaciones y otras interacciones con los medicamentos';
        $p_antecedentes_2 = 'Si alguno de los antecedentes interactua con los medicamentos, podrían ocasionar efectos secundarios, contraindicaciones e interacciones';

        $p_enfermedades_1 = 'El registro de falencias permite buscar, efectos secundarios, contraindicaciones y otras interacciones con los medicamentos';
        $p_enfermedades_2 = 'Si alguna de las enfermedades interactua con los medicamentos, podrían ocasionar efectos secundarios, contraindicaciones e interacciones';

        $p_alergias_1 = 'El registro de alergias permite buscar, efectos secundarios, contraindicaciones y otras interacciones con los medicamentos';
        $p_alergias_2 = 'Si alguna de las alergias interactua con el nuevo medicamento, podría ocasionar efectos secundarios, contraindicaciones e interacciones';

        $p_recetas_1 = 'El registro de medicamentos en consumo permite buscar, efectos secundarios, contraindicaciones y otras interacciones con los medicamentos';
        $p_recetas_2 = 'Si alguno de los medicamentos que consume interactua con el nuevo medicamento, podría ocasionar efectos secundarios, contraindicaciones, sobredosis e interacciones';

        $p_final = 'El medicamento puede contraer interacciones respecto a la Historia Clinica del paciente.';


        //Obteniendo el paciente o adulto mayor actual
        $paciente = Persona::findOrFail($id);

        //Obteniendo su Historial Clínico
        $historia = Historial::where('id_persona', $paciente->id_persona)->first();

        // Creando variables para el Historial
        $antecedentes = [];
        $enfermedades = [];
        $alergias = [];
        $recetas = [];

        // Creando variable para el resultado final
        $resultados = array();

        //INFERENCIA SOBRE HISTORIA CLINICA

        if($historia){
            //Verificando si existen antecedentes
            if ($historia->antecedentes) {$antecedentes = json_decode($historia->antecedentes, true);}
            else{
                $e = array();
                $e['premisa'] = $p_antecedentes_1;
                $e['resultado'] = 'No hay registro de antecedentes';
                $e['conclusion'] = 'Se recomienda actualizar Hisoria Clínica, para obtener mejores resultados.';
                $e['grado'] = $grado_bajo;
                array_push($resultados, $e);
            }
            //Verificando si existen enfermedades
            if ($historia->enfermedades) {$enfermedades = array_keys(json_decode($historia->enfermedades, true));}
            else{
                $e = array();
                $e['premisa'] = $p_enfermedades_1;
                $e['resultado'] = 'No hay registro de enfermedades';;
                $e['conclusion'] = 'Se recomienda actualizar Hisoria Clínica, para obtener mejores resultados.';
                $e['grado'] = $grado_bajo;
                array_push($resultados, $e);
            }
            //Verificando si existen alergias
            if ($historia->alergias) {$alergias = json_decode($historia->alergias);}
            else{
                $e = array();
                $e['premisa'] = $p_alergias_1;
                $e['resultado'] = 'No hay registro de alergias';
                $e['conclusion'] = 'Se recomienda actualizar Hisoria Clínica, para obtener mejores resultados.';
                $e['grado'] = $grado_bajo;
                array_push($resultados, $e);
            }
            // Verificando si existen medicamentos
            if ($historia->recetas) {$recetas = json_decode($historia->recetas);}
            else{$recetas = [];}

        }

        //Dando formato de arreglos a las variables de la historia clinica
        $arr_antecedentes = array_keys($antecedentes);
        $arr_enfermedades = $enfermedades;
        $arr_alergias = $alergias;
        $arr_recetas = $recetas;

        // $medicamentos = Medicamento::orderBy('efectos', 'asc')->distinct()->pluck('efectos');
        // $efectos = Medicamento::orderBy('efectos', 'asc')->distinct()->pluck('efectos');

        // Obteniendo el medicamento consultado
        $medicamentos = Medicamento::where('nombre', $datos);
        
        // Verificando que existe el medicamento
        if(count($medicamentos->get()) > 0){

            //CONSULTANDO ANTECEDENTES QUE INFIEREN CON EL MEDICAMENTO
            foreach ($arr_antecedentes as $value) {
                $medicamentos = Medicamento::where('nombre', $datos);
                
                //Almacenando resultados de la metadata obtenida
                $meta = $medicamentos->where('meta', 'like', '%'.$value.'%')->get();
                
                // Incluyendo a los resultados
                foreach ($meta as $key => $data) {

                    $e = array();
                    $e['premisa'] = $p_antecedentes_2;
                    $e['resultado'] = 'El medicamento: '.$data->nombre.' presenta "'.$data->efectos.'"';
                    $e['conclusion'] = $data->conclusion.' por presencia de "'.$value.'" en sus antecedentes registrados en su Historia Clínica.';
                    $e['grado'] = $this->ObtenerGrado($data->conclusion);
                    array_push($resultados, $e);
                }
            }


            //CONSULTANDO FALENCIAS QUE INFIEREN CON EL MEDICAMENTO

            foreach ($arr_enfermedades as $value) {
                $medicamentos = Medicamento::where('nombre', $datos);

                //Almacenando resultados de la metadata obtenida
                $meta = $medicamentos->where('meta', 'like', '%'.str_replace('_', ' ', $value).'%')->get();

                // Incluyendo a los resultados
                foreach ($meta as $key => $data) {
                    $e = array();
                    $e['premisa'] = $p_enfermedades_2;
                    $e['resultado'] = 'El medicamento: '.$data->nombre.' presenta "'.$data->efectos.'"';
                    $e['conclusion'] = $data->conclusion.' por presencia de "'.str_replace('_', ' ', $value).'" en sus falencias registradas en su Historia Clínica.';
                    $e['grado'] = $this->ObtenerGrado($data->conclusion);
                    array_push($resultados, $e);
                }
                
            }

            //CONSULTANDO ALERGIAS QUE INFIEREN CON EL MEDICAMENTO
            
            foreach ($arr_alergias as $value) {
                $meta = Medicamento::where('nombre', $datos)->first();

                if($meta->nombre == $value){
                    
                    $e = array();
                    $e['premisa'] = $p_alergias_2;
                    $e['resultado'] = 'El medicamento: '.$meta->nombre.' presenta "Interacciones"';
                    $e['conclusion'] = 'Las alergias causadas por "'.$value.'" podría ser de gravedad.';
                    $e['grado'] = $e['grado'] = $grado_alto;
                    array_push($resultados, $e);
                }
            }

            //CONSULTANDO MEDICAMENTO QUE INFIEREN CON EL NUEVO MEDICAMENTO

            foreach ($arr_recetas as $value) {
                $meta = Medicamento::where('nombre', $datos)->first();

                if($meta->nombre == $value){
                    
                    $e = array();
                    $e['premisa'] = $p_recetas_2;
                    $e['resultado'] = 'El medicamento: '.$meta->nombre.' presenta "Interacciones"';
                    $e['conclusion'] = 'Las interaciones por "'.$value.'" podrían causar sobredosis.';
                    $e['grado'] = $e['grado'] = $grado_alto;
                    array_push($resultados, $e);
                }
            }

            // CONSULTANDO SI EL NUEVO MEDICAMENTO INFIERE CON LOS MEDICAMENTOS QUE CONSUME EL PACIENTE

            foreach ($arr_recetas as $value) {

                $meta = Medicamento::where('nombre', $datos)
                ->where('meta', 'like', '%'.$value.'%')->get();
                
                foreach ($meta as $key => $data) {
                    if($data){
                        $e = array();
                        $e['premisa'] = $p_recetas_2;
                        $e['resultado'] = 'El medicamento: '.$data->nombre.' presenta "'.$data->efectos.'"';
                        $e['conclusion'] = $data->conclusion.' por presencia de "'.$value.'" en los medicamentos que consume según su Historia Clínica.';
                        $e['grado'] = $this->ObtenerGrado($data->conclusion);
                        array_push($resultados, $e);
                    }
                }
                
            }
            

        }

        // Obteniendo total de grados de riesgo obtenidos
        $grados_obtenidos = Arr::pluck($resultados, 'grado');

        if(count($grados_obtenidos) > 0){
            if (max($grados_obtenidos) == 0) {
                $e = array();
    
                $e['premisa'] = $p_final;
                $e['resultado'] = 'El medicamento presenta un Riesgo bajo o leve';
                $e['conclusion'] = 'Se recomienda tomar el medicamento';
                $e['grado'] = $grado_bajo;
                array_push($resultados, $e);
            }
            if (max($grados_obtenidos) == 1) {
                $e = array();
    
                $e['premisa'] = $p_final;
                $e['resultado'] = 'El medicamento presenta un Riesgo moderado o de consideración';
                $e['conclusion'] = 'Se recomienda tomar el medicamento con precaución';
                $e['grado'] = $grado_medio;
                array_push($resultados, $e);
            }
            if (max($grados_obtenidos) == 2) {
                $e = array();
    
                $e['premisa'] = $p_final;
                $e['resultado'] = 'El medicamento presenta un Riesgo alto o grave';
                $e['conclusion'] = 'No se recomienda tomar el medicamento';
                $e['grado'] = $grado_alto;
                array_push($resultados, $e);
            }
        }else{
            $e = array();
            $e['premisa'] = $p_final;
            $e['resultado'] = 'El medicamento no presenta ninguna interación con el Historial Clínico del paciente';
            $e['conclusion'] = 'Se recomienda tomar el medicamento';
            $e['grado'] = $grado_bajo;
            array_push($resultados, $e);
        }

        return json_encode($resultados);
    }

    //Verificando si el medicamento tuviese un Grado Alto o Bajo de riesgo
    public function ObtenerGrado ($conclusion)
    {
        $grado_alto = 2;
        $grado_medio = 1;
        $grado_bajo = 0;

        $grado = $grado_medio;

        // Definiendo lista de grados
        $lista_grado_alto = ['alto', 'Alto', 'Aumenta', 'grave', 'Grave', 'potencia', 'Potencia'];
        $lista_grado_bajo = ['bajo', 'Bajo', 'leve', 'Leve', 'menor', 'Menor'];

        $cont_grado_bajo = 0;
        $cont_grado_alto = 0;

        foreach ($lista_grado_bajo as $key => $value) {
            if(strpos($conclusion, $value) !== false){ $cont_grado_bajo = $cont_grado_bajo + 1; }
        }
        foreach ($lista_grado_alto as $key => $value) {
            if(strpos($conclusion, $value) !== false){ $cont_grado_alto = $cont_grado_alto + 1; }
        }
        if($cont_grado_bajo > 0){
            $grado = $grado_bajo;
        }
        if($cont_grado_alto > 0){
            $grado = $grado_alto;
        }
        return $grado;
    }

}
