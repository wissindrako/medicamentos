<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Encuestas\Poda;
use App\Models\Encuestas\Enfermedad;
use App\Models\Encuestas\Deficiencia;
use Illuminate\Support\Facades\Auth;
use DateTime;

class FormEncuestasController extends Controller
{
    public function home_encuestas(){
        return view("formularios.home_encuestas");
    }

    public function form_cliente_cargar_datos(){
      return view("formularios.encuestas.form_cliente_cargar_datos");
    }

    public function form_informacion_basica_opcion(){
      return view("formularios.encuestas.form_informacion_basica_opcion");
    }

    public function form_cliente_podas_control_opcion(){
      return view("formularios.encuestas.form_cliente_podas_control_opcion");
    }

    public function mapa(){
        return view("encuestas.mapa");
    }

    public function quienes_somos(){
        return view("encuestas.quienes_somos");
    }

    public function contactos(){
        return view("encuestas.contactos");
    }

    public function form_enc_controles_maleza(){
        return view("formularios.form_enc_controles_maleza");
    }

    public function form_podas_control_opcion(){
        return view("formularios.encuestas.form_podas_control_opcion");
    }

    public function form_transformacion_opcion(){
        return view("formularios.encuestas.form_transformacion_opcion");
    }

    public function form_enfermedades_plagas_opcion(){
        return view("formularios.encuestas.form_enfermedades_plagas_opcion");
    }

    public function form_densidad_tabla(){
        $datos = \DB::table('enc_densidad')->orderBy('id_densidad', 'desc')->where('object_id', Auth::user()->object_id)->where('activo', 1)->get();
        return view("listados.encuesta.listado_densidad", compact('datos'));
    }

    public function form_sist_agroforestales_tabla(){
        $datos = \DB::table('enc_sist_agroforestales')->orderBy('id_sist_agroforestal', 'desc')->where('object_id', Auth::user()->object_id)->where('activo', 1)->get();
        return view("listados.encuesta.listado_sist_agroforestales", compact('datos'));
    }

    public function form_cosecha_tabla(){
        $datos = \DB::table('enc_cosechas')->orderBy('id_cosecha', 'desc')->where('object_id', Auth::user()->object_id)->where('activo', 1)->get();
        return view("listados.encuesta.form_cosecha_tabla", compact('datos'));
    }

    public function form_post_cosecha_tabla(){
        $datos = \DB::table('enc_post_cosechas')->orderBy('id_post_cosecha', 'desc')->where('object_id', Auth::user()->object_id)->where('activo', 1)->get();
        return view("listados.encuesta.form_post_cosecha_tabla", compact('datos'));
    }

    public function form_secado_tabla(){
        $datos = \DB::table('enc_secados')->orderBy('id_secado', 'desc')->where('object_id', Auth::user()->object_id)->where('activo', 1)->get();
        return view("listados.encuesta.form_secado_tabla", compact('datos'));
    }

    //Simplemente envia a agregar o editar en funcion a la existencia del registro en la bd
    public function form_informacion_basica(){
      //Tomamos los datos del productor logeado
      $datos = \DB::table('enc_productores')->orderBy('id_productor', 'desc')->where('object_id', Auth::user()->object_id)->where('activo', 1)->get();

      //Si esta vacio, significa que no hay el registro, envìa a formulario vacio
      if (empty($datos->first())) {
        return $this->form_informacion_basica_agregar();
      }
      else {
        //Por el contrario, si hay el registro, envìa a actualizar
        return $this->form_informacion_basica_editar();
      }
        //return view("formularios.encuestas.form_informacion_basica_agregar");
    }

    public function form_informacion_basica_agregar(){
      $departamentos = \DB::table('departamentos')
      ->where('activo', 1)
      ->orderBy('departamento')
      ->get();

      return view("formularios.encuestas.form_informacion_basica_agregar")
            ->with('departamentos', $departamentos);
    }

    public function form_sist_agroforestales_agregar(){
        return view("formularios.encuestas.form_sist_agroforestales_agregar");
    }

    public function form_cosecha_agregar(){
        return view("formularios.encuestas.form_cosecha_agregar");
    }

    public function form_post_cosecha_agregar(){
        return view("formularios.encuestas.form_post_cosecha_agregar");
    }

    public function form_secado_agregar(){
        return view("formularios.encuestas.form_secado_agregar");
    }

    public function listado_densidad(){
        $datos = \DB::table('enc_densidad')->orderBy('id_densidad', 'desc')->get();
        return view("listados.encuesta.listado_densidad", compact('datos'));
    }

    public function form_preparacion_tabla(){
        $datos = \DB::table('enc_preparaciones')->where('object_id', Auth::user()->object_id)->where('activo', 1)->orderBy('id_preparacion', 'desc')->get();
        return view("listados.encuesta.form_preparacion_tabla", compact('datos'));
    }

    public function form_podas_tabla(){
        $datos = \DB::table('enc_podas')->where('object_id', Auth::user()->object_id)->where('activo', 1)->orderBy('id_poda', 'desc')->get();
        return view("listados.encuesta.form_podas_tabla", compact('datos'));
    }

    public function form_controles_tabla(){
        $datos = \DB::table('enc_controles_maleza')->where('object_id', Auth::user()->object_id)->where('activo', 1)->orderBy('id_control_maleza', 'desc')->get();
        return view("listados.encuesta.form_controles_tabla", compact('datos'));
    }

    public function form_deficiencias_tabla(){
        $datos = \DB::table('enc_deficiencias')->where('object_id', Auth::user()->object_id)->where('activo', 1)->orderBy('id_deficiencia', 'desc')->get();
        return view("listados.encuesta.form_deficiencias_tabla", compact('datos'));
    }

    public function form_enfermedades_tabla(){
        $datos = \DB::table('enc_enfermedades')->where('object_id', Auth::user()->object_id)->where('activo', 1)->orderBy('id_enfermedad', 'desc')->get();
        return view("listados.encuesta.form_enfermedades_tabla", compact('datos'));
    }

    public function form_plagas_tabla(){
        $datos = \DB::table('enc_plagas')->where('object_id', Auth::user()->object_id)->where('activo', 1)->orderBy('id_plaga', 'desc')->get();
        return view("listados.encuesta.form_plagas_tabla", compact('datos'));
    }

    public function form_fertilizacion_tabla(){
        $datos = \DB::table('enc_fertilizaciones')->where('object_id', Auth::user()->object_id)->where('activo', 1)->orderBy('id_fertilizacion', 'desc')->get();
        return view("listados.encuesta.form_fertilizaciones_tabla", compact('datos'));
    }

    //FORMS AGREGAR
    public function form_densidad_agregar(){
        return view("formularios.encuestas.form_densidad_agregar");
    }

    public function form_preparacion_agregar(){
        return view("formularios.encuestas.form_preparacion_agregar");
    }
    public function form_podas_agregar(){
        return view("formularios.encuestas.form_podas_agregar");
    }

    public function form_controles_agregar(){
        return view("formularios.encuestas.form_controles_agregar");
    }

    public function form_deficiencias_agregar(){
        return view("formularios.encuestas.form_deficiencias_agregar");
    }

    public function form_enfermedades_agregar(){
        return view("formularios.encuestas.form_enfermedades_agregar");
    }

    public function form_plagas_agregar(){
        return view("formularios.encuestas.form_plagas_agregar");
    }

    public function form_fertilizaciones_agregar(){
        return view("formularios.encuestas.form_fertilizaciones_agregar");
    }






    //FORMS GUARDAR
    public function informacion_basica_guardar(Request $request){
        $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));

        //Establecemos el tipo de cultipo id
        if ($request->tipo_cultivo == "Cafe") {$tipo_cultivo_id = 1;}
        else {$tipo_cultivo_id = 2;}
        \DB::table('enc_productores')->insert([
            ['object_id' => Auth::user()->object_id,
             'productor_nombres' => $request->productor_nombres,
             'productor_paterno' => $request->productor_paterno,
             'productor_materno' => $request->productor_materno,
             'productor_ci' => $request->productor_ci,
             'productor_sexo' => $request->productor_sexo,
             'productor_telefono' => $request->productor_telefono,
             'tecnico_responsable' => $request->tecnico_responsable,
             'id_departamento' => $request->id_departamento,
             'id_provincia' => $request->id_provincia,
             'id_municipio' => $request->id_municipio,
             'localidad' => $request->localidad,
             'comunidad' => $request->comunidad,
             'tipo_cultivo' => $request->tipo_cultivo,
             'tipo_cultivo_id' => $tipo_cultivo_id,
             'created_at' => $tiempo_actual,
             'updated_at' => $tiempo_actual,
             'activo' => 1]
        ]);
        return redirect('/home_encuestas')->with('mensaje_exito', 'Información Básica Guardada Exitosamente');
    }

    public function densidad_guardar(Request $request){
        // dd($request);
        $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));
        \DB::table('enc_densidad')->insert([
            ['object_id' => Auth::user()->object_id,
             'ano' => $request->ano,
             'densidad' => $request->densidad,
             'superficie' => $request->superficie,
             'cantidad_plantas' => $request->cantidad_plantas,
             'plantas_muertas' => $request->plantas_muertas,
             'plantas_efectivas' => $request->plntas_efectivas,
             'created_at' => $tiempo_actual,
             'updated_at' => $tiempo_actual,
             'activo' => 1]
        ]);
        return redirect('/home_encuestas')->with('mensaje_exito', 'Encuesta de Densidad de Plantación de Café Guardada Exitosamente');
    }

    public function preparacion_guardar(Request $request){
        $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));
        if($request->quema == 1){
            $con_quema = 1;
            $sin_quema = 0;

        } else{
            $con_quema = 0;
            $sin_quema = 1;
        }

        \DB::table('enc_preparaciones')->insert([
            ['object_id' => Auth::user()->object_id,
                'fecha' => $request->fecha,
                'con_quema' => $con_quema,
                'sin_quema' => $sin_quema,
                'created_at' => $tiempo_actual,
                'updated_at' => $tiempo_actual,
                'activo' => 1
                ]
        ]);
        return redirect('/home_encuestas')->with('mensaje_exito', 'Encuesta de Información Básica (Zona de Plantación) Guardada Exitosamente');
    }

    public function podas_guardar(Request $request){


        $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));

        //FORMACION DE PLANTAS
        if ($request->form_planta == 1) {
            $form_planta_fecha = $request->form_planta_fecha;
            $form_planta_fecha_final = $request->form_planta_fecha_final;
            if ($request->form_planta_foto){
              $form_planta_foto = Poda::setFoto($request->form_planta_foto);
            }else{
              $form_planta_foto = "";
            }
          }
        else {
          $form_planta_fecha = "0000-00-00";
          $form_planta_fecha_final = "0000-00-00";
          $form_planta_foto = "";
        }

        //MANTENIMIENTO
        if ($request->mantenimiento == 1) {
            $mantenimiento_fecha = $request->mantenimiento_fecha;
            $mantenimiento_fecha_final = $request->mantenimiento_fecha_final;
            if ($request->mantenimiento_foto){
              $mantenimiento_foto = Poda::setFoto($request->mantenimiento_foto);
            }else{
              $mantenimiento_foto = "";
            }
          }
          else {
            $mantenimiento_fecha = "0000-00-00";
            $mantenimiento_fecha_final = "0000-00-00";
            $mantenimiento_foto = "";
          }

        //SELECCION DE BROTES
        if ($request->sel_brotes == 1) {
            $sel_brotes_fecha = $request->sel_brotes_fecha;
            $sel_brotes_fecha_final = $request->sel_brotes_fecha_final;
            if ($request->sel_brotes_foto){
              $sel_brotes_foto = Poda::setFoto($request->sel_brotes_foto);
            }else{
              $sel_brotes_foto = "";
            }
          }
          else {
            $sel_brotes_fecha = "0000-00-00";
            $sel_brotes_fecha_final = "0000-00-00";
            $sel_brotes_foto = "";
          }

        //REHABILITACION
        if ($request->rehabilitacion == 1) {
            $rehabilitacion_fecha = $request->rehabilitacion_fecha;
            $rehabilitacion_fecha_final = $request->rehabilitacion_fecha_final;
            if ($request->rehabilitacion_foto){
              $rehabilitacion_foto = Poda::setFoto($request->rehabilitacion_foto);
            }else{
              $rehabilitacion_foto = "";
            }
          }
          else {
            $rehabilitacion_fecha = "0000-00-00";
            $rehabilitacion_fecha_final = "0000-00-00";
            $rehabilitacion_foto = "";
          }

        //RENOVACION
        if ($request->renovacion == 1) {
            $renovacion_fecha = $request->renovacion_fecha;
            $renovacion_fecha_final = $request->renovacion_fecha_final;
            if ($request->renovacion_foto){
              $renovacion_foto = Poda::setFoto($request->renovacion_foto);
            }else{
              $renovacion_foto = "";
            }
          }
          else {
            $renovacion_fecha = "0000-00-00";
            $renovacion_fecha_final = "0000-00-00";
            $renovacion_foto = "";
          }

        //DESHOJE Y DESPUNTE
        if ($request->deshoje_despunte == 1) {
            $deshoje_despunte_fecha = $request->deshoje_despunte_fecha;
            $deshoje_despunte_fecha_final = $request->deshoje_despunte_fecha_final;
            if ($request->deshoje_despunte_foto){
              $deshoje_despunte_foto = Poda::setFoto($request->deshoje_despunte_foto);
            }else{
              $deshoje_despunte_foto = "";
            }
          }
          else {
            $deshoje_despunte_fecha = "0000-00-00";
            $deshoje_despunte_fecha_final = "0000-00-00";
            $deshoje_despunte_foto = "";
          }

          \DB::table('enc_podas')->insert([
            [
                'object_id' => Auth::user()->object_id,
                'form_planta' => $request->form_planta,
                'form_planta_fecha' => $form_planta_fecha,
                'form_planta_fecha_final' => $form_planta_fecha_final,
                'form_planta_foto' => $form_planta_foto,
                'mantenimiento' => $request->mantenimiento,
                'mantenimiento_fecha' => $mantenimiento_fecha,
                'mantenimiento_fecha_final' => $mantenimiento_fecha_final,
                'mantenimiento_foto' => $mantenimiento_foto,
                'sel_brotes' => $request->sel_brotes,
                'sel_brotes_fecha' => $sel_brotes_fecha,
                'sel_brotes_fecha_final' => $sel_brotes_fecha_final,
                'sel_brotes_foto' => $sel_brotes_foto,
                'rehabilitacion' => $request->rehabilitacion,
                'rehabilitacion_fecha' => $rehabilitacion_fecha,
                'rehabilitacion_fecha_final' => $rehabilitacion_fecha_final,
                'rehabilitacion_foto' => $rehabilitacion_foto,
                'renovacion' => $request->renovacion,
                'renovacion_fecha' => $renovacion_fecha,
                'renovacion_fecha_final' => $renovacion_fecha_final,
                'renovacion_foto' => $renovacion_foto,
                'deshoje_despunte' => $request->deshoje_despunte,
                'deshoje_despunte_fecha' => $deshoje_despunte_fecha,
                'deshoje_despunte_fecha_final' => $deshoje_despunte_fecha_final,
                'deshoje_despunte_foto' => $deshoje_despunte_foto,
                'created_at' => $tiempo_actual,
                'updated_at' => $tiempo_actual,
                'activo' => 1
                ]
            ]);

            return redirect('/home_encuestas')->with('mensaje_exito', 'Encuesta de Podas Guardada Exitosamente');
    }

    public function controles_guardar(Request $request){
        $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));

        //METODO BIOLOGICO
        if ($request->biologico == 1) {
            $biologico_fecha = $request->biologico_fecha;
            $biologico_producto = $request->biologico_producto;
        }
        else {
            $biologico_fecha = "0000-00-00";
            $biologico_producto = "";
        }

        //METODO QUIMICO
        if ($request->quimico == 1) {
            $quimico_fecha = $request->quimico_fecha;
            $quimico_producto = $request->quimico_producto;
        }
        else {
            $quimico_fecha = "0000-00-00";
            $quimico_producto = "";
        }


        //METODO MECANICO
        if ($request->mecanico == 1) {
            $mecanico_fecha = $request->mecanico_fecha;
            $mecanico_producto = $request->mecanico_producto;
        }
        else {
            $mecanico_fecha = "0000-00-00";
            $mecanico_producto = "";
        }
        \DB::table('enc_controles_maleza')->insert([
            [
                'object_id' => Auth::user()->object_id,
                'biologico' => $request->biologico,
                'biologico_fecha' => $biologico_fecha,
                'biologico_producto' => $biologico_producto,
                'quimico' => $request->quimico,
                'quimico_fecha' => $quimico_fecha,
                'quimico_producto' => $quimico_producto,
                'mecanico' => $request->mecanico,
                'mecanico_fecha' => $mecanico_fecha,
                'mecanico_producto' => $mecanico_producto,
                'created_at' => $tiempo_actual,
                'updated_at' => $tiempo_actual,
                'activo' => 1
                ]
            ]);
        return redirect('/home_encuestas')->with('mensaje_exito', 'Encuesta de Control de Malezas Guardada Exitosamente');
    }

    public function sist_agroforestales_guardar(Request $request){
        $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));

        //Tomamos los valores y les asignamos valores según corresponda
        if ($request->pacay == 1) {
          $pacay_fecha_siembra = $request->pacay_fecha_siembra;
          $pacay_cantidad = $request->pacay_cantidad;
          $pacay_permanente = $request->pacay_permanente;
        }
        else {
          $pacay_fecha_siembra = "0000-00-00";
          $pacay_cantidad = 0;
          $pacay_permanente = 0;
        }

        if ($request->platano == 1) {
          $platano_fecha_siembra = $request->platano_fecha_siembra;
          $platano_cantidad = $request->platano_cantidad;
          $platano_permanente = $request->platano_permanente;
        }
        else {
          $platano_fecha_siembra = "0000-00-00";
          $platano_cantidad = 0;
          $platano_permanente = 0;
        }

        if ($request->citricos == 1) {
          $citricos_fecha_siembra = $request->citricos_fecha_siembra;
          $citricos_cantidad = $request->citricos_cantidad;
          $citricos_permanente = $request->citricos_permanente;
        }
        else {
          $citricos_fecha_siembra = "0000-00-00";
          $citricos_cantidad = 0;
          $citricos_permanente = 0;
        }

        if ($request->maderables == 1) {
          $maderables_fecha_siembra = $request->maderables_fecha_siembra;
          $maderables_cantidad = $request->maderables_cantidad;
          $maderables_permanente = $request->maderables_permanente;
        }
        else {
          $maderables_fecha_siembra = "0000-00-00";
          $maderables_cantidad = 0;
          $maderables_permanente = 0;
        }

        if ($request->frutas_amazonicas == 1) {
          $frutas_amazonicas_fecha_siembra = $request->frutas_amazonicas_fecha_siembra;
          $frutas_amazonicas_cantidad = $request->frutas_amazonicas_cantidad;
          $frutas_amazonicas_permanente = $request->frutas_amazonicas_permanente;
        }
        else {
          $frutas_amazonicas_fecha_siembra = "0000-00-00";
          $frutas_amazonicas_cantidad = 0;
          $frutas_amazonicas_permanente = 0;
        }

        if ($request->otros == 1) {
          $otros_descripcion = $request->otros_descripcion;
          $otros_fecha_siembra = $request->otros_fecha_siembra;
          $otros_cantidad = $request->otros_cantidad;
          $otros_permanente = $request->otros_permanente;
        }
        else {
          $otros_descripcion = "";
          $otros_fecha_siembra = "0000-00-00";
          $otros_cantidad = 0;
          $otros_permanente = 0;
        }

        \DB::table('enc_sist_agroforestales')->insert([
            ['object_id' => Auth::user()->object_id,
             'ano' => $request->ano,
             'pacay' => $request->pacay,
             'pacay_fecha_siembra' => $pacay_fecha_siembra,
             'pacay_cantidad' => $pacay_cantidad,
             'pacay_permanente' => $pacay_permanente,
             'platano' => $request->platano,
             'platano_fecha_siembra' => $platano_fecha_siembra,
             'platano_cantidad' => $platano_cantidad,
             'platano_permanente' => $platano_permanente,
             'citricos' => $request->citricos,
             'citricos_fecha_siembra' => $citricos_fecha_siembra,
             'citricos_cantidad' => $citricos_cantidad,
             'citricos_permanente' => $citricos_permanente,
             'maderables' => $request->maderables,
             'maderables_fecha_siembra' => $maderables_fecha_siembra,
             'maderables_cantidad' => $maderables_cantidad,
             'maderables_permanente' => $maderables_permanente,
             'frutas_amazonicas' => $request->frutas_amazonicas,
             'frutas_amazonicas_fecha_siembra' => $frutas_amazonicas_fecha_siembra,
             'frutas_amazonicas_cantidad' => $frutas_amazonicas_cantidad,
             'frutas_amazonicas_permanente' => $frutas_amazonicas_permanente,
             'otros' => $request->otros,
             'otros_descripcion' => $otros_descripcion,
             'otros_fecha_siembra' => $otros_fecha_siembra,
             'otros_cantidad' => $otros_cantidad,
             'otros_permanente' => $otros_permanente,
             'created_at' => $tiempo_actual,
             'updated_at' => $tiempo_actual,
             'activo' => 1]
        ]);
        return redirect('/home_encuestas')->with('mensaje_exito', 'Encuesta de Sistemas Agroforestales Guardada Exitosamente');
    }

    public function cosecha_guardar(Request $request){
        $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));

        //Tomamos los valores y les asignamos valores según corresponda
        if ($request->metodo == 1) {
          $manual = 1;
          $mecanica = 0;
        }
        else {
          $manual = 0;
          $mecanica = 1;
        }

        \DB::table('enc_cosechas')->insert([
            ['object_id' => Auth::user()->object_id,
             'fecha' => $request->fecha,
             'manual' => $manual,
             'mecanica' => $mecanica,
             'peso_bruto' => $request->peso_bruto,
             'created_at' => $tiempo_actual,
             'updated_at' => $tiempo_actual,
             'activo' => 1]
        ]);
        return redirect('/home_encuestas')->with('mensaje_exito', 'Encuesta de Cosecha Guardada Exitosamente');
    }

    public function post_cosecha_guardar(Request $request){
        $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));

        //Tomamos los valores y les asignamos valores según corresponda
        if ($request->cosecha == 1) {
          $cosecha_fecha = $request->cosecha_fecha;
          $cosecha_p_bruto = $request->cosecha_p_bruto;
          $cosecha_p_descarte = $request->cosecha_p_descarte;
          $cosecha_p_efecivo = $request->cosecha_p_efectivo;
        }
        else {
          $cosecha_fecha = "0000-00-00";
          $cosecha_p_bruto = 0;
          $cosecha_p_descarte = 0;
          $cosecha_p_efecivo = 0;
        }

        if ($request->limpieza == 1) {
          $limpieza_fecha = $request->limpieza_fecha;
          $limpieza_p_bruto = $request->limpieza_p_bruto;
          $limpieza_p_descarte = $request->limpieza_p_descarte;
          $limpieza_p_efecivo = $request->limpieza_p_efectivo;
        }
        else {
          $limpieza_fecha = "0000-00-00";
          $limpieza_p_bruto = 0;
          $limpieza_p_descarte = 0;
          $limpieza_p_efecivo = 0;
        }

        if ($request->despulpado == 1) {
          $despulpado_fecha = $request->despulpado_fecha;
          $despulpado_p_bruto = $request->despulpado_p_bruto;
          $despulpado_p_descarte = $request->despulpado_p_descarte;
          $despulpado_p_efecivo = $request->despulpado_p_efectivo;
        }
        else {
          $despulpado_fecha = "0000-00-00";
          $despulpado_p_bruto = 0;
          $despulpado_p_descarte = 0;
          $despulpado_p_efecivo = 0;
        }

        \DB::table('enc_post_cosechas')->insert([
                  ['object_id' => Auth::user()->object_id,
                  'cosecha' => $request->cosecha,
                  'cosecha_fecha' => $cosecha_fecha,
                  'cosecha_p_bruto' => $cosecha_p_bruto,
                  'cosecha_p_descarte' => $cosecha_p_descarte,
                  'cosecha_p_efectivo' => $cosecha_p_efecivo,
                  'limpieza' => $request->limpieza,
                  'limpieza_fecha' => $limpieza_fecha,
                  'limpieza_p_bruto' => $limpieza_p_bruto,
                  'limpieza_p_descarte' => $limpieza_p_descarte,
                  'limpieza_p_efectivo' => $limpieza_p_efecivo,
                  'despulpado' => $request->despulpado,
                  'despulpado_fecha' => $despulpado_fecha,
                  'despulpado_p_bruto' => $despulpado_p_bruto,
                  'despulpado_p_descarte' => $despulpado_p_descarte,
                  'despulpado_p_efectivo' => $despulpado_p_efecivo,
                  'created_at' => $tiempo_actual,
                  'updated_at' => $tiempo_actual,
                  'activo' => 1]
        ]);
        return redirect('/home_encuestas')->with('mensaje_exito', 'Encuesta de Post Cosecha Guardada Exitosamente');
    }

    public function secado_guardar(Request $request){
        $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));

        //Tomamos los valores y les asignamos valores según corresponda
        if ($request->secado == 1) {
          $secado_fecha = $request->secado_fecha;
          $secado_p_total = $request->secado_p_total;
          $secado_humedad = $request->secado_humedad;
          $secado_p_efectivo = $request->secado_p_efectivo;
        }
        else {
          $secado_fecha = "0000-00-00";
          $secado_p_total = 0;
          $secado_humedad = 0;
          $secado_p_efectivo = 0;
        }

        if ($request->lavado == 1) {
          $lavado_fecha = $request->lavado_fecha;
          $lavado_p_total = $request->lavado_p_total;
          $lavado_humedad = $request->lavado_humedad;
          $lavado_p_efectivo = $request->lavado_p_efectivo;
        }
        else {
          $lavado_fecha = "0000-00-00";
          $lavado_p_total = 0;
          $lavado_humedad = 0;
          $lavado_p_efectivo = 0;
        }

        if ($request->miel == 1) {
          $miel_fecha = $request->miel_fecha;
          $miel_p_total = $request->miel_p_total;
          $miel_humedad = $request->miel_humedad;
          $miel_p_efectivo = $request->miel_p_efectivo;
        }
        else {
          $miel_fecha = "0000-00-00";
          $miel_p_total = 0;
          $miel_humedad = 0;
          $miel_p_efectivo = 0;
        }

        \DB::table('enc_secados')->insert([
                  ['object_id' => Auth::user()->object_id,

                  'secado' => $request->secado,
                  'secado_fecha' => $secado_fecha,
                  'secado_p_total' => $secado_p_total,
                  'secado_humedad' => $secado_humedad,
                  'secado_p_efectivo' => $secado_p_efectivo,
                  'lavado' => $request->lavado,
                  'lavado_fecha' => $lavado_fecha,
                  'lavado_p_total' => $lavado_p_total,
                  'lavado_humedad' => $lavado_humedad,
                  'lavado_p_efectivo' => $lavado_p_efectivo,
                  'miel' => $request->miel,
                  'miel_fecha' => $miel_fecha,
                  'miel_p_total' => $miel_p_total,
                  'miel_humedad' => $miel_humedad,
                  'miel_p_efectivo' => $miel_p_efectivo,
                  'created_at' => $tiempo_actual,
                  'updated_at' => $tiempo_actual,
                  'activo' => 1]
        ]);
        return redirect('/home_encuestas')->with('mensaje_exito', 'Encuesta de Secado Guardada Exitosamente');
    }

    public function deficiencias_guardar(Request $request){
      $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));

      //Tomamos los valores y les asignamos valores según corresponda
      if ($request->p == 1) {
        $p_fecha = $request->p_fecha;
        $p_deficiencia = "";
        //Concatenamos todas las deficiencias para guardarlas en un solo campo
        for ($i=0;$i<count($request->p_deficiencia);$i++){
          if ($p_deficiencia == "") {
            $p_deficiencia = $request->p_deficiencia[$i];
          }
          else {
            $p_deficiencia = $p_deficiencia." & ".$request->p_deficiencia[$i];
          }
        }
        $p_severidad = $request->p_severidad;
        $p_producto = $request->p_producto;
        $p_fecha_aplicacion = $request->p_fecha_aplicacion;
        if ($request->p_foto){
          $p_foto = Deficiencia::setFoto($request->p_foto);
        }else{
          $p_foto = "";
        }
      }
      else {
        $p_fecha = "0000-00-00";
        $p_deficiencia = "";
        $p_severidad = 0;
        $p_producto = "";
        $p_fecha_aplicacion = "0000-00-00";
        $p_foto = "";
      }

      if ($request->k == 1) {
        $k_fecha = $request->k_fecha;
        $k_deficiencia = "";
        //Concatenamos todas las deficiencias para guardarlas en un solo campo
        for ($i=0;$i<count($request->k_deficiencia);$i++){
          if ($k_deficiencia == "") {
            $k_deficiencia = $request->k_deficiencia[$i];
          }
          else {
            $k_deficiencia = $k_deficiencia." & ".$request->k_deficiencia[$i];
          }
        }
        $k_severidad = $request->k_severidad;
        $k_producto = $request->k_producto;
        $k_fecha_aplicacion = $request->k_fecha_aplicacion;
        if ($request->k_foto){
          $k_foto = Deficiencia::setFoto($request->k_foto);
        }else{
          $k_foto = "";
        }
      }
      else {
        $k_fecha = "0000-00-00";
        $k_deficiencia = "";
        $k_severidad = 0;
        $k_producto = "";
        $k_fecha_aplicacion = "0000-00-00";
        $k_foto = "";
      }

      if ($request->ca == 1) {
        $ca_fecha = $request->ca_fecha;
        $ca_deficiencia = "";
        //Concatenamos todas las deficiencias para guardarlas en un solo campo
        for ($i=0;$i<count($request->ca_deficiencia);$i++){
          if ($ca_deficiencia == "") {
            $ca_deficiencia = $request->ca_deficiencia[$i];
          }
          else {
            $ca_deficiencia = $ca_deficiencia." & ".$request->ca_deficiencia[$i];
          }
        }
        $ca_severidad = $request->ca_severidad;
        $ca_producto = $request->ca_producto;
        $ca_fecha_aplicacion = $request->ca_fecha_aplicacion;
        if ($request->ca_foto){
          $ca_foto = Deficiencia::setFoto($request->ca_foto);
        }else{
          $ca_foto = "";
        }
      }
      else {
        $ca_fecha = "0000-00-00";
        $ca_deficiencia = "";
        $ca_severidad = 0;
        $ca_producto = "";
        $ca_fecha_aplicacion = "0000-00-00";
        $ca_foto = "";
      }

      if ($request->mg == 1) {
        $mg_fecha = $request->mg_fecha;
        $mg_deficiencia = "";
        //Concatenamos todas las deficiencias para guardarlas en un solo campo
        for ($i=0;$i<count($request->mg_deficiencia);$i++){
          if ($mg_deficiencia == "") {
            $mg_deficiencia = $request->mg_deficiencia[$i];
          }
          else {
            $mg_deficiencia = $mg_deficiencia." & ".$request->mg_deficiencia[$i];
          }
        }
        $mg_severidad = $request->mg_severidad;
        $mg_producto = $request->mg_producto;
        $mg_fecha_aplicacion = $request->mg_fecha_aplicacion;
        if ($request->mg_foto){
          $mg_foto = Deficiencia::setFoto($request->mg_foto);
        }else{
          $mg_foto = "";
        }
      }
      else {
        $mg_fecha = "0000-00-00";
        $mg_deficiencia = "";
        $mg_severidad = 0;
        $mg_producto = "";
        $mg_fecha_aplicacion = "0000-00-00";
        $mg_foto = "";
      }

      if ($request->s == 1) {
        $s_fecha = $request->s_fecha;
        $s_deficiencia = "";
        //Concatenamos todas las deficiencias para guardarlas en un solo campo
        for ($i=0;$i<count($request->s_deficiencia);$i++){
          if ($s_deficiencia == "") {
            $s_deficiencia = $request->s_deficiencia[$i];
          }
          else {
            $s_deficiencia = $s_deficiencia." & ".$request->s_deficiencia[$i];
          }
        }
        $s_severidad = $request->s_severidad;
        $s_producto = $request->s_producto;
        $s_fecha_aplicacion = $request->s_fecha_aplicacion;
        if ($request->s_foto){
          $s_foto = Deficiencia::setFoto($request->s_foto);
        }else{
          $s_foto = "";
        }
      }
      else {
        $s_fecha = "0000-00-00";
        $s_deficiencia = "";
        $s_severidad = 0;
        $s_producto = "";
        $s_fecha_aplicacion = "0000-00-00";
        $s_foto = "";
      }

      if ($request->fe == 1) {
        $fe_fecha = $request->fe_fecha;
        $fe_deficiencia = "";
        //Concatenamos todas las deficiencias para guardarlas en un solo campo
        for ($i=0;$i<count($request->fe_deficiencia);$i++){
          if ($fe_deficiencia == "") {
            $fe_deficiencia = $request->fe_deficiencia[$i];
          }
          else {
            $fe_deficiencia = $fe_deficiencia." & ".$request->fe_deficiencia[$i];
          }
        }
        $fe_severidad = $request->fe_severidad;
        $fe_producto = $request->fe_producto;
        $fe_fecha_aplicacion = $request->fe_fecha_aplicacion;
        if ($request->fe_foto){
          $fe_foto = Deficiencia::setFoto($request->fe_foto);
        }else{
          $fe_foto = "";
        }
      }
      else {
        $fe_fecha = "0000-00-00";
        $fe_deficiencia = "";
        $fe_severidad = 0;
        $fe_producto = "";
        $fe_fecha_aplicacion = "0000-00-00";
        $fe_foto = "";
      }

      if ($request->zc == 1) {
        $zc_fecha = $request->zc_fecha;
        $zc_deficiencia = "";
        //Concatenamos todas las deficiencias para guardarlas en un solo campo
        for ($i=0;$i<count($request->zc_deficiencia);$i++){
          if ($zc_deficiencia == "") {
            $zc_deficiencia = $request->zc_deficiencia[$i];
          }
          else {
            $zc_deficiencia = $zc_deficiencia." & ".$request->zc_deficiencia[$i];
          }
        }
        $zc_severidad = $request->zc_severidad;
        $zc_producto = $request->zc_producto;
        $zc_fecha_aplicacion = $request->zc_fecha_aplicacion;
        if ($request->zc_foto){
          $zc_foto = Deficiencia::setFoto($request->zc_foto);
        }else{
          $zc_foto = "";
        }
      }
      else {
        $zc_fecha = "0000-00-00";
        $zc_deficiencia = "";
        $zc_severidad = 0;
        $zc_producto = "";
        $zc_fecha_aplicacion = "0000-00-00";
        $zc_foto = "";
      }

      if ($request->cu == 1) {
        $cu_fecha = $request->cu_fecha;
        $cu_deficiencia = "";
        //Concatenamos todas las deficiencias para guardarlas en un solo campo
        for ($i=0;$i<count($request->cu_deficiencia);$i++){
          if ($cu_deficiencia == "") {
            $cu_deficiencia = $request->cu_deficiencia[$i];
          }
          else {
            $cu_deficiencia = $cu_deficiencia." & ".$request->cu_deficiencia[$i];
          }
        }
        $cu_severidad = $request->cu_severidad;
        $cu_producto = $request->cu_producto;
        $cu_fecha_aplicacion = $request->cu_fecha_aplicacion;
        if ($request->cu_foto){
          $cu_foto = Deficiencia::setFoto($request->cu_foto);
        }else{
          $cu_foto = "";
        }
      }
      else {
        $cu_fecha = "0000-00-00";
        $cu_deficiencia = "";
        $cu_severidad = 0;
        $cu_producto = "";
        $cu_fecha_aplicacion = "0000-00-00";
        $cu_foto = "";
      }

      if ($request->b == 1) {
        $b_fecha = $request->b_fecha;
        $b_deficiencia = "";
        //Concatenamos todas las deficiencias para guardarlas en un solo campo
        for ($i=0;$i<count($request->b_deficiencia);$i++){
          if ($b_deficiencia == "") {
            $b_deficiencia = $request->b_deficiencia[$i];
          }
          else {
            $b_deficiencia = $b_deficiencia." & ".$request->b_deficiencia[$i];
          }
        }
        $b_severidad = $request->b_severidad;
        $b_producto = $request->b_producto;
        $b_fecha_aplicacion = $request->b_fecha_aplicacion;
        if ($request->b_foto){
          $b_foto = Deficiencia::setFoto($request->b_foto);
        }else{
          $b_foto = "";
        }
      }
      else {
        $b_fecha = "0000-00-00";
        $b_deficiencia = "";
        $b_severidad = 0;
        $b_producto = "";
        $b_fecha_aplicacion = "0000-00-00";
        $b_foto = "";
      }

     \DB::table('enc_deficiencias')->insert([
                ['object_id' => Auth::user()->object_id,
                'p' => $request->p,
                'p_fecha' => $p_fecha,
                'p_deficiencia' => $p_deficiencia,
                'p_severidad' => $p_severidad,
                'p_producto' => $p_producto,
                'p_fecha_aplicacion' => $p_fecha_aplicacion,
                'p_foto' => $p_foto,

                'k' => $request->k,
                'k_fecha' => $k_fecha,
                'k_deficiencia' => $k_deficiencia,
                'k_severidad' => $k_severidad,
                'k_producto' => $k_producto,
                'k_fecha_aplicacion' => $k_fecha_aplicacion,
                'k_foto' => $k_foto,

                'ca' => $request->ca,
                'ca_fecha' => $ca_fecha,
                'ca_deficiencia' => $ca_deficiencia,
                'ca_severidad' => $ca_severidad,
                'ca_producto' => $ca_producto,
                'ca_fecha_aplicacion' => $ca_fecha_aplicacion,
                'ca_foto' => $ca_foto,

                'mg' => $request->mg,
                'mg_fecha' => $mg_fecha,
                'mg_deficiencia' => $mg_deficiencia,
                'mg_severidad' => $mg_severidad,
                'mg_producto' => $mg_producto,
                'mg_fecha_aplicacion' => $mg_fecha_aplicacion,
                'mg_foto' => $mg_foto,

                's' => $request->s,
                's_fecha' => $s_fecha,
                's_deficiencia' => $s_deficiencia,
                's_severidad' => $s_severidad,
                's_producto' => $s_producto,
                's_fecha_aplicacion' => $s_fecha_aplicacion,
                's_foto' => $s_foto,

                'fe' => $request->fe,
                'fe_fecha' => $fe_fecha,
                'fe_deficiencia' => $fe_deficiencia,
                'fe_severidad' => $fe_severidad,
                'fe_producto' => $fe_producto,
                'fe_fecha_aplicacion' => $fe_fecha_aplicacion,
                'fe_foto' => $fe_foto,

                'zc' => $request->zc,
                'zc_fecha' => $zc_fecha,
                'zc_deficiencia' => $zc_deficiencia,
                'zc_severidad' => $zc_severidad,
                'zc_producto' => $zc_producto,
                'zc_fecha_aplicacion' => $zc_fecha_aplicacion,
                'zc_foto' => $zc_foto,

                'cu' => $request->cu,
                'cu_fecha' => $cu_fecha,
                'cu_deficiencia' => $cu_deficiencia,
                'cu_severidad' => $cu_severidad,
                'cu_producto' => $cu_producto,
                'cu_fecha_aplicacion' => $cu_fecha_aplicacion,
                'cu_foto' => $cu_foto,

                'b' => $request->b,
                'b_fecha' => $b_fecha,
                'b_deficiencia' => $b_deficiencia,
                'b_severidad' => $b_severidad,
                'b_producto' => $b_producto,
                'b_fecha_aplicacion' => $b_fecha_aplicacion,
                'b_foto' => $b_foto,

                'created_at' => $tiempo_actual,
                'updated_at' => $tiempo_actual,
                'activo' => 1]
      ]);
      return redirect('/home_encuestas')->with('mensaje_exito', 'Encuesta de Deficiencia Guardada Exitosamente');
    }

    public function enfermedades_guardar(Request $request){
      $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));

      //Tomamos los valores y les asignamos valores según corresponda
      if ($request->cercospora == 1) {
        $cercospora_fecha = $request->cercospora_fecha;
        $cercospora_area_afectada = "";
        //Concatenamos todas las areas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->cercospora_area_afectada);$i++){
          if ($cercospora_area_afectada == "") {
            $cercospora_area_afectada = $request->cercospora_area_afectada[$i];
          }
          else {
            $cercospora_area_afectada = $cercospora_area_afectada." & ".$request->cercospora_area_afectada[$i];
          }
        }
        $cercospora_incidencia = $request->cercospora_incidencia;
        $cercospora_recomendacion = $request->cercospora_recomendacion;
        if ($request->cercospora_foto){
          $cercospora_foto = Enfermedad::setFoto($request->cercospora_foto);
        }else{
          $cercospora_foto = "";
        }
      }
      else {
        $cercospora_fecha = "0000-00-00";
        $cercospora_area_afectada = "";
        $cercospora_incidencia = 0;
        $cercospora_recomendacion = "";
        $cercospora_foto = "";
      }

      if ($request->roya == 1) {
        $roya_fecha = $request->roya_fecha;
        $roya_area_afectada = "";
        //Concatenamos todas las areas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->roya_area_afectada);$i++){
          if ($roya_area_afectada == "") {
            $roya_area_afectada = $request->roya_area_afectada[$i];
          }
          else {
            $roya_area_afectada = $roya_area_afectada." & ".$request->roya_area_afectada[$i];
          }
        }
        $roya_incidencia = $request->roya_incidencia;
        $roya_recomendacion = $request->roya_recomendacion;
        if ($request->roya_foto){
          $roya_foto = Enfermedad::setFoto($request->roya_foto);
        }else{
          $roya_foto = "";
        }
      }
      else {
        $roya_fecha = "0000-00-00";
        $roya_area_afectada = "";
        $roya_incidencia = 0;
        $roya_recomendacion = "";
          $roya_foto = "";
      }

      if ($request->gallo == 1) {
        $gallo_fecha = $request->gallo_fecha;
        $gallo_area_afectada = "";
        //Concatenamos todas las areas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->gallo_area_afectada);$i++){
          if ($gallo_area_afectada == "") {
            $gallo_area_afectada = $request->gallo_area_afectada[$i];
          }
          else {
            $gallo_area_afectada = $gallo_area_afectada." & ".$request->gallo_area_afectada[$i];
          }
        }
        $gallo_incidencia = $request->gallo_incidencia;
        $gallo_recomendacion = $request->gallo_recomendacion;
        if ($request->gallo_foto){
          $gallo_foto = Enfermedad::setFoto($request->gallo_foto);
        }else{
          $gallo_foto = "";
        }
      }
      else {
        $gallo_fecha = "0000-00-00";
        $gallo_area_afectada = "";
        $gallo_incidencia = 0;
        $gallo_recomendacion = "";
        $gallo_foto = "";
      }

      if ($request->antracnosis == 1) {
        $antracnosis_fecha = $request->antracnosis_fecha;
        $antracnosis_area_afectada = "";
        //Concatenamos todas las areas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->antracnosis_area_afectada);$i++){
          if ($antracnosis_area_afectada == "") {
            $antracnosis_area_afectada = $request->antracnosis_area_afectada[$i];
          }
          else {
            $antracnosis_area_afectada = $antracnosis_area_afectada." & ".$request->antracnosis_area_afectada[$i];
          }
        }
        $antracnosis_incidencia = $request->antracnosis_incidencia;
        $antracnosis_recomendacion = $request->antracnosis_recomendacion;
        if ($request->antracnosis_foto){
          $antracnosis_foto = Enfermedad::setFoto($request->antracnosis_foto);
        }else{
          $antracnosis_foto = "";
        }
      }
      else {
        $antracnosis_fecha = "0000-00-00";
        $antracnosis_area_afectada = "";
        $antracnosis_incidencia = 0;
        $antracnosis_recomendacion = "";
          $antracnosis_foto = "";
      }

      if ($request->marchites == 1) {
        $marchites_fecha = $request->marchites_fecha;
        $marchites_area_afectada = "";
        //Concatenamos todas las areas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->marchites_area_afectada);$i++){
          if ($marchites_area_afectada == "") {
            $marchites_area_afectada = $request->marchites_area_afectada[$i];
          }
          else {
            $marchites_area_afectada = $marchites_area_afectada." & ".$request->marchites_area_afectada[$i];
          }
        }
        $marchites_incidencia = $request->marchites_incidencia;
        $marchites_recomendacion = $request->marchites_recomendacion;
        if ($request->marchites_foto){
          $marchites_foto = Enfermedad::setFoto($request->marchites_foto);
        }else{
          $marchites_foto = "";
        }
      }
      else {
        $marchites_fecha = "0000-00-00";
        $marchites_area_afectada = "";
        $marchites_incidencia = 0;
        $marchites_recomendacion = "";
        $marchites_foto = "";
      }

      if ($request->gotera == 1) {
        $gotera_fecha = $request->gotera_fecha;
        $gotera_area_afectada = "";
        //Concatenamos todas las areas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->gotera_area_afectada);$i++){
          if ($gotera_area_afectada == "") {
            $gotera_area_afectada = $request->gotera_area_afectada[$i];
          }
          else {
            $gotera_area_afectada = $gotera_area_afectada." & ".$request->gotera_area_afectada[$i];
          }
        }
        $gotera_incidencia = $request->gotera_incidencia;
        $gotera_recomendacion = $request->gotera_recomendacion;
        if ($request->gotera_foto){
          $gotera_foto = Enfermedad::setFoto($request->gotera_foto);
        }else{
          $gotera_foto = "";
        }
      }
      else {
        $gotera_fecha = "0000-00-00";
        $gotera_area_afectada = "";
        $gotera_incidencia = 0;
        $gotera_recomendacion = "";
        $gotera_foto = "";
      }

      if ($request->mancha == 1) {
        $mancha_fecha = $request->mancha_fecha;
        $mancha_area_afectada = "";
        //Concatenamos todas las areas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->mancha_area_afectada);$i++){
          if ($mancha_area_afectada == "") {
            $mancha_area_afectada = $request->mancha_area_afectada[$i];
          }
          else {
            $mancha_area_afectada = $mancha_area_afectada." & ".$request->mancha_area_afectada[$i];
          }
        }
        $mancha_incidencia = $request->mancha_incidencia;
        $mancha_recomendacion = $request->mancha_recomendacion;
        if ($request->mancha_foto){
          $mancha_foto = Enfermedad::setFoto($request->mancha_foto);
        }else{
          $mancha_foto = "";
        }
      }
      else {
        $mancha_fecha = "0000-00-00";
        $mancha_area_afectada = "";
        $mancha_incidencia = 0;
        $mancha_recomendacion = "";
        $mancha_foto = "";
      }

      if ($request->pudricion == 1) {
        $pudricion_fecha = $request->pudricion_fecha;
        $pudricion_area_afectada = "";
        //Concatenamos todas las areas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->pudricion_area_afectada);$i++){
          if ($pudricion_area_afectada == "") {
            $pudricion_area_afectada = $request->pudricion_area_afectada[$i];
          }
          else {
            $pudricion_area_afectada = $pudricion_area_afectada." & ".$request->pudricion_area_afectada[$i];
          }
        }
        $pudricion_incidencia = $request->pudricion_incidencia;
        $pudricion_recomendacion = $request->pudricion_recomendacion;
        if ($request->pudricion_foto){
          $pudricion_foto = Enfermedad::setFoto($request->pudricion_foto);
        }else{
          $pudricion_foto = "";
        }
      }
      else {
        $pudricion_fecha = "0000-00-00";
        $pudricion_area_afectada = "";
        $pudricion_incidencia = 0;
        $pudricion_recomendacion = "";
        $pudricion_foto = "";
      }

      if ($request->rosado == 1) {
        $rosado_fecha = $request->rosado_fecha;
        $rosado_area_afectada = "";
        //Concatenamos todas las areas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->rosado_area_afectada);$i++){
          if ($rosado_area_afectada == "") {
            $rosado_area_afectada = $request->rosado_area_afectada[$i];
          }
          else {
            $rosado_area_afectada = $rosado_area_afectada." & ".$request->rosado_area_afectada[$i];
          }
        }
        $rosado_incidencia = $request->rosado_incidencia;
        $rosado_recomendacion = $request->rosado_recomendacion;
        if ($request->rosado_foto){
          $rosado_foto = Enfermedad::setFoto($request->rosado_foto);
        }else{
          $rosado_foto = "";
        }
      }
      else {
        $rosado_fecha = "0000-00-00";
        $rosado_area_afectada = "";
        $rosado_incidencia = 0;
        $rosado_recomendacion = "";
        $rosado_foto = "";
      }

      if ($request->moho == 1) {
        $moho_fecha = $request->moho_fecha;
        $moho_area_afectada = "";
        //Concatenamos todas las areas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->moho_area_afectada);$i++){
          if ($moho_area_afectada == "") {
            $moho_area_afectada = $request->moho_area_afectada[$i];
          }
          else {
            $moho_area_afectada = $moho_area_afectada." & ".$request->moho_area_afectada[$i];
          }
        }
        $moho_incidencia = $request->moho_incidencia;
        $moho_recomendacion = $request->moho_recomendacion;
        if ($request->moho_foto){
          $moho_foto = Enfermedad::setFoto($request->moho_foto);
        }else{
          $moho_foto = "";
        }
      }
      else {
        $moho_fecha = "0000-00-00";
        $moho_area_afectada = "";
        $moho_incidencia = 0;
        $moho_recomendacion = "";
        $moho_foto = "";
      }


     \DB::table('enc_enfermedades')->insert([
                ['object_id' => Auth::user()->object_id,
                'cercospora' => $request->cercospora,
                'cercospora_fecha' => $cercospora_fecha,
                'cercospora_area_afectada' => $cercospora_area_afectada,
                'cercospora_incidencia' => $cercospora_incidencia,
                'cercospora_recomendacion' => $cercospora_recomendacion,
                'cercospora_foto' => $cercospora_foto,

                'roya' => $request->roya,
                'roya_fecha' => $roya_fecha,
                'roya_area_afectada' => $roya_area_afectada,
                'roya_incidencia' => $roya_incidencia,
                'roya_recomendacion' => $roya_recomendacion,
                'roya_foto' => $roya_foto,

                'gallo' => $request->gallo,
                'gallo_fecha' => $gallo_fecha,
                'gallo_area_afectada' => $gallo_area_afectada,
                'gallo_incidencia' => $gallo_incidencia,
                'gallo_recomendacion' => $gallo_recomendacion,
                'gallo_foto' => $gallo_foto,

                'antracnosis' => $request->antracnosis,
                'antracnosis_fecha' => $antracnosis_fecha,
                'antracnosis_area_afectada' => $antracnosis_area_afectada,
                'antracnosis_incidencia' => $antracnosis_incidencia,
                'antracnosis_recomendacion' => $antracnosis_recomendacion,
                'antracnosis_foto' => $antracnosis_foto,

                'marchites' => $request->marchites,
                'marchites_fecha' => $marchites_fecha,
                'marchites_area_afectada' => $marchites_area_afectada,
                'marchites_incidencia' => $marchites_incidencia,
                'marchites_recomendacion' => $marchites_recomendacion,
                'marchites_foto' => $marchites_foto,

                'gotera' => $request->gotera,
                'gotera_fecha' => $gotera_fecha,
                'gotera_area_afectada' => $gotera_area_afectada,
                'gotera_incidencia' => $gotera_incidencia,
                'gotera_recomendacion' => $gotera_recomendacion,
                'gotera_foto' => $gotera_foto,

                'mancha' => $request->mancha,
                'mancha_fecha' => $mancha_fecha,
                'mancha_area_afectada' => $mancha_area_afectada,
                'mancha_incidencia' => $mancha_incidencia,
                'mancha_recomendacion' => $mancha_recomendacion,
                'mancha_foto' => $mancha_foto,

                'pudricion' => $request->pudricion,
                'pudricion_fecha' => $pudricion_fecha,
                'pudricion_area_afectada' => $pudricion_area_afectada,
                'pudricion_incidencia' => $pudricion_incidencia,
                'pudricion_recomendacion' => $pudricion_recomendacion,
                'pudricion_foto' => $pudricion_foto,

                'rosado' => $request->rosado,
                'rosado_fecha' => $rosado_fecha,
                'rosado_area_afectada' => $rosado_area_afectada,
                'rosado_incidencia' => $rosado_incidencia,
                'rosado_recomendacion' => $rosado_recomendacion,
                'rosado_foto' => $rosado_foto,

                'moho' => $request->moho,
                'moho_fecha' => $moho_fecha,
                'moho_area_afectada' => $moho_area_afectada,
                'moho_incidencia' => $moho_incidencia,
                'moho_recomendacion' => $moho_recomendacion,
                'moho_foto' => $moho_foto,

                'created_at' => $tiempo_actual,
                'updated_at' => $tiempo_actual,
                'activo' => 1]
      ]);
      return redirect('/home_encuestas')->with('mensaje_exito', 'Encuesta de Enfermedades Guardada Exitosamente');
    }

    public function plagas_guardar(Request $request){
      $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));

      //Tomamos los valores y les asignamos valores según corresponda
      if ($request->broca == 1) {
        $broca_fecha = $request->broca_fecha;
        $broca_zona_afectada = "";
        //Concatenamos todas las zonas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->broca_zona_afectada);$i++){
          if ($broca_zona_afectada == "") {
            $broca_zona_afectada = $request->broca_zona_afectada[$i];
          }
          else {
            $broca_zona_afectada = $broca_zona_afectada." & ".$request->broca_zona_afectada[$i];
          }
        }
        $broca_incidencia = $request->broca_incidencia;
        $broca_control = $request->broca_control;
      }
      else {
        $broca_fecha = "0000-00-00";
        $broca_zona_afectada = "";
        $broca_incidencia = 0;
        $broca_control = "";
      }

      if ($request->cepe == 1) {
        $cepe_fecha = $request->cepe_fecha;
        $cepe_zona_afectada = "";
        //Concatenamos todas las zonas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->cepe_zona_afectada);$i++){
          if ($cepe_zona_afectada == "") {
            $cepe_zona_afectada = $request->cepe_zona_afectada[$i];
          }
          else {
            $cepe_zona_afectada = $cepe_zona_afectada." & ".$request->cepe_zona_afectada[$i];
          }
        }
        $cepe_incidencia = $request->cepe_incidencia;
        $cepe_control = $request->cepe_control;
      }
      else {
        $cepe_fecha = "0000-00-00";
        $cepe_zona_afectada = "";
        $cepe_incidencia = 0;
        $cepe_control = "";
      }

      if ($request->grillo == 1) {
        $grillo_fecha = $request->grillo_fecha;
        $grillo_zona_afectada = "";
        //Concatenamos todas las zonas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->grillo_zona_afectada);$i++){
          if ($grillo_zona_afectada == "") {
            $grillo_zona_afectada = $request->grillo_zona_afectada[$i];
          }
          else {
            $grillo_zona_afectada = $grillo_zona_afectada." & ".$request->grillo_zona_afectada[$i];
          }
        }
        $grillo_incidencia = $request->grillo_incidencia;
        $grillo_control = $request->grillo_control;
      }
      else {
        $grillo_fecha = "0000-00-00";
        $grillo_zona_afectada = "";
        $grillo_incidencia = 0;
        $grillo_control = "";
      }

      if ($request->cochinilla == 1) {
        $cochinilla_fecha = $request->cochinilla_fecha;
        $cochinilla_zona_afectada = "";
        //Concatenamos todas las zonas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->cochinilla_zona_afectada);$i++){
          if ($cochinilla_zona_afectada == "") {
            $cochinilla_zona_afectada = $request->cochinilla_zona_afectada[$i];
          }
          else {
            $cochinilla_zona_afectada = $cochinilla_zona_afectada." & ".$request->cochinilla_zona_afectada[$i];
          }
        }
        $cochinilla_incidencia = $request->cochinilla_incidencia;
        $cochinilla_control = $request->cochinilla_control;
      }
      else {
        $cochinilla_fecha = "0000-00-00";
        $cochinilla_zona_afectada = "";
        $cochinilla_incidencia = 0;
        $cochinilla_control = "";
      }

      if ($request->escamas == 1) {
        $escamas_fecha = $request->escamas_fecha;
        $escamas_zona_afectada = "";
        //Concatenamos todas las zonas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->escamas_zona_afectada);$i++){
          if ($escamas_zona_afectada == "") {
            $escamas_zona_afectada = $request->escamas_zona_afectada[$i];
          }
          else {
            $escamas_zona_afectada = $escamas_zona_afectada." & ".$request->escamas_zona_afectada[$i];
          }
        }
        $escamas_incidencia = $request->escamas_incidencia;
        $escamas_control = $request->escamas_control;
      }
      else {
        $escamas_fecha = "0000-00-00";
        $escamas_zona_afectada = "";
        $escamas_incidencia = 0;
        $escamas_control = "";
      }

      if ($request->minador == 1) {
        $minador_fecha = $request->minador_fecha;
        $minador_zona_afectada = "";
        //Concatenamos todas las zonas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->minador_zona_afectada);$i++){
          if ($minador_zona_afectada == "") {
            $minador_zona_afectada = $request->minador_zona_afectada[$i];
          }
          else {
            $minador_zona_afectada = $minador_zona_afectada." & ".$request->minador_zona_afectada[$i];
          }
        }
        $minador_incidencia = $request->minador_incidencia;
        $minador_control = $request->minador_control;
      }
      else {
        $minador_fecha = "0000-00-00";
        $minador_zona_afectada = "";
        $minador_incidencia = 0;
        $minador_control = "";
      }

      if ($request->barrenador == 1) {
        $barrenador_fecha = $request->barrenador_fecha;
        $barrenador_zona_afectada = "";
        //Concatenamos todas las zonas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->barrenador_zona_afectada);$i++){
          if ($barrenador_zona_afectada == "") {
            $barrenador_zona_afectada = $request->barrenador_zona_afectada[$i];
          }
          else {
            $barrenador_zona_afectada = $barrenador_zona_afectada." & ".$request->barrenador_zona_afectada[$i];
          }
        }
        $barrenador_incidencia = $request->barrenador_incidencia;
        $barrenador_control = $request->barrenador_control;
      }
      else {
        $barrenador_fecha = "0000-00-00";
        $barrenador_zona_afectada = "";
        $barrenador_incidencia = 0;
        $barrenador_control = "";
      }

      if ($request->nematodos == 1) {
        $nematodos_fecha = $request->nematodos_fecha;
        $nematodos_zona_afectada = "";
        //Concatenamos todas las zonas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->nematodos_zona_afectada);$i++){
          if ($nematodos_zona_afectada == "") {
            $nematodos_zona_afectada = $request->nematodos_zona_afectada[$i];
          }
          else {
            $nematodos_zona_afectada = $nematodos_zona_afectada." & ".$request->nematodos_zona_afectada[$i];
          }
        }
        $nematodos_incidencia = $request->nematodos_incidencia;
        $nematodos_control = $request->nematodos_control;
      }
      else {
        $nematodos_fecha = "0000-00-00";
        $nematodos_zona_afectada = "";
        $nematodos_incidencia = 0;
        $nematodos_control = "";
      }


     \DB::table('enc_plagas')->insert([
                ['object_id' => Auth::user()->object_id,
                'broca' => $request->broca,
                'broca_fecha' => $broca_fecha,
                'broca_zona_afectada' => $broca_zona_afectada,
                'broca_incidencia' => $broca_incidencia,
                'broca_control' => $broca_control,

                'cepe' => $request->cepe,
                'cepe_fecha' => $cepe_fecha,
                'cepe_zona_afectada' => $cepe_zona_afectada,
                'cepe_incidencia' => $cepe_incidencia,
                'cepe_control' => $cepe_control,

                'grillo' => $request->grillo,
                'grillo_fecha' => $grillo_fecha,
                'grillo_zona_afectada' => $grillo_zona_afectada,
                'grillo_incidencia' => $grillo_incidencia,
                'grillo_control' => $grillo_control,

                'cochinilla' => $request->cochinilla,
                'cochinilla_fecha' => $cochinilla_fecha,
                'cochinilla_zona_afectada' => $cochinilla_zona_afectada,
                'cochinilla_incidencia' => $cochinilla_incidencia,
                'cochinilla_control' => $cochinilla_control,

                'escamas' => $request->escamas,
                'escamas_fecha' => $escamas_fecha,
                'escamas_zona_afectada' => $escamas_zona_afectada,
                'escamas_incidencia' => $escamas_incidencia,
                'escamas_control' => $escamas_control,

                'minador' => $request->minador,
                'minador_fecha' => $minador_fecha,
                'minador_zona_afectada' => $minador_zona_afectada,
                'minador_incidencia' => $minador_incidencia,
                'minador_control' => $minador_control,

                'barrenador' => $request->barrenador,
                'barrenador_fecha' => $barrenador_fecha,
                'barrenador_zona_afectada' => $barrenador_zona_afectada,
                'barrenador_incidencia' => $barrenador_incidencia,
                'barrenador_control' => $barrenador_control,

                'nematodos' => $request->nematodos,
                'nematodos_fecha' => $nematodos_fecha,
                'nematodos_zona_afectada' => $nematodos_zona_afectada,
                'nematodos_incidencia' => $nematodos_incidencia,
                'nematodos_control' => $nematodos_control,

                'created_at' => $tiempo_actual,
                'updated_at' => $tiempo_actual,
                'activo' => 1]
      ]);
      return redirect('/home_encuestas')->with('mensaje_exito', 'Encuesta de Plagas Guardada Exitosamente');
    }


    public function fertilizaciones_guardar(Request $request){
      $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));

      //Tomamos los valores y les asignamos valores según corresponda
      if ($request->vegetativo == 1) {
        $vegetativo_fecha = $request->vegetativo_fecha;
        $vegetativo_fecha_aplicacion = $request->vegetativo_fecha_aplicacion;
        $vegetativo_bioles_producto = $request->vegetativo_bioles_producto;
        $vegetativo_bioles_dosis = $request->vegetativo_bioles_dosis;
        $vegetativo_purines_producto = $request->vegetativo_purines_producto;
        $vegetativo_purines_dosis = $request->vegetativo_purines_dosis;
      }
      else {
        $vegetativo_fecha = "0000-00-00";
        $vegetativo_fecha_aplicacion = "0000-00-00";
        $vegetativo_bioles_producto = "";
        $vegetativo_bioles_dosis = 0;
        $vegetativo_purines_producto = "";
        $vegetativo_purines_dosis = 0;
      }

      if ($request->reproductivo == 1) {
        $reproductivo_fecha = $request->reproductivo_fecha;
        $reproductivo_fecha_aplicacion = $request->reproductivo_fecha_aplicacion;
        $reproductivo_producto = $request->reproductivo_producto;
        $reproductivo_dosis = $request->reproductivo_dosis;
      }
      else {
        $reproductivo_fecha = "0000-00-00";
        $reproductivo_fecha_aplicacion = "0000-00-00";
        $reproductivo_producto = "";
        $reproductivo_dosis = 0;
      }

      if ($request->floracion == 1) {
        $floracion_fecha = $request->floracion_fecha;
        $floracion_fecha_aplicacion = $request->floracion_fecha_aplicacion;
        $floracion_producto = $request->floracion_producto;
        $floracion_dosis = $request->floracion_dosis;
      }
      else {
        $floracion_fecha = "0000-00-00";
        $floracion_fecha_aplicacion = "0000-00-00";
        $floracion_producto = "";
        $floracion_dosis = 0;
      }

      if ($request->fructificacion == 1) {
        $fructificacion_fecha = $request->fructificacion_fecha;
        $fructificacion_fecha_aplicacion = $request->fructificacion_fecha_aplicacion;
        $fructificacion_producto = $request->fructificacion_producto;
        $fructificacion_dosis = $request->fructificacion_dosis;
      }
      else {
        $fructificacion_fecha = "0000-00-00";
        $fructificacion_fecha_aplicacion = "0000-00-00";
        $fructificacion_producto = "";
        $fructificacion_dosis = 0;
      }


     \DB::table('enc_fertilizaciones')->insert([
                ['object_id' => Auth::user()->object_id,
                'vegetativo' => $request->vegetativo,
                'vegetativo_fecha' => $vegetativo_fecha,
                'vegetativo_fecha_aplicacion' => $vegetativo_fecha_aplicacion,
                'vegetativo_bioles_producto' => $vegetativo_bioles_producto,
                'vegetativo_bioles_dosis' => $vegetativo_bioles_dosis,
                'vegetativo_purines_producto' => $vegetativo_purines_producto,
                'vegetativo_purines_dosis' => $vegetativo_purines_dosis,

                'reproductivo' => $request->reproductivo,
                'reproductivo_fecha' => $reproductivo_fecha,
                'reproductivo_fecha_aplicacion' => $reproductivo_fecha_aplicacion,
                'reproductivo_producto' => $reproductivo_producto,
                'reproductivo_dosis' => $reproductivo_dosis,

                'floracion' => $request->floracion,
                'floracion_fecha' => $floracion_fecha,
                'floracion_fecha_aplicacion' => $floracion_fecha_aplicacion,
                'floracion_producto' => $floracion_producto,
                'floracion_dosis' => $floracion_dosis,

                'fructificacion' => $request->fructificacion,
                'fructificacion_fecha' => $fructificacion_fecha,
                'fructificacion_fecha_aplicacion' => $fructificacion_fecha_aplicacion,
                'fructificacion_producto' => $fructificacion_producto,
                'fructificacion_dosis' => $fructificacion_dosis,

                'created_at' => $tiempo_actual,
                'updated_at' => $tiempo_actual,
                'activo' => 1]
      ]);
      return redirect('/home_encuestas')->with('mensaje_exito', 'Encuesta de Fertilizacion Guardada Exitosamente');
    }


    //FORMS EDITAR
    public function form_informacion_basica_editar(){
      $departamentos = \DB::table('departamentos')
                      ->where('activo', 1)
                      ->orderBy('departamento')
                      ->get();

      $dato = \DB::table('enc_productores')->where('object_id', Auth::user()->object_id)->where('activo', 1)->first();


      $provincias = \DB::table('provincias')
                    ->where('id_departamento', $dato->id_departamento)
                    ->where('activo', 1)
                    ->distinct()
                    ->orderBy('provincia', 'asc')
                    ->get();

      $municipios = \DB::table('municipios')
                    ->where('id_provincia', $dato->id_provincia)
                    ->where('activo', 1)
                    ->distinct()
                    ->orderBy('municipio', 'asc')
                    ->get();

      return view("formularios.encuestas.form_informacion_basica_editar", compact('dato'))
            ->with('departamentos', $departamentos)
            ->with('provincias', $provincias)
            ->with('municipios', $municipios);
    }

    public function form_densidad_editar($id){
      $id_densidad = base64_decode($id);
      $dato = \DB::table('enc_densidad')->where('id_densidad', $id_densidad)->first();
      return view("formularios.encuestas.form_densidad_editar", compact('dato'));
    }

    public function form_sist_agroforestales_editar($id){
      $id_sist_agroforestal = base64_decode($id);
      $dato = \DB::table('enc_sist_agroforestales')->where('id_sist_agroforestal', $id_sist_agroforestal)->first();
      return view("formularios.encuestas.form_sist_agroforestales_editar", compact('dato'));
    }

    public function form_preparacion_editar($id){
        $id = base64_decode($id);
        $dato = \DB::table('enc_preparaciones')->where('id_preparacion', $id)->first();
        return view("formularios.encuestas.form_preparacion_editar", compact('dato'));
    }
    public function form_podas_editar($id){
        $id = base64_decode($id);
        $dato = \DB::table('enc_podas')->where('id_poda', $id)->first();
        return view("formularios.encuestas.form_podas_editar", compact('dato'));
    }

    public function form_controles_editar($id){
        $id = base64_decode($id);
        $dato = \DB::table('enc_controles_maleza')->where('id_control_maleza', $id)->first();
        return view("formularios.encuestas.form_controles_editar", compact('dato'));
    }

    public function form_cosecha_editar($id){
      $id_cosecha = base64_decode($id);
      $dato = \DB::table('enc_cosechas')->where('id_cosecha', $id_cosecha)->first();
      return view("formularios.encuestas.form_cosecha_editar", compact('dato'));
    }

    public function form_post_cosecha_editar($id){
      $id_post_cosecha = base64_decode($id);
      $dato = \DB::table('enc_post_cosechas')->where('id_post_cosecha', $id_post_cosecha)->first();
      return view("formularios.encuestas.form_post_cosecha_editar", compact('dato'));
    }

    public function form_secado_editar($id){
      $id_secado = base64_decode($id);
      $dato = \DB::table('enc_secados')->where('id_secado', $id_secado)->first();
      return view("formularios.encuestas.form_secado_editar", compact('dato'));
    }

    public function form_deficiencias_editar($id){
      $id_deficiencia = base64_decode($id);
      $dato = \DB::table('enc_deficiencias')->where('id_deficiencia', $id_deficiencia)->first();
      return view("formularios.encuestas.form_deficiencias_editar", compact('dato'));
    }

    public function form_enfermedades_editar($id){
      $id_enfermedad = base64_decode($id);
      $dato = \DB::table('enc_enfermedades')->where('id_enfermedad', $id_enfermedad)->first();
      return view("formularios.encuestas.form_enfermedades_editar", compact('dato'));
    }

    public function form_plagas_editar($id){
      $id_plaga = base64_decode($id);
      $dato = \DB::table('enc_plagas')->where('id_plaga', $id_plaga)->first();
      return view("formularios.encuestas.form_plagas_editar", compact('dato'));
    }

    public function form_fertilizaciones_editar($id){
      $id_fertilizacion = base64_decode($id);
      $dato = \DB::table('enc_fertilizaciones')->where('id_fertilizacion', $id_fertilizacion)->first();
      return view("formularios.encuestas.form_fertilizaciones_editar", compact('dato'));
    }




    //FORMS ACTUALIZAR
    public function informacion_basica_actualizar(Request $request){
        $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));

        //Establecemos el tipo de cultipo id
        if ($request->tipo_cultivo == "Cafe") {$tipo_cultivo_id = 1;}
        else {$tipo_cultivo_id = 2;}

        \DB::table('enc_productores')
              ->where('object_id', Auth::user()->object_id)
              ->where('activo', 1)
              ->update([ 'productor_nombres' => $request->productor_nombres,
                         'productor_paterno' => $request->productor_paterno,
                         'productor_materno' => $request->productor_materno,
                         'productor_ci' => $request->productor_ci,
                         'productor_sexo' => $request->productor_sexo,
                         'productor_telefono' => $request->productor_telefono,
                         'tecnico_responsable' => $request->tecnico_responsable,
                         'id_departamento' => $request->id_departamento,
                         'id_provincia' => $request->id_provincia,
                         'id_municipio' => $request->id_municipio,
                         'localidad' => $request->localidad,
                         'comunidad' => $request->comunidad,
                         'tipo_cultivo' => $request->tipo_cultivo,
                         'tipo_cultivo_id' => $tipo_cultivo_id,
                         'updated_at' => $tiempo_actual]);

        return redirect('/home_encuestas')->with('mensaje_exito', 'Información Básica Actualizada Exitosamente');
    }

    public function densidad_actualizar(Request $request, $id){

      $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));

      \DB::table('enc_densidad')
            ->where('id_densidad', $id)
            ->update(['ano' => $request->ano,
                       'densidad' => $request->densidad,
                       'superficie' => $request->superficie,
                       'cantidad_plantas' => $request->cantidad_plantas,
                       'plantas_muertas' => $request->plantas_muertas,
                       'plantas_efectivas' => $request->plntas_efectivas,
                       'updated_at' => $tiempo_actual]);

       return redirect('/home_encuestas')->with('mensaje_exito', 'Encuesta de Densidad de Plantación de Café Actualizada Exitosamente');
    }

    public function sist_agroforestales_actualizar(Request $request, $id){
      $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));

      //Tomamos los valores y les asignamos valores según corresponda
      if ($request->pacay == 1) {
        $pacay_fecha_siembra = $request->pacay_fecha_siembra;
        $pacay_cantidad = $request->pacay_cantidad;
        $pacay_permanente = $request->pacay_permanente;
      }
      else {
        $pacay_fecha_siembra = "0000-00-00";
        $pacay_cantidad = 0;
        $pacay_permanente = 0;
      }

      if ($request->platano == 1) {
        $platano_fecha_siembra = $request->platano_fecha_siembra;
        $platano_cantidad = $request->platano_cantidad;
        $platano_permanente = $request->platano_permanente;
      }
      else {
        $platano_fecha_siembra = "0000-00-00";
        $platano_cantidad = 0;
        $platano_permanente = 0;
      }

      if ($request->citricos == 1) {
        $citricos_fecha_siembra = $request->citricos_fecha_siembra;
        $citricos_cantidad = $request->citricos_cantidad;
        $citricos_permanente = $request->citricos_permanente;
      }
      else {
        $citricos_fecha_siembra = "0000-00-00";
        $citricos_cantidad = 0;
        $citricos_permanente = 0;
      }

      if ($request->maderables == 1) {
        $maderables_fecha_siembra = $request->maderables_fecha_siembra;
        $maderables_cantidad = $request->maderables_cantidad;
        $maderables_permanente = $request->maderables_permanente;
      }
      else {
        $maderables_fecha_siembra = "0000-00-00";
        $maderables_cantidad = 0;
        $maderables_permanente = 0;
      }

      if ($request->frutas_amazonicas == 1) {
        $frutas_amazonicas_fecha_siembra = $request->frutas_amazonicas_fecha_siembra;
        $frutas_amazonicas_cantidad = $request->frutas_amazonicas_cantidad;
        $frutas_amazonicas_permanente = $request->frutas_amazonicas_permanente;
      }
      else {
        $frutas_amazonicas_fecha_siembra = "0000-00-00";
        $frutas_amazonicas_cantidad = 0;
        $frutas_amazonicas_permanente = 0;
      }

      if ($request->otros == 1) {
        $otros_descripcion = $request->otros_descripcion;
        $otros_fecha_siembra = $request->otros_fecha_siembra;
        $otros_cantidad = $request->otros_cantidad;
        $otros_permanente = $request->otros_permanente;
      }
      else {
        $otros_descripcion = "";
        $otros_fecha_siembra = "0000-00-00";
        $otros_cantidad = 0;
        $otros_permanente = 0;
      }

      \DB::table('enc_sist_agroforestales')
            ->where('id_sist_agroforestal', $id)
            ->update(['ano' => $request->ano,
                      'pacay' => $request->pacay,
                      'pacay_fecha_siembra' => $pacay_fecha_siembra,
                      'pacay_cantidad' => $pacay_cantidad,
                      'pacay_permanente' => $pacay_permanente,
                      'platano' => $request->platano,
                      'platano_fecha_siembra' => $platano_fecha_siembra,
                      'platano_cantidad' => $platano_cantidad,
                      'platano_permanente' => $platano_permanente,
                      'citricos' => $request->citricos,
                      'citricos_fecha_siembra' => $citricos_fecha_siembra,
                      'citricos_cantidad' => $citricos_cantidad,
                      'citricos_permanente' => $citricos_permanente,
                      'maderables' => $request->maderables,
                      'maderables_fecha_siembra' => $maderables_fecha_siembra,
                      'maderables_cantidad' => $maderables_cantidad,
                      'maderables_permanente' => $maderables_permanente,
                      'frutas_amazonicas' => $request->frutas_amazonicas,
                      'frutas_amazonicas_fecha_siembra' => $frutas_amazonicas_fecha_siembra,
                      'frutas_amazonicas_cantidad' => $frutas_amazonicas_cantidad,
                      'frutas_amazonicas_permanente' => $frutas_amazonicas_permanente,
                      'otros' => $request->otros,
                      'otros_descripcion' => $otros_descripcion,
                      'otros_fecha_siembra' => $otros_fecha_siembra,
                      'otros_cantidad' => $otros_cantidad,
                      'otros_permanente' => $otros_permanente,
                      'updated_at' => $tiempo_actual]);

       return redirect('/home_encuestas')->with('mensaje_exito', 'Encuesta de Sistemas Agroforestales Actualizada Exitosamente');
    }


    public function preparacion_actualizar(Request $request, $id){

        $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));
        if($request->quema == 1){
            $con_quema = 1;
            $sin_quema = 0;

        } else{
            $con_quema = 0;
            $sin_quema = 1;
        }
        $dato = \DB::table('enc_preparaciones')->where('id_preparacion', $id)->update([
            'fecha' => $request->fecha,
            'con_quema' => $con_quema,
            'sin_quema' => $sin_quema,
            'updated_at' => $tiempo_actual
        ]);
        return redirect('/home_encuestas')->with('mensaje_exito', 'Encuesta de Información Básica Actualizada Exitosamente');
    }


    public function podas_actualizar(Request $request, $id){
        $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));

        //Tomamos los datos del registro a actualizar, para tomar la foto que cargaron previamente
        $selec_dato = \DB::table('enc_podas')->where('id_poda', $id)->first();

        //FORMACION DE PLANTAS
        if ($request->form_planta == 1) {
            $form_planta_fecha = $request->form_planta_fecha;
            $form_planta_fecha_final = $request->form_planta_fecha_final;
            if ($request->form_planta_foto){
              $form_planta_foto = Poda::setFoto($request->form_planta_foto);
            }else{
              $form_planta_foto = $selec_dato->form_planta_foto;
            }
          }
          else {
            $form_planta_fecha = "0000-00-00";
            $form_planta_fecha_final = "0000-00-00";
            $form_planta_foto = "";
          }

        //MANTENIMIENTO
        if ($request->mantenimiento == 1) {
            $mantenimiento_fecha = $request->mantenimiento_fecha;
            $mantenimiento_fecha_final = $request->mantenimiento_fecha_final;
            if ($request->mantenimiento_foto){
              $mantenimiento_foto = Poda::setFoto($request->mantenimiento_foto);
            }else{
              $mantenimiento_foto = $selec_dato->mantenimiento_foto;
            }
          }
          else {
            $mantenimiento_fecha = "0000-00-00";
            $mantenimiento_fecha_final = "0000-00-00";
            $mantenimiento_foto = "";
          }

        //SELECCION DE BROTES
        if ($request->sel_brotes == 1) {
            $sel_brotes_fecha = $request->sel_brotes_fecha;
            $sel_brotes_fecha_final = $request->sel_brotes_fecha_final;
            if ($request->sel_brotes_foto){
              $sel_brotes_foto = Poda::setFoto($request->sel_brotes_foto);
            }else{
              $sel_brotes_foto = $selec_dato->sel_brotes_foto;
            }
          }
          else {
            $sel_brotes_fecha = "0000-00-00";
            $sel_brotes_fecha_final = "0000-00-00";
            $sel_brotes_foto = "";
          }

        //REHABILITACION
        if ($request->rehabilitacion == 1) {
            $rehabilitacion_fecha = $request->rehabilitacion_fecha;
            $rehabilitacion_fecha_final = $request->rehabilitacion_fecha_final;
            if ($request->rehabilitacion_foto){
              $rehabilitacion_foto = Poda::setFoto($request->rehabilitacion_foto);
            }else{
              $rehabilitacion_foto = $selec_dato->rehabilitacion_foto;
            }
          }
          else {
            $rehabilitacion_fecha = "0000-00-00";
            $rehabilitacion_fecha_final = "0000-00-00";
            $rehabilitacion_foto = "";
          }

        //RENOVACION
        if ($request->renovacion == 1) {
            $renovacion_fecha = $request->renovacion_fecha;
            $renovacion_fecha_final = $request->renovacion_fecha_final;
            if ($request->renovacion_foto){
              $renovacion_foto = Poda::setFoto($request->renovacion_foto);
            }else{
              $renovacion_foto = $selec_dato->renovacion_foto;
            }
          }
          else {
            $renovacion_fecha = "0000-00-00";
            $renovacion_fecha_final = "0000-00-00";
            $renovacion_foto = "";
          }

        //DESHOJE Y DESPUNTE
        if ($request->deshoje_despunte == 1) {
            $deshoje_despunte_fecha = $request->deshoje_despunte_fecha;
            $deshoje_despunte_fecha_final = $request->deshoje_despunte_fecha_final;
            if ($request->deshoje_despunte_foto){
              $deshoje_despunte_foto = Poda::setFoto($request->deshoje_despunte_foto);
            }else{
              $deshoje_despunte_foto = $selec_dato->deshoje_despunte_foto;
            }
          }
          else {
            $deshoje_despunte_fecha = "0000-00-00";
            $deshoje_despunte_fecha_final = "0000-00-00";
            $deshoje_despunte_foto = "";
          }

          $dato = \DB::table('enc_podas')->where('id_poda', $id)->update([
                'form_planta' => $request->form_planta,
                'form_planta_fecha' => $form_planta_fecha,
                'form_planta_fecha_final' => $form_planta_fecha_final,
                'form_planta_foto' => $form_planta_foto,
                'mantenimiento' => $request->mantenimiento,
                'mantenimiento_fecha' => $mantenimiento_fecha,
                'mantenimiento_fecha_final' => $mantenimiento_fecha_final,
                'mantenimiento_foto' => $mantenimiento_foto,
                'sel_brotes' => $request->sel_brotes,
                'sel_brotes_fecha' => $sel_brotes_fecha,
                'sel_brotes_fecha_final' => $sel_brotes_fecha_final,
                'sel_brotes_foto' => $sel_brotes_foto,
                'rehabilitacion' => $request->rehabilitacion,
                'rehabilitacion_fecha' => $rehabilitacion_fecha,
                'rehabilitacion_fecha_final' => $rehabilitacion_fecha_final,
                'rehabilitacion_foto' => $rehabilitacion_foto,
                'renovacion' => $request->renovacion,
                'renovacion_fecha' => $renovacion_fecha,
                'renovacion_fecha_final' => $renovacion_fecha_final,
                'renovacion_foto' => $renovacion_foto,
                'deshoje_despunte' => $request->deshoje_despunte,
                'deshoje_despunte_fecha' => $deshoje_despunte_fecha,
                'deshoje_despunte_fecha_final' => $deshoje_despunte_fecha_final,
                'deshoje_despunte_foto' => $deshoje_despunte_foto,
                'updated_at' => $tiempo_actual,
            ]);

            return redirect('/home_encuestas')->with('mensaje_exito', 'Encuesta de Podas Actualizada Exitosamente');

    }

    public function controles_actualizar(Request $request, $id){

        $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));

        //METODO BIOLOGICO
        if ($request->biologico == 1) {
            $biologico_fecha = $request->biologico_fecha;
            $biologico_producto = $request->biologico_producto;
        }
        else {
            $biologico_fecha = "0000-00-00";
            $biologico_producto = "";
        }

        //METODO QUIMICO
        if ($request->quimico == 1) {
            $quimico_fecha = $request->quimico_fecha;
            $quimico_producto = $request->quimico_producto;
        }
        else {
            $quimico_fecha = "0000-00-00";
            $quimico_producto = "";
        }

        //METODO MECANICO
        if ($request->mecanico == 1) {
            $mecanico_fecha = $request->mecanico_fecha;
            $mecanico_producto = $request->mecanico_producto;
        }
        else {
            $mecanico_fecha = "0000-00-00";
            $mecanico_producto = "";
        }

        $dato = \DB::table('enc_controles_maleza')->where('id_control_maleza', $id)->update([
            'biologico' => $request->biologico,
            'biologico_fecha' => $biologico_fecha,
            'biologico_producto' => $biologico_producto,
            'quimico' => $request->quimico,
            'quimico_fecha' => $quimico_fecha,
            'quimico_producto' => $quimico_producto,
            'mecanico' => $request->mecanico,
            'mecanico_fecha' => $mecanico_fecha,
            'mecanico_producto' => $mecanico_producto,
            'updated_at' => $tiempo_actual
        ]);
        return redirect('/home_encuestas')->with('mensaje_exito', 'Encuesta de Control de Malezas Actualizada Exitosamente');
    }

    public function cosecha_actualizar(Request $request, $id){
        $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));

        //Tomamos los valores y les asignamos valores según corresponda
        if ($request->metodo == 1) {
          $manual = 1;
          $mecanica = 0;
        }
        else {
          $manual = 0;
          $mecanica = 1;
        }

        $dato = \DB::table('enc_cosechas')
                ->where('id_cosecha', $id)
                ->update([
                   'fecha' => $request->fecha,
                   'manual' => $manual,
                   'mecanica' => $mecanica,
                   'peso_bruto' => $request->peso_bruto,
                   'updated_at' => $tiempo_actual
        ]);

        return redirect('/home_encuestas')->with('mensaje_exito', 'Encuesta de Cosecha Actualizada Exitosamente');
    }

    public function post_cosecha_actualizar(Request $request, $id){
      $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));

      //Tomamos los valores y les asignamos valores según corresponda
      if ($request->cosecha == 1) {
        $cosecha_fecha = $request->cosecha_fecha;
        $cosecha_p_bruto = $request->cosecha_p_bruto;
        $cosecha_p_descarte = $request->cosecha_p_descarte;
        $cosecha_p_efecivo = $request->cosecha_p_efectivo;
      }
      else {
        $cosecha_fecha = "0000-00-00";
        $cosecha_p_bruto = 0;
        $cosecha_p_descarte = 0;
        $cosecha_p_efecivo = 0;
      }

      if ($request->limpieza == 1) {
        $limpieza_fecha = $request->limpieza_fecha;
        $limpieza_p_bruto = $request->limpieza_p_bruto;
        $limpieza_p_descarte = $request->limpieza_p_descarte;
        $limpieza_p_efecivo = $request->limpieza_p_efectivo;
      }
      else {
        $limpieza_fecha = "0000-00-00";
        $limpieza_p_bruto = 0;
        $limpieza_p_descarte = 0;
        $limpieza_p_efecivo = 0;
      }

      if ($request->despulpado == 1) {
        $despulpado_fecha = $request->despulpado_fecha;
        $despulpado_p_bruto = $request->despulpado_p_bruto;
        $despulpado_p_descarte = $request->despulpado_p_descarte;
        $despulpado_p_efecivo = $request->despulpado_p_efectivo;
      }
      else {
        $despulpado_fecha = "0000-00-00";
        $despulpado_p_bruto = 0;
        $despulpado_p_descarte = 0;
        $despulpado_p_efecivo = 0;
      }

      $dato = \DB::table('enc_post_cosechas')
              ->where('id_post_cosecha', $id)
              ->update([
                'cosecha' => $request->cosecha,
                'cosecha_fecha' => $cosecha_fecha,
                'cosecha_p_bruto' => $cosecha_p_bruto,
                'cosecha_p_descarte' => $cosecha_p_descarte,
                'cosecha_p_efectivo' => $cosecha_p_efecivo,
                'limpieza' => $request->limpieza,
                'limpieza_fecha' => $limpieza_fecha,
                'limpieza_p_bruto' => $limpieza_p_bruto,
                'limpieza_p_descarte' => $limpieza_p_descarte,
                'limpieza_p_efectivo' => $limpieza_p_efecivo,
                'despulpado' => $request->despulpado,
                'despulpado_fecha' => $despulpado_fecha,
                'despulpado_p_bruto' => $despulpado_p_bruto,
                'despulpado_p_descarte' => $despulpado_p_descarte,
                'despulpado_p_efectivo' => $despulpado_p_efecivo,
                'updated_at' => $tiempo_actual
      ]);

      return redirect('/home_encuestas')->with('mensaje_exito', 'Encuesta de Post Cosecha Actualizada Exitosamente');
    }

    public function secado_actualizar(Request $request, $id){
      $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));

      //Tomamos los valores y les asignamos valores según corresponda
      if ($request->secado == 1) {
        $secado_fecha = $request->secado_fecha;
        $secado_p_total = $request->secado_p_total;
        $secado_humedad = $request->secado_humedad;
        $secado_p_efectivo = $request->secado_p_efectivo;
      }
      else {
        $secado_fecha = "0000-00-00";
        $secado_p_total = 0;
        $secado_humedad = 0;
        $secado_p_efectivo = 0;
      }

      if ($request->lavado == 1) {
        $lavado_fecha = $request->lavado_fecha;
        $lavado_p_total = $request->lavado_p_total;
        $lavado_humedad = $request->lavado_humedad;
        $lavado_p_efectivo = $request->lavado_p_efectivo;
      }
      else {
        $lavado_fecha = "0000-00-00";
        $lavado_p_total = 0;
        $lavado_humedad = 0;
        $lavado_p_efectivo = 0;
      }

      if ($request->miel == 1) {
        $miel_fecha = $request->miel_fecha;
        $miel_p_total = $request->miel_p_total;
        $miel_humedad = $request->miel_humedad;
        $miel_p_efectivo = $request->miel_p_efectivo;
      }
      else {
        $miel_fecha = "0000-00-00";
        $miel_p_total = 0;
        $miel_humedad = 0;
        $miel_p_efectivo = 0;
      }

      $dato = \DB::table('enc_secados')
              ->where('id_secado', $id)
              ->update([
                'secado' => $request->secado,
                'secado_fecha' => $secado_fecha,
                'secado_p_total' => $secado_p_total,
                'secado_humedad' => $secado_humedad,
                'secado_p_efectivo' => $secado_p_efectivo,
                'lavado' => $request->lavado,
                'lavado_fecha' => $lavado_fecha,
                'lavado_p_total' => $lavado_p_total,
                'lavado_humedad' => $lavado_humedad,
                'lavado_p_efectivo' => $lavado_p_efectivo,
                'miel' => $request->miel,
                'miel_fecha' => $miel_fecha,
                'miel_p_total' => $miel_p_total,
                'miel_humedad' => $miel_humedad,
                'miel_p_efectivo' => $miel_p_efectivo,
                'updated_at' => $tiempo_actual
      ]);

      return redirect('/home_encuestas')->with('mensaje_exito', 'Encuesta de Secado Actualizada Exitosamente');
    }

    public function deficiencias_actualizar(Request $request, $id){
      $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));
      //Tomamos los datos del registro a actualizar, para tomar la foto que cargaron previamente
      $selec_dato = \DB::table('enc_deficiencias')->where('id_deficiencia', $id)->first();

      //Tomamos los valores y les asignamos valores según corresponda
      if ($request->p == 1) {
        $p_fecha = $request->p_fecha;
        $p_deficiencia = "";
        //Concatenamos todas las deficiencias para guardarlas en un solo campo
        for ($i=0;$i<count($request->p_deficiencia);$i++){
          if ($p_deficiencia == "") {
            $p_deficiencia = $request->p_deficiencia[$i];
          }
          else {
            $p_deficiencia = $p_deficiencia." & ".$request->p_deficiencia[$i];
          }
        }
        $p_severidad = $request->p_severidad;
        $p_producto = $request->p_producto;
        $p_fecha_aplicacion = $request->p_fecha_aplicacion;
        if ($request->p_foto){
          $p_foto = Deficiencia::setFoto($request->p_foto);
        }else{
          $p_foto = $selec_dato->p_foto;
        }
      }
      else {
        $p_fecha = "0000-00-00";
        $p_deficiencia = "";
        $p_severidad = 0;
        $p_producto = "";
        $p_fecha_aplicacion = "0000-00-00";
        $p_foto = "";
      }

      if ($request->k == 1) {
        $k_fecha = $request->k_fecha;
        $k_deficiencia = "";
        //Concatenamos todas las deficiencias para guardarlas en un solo campo
        for ($i=0;$i<count($request->k_deficiencia);$i++){
          if ($k_deficiencia == "") {
            $k_deficiencia = $request->k_deficiencia[$i];
          }
          else {
            $k_deficiencia = $k_deficiencia." & ".$request->k_deficiencia[$i];
          }
        }
        $k_severidad = $request->k_severidad;
        $k_producto = $request->k_producto;
        $k_fecha_aplicacion = $request->k_fecha_aplicacion;
        if ($request->k_foto){
          $k_foto = Deficiencia::setFoto($request->k_foto);
        }else{
          $k_foto = $selec_dato->k_foto;
        }
      }
      else {
        $k_fecha = "0000-00-00";
        $k_deficiencia = "";
        $k_severidad = 0;
        $k_producto = "";
        $k_fecha_aplicacion = "0000-00-00";
        $k_foto = "";
      }

      if ($request->ca == 1) {
        $ca_fecha = $request->ca_fecha;
        $ca_deficiencia = "";
        //Concatenamos todas las deficiencias para guardarlas en un solo campo
        for ($i=0;$i<count($request->ca_deficiencia);$i++){
          if ($ca_deficiencia == "") {
            $ca_deficiencia = $request->ca_deficiencia[$i];
          }
          else {
            $ca_deficiencia = $ca_deficiencia." & ".$request->ca_deficiencia[$i];
          }
        }
        $ca_severidad = $request->ca_severidad;
        $ca_producto = $request->ca_producto;
        $ca_fecha_aplicacion = $request->ca_fecha_aplicacion;
        if ($request->ca_foto){
          $ca_foto = Deficiencia::setFoto($request->ca_foto);
        }else{
          $ca_foto = $selec_dato->ca_foto;
        }
      }
      else {
        $ca_fecha = "0000-00-00";
        $ca_deficiencia = "";
        $ca_severidad = 0;
        $ca_producto = "";
        $ca_fecha_aplicacion = "0000-00-00";
        $ca_foto = "";
      }

      if ($request->mg == 1) {
        $mg_fecha = $request->mg_fecha;
        $mg_deficiencia = "";
        //Concatenamos todas las deficiencias para guardarlas en un solo campo
        for ($i=0;$i<count($request->mg_deficiencia);$i++){
          if ($mg_deficiencia == "") {
            $mg_deficiencia = $request->mg_deficiencia[$i];
          }
          else {
            $mg_deficiencia = $mg_deficiencia." & ".$request->mg_deficiencia[$i];
          }
        }
        $mg_severidad = $request->mg_severidad;
        $mg_producto = $request->mg_producto;
        $mg_fecha_aplicacion = $request->mg_fecha_aplicacion;
        if ($request->mg_foto){
          $mg_foto = Deficiencia::setFoto($request->mg_foto);
        }else{
          $mg_foto = $selec_dato->mg_foto;
        }
      }
      else {
        $mg_fecha = "0000-00-00";
        $mg_deficiencia = "";
        $mg_severidad = 0;
        $mg_producto = "";
        $mg_fecha_aplicacion = "0000-00-00";
        $mg_foto = "";
      }

      if ($request->s == 1) {
        $s_fecha = $request->s_fecha;
        $s_deficiencia = "";
        //Concatenamos todas las deficiencias para guardarlas en un solo campo
        for ($i=0;$i<count($request->s_deficiencia);$i++){
          if ($s_deficiencia == "") {
            $s_deficiencia = $request->s_deficiencia[$i];
          }
          else {
            $s_deficiencia = $s_deficiencia." & ".$request->s_deficiencia[$i];
          }
        }
        $s_severidad = $request->s_severidad;
        $s_producto = $request->s_producto;
        $s_fecha_aplicacion = $request->s_fecha_aplicacion;
        if ($request->s_foto){
          $s_foto = Deficiencia::setFoto($request->s_foto);
        }else{
          $s_foto = $selec_dato->s_foto;
        }
      }
      else {
        $s_fecha = "0000-00-00";
        $s_deficiencia = "";
        $s_severidad = 0;
        $s_producto = "";
        $s_fecha_aplicacion = "0000-00-00";
        $s_foto = "";
      }

      if ($request->fe == 1) {
        $fe_fecha = $request->fe_fecha;
        $fe_deficiencia = "";
        //Concatenamos todas las deficiencias para guardarlas en un solo campo
        for ($i=0;$i<count($request->fe_deficiencia);$i++){
          if ($fe_deficiencia == "") {
            $fe_deficiencia = $request->fe_deficiencia[$i];
          }
          else {
            $fe_deficiencia = $fe_deficiencia." & ".$request->fe_deficiencia[$i];
          }
        }
        $fe_severidad = $request->fe_severidad;
        $fe_producto = $request->fe_producto;
        $fe_fecha_aplicacion = $request->fe_fecha_aplicacion;
        if ($request->fe_foto){
          $fe_foto = Deficiencia::setFoto($request->fe_foto);
        }else{
          $fe_foto = $selec_dato->fe_foto;
        }
      }
      else {
        $fe_fecha = "0000-00-00";
        $fe_deficiencia = "";
        $fe_severidad = 0;
        $fe_producto = "";
        $fe_fecha_aplicacion = "0000-00-00";
        $fe_foto = "";
      }

      if ($request->zc == 1) {
        $zc_fecha = $request->zc_fecha;
        $zc_deficiencia = "";
        //Concatenamos todas las deficiencias para guardarlas en un solo campo
        for ($i=0;$i<count($request->zc_deficiencia);$i++){
          if ($zc_deficiencia == "") {
            $zc_deficiencia = $request->zc_deficiencia[$i];
          }
          else {
            $zc_deficiencia = $zc_deficiencia." & ".$request->zc_deficiencia[$i];
          }
        }
        $zc_severidad = $request->zc_severidad;
        $zc_producto = $request->zc_producto;
        $zc_fecha_aplicacion = $request->zc_fecha_aplicacion;
        if ($request->zc_foto){
          $zc_foto = Deficiencia::setFoto($request->zc_foto);
        }else{
          $zc_foto = $selec_dato->zc_foto;
        }
      }
      else {
        $zc_fecha = "0000-00-00";
        $zc_deficiencia = "";
        $zc_severidad = 0;
        $zc_producto = "";
        $zc_fecha_aplicacion = "0000-00-00";
        $zc_foto = "";
      }

      if ($request->cu == 1) {
        $cu_fecha = $request->cu_fecha;
        $cu_deficiencia = "";
        //Concatenamos todas las deficiencias para guardarlas en un solo campo
        for ($i=0;$i<count($request->cu_deficiencia);$i++){
          if ($cu_deficiencia == "") {
            $cu_deficiencia = $request->cu_deficiencia[$i];
          }
          else {
            $cu_deficiencia = $cu_deficiencia." & ".$request->cu_deficiencia[$i];
          }
        }
        $cu_severidad = $request->cu_severidad;
        $cu_producto = $request->cu_producto;
        $cu_fecha_aplicacion = $request->cu_fecha_aplicacion;
        if ($request->cu_foto){
          $cu_foto = Deficiencia::setFoto($request->cu_foto);
        }else{
          $cu_foto = $selec_dato->cu_foto;
        }
      }
      else {
        $cu_fecha = "0000-00-00";
        $cu_deficiencia = "";
        $cu_severidad = 0;
        $cu_producto = "";
        $cu_fecha_aplicacion = "0000-00-00";
        $cu_foto = "";
      }

      if ($request->b == 1) {
        $b_fecha = $request->b_fecha;
        $b_deficiencia = "";
        //Concatenamos todas las deficiencias para guardarlas en un solo campo
        for ($i=0;$i<count($request->b_deficiencia);$i++){
          if ($b_deficiencia == "") {
            $b_deficiencia = $request->b_deficiencia[$i];
          }
          else {
            $b_deficiencia = $b_deficiencia." & ".$request->b_deficiencia[$i];
          }
        }
        $b_severidad = $request->b_severidad;
        $b_producto = $request->b_producto;
        $b_fecha_aplicacion = $request->b_fecha_aplicacion;
        if ($request->b_foto){
          $b_foto = Deficiencia::setFoto($request->b_foto);
        }else{
          $b_foto = $selec_dato->b_foto;
        }
      }
      else {
        $b_fecha = "0000-00-00";
        $b_deficiencia = "";
        $b_severidad = 0;
        $b_producto = "";
        $b_fecha_aplicacion = "0000-00-00";
        $b_foto = "";
      }

      $dato = \DB::table('enc_deficiencias')
              ->where('id_deficiencia', $id)
              ->update([
                'p' => $request->p,
                'p_fecha' => $p_fecha,
                'p_deficiencia' => $p_deficiencia,
                'p_severidad' => $p_severidad,
                'p_producto' => $p_producto,
                'p_fecha_aplicacion' => $p_fecha_aplicacion,
                'p_foto' => $p_foto,

                'k' => $request->k,
                'k_fecha' => $k_fecha,
                'k_deficiencia' => $k_deficiencia,
                'k_severidad' => $k_severidad,
                'k_producto' => $k_producto,
                'k_fecha_aplicacion' => $k_fecha_aplicacion,
                'k_foto' => $k_foto,

                'ca' => $request->ca,
                'ca_fecha' => $ca_fecha,
                'ca_deficiencia' => $ca_deficiencia,
                'ca_severidad' => $ca_severidad,
                'ca_producto' => $ca_producto,
                'ca_fecha_aplicacion' => $ca_fecha_aplicacion,
                'ca_foto' => $ca_foto,

                'mg' => $request->mg,
                'mg_fecha' => $mg_fecha,
                'mg_deficiencia' => $mg_deficiencia,
                'mg_severidad' => $mg_severidad,
                'mg_producto' => $mg_producto,
                'mg_fecha_aplicacion' => $mg_fecha_aplicacion,
                'mg_foto' => $mg_foto,

                's' => $request->s,
                's_fecha' => $s_fecha,
                's_deficiencia' => $s_deficiencia,
                's_severidad' => $s_severidad,
                's_producto' => $s_producto,
                's_fecha_aplicacion' => $s_fecha_aplicacion,
                's_foto' => $s_foto,

                'fe' => $request->fe,
                'fe_fecha' => $fe_fecha,
                'fe_deficiencia' => $fe_deficiencia,
                'fe_severidad' => $fe_severidad,
                'fe_producto' => $fe_producto,
                'fe_fecha_aplicacion' => $fe_fecha_aplicacion,
                'fe_foto' => $fe_foto,

                'zc' => $request->zc,
                'zc_fecha' => $zc_fecha,
                'zc_deficiencia' => $zc_deficiencia,
                'zc_severidad' => $zc_severidad,
                'zc_producto' => $zc_producto,
                'zc_fecha_aplicacion' => $zc_fecha_aplicacion,
                'zc_foto' => $zc_foto,

                'cu' => $request->cu,
                'cu_fecha' => $cu_fecha,
                'cu_deficiencia' => $cu_deficiencia,
                'cu_severidad' => $cu_severidad,
                'cu_producto' => $cu_producto,
                'cu_fecha_aplicacion' => $cu_fecha_aplicacion,
                'cu_foto' => $cu_foto,

                'b' => $request->b,
                'b_fecha' => $b_fecha,
                'b_deficiencia' => $b_deficiencia,
                'b_severidad' => $b_severidad,
                'b_producto' => $b_producto,
                'b_fecha_aplicacion' => $b_fecha_aplicacion,
                'b_foto' => $b_foto,

                'updated_at' => $tiempo_actual
      ]);

      return redirect('/home_encuestas')->with('mensaje_exito', 'Encuesta de Deficiencias Actualizada Exitosamente');
    }


    public function enfermedades_actualizar(Request $request, $id){
      $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));

      //Tomamos los datos del registro a actualizar, para tomar la foto que cargaron previamente
      $selec_dato = \DB::table('enc_enfermedades')->where('id_enfermedad', $id)->first();

      //Tomamos los valores y les asignamos valores según corresponda
      if ($request->cercospora == 1) {
        $cercospora_fecha = $request->cercospora_fecha;
        $cercospora_area_afectada = "";
        //Concatenamos todas las areas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->cercospora_area_afectada);$i++){
          if ($cercospora_area_afectada == "") {
            $cercospora_area_afectada = $request->cercospora_area_afectada[$i];
          }
          else {
            $cercospora_area_afectada = $cercospora_area_afectada." & ".$request->cercospora_area_afectada[$i];
          }
        }
        $cercospora_incidencia = $request->cercospora_incidencia;
        $cercospora_recomendacion = $request->cercospora_recomendacion;
        if ($request->cercospora_foto){
          $cercospora_foto = Deficiencia::setFoto($request->cercospora_foto);
        }else{
          $cercospora_foto = $selec_dato->cercospora_foto;
        }
      }
      else {
        $cercospora_fecha = "0000-00-00";
        $cercospora_area_afectada = "";
        $cercospora_incidencia = 0;
        $cercospora_recomendacion = "";
        $cercospora_foto = "";
      }

      if ($request->roya == 1) {
        $roya_fecha = $request->roya_fecha;
        $roya_area_afectada = "";
        //Concatenamos todas las areas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->roya_area_afectada);$i++){
          if ($roya_area_afectada == "") {
            $roya_area_afectada = $request->roya_area_afectada[$i];
          }
          else {
            $roya_area_afectada = $roya_area_afectada." & ".$request->roya_area_afectada[$i];
          }
        }
        $roya_incidencia = $request->roya_incidencia;
        $roya_recomendacion = $request->roya_recomendacion;
        if ($request->roya_foto){
          $roya_foto = Deficiencia::setFoto($request->roya_foto);
        }else{
          $roya_foto = $selec_dato->roya_foto;
        }
      }
      else {
        $roya_fecha = "0000-00-00";
        $roya_area_afectada = "";
        $roya_incidencia = 0;
        $roya_recomendacion = "";
        $roya_foto = "";
      }

      if ($request->gallo == 1) {
        $gallo_fecha = $request->gallo_fecha;
        $gallo_area_afectada = "";
        //Concatenamos todas las areas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->gallo_area_afectada);$i++){
          if ($gallo_area_afectada == "") {
            $gallo_area_afectada = $request->gallo_area_afectada[$i];
          }
          else {
            $gallo_area_afectada = $gallo_area_afectada." & ".$request->gallo_area_afectada[$i];
          }
        }
        $gallo_incidencia = $request->gallo_incidencia;
        $gallo_recomendacion = $request->gallo_recomendacion;
        if ($request->gallo_foto){
          $gallo_foto = Deficiencia::setFoto($request->gallo_foto);
        }else{
          $gallo_foto = $selec_dato->gallo_foto;
        }
      }
      else {
        $gallo_fecha = "0000-00-00";
        $gallo_area_afectada = "";
        $gallo_incidencia = 0;
        $gallo_recomendacion = "";
        $gallo_foto = "";
      }

      if ($request->antracnosis == 1) {
        $antracnosis_fecha = $request->antracnosis_fecha;
        $antracnosis_area_afectada = "";
        //Concatenamos todas las areas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->antracnosis_area_afectada);$i++){
          if ($antracnosis_area_afectada == "") {
            $antracnosis_area_afectada = $request->antracnosis_area_afectada[$i];
          }
          else {
            $antracnosis_area_afectada = $antracnosis_area_afectada." & ".$request->antracnosis_area_afectada[$i];
          }
        }
        $antracnosis_incidencia = $request->antracnosis_incidencia;
        $antracnosis_recomendacion = $request->antracnosis_recomendacion;
        if ($request->antracnosis_foto){
          $antracnosis_foto = Deficiencia::setFoto($request->antracnosis_foto);
        }else{
          $antracnosis_foto = $selec_dato->antracnosis_foto;
        }
      }
      else {
        $antracnosis_fecha = "0000-00-00";
        $antracnosis_area_afectada = "";
        $antracnosis_incidencia = 0;
        $antracnosis_recomendacion = "";
        $antracnosis_foto = "";
      }

      if ($request->marchites == 1) {
        $marchites_fecha = $request->marchites_fecha;
        $marchites_area_afectada = "";
        //Concatenamos todas las areas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->marchites_area_afectada);$i++){
          if ($marchites_area_afectada == "") {
            $marchites_area_afectada = $request->marchites_area_afectada[$i];
          }
          else {
            $marchites_area_afectada = $marchites_area_afectada." & ".$request->marchites_area_afectada[$i];
          }
        }
        $marchites_incidencia = $request->marchites_incidencia;
        $marchites_recomendacion = $request->marchites_recomendacion;
        if ($request->marchites_foto){
          $marchites_foto = Deficiencia::setFoto($request->marchites_foto);
        }else{
          $marchites_foto = $selec_dato->marchites_foto;
        }
      }
      else {
        $marchites_fecha = "0000-00-00";
        $marchites_area_afectada = "";
        $marchites_incidencia = 0;
        $marchites_recomendacion = "";
        $marchites_foto = "";
      }

      if ($request->gotera == 1) {
        $gotera_fecha = $request->gotera_fecha;
        $gotera_area_afectada = "";
        //Concatenamos todas las areas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->gotera_area_afectada);$i++){
          if ($gotera_area_afectada == "") {
            $gotera_area_afectada = $request->gotera_area_afectada[$i];
          }
          else {
            $gotera_area_afectada = $gotera_area_afectada." & ".$request->gotera_area_afectada[$i];
          }
        }
        $gotera_incidencia = $request->gotera_incidencia;
        $gotera_recomendacion = $request->gotera_recomendacion;
        if ($request->gotera_foto){
          $gotera_foto = Deficiencia::setFoto($request->gotera_foto);
        }else{
          $gotera_foto = $selec_dato->gotera_foto;
        }
      }
      else {
        $gotera_fecha = "0000-00-00";
        $gotera_area_afectada = "";
        $gotera_incidencia = 0;
        $gotera_recomendacion = "";
        $gotera_foto = "";
      }

      if ($request->mancha == 1) {
        $mancha_fecha = $request->mancha_fecha;
        $mancha_area_afectada = "";
        //Concatenamos todas las areas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->mancha_area_afectada);$i++){
          if ($mancha_area_afectada == "") {
            $mancha_area_afectada = $request->mancha_area_afectada[$i];
          }
          else {
            $mancha_area_afectada = $mancha_area_afectada." & ".$request->mancha_area_afectada[$i];
          }
        }
        $mancha_incidencia = $request->mancha_incidencia;
        $mancha_recomendacion = $request->mancha_recomendacion;
        if ($request->mancha_foto){
          $mancha_foto = Deficiencia::setFoto($request->mancha_foto);
        }else{
          $mancha_foto = $selec_dato->mancha_foto;
        }
      }
      else {
        $mancha_fecha = "0000-00-00";
        $mancha_area_afectada = "";
        $mancha_incidencia = 0;
        $mancha_recomendacion = "";
        $mancha_foto = "";
      }

      if ($request->pudricion == 1) {
        $pudricion_fecha = $request->pudricion_fecha;
        $pudricion_area_afectada = "";
        //Concatenamos todas las areas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->pudricion_area_afectada);$i++){
          if ($pudricion_area_afectada == "") {
            $pudricion_area_afectada = $request->pudricion_area_afectada[$i];
          }
          else {
            $pudricion_area_afectada = $pudricion_area_afectada." & ".$request->pudricion_area_afectada[$i];
          }
        }
        $pudricion_incidencia = $request->pudricion_incidencia;
        $pudricion_recomendacion = $request->pudricion_recomendacion;
        if ($request->pudricion_foto){
          $pudricion_foto = Deficiencia::setFoto($request->pudricion_foto);
        }else{
          $pudricion_foto = $selec_dato->pudricion_foto;
        }
      }
      else {
        $pudricion_fecha = "0000-00-00";
        $pudricion_area_afectada = "";
        $pudricion_incidencia = 0;
        $pudricion_recomendacion = "";
        $pudricion_foto = "";
      }

      if ($request->rosado == 1) {
        $rosado_fecha = $request->rosado_fecha;
        $rosado_area_afectada = "";
        //Concatenamos todas las areas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->rosado_area_afectada);$i++){
          if ($rosado_area_afectada == "") {
            $rosado_area_afectada = $request->rosado_area_afectada[$i];
          }
          else {
            $rosado_area_afectada = $rosado_area_afectada." & ".$request->rosado_area_afectada[$i];
          }
        }
        $rosado_incidencia = $request->rosado_incidencia;
        $rosado_recomendacion = $request->rosado_recomendacion;
        if ($request->rosado_foto){
          $rosado_foto = Deficiencia::setFoto($request->rosado_foto);
        }else{
          $rosado_foto = $selec_dato->rosado_foto;
        }
      }
      else {
        $rosado_fecha = "0000-00-00";
        $rosado_area_afectada = "";
        $rosado_incidencia = 0;
        $rosado_recomendacion = "";
        $rosado_foto = "";
      }

      if ($request->moho == 1) {
        $moho_fecha = $request->moho_fecha;
        $moho_area_afectada = "";
        //Concatenamos todas las areas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->moho_area_afectada);$i++){
          if ($moho_area_afectada == "") {
            $moho_area_afectada = $request->moho_area_afectada[$i];
          }
          else {
            $moho_area_afectada = $moho_area_afectada." & ".$request->moho_area_afectada[$i];
          }
        }
        $moho_incidencia = $request->moho_incidencia;
        $moho_recomendacion = $request->moho_recomendacion;
        if ($request->moho_foto){
          $moho_foto = Deficiencia::setFoto($request->moho_foto);
        }else{
          $moho_foto = $selec_dato->moho_foto;
        }
      }
      else {
        $moho_fecha = "0000-00-00";
        $moho_area_afectada = "";
        $moho_incidencia = 0;
        $moho_recomendacion = "";
        $moho_foto = "";
      }

      $dato = \DB::table('enc_enfermedades')
              ->where('id_enfermedad', $id)
              ->update([
                'cercospora' => $request->cercospora,
                'cercospora_fecha' => $cercospora_fecha,
                'cercospora_area_afectada' => $cercospora_area_afectada,
                'cercospora_incidencia' => $cercospora_incidencia,
                'cercospora_recomendacion' => $cercospora_recomendacion,
                'cercospora_foto' => $cercospora_foto,

                'roya' => $request->roya,
                'roya_fecha' => $roya_fecha,
                'roya_area_afectada' => $roya_area_afectada,
                'roya_incidencia' => $roya_incidencia,
                'roya_recomendacion' => $roya_recomendacion,
                'roya_foto' => $roya_foto,

                'gallo' => $request->gallo,
                'gallo_fecha' => $gallo_fecha,
                'gallo_area_afectada' => $gallo_area_afectada,
                'gallo_incidencia' => $gallo_incidencia,
                'gallo_recomendacion' => $gallo_recomendacion,
                'gallo_foto' => $gallo_foto,

                'antracnosis' => $request->antracnosis,
                'antracnosis_fecha' => $antracnosis_fecha,
                'antracnosis_area_afectada' => $antracnosis_area_afectada,
                'antracnosis_incidencia' => $antracnosis_incidencia,
                'antracnosis_recomendacion' => $antracnosis_recomendacion,
                'antracnosis_foto' => $antracnosis_foto,

                'marchites' => $request->marchites,
                'marchites_fecha' => $marchites_fecha,
                'marchites_area_afectada' => $marchites_area_afectada,
                'marchites_incidencia' => $marchites_incidencia,
                'marchites_recomendacion' => $marchites_recomendacion,
                'marchites_foto' => $marchites_foto,

                'gotera' => $request->gotera,
                'gotera_fecha' => $gotera_fecha,
                'gotera_area_afectada' => $gotera_area_afectada,
                'gotera_incidencia' => $gotera_incidencia,
                'gotera_recomendacion' => $gotera_recomendacion,
                'gotera_foto' => $gotera_foto,

                'mancha' => $request->mancha,
                'mancha_fecha' => $mancha_fecha,
                'mancha_area_afectada' => $mancha_area_afectada,
                'mancha_incidencia' => $mancha_incidencia,
                'mancha_recomendacion' => $mancha_recomendacion,
                'mancha_foto' => $mancha_foto,

                'pudricion' => $request->pudricion,
                'pudricion_fecha' => $pudricion_fecha,
                'pudricion_area_afectada' => $pudricion_area_afectada,
                'pudricion_incidencia' => $pudricion_incidencia,
                'pudricion_recomendacion' => $pudricion_recomendacion,
                'pudricion_foto' => $pudricion_foto,

                'rosado' => $request->rosado,
                'rosado_fecha' => $rosado_fecha,
                'rosado_area_afectada' => $rosado_area_afectada,
                'rosado_incidencia' => $rosado_incidencia,
                'rosado_recomendacion' => $rosado_recomendacion,
                'rosado_foto' => $rosado_foto,

                'moho' => $request->moho,
                'moho_fecha' => $moho_fecha,
                'moho_area_afectada' => $moho_area_afectada,
                'moho_incidencia' => $moho_incidencia,
                'moho_recomendacion' => $moho_recomendacion,
                'moho_foto' => $moho_foto,

                'updated_at' => $tiempo_actual
      ]);

      return redirect('/home_encuestas')->with('mensaje_exito', 'Encuesta de Enfermedades Actualizada Exitosamente');
    }

    public function plagas_actualizar(Request $request, $id){
      $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));

      //Tomamos los valores y les asignamos valores según corresponda
      if ($request->broca == 1) {
        $broca_fecha = $request->broca_fecha;
        $broca_zona_afectada = "";
        //Concatenamos todas las zonas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->broca_zona_afectada);$i++){
          if ($broca_zona_afectada == "") {
            $broca_zona_afectada = $request->broca_zona_afectada[$i];
          }
          else {
            $broca_zona_afectada = $broca_zona_afectada." & ".$request->broca_zona_afectada[$i];
          }
        }
        $broca_incidencia = $request->broca_incidencia;
        $broca_control = $request->broca_control;
      }
      else {
        $broca_fecha = "0000-00-00";
        $broca_zona_afectada = "";
        $broca_incidencia = 0;
        $broca_control = "";
      }

      if ($request->cepe == 1) {
        $cepe_fecha = $request->cepe_fecha;
        $cepe_zona_afectada = "";
        //Concatenamos todas las zonas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->cepe_zona_afectada);$i++){
          if ($cepe_zona_afectada == "") {
            $cepe_zona_afectada = $request->cepe_zona_afectada[$i];
          }
          else {
            $cepe_zona_afectada = $cepe_zona_afectada." & ".$request->cepe_zona_afectada[$i];
          }
        }
        $cepe_incidencia = $request->cepe_incidencia;
        $cepe_control = $request->cepe_control;
      }
      else {
        $cepe_fecha = "0000-00-00";
        $cepe_zona_afectada = "";
        $cepe_incidencia = 0;
        $cepe_control = "";
      }

      if ($request->grillo == 1) {
        $grillo_fecha = $request->grillo_fecha;
        $grillo_zona_afectada = "";
        //Concatenamos todas las zonas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->grillo_zona_afectada);$i++){
          if ($grillo_zona_afectada == "") {
            $grillo_zona_afectada = $request->grillo_zona_afectada[$i];
          }
          else {
            $grillo_zona_afectada = $grillo_zona_afectada." & ".$request->grillo_zona_afectada[$i];
          }
        }
        $grillo_incidencia = $request->grillo_incidencia;
        $grillo_control = $request->grillo_control;
      }
      else {
        $grillo_fecha = "0000-00-00";
        $grillo_zona_afectada = "";
        $grillo_incidencia = 0;
        $grillo_control = "";
      }

      if ($request->cochinilla == 1) {
        $cochinilla_fecha = $request->cochinilla_fecha;
        $cochinilla_zona_afectada = "";
        //Concatenamos todas las zonas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->cochinilla_zona_afectada);$i++){
          if ($cochinilla_zona_afectada == "") {
            $cochinilla_zona_afectada = $request->cochinilla_zona_afectada[$i];
          }
          else {
            $cochinilla_zona_afectada = $cochinilla_zona_afectada." & ".$request->cochinilla_zona_afectada[$i];
          }
        }
        $cochinilla_incidencia = $request->cochinilla_incidencia;
        $cochinilla_control = $request->cochinilla_control;
      }
      else {
        $cochinilla_fecha = "0000-00-00";
        $cochinilla_zona_afectada = "";
        $cochinilla_incidencia = 0;
        $cochinilla_control = "";
      }

      if ($request->escamas == 1) {
        $escamas_fecha = $request->escamas_fecha;
        $escamas_zona_afectada = "";
        //Concatenamos todas las zonas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->escamas_zona_afectada);$i++){
          if ($escamas_zona_afectada == "") {
            $escamas_zona_afectada = $request->escamas_zona_afectada[$i];
          }
          else {
            $escamas_zona_afectada = $escamas_zona_afectada." & ".$request->escamas_zona_afectada[$i];
          }
        }
        $escamas_incidencia = $request->escamas_incidencia;
        $escamas_control = $request->escamas_control;
      }
      else {
        $escamas_fecha = "0000-00-00";
        $escamas_zona_afectada = "";
        $escamas_incidencia = 0;
        $escamas_control = "";
      }

      if ($request->minador == 1) {
        $minador_fecha = $request->minador_fecha;
        $minador_zona_afectada = "";
        //Concatenamos todas las zonas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->minador_zona_afectada);$i++){
          if ($minador_zona_afectada == "") {
            $minador_zona_afectada = $request->minador_zona_afectada[$i];
          }
          else {
            $minador_zona_afectada = $minador_zona_afectada." & ".$request->minador_zona_afectada[$i];
          }
        }
        $minador_incidencia = $request->minador_incidencia;
        $minador_control = $request->minador_control;
      }
      else {
        $minador_fecha = "0000-00-00";
        $minador_zona_afectada = "";
        $minador_incidencia = 0;
        $minador_control = "";
      }

      if ($request->barrenador == 1) {
        $barrenador_fecha = $request->barrenador_fecha;
        $barrenador_zona_afectada = "";
        //Concatenamos todas las zonas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->barrenador_zona_afectada);$i++){
          if ($barrenador_zona_afectada == "") {
            $barrenador_zona_afectada = $request->barrenador_zona_afectada[$i];
          }
          else {
            $barrenador_zona_afectada = $barrenador_zona_afectada." & ".$request->barrenador_zona_afectada[$i];
          }
        }
        $barrenador_incidencia = $request->barrenador_incidencia;
        $barrenador_control = $request->barrenador_control;
      }
      else {
        $barrenador_fecha = "0000-00-00";
        $barrenador_zona_afectada = "";
        $barrenador_incidencia = 0;
        $barrenador_control = "";
      }

      if ($request->nematodos == 1) {
        $nematodos_fecha = $request->nematodos_fecha;
        $nematodos_zona_afectada = "";
        //Concatenamos todas las zonas afectadas para guardarlas en un solo campo
        for ($i=0;$i<count($request->nematodos_zona_afectada);$i++){
          if ($nematodos_zona_afectada == "") {
            $nematodos_zona_afectada = $request->nematodos_zona_afectada[$i];
          }
          else {
            $nematodos_zona_afectada = $nematodos_zona_afectada." & ".$request->nematodos_zona_afectada[$i];
          }
        }
        $nematodos_incidencia = $request->nematodos_incidencia;
        $nematodos_control = $request->nematodos_control;
      }
      else {
        $nematodos_fecha = "0000-00-00";
        $nematodos_zona_afectada = "";
        $nematodos_incidencia = 0;
        $nematodos_control = "";
      }

      $dato = \DB::table('enc_plagas')
              ->where('id_plaga', $id)
              ->update([
                'broca' => $request->broca,
                'broca_fecha' => $broca_fecha,
                'broca_zona_afectada' => $broca_zona_afectada,
                'broca_incidencia' => $broca_incidencia,
                'broca_control' => $broca_control,

                'cepe' => $request->cepe,
                'cepe_fecha' => $cepe_fecha,
                'cepe_zona_afectada' => $cepe_zona_afectada,
                'cepe_incidencia' => $cepe_incidencia,
                'cepe_control' => $cepe_control,

                'grillo' => $request->grillo,
                'grillo_fecha' => $grillo_fecha,
                'grillo_zona_afectada' => $grillo_zona_afectada,
                'grillo_incidencia' => $grillo_incidencia,
                'grillo_control' => $grillo_control,

                'cochinilla' => $request->cochinilla,
                'cochinilla_fecha' => $cochinilla_fecha,
                'cochinilla_zona_afectada' => $cochinilla_zona_afectada,
                'cochinilla_incidencia' => $cochinilla_incidencia,
                'cochinilla_control' => $cochinilla_control,

                'escamas' => $request->escamas,
                'escamas_fecha' => $escamas_fecha,
                'escamas_zona_afectada' => $escamas_zona_afectada,
                'escamas_incidencia' => $escamas_incidencia,
                'escamas_control' => $escamas_control,

                'minador' => $request->minador,
                'minador_fecha' => $minador_fecha,
                'minador_zona_afectada' => $minador_zona_afectada,
                'minador_incidencia' => $minador_incidencia,
                'minador_control' => $minador_control,

                'barrenador' => $request->barrenador,
                'barrenador_fecha' => $barrenador_fecha,
                'barrenador_zona_afectada' => $barrenador_zona_afectada,
                'barrenador_incidencia' => $barrenador_incidencia,
                'barrenador_control' => $barrenador_control,

                'nematodos' => $request->nematodos,
                'nematodos_fecha' => $nematodos_fecha,
                'nematodos_zona_afectada' => $nematodos_zona_afectada,
                'nematodos_incidencia' => $nematodos_incidencia,
                'nematodos_control' => $nematodos_control,

                'updated_at' => $tiempo_actual
      ]);

      return redirect('/home_encuestas')->with('mensaje_exito', 'Encuesta de Plagas Actualizada Exitosamente');
    }

    public function fertilizaciones_actualizar(Request $request, $id){
      $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));

      //Tomamos los valores y les asignamos valores según corresponda
      if ($request->vegetativo == 1) {
        $vegetativo_fecha = $request->vegetativo_fecha;
        $vegetativo_fecha_aplicacion = $request->vegetativo_fecha_aplicacion;
        $vegetativo_bioles_producto = $request->vegetativo_bioles_producto;
        $vegetativo_bioles_dosis = $request->vegetativo_bioles_dosis;
        $vegetativo_purines_producto = $request->vegetativo_purines_producto;
        $vegetativo_purines_dosis = $request->vegetativo_purines_dosis;
      }
      else {
        $vegetativo_fecha = "0000-00-00";
        $vegetativo_fecha_aplicacion = "0000-00-00";
        $vegetativo_bioles_producto = "";
        $vegetativo_bioles_dosis = 0;
        $vegetativo_purines_producto = "";
        $vegetativo_purines_dosis = 0;
      }

      if ($request->reproductivo == 1) {
        $reproductivo_fecha = $request->reproductivo_fecha;
        $reproductivo_fecha_aplicacion = $request->reproductivo_fecha_aplicacion;
        $reproductivo_producto = $request->reproductivo_producto;
        $reproductivo_dosis = $request->reproductivo_dosis;
      }
      else {
        $reproductivo_fecha = "0000-00-00";
        $reproductivo_fecha_aplicacion = "0000-00-00";
        $reproductivo_producto = "";
        $reproductivo_dosis = 0;
      }

      if ($request->floracion == 1) {
        $floracion_fecha = $request->floracion_fecha;
        $floracion_fecha_aplicacion = $request->floracion_fecha_aplicacion;
        $floracion_producto = $request->floracion_producto;
        $floracion_dosis = $request->floracion_dosis;
      }
      else {
        $floracion_fecha = "0000-00-00";
        $floracion_fecha_aplicacion = "0000-00-00";
        $floracion_producto = "";
        $floracion_dosis = 0;
      }

      if ($request->fructificacion == 1) {
        $fructificacion_fecha = $request->fructificacion_fecha;
        $fructificacion_fecha_aplicacion = $request->fructificacion_fecha_aplicacion;
        $fructificacion_producto = $request->fructificacion_producto;
        $fructificacion_dosis = $request->fructificacion_dosis;
      }
      else {
        $fructificacion_fecha = "0000-00-00";
        $fructificacion_fecha_aplicacion = "0000-00-00";
        $fructificacion_producto = "";
        $fructificacion_dosis = 0;
      }

      $dato = \DB::table('enc_fertilizaciones')
              ->where('id_fertilizacion', $id)
              ->update([
                'vegetativo' => $request->vegetativo,
                'vegetativo_fecha' => $vegetativo_fecha,
                'vegetativo_fecha_aplicacion' => $vegetativo_fecha_aplicacion,
                'vegetativo_bioles_producto' => $vegetativo_bioles_producto,
                'vegetativo_bioles_dosis' => $vegetativo_bioles_dosis,
                'vegetativo_purines_producto' => $vegetativo_purines_producto,
                'vegetativo_purines_dosis' => $vegetativo_purines_dosis,

                'reproductivo' => $request->reproductivo,
                'reproductivo_fecha' => $reproductivo_fecha,
                'reproductivo_fecha_aplicacion' => $reproductivo_fecha_aplicacion,
                'reproductivo_producto' => $reproductivo_producto,
                'reproductivo_dosis' => $reproductivo_dosis,

                'floracion' => $request->floracion,
                'floracion_fecha' => $floracion_fecha,
                'floracion_fecha_aplicacion' => $floracion_fecha_aplicacion,
                'floracion_producto' => $floracion_producto,
                'floracion_dosis' => $floracion_dosis,

                'fructificacion' => $request->fructificacion,
                'fructificacion_fecha' => $fructificacion_fecha,
                'fructificacion_fecha_aplicacion' => $fructificacion_fecha_aplicacion,
                'fructificacion_producto' => $fructificacion_producto,
                'fructificacion_dosis' => $fructificacion_dosis,

                'updated_at' => $tiempo_actual
      ]);

      return redirect('/home_encuestas')->with('mensaje_exito', 'Encuesta de Fertilización Actualizada Exitosamente');
    }

    public function consultaProvincias($id_departamento){
        $provincias = \DB::table('provincias')
        ->where('id_departamento', $id_departamento)
        ->where('activo', 1)
        ->distinct()
        ->orderBy('provincia', 'asc')
        ->get();
        return $provincias;
    }

    public function consultaMunicipios($id_provincia){
        $municipios = \DB::table('municipios')
        ->where('id_provincia', $id_provincia)
        ->where('activo', 1)
        ->distinct()
        ->orderBy('municipio', 'asc')
        ->get();
        return $municipios;
    }


}
