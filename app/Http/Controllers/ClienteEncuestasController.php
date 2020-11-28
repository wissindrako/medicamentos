<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositorios\EncuestasCafe;


class ClienteEncuestasController extends Controller
{
    protected $encuestas;

    public function __construct(EncuestasCafe $encuestas)
    {
        $this->encuestas = $encuestas;
    }

    public function test_server(){
        return $this->encuestas->test_server();
    }

    public function form_agregar_ip_server(){
        $dato = \DB::table('enc_ip_servidor')->orderBy('id_ip_servidor', 'asc')->first();
        return view('formularios.encuestas.form_agregar_ip_server', compact('dato'));
    }

    public function agregar_ip_server(Request $request, $id){
        $dato = \DB::table('enc_ip_servidor')->where('id_ip_servidor', $id)->first();
        if($dato == null){
            \DB::table('enc_ip_servidor')->insert(['ip' => $request->ip]);
        }else{
            \DB::table('enc_ip_servidor')->where('id_ip_servidor', $id)->update(['ip' => $request->ip]);
        }
         return redirect('/home_encuestas')->with('mensaje_exito', 'IP del servidor Actualizado Exitosamente');
      }

    public function cliente_informacion_basica_datas(){
        $url = 'datas_informacion_basica';
        return $this->encuestas->datas($url);
    }

    public function cliente_preparacion_datas(){
        $url = 'datas_preparacion';
        return $this->encuestas->datas($url);
    }

    public function cliente_densidad_datas(){
        $url = 'datas_densidad';
        return $this->encuestas->datas($url);
    }

    public function cliente_agroforestales_datas(){
        $url = 'datas_agroforestales';
        return $this->encuestas->datas($url);
    }

    public function cliente_podas_datas(){
        $url = 'datas_podas';
        return $this->encuestas->datas($url);
    }

    public function cliente_control_malezas_datas(){
        $url = 'datas_control_malezas';
        return $this->encuestas->datas($url);
    }

    public function cliente_enfermedades_datas(){
        $url = 'datas_enfermedades';
        return $this->encuestas->datas($url);
    }

    public function cliente_plagas_datas(){
        $url = 'datas_plagas';
        return $this->encuestas->datas($url);
    }

    public function cliente_cosechas_datas(){
        $url = 'datas_cosechas';
        return $this->encuestas->datas($url);
    }

    public function cliente_post_cosechas_datas(){
        $url = 'datas_post_cosechas';
        return $this->encuestas->datas($url);
    }

    public function cliente_secados_datas(){
        $url = 'datas_secados';
        return $this->encuestas->datas($url);
    }

    public function cliente_fertilizaciones_datas(){
        $url = 'datas_fertilizaciones';
        return $this->encuestas->datas($url);
    }

    public function cliente_deficiencias_datas(){
        $url = 'datas_deficiencias';
        return $this->encuestas->datas($url);
    }

    public function cliente_cargar_datos(){
        // dd($this->encuestas->test_server());
        if($this->encuestas->test_server()){
            $this->cliente_informacion_basica_guardar();
            $this->cliente_preparacion_guardar();
            $this->cliente_densidad_guardar();
            $this->cliente_agroforestales_guardar();
            $this->cliente_podas_guardar();
            $this->cliente_control_malezas_guardar();
            $this->cliente_enfermedades_guardar();
            $this->cliente_plagas_guardar();
            $this->cliente_cosechas_guardar();
            $this->cliente_post_cosechas_guardar();
            $this->cliente_secados_guardar();
            $this->cliente_fertilizaciones_guardar();
            $this->cliente_deficiencias_guardar();
            return redirect('/home_encuestas')->with('mensaje_exito', 'Registros cargados al servidor Exitosamente');
        }else{
            // return redirect('/home_encuestas')->with('mensaje_error', 'El servidor no esta disponible, revise su conexión');
            $dato = \DB::table('enc_ip_servidor')->orderBy('id_ip_servidor', 'asc')->first();
            return view('formularios.encuestas.form_agregar_ip_server', compact('dato'));
        }
    }

    public function cliente_informacion_basica_guardar(){
        $url = 'servicio_informacion_basica_guardar';
        $datas = \DB::table('enc_productores')->where('activo', 1)->get();
        // dd($datas);
        if ($datas != null) {
            foreach ($datas as $key => $value) {
                $e = array();
                $e['object_id'] = $value->object_id;
                $e['productor_nombres'] = $value->productor_nombres;
                $e['productor_paterno'] = $value->productor_paterno;
                $e['productor_materno'] = $value->productor_materno;
                $e['productor_ci'] = $value->productor_ci;
                $e['productor_sexo'] = $value->productor_sexo;
                $e['productor_telefono'] = $value->productor_telefono;
                $e['tecnico_responsable'] = $value->tecnico_responsable;
                $e['id_departamento'] = $value->id_departamento;
                $e['id_provincia'] = $value->id_provincia;
                $e['id_municipio'] = $value->id_municipio;
                $e['localidad'] = $value->localidad;
                $e['comunidad'] = $value->comunidad;
                $e['tipo_cultivo'] = $value->tipo_cultivo;
                $e['tipo_cultivo_id'] = $value->tipo_cultivo_id;
                $e['created_at'] = $value->created_at;
                $e['updated_at'] = $value->updated_at;
                $e['activo'] = $value->activo;
                    // dd(\DB::table('enc_productores')->where('id_preparacion', $value->id_preparacion)->get());
                if($this->encuestas->guardar_data($e, $url)){
                    // \DB::table('enc_productores')->where('id_preparacion', $value->id_preparacion)
                    // ->update(['activo' => 0]);
                }
            }
            // return redirect('/form_cliente_cargar_datos')->with('mensaje_exito', 'Registros de la Tabla Información Básica subidos al servidor Exitosamente');
        }
    }

    public function cliente_preparacion_guardar(){
        $url = 'servicio_preparacion_guardar';
        $datas = \DB::table('enc_preparaciones')->where('activo', 1)->get();
        if (count($datas) > 0) {
            foreach ($datas as $key => $value) {
                $e = array();
                    $e['object_id'] = $value->object_id;
                    $e['fecha'] = $value->fecha;
                    $e['con_quema'] = $value->con_quema;
                    $e['sin_quema'] = $value->sin_quema;
                    $e['created_at'] = $value->created_at;
                    $e['updated_at'] = $value->updated_at;
                    $e['activo'] = $value->activo;
                    // dd(\DB::table('enc_preparaciones')->where('id_preparacion', $value->id_preparacion)->get());
                if($this->encuestas->guardar_data($e, $url)){
                    
                    \DB::table('enc_preparaciones')->where('id_preparacion', $value->id_preparacion)
                    ->update(['activo' => 0]);
                }
            }
            // return redirect('/form_cliente_cargar_datos')->with('mensaje_exito', 'Registros de la Tabla Información Básica subidos al servidor Exitosamente');
        }
    }

    public function cliente_densidad_guardar(){
        $url = 'servicio_densidad_guardar';
        $datas = \DB::table('enc_densidad')->where('activo', 1)->get();
        if (count($datas) > 0) {
            foreach ($datas as $key => $value) {
                $e = array();
                    $e['object_id'] = $value->object_id;
                    $e['ano'] = $value->ano;
                    $e['densidad'] = $value->densidad;
                    $e['superficie'] = $value->superficie;
                    $e['cantidad_plantas'] = $value->cantidad_plantas;
                    $e['plantas_muertas'] = $value->plantas_muertas;
                    $e['plantas_efectivas'] = $value->plantas_efectivas;
                    $e['created_at'] = $value->created_at;
                    $e['updated_at'] = $value->updated_at;
                    $e['activo'] = $value->activo;
                if($this->encuestas->guardar_data($e, $url)){
                    \DB::table('enc_densidad')->where('id_densidad', $value->id_densidad)
                    ->update(['activo' => 0]);
                }
            }
        }
    }

    public function cliente_agroforestales_guardar(){
        $url = 'servicio_agroforestales_guardar';
        $datas = \DB::table('enc_sist_agroforestales')->where('activo', 1)->get();
        if (count($datas) > 0) {
            foreach ($datas as $key => $value) {
                $e = array();
                    $e['object_id'] = $value->object_id;
                    $e['ano'] = $value->ano;
                    $e['pacay'] = $value->pacay;
                    $e['pacay_cantidad'] = $value->pacay_cantidad;
                    $e['pacay_permanente'] = $value->pacay_permanente;
                    $e['pacay_fecha_siembra'] = $value->pacay_fecha_siembra;
                    $e['platano'] = $value->platano;
                    $e['platano_cantidad'] = $value->platano_cantidad;
                    $e['platano_permanente'] = $value->platano_permanente;
                    $e['platano_fecha_siembra'] = $value->platano_fecha_siembra;
                    $e['citricos'] = $value->citricos;
                    $e['citricos_cantidad'] = $value->citricos_cantidad;
                    $e['citricos_permanente'] = $value->citricos_permanente;
                    $e['citricos_fecha_siembra'] = $value->citricos_fecha_siembra;
                    $e['maderables'] = $value->maderables;
                    $e['maderables_cantidad'] = $value->maderables_cantidad;
                    $e['maderables_permanente'] = $value->maderables_permanente;
                    $e['maderables_fecha_siembra'] = $value->maderables_fecha_siembra;
                    $e['frutas_amazonicas'] = $value->frutas_amazonicas;
                    $e['frutas_amazonicas_cantidad'] = $value->frutas_amazonicas_cantidad;
                    $e['frutas_amazonicas_permanente'] = $value->frutas_amazonicas_permanente;
                    $e['frutas_amazonicas_fecha_siembra'] = $value->frutas_amazonicas_fecha_siembra;
                    $e['otros'] = $value->otros;
                    $e['otros_descripcion'] = $value->otros_descripcion;
                    $e['otros_cantidad'] = $value->otros_cantidad;
                    $e['otros_permanente'] = $value->otros_permanente;
                    $e['otros_fecha_siembra'] = $value->otros_fecha_siembra;
                    $e['created_at'] = $value->created_at;
                    $e['updated_at'] = $value->updated_at;
                    $e['activo'] = $value->activo;
                if($this->encuestas->guardar_data($e, $url)){
                    \DB::table('enc_sist_agroforestales')->where('id_sist_agroforestal', $value->id_sist_agroforestal)
                    ->update(['activo' => 0]);
                }
            }
        }
    }

    public function cliente_podas_guardar(){
        $url = 'servicio_podas_guardar';
        $datas = \DB::table('enc_podas')->where('activo', 1)->get();
        if (count($datas) > 0) {
            foreach ($datas as $key => $value) {
                $e = array();
                    $e['object_id'] = $value->object_id;
                    $e['form_planta'] = $value->form_planta;
                    $e['form_planta_fecha'] = $value->form_planta_fecha;
                    $e['form_planta_fecha_final'] = $value->form_planta_fecha_final;
                    $e['form_planta_foto'] = $value->form_planta_foto;
                    $e['mantenimiento'] = $value->mantenimiento;
                    $e['mantenimiento_fecha'] = $value->mantenimiento_fecha;
                    $e['mantenimiento_fecha_final'] = $value->mantenimiento_fecha_final;
                    $e['mantenimiento_foto'] = $value->mantenimiento_foto;
                    $e['sel_brotes'] = $value->sel_brotes;
                    $e['sel_brotes_fecha'] = $value->sel_brotes_fecha;
                    $e['sel_brotes_fecha_final'] = $value->sel_brotes_fecha_final;
                    $e['sel_brotes_foto'] = $value->sel_brotes_foto;
                    $e['rehabilitacion'] = $value->rehabilitacion;
                    $e['rehabilitacion_fecha'] = $value->rehabilitacion_fecha;
                    $e['rehabilitacion_fecha_final'] = $value->rehabilitacion_fecha_final;
                    $e['rehabilitacion_foto'] = $value->rehabilitacion_foto;
                    $e['renovacion'] = $value->renovacion;
                    $e['renovacion_fecha'] = $value->renovacion_fecha;
                    $e['renovacion_fecha_final'] = $value->renovacion_fecha_final;
                    $e['renovacion_foto'] = $value->renovacion_foto;
                    $e['deshoje_despunte'] = $value->deshoje_despunte;
                    $e['deshoje_despunte_fecha'] = $value->deshoje_despunte_fecha;
                    $e['deshoje_despunte_fecha_final'] = $value->deshoje_despunte_fecha_final;
                    $e['deshoje_despunte_foto'] = $value->deshoje_despunte_foto;
                    $e['created_at'] = $value->created_at;
                    $e['updated_at'] = $value->updated_at;
                    $e['activo'] = $value->activo;
                if($this->encuestas->guardar_data($e, $url)){
                    \DB::table('enc_podas')->where('id_poda', $value->id_poda)
                    ->update(['activo' => 0]);
                }
            }
        }
    }

    public function cliente_control_malezas_guardar(){
        $url = 'servicio_control_malezas_guardar';
        $datas = \DB::table('enc_controles_maleza')->where('activo', 1)->get();
        if (count($datas) > 0) {
            foreach ($datas as $key => $value) {
                $e = array();
                    $e['object_id'] = $value->object_id;
                    $e['biologico'] = $value->biologico;
                    $e['biologico_fecha'] = $value->biologico_fecha;
                    $e['biologico_producto'] = $value->biologico_producto;
                    $e['quimico'] = $value->quimico;
                    $e['quimico_fecha'] = $value->quimico_fecha;
                    $e['quimico_producto'] = $value->quimico_producto;
                    $e['mecanico'] = $value->mecanico;
                    $e['mecanico_fecha'] = $value->mecanico_fecha;
                    $e['mecanico_producto'] = $value->mecanico_producto;
                    $e['created_at'] = $value->created_at;
                    $e['updated_at'] = $value->updated_at;
                    $e['activo'] = $value->activo;
                if($this->encuestas->guardar_data($e, $url)){
                    \DB::table('enc_controles_maleza')->where('id_control_maleza', $value->id_control_maleza)
                    ->update(['activo' => 0]);
                }
            }
        }
    }

    public function cliente_enfermedades_guardar(){
        $url = 'servicio_enfermedades_guardar';
        $datas = \DB::table('enc_enfermedades')->where('activo', 1)->get();
        if (count($datas) > 0) {
            foreach ($datas as $key => $value) {
                $e = array();
                    $e['object_id'] = $value->object_id;
                    $e['cercospora'] = $value->cercospora;
                    $e['cercospora_fecha'] = $value->cercospora_fecha;
                    $e['cercospora_area_afectada'] = $value->cercospora_area_afectada;
                    $e['cercospora_incidencia'] = $value->cercospora_incidencia;
                    $e['cercospora_recomendacion'] = $value->cercospora_recomendacion;
                    $e['cercospora_foto'] = $value->cercospora_foto;
                    $e['roya'] = $value->roya;
                    $e['roya_fecha'] = $value->roya_fecha;
                    $e['roya_area_afectada'] = $value->roya_area_afectada;
                    $e['roya_incidencia'] = $value->roya_incidencia;
                    $e['roya_recomendacion'] = $value->roya_recomendacion;
                    $e['roya_foto'] = $value->roya_foto;
                    $e['gallo'] = $value->gallo;
                    $e['gallo_fecha'] = $value->gallo_fecha;
                    $e['gallo_area_afectada'] = $value->gallo_area_afectada;
                    $e['gallo_incidencia'] = $value->gallo_incidencia;
                    $e['gallo_recomendacion'] = $value->gallo_recomendacion;
                    $e['gallo_foto'] = $value->gallo_foto;
                    $e['antracnosis'] = $value->antracnosis;
                    $e['antracnosis_fecha'] = $value->antracnosis_fecha;
                    $e['antracnosis_area_afectada'] = $value->antracnosis_area_afectada;
                    $e['antracnosis_incidencia'] = $value->antracnosis_incidencia;
                    $e['antracnosis_recomendacion'] = $value->antracnosis_recomendacion;
                    $e['antracnosis_foto'] = $value->antracnosis_foto;
                    $e['marchites'] = $value->marchites;
                    $e['marchites_fecha'] = $value->marchites_fecha;
                    $e['marchites_area_afectada'] = $value->marchites_area_afectada;
                    $e['marchites_incidencia'] = $value->marchites_incidencia;
                    $e['marchites_recomendacion'] = $value->marchites_recomendacion;
                    $e['marchites_foto'] = $value->marchites_foto;
                    $e['gotera'] = $value->gotera;
                    $e['gotera_fecha'] = $value->gotera_fecha;
                    $e['gotera_area_afectada'] = $value->gotera_area_afectada;
                    $e['gotera_incidencia'] = $value->gotera_incidencia;
                    $e['gotera_recomendacion'] = $value->gotera_recomendacion;
                    $e['gotera_foto'] = $value->gotera_foto;
                    $e['mancha'] = $value->mancha;
                    $e['mancha_fecha'] = $value->mancha_fecha;
                    $e['mancha_area_afectada'] = $value->mancha_area_afectada;
                    $e['mancha_incidencia'] = $value->mancha_incidencia;
                    $e['mancha_recomendacion'] = $value->mancha_recomendacion;
                    $e['mancha_foto'] = $value->mancha_foto;
                    $e['pudricion'] = $value->pudricion;
                    $e['pudricion_fecha'] = $value->pudricion_fecha;
                    $e['pudricion_area_afectada'] = $value->pudricion_area_afectada;
                    $e['pudricion_incidencia'] = $value->pudricion_incidencia;
                    $e['pudricion_recomendacion'] = $value->pudricion_recomendacion;
                    $e['pudricion_foto'] = $value->pudricion_foto;
                    $e['rosado'] = $value->rosado;
                    $e['rosado_fecha'] = $value->rosado_fecha;
                    $e['rosado_area_afectada'] = $value->rosado_area_afectada;
                    $e['rosado_incidencia'] = $value->rosado_incidencia;
                    $e['rosado_recomendacion'] = $value->rosado_recomendacion;
                    $e['rosado_foto'] = $value->rosado_foto;
                    $e['moho'] = $value->moho;
                    $e['moho_fecha'] = $value->moho_fecha;
                    $e['moho_area_afectada'] = $value->moho_area_afectada;
                    $e['moho_incidencia'] = $value->moho_incidencia;
                    $e['moho_recomendacion'] = $value->moho_recomendacion;
                    $e['moho_foto'] = $value->moho_foto;
                    $e['created_at'] = $value->created_at;
                    $e['updated_at'] = $value->updated_at;
                    $e['activo'] = $value->activo;
                if($this->encuestas->guardar_data($e, $url)){
                    \DB::table('enc_enfermedades')->where('id_enfermedad', $value->id_enfermedad)
                    ->update(['activo' => 0]);
                }
            }
        }
    }

    public function cliente_plagas_guardar(){
        $url = 'servicio_plagas_guardar';
        $datas = \DB::table('enc_plagas')->where('activo', 1)->get();
        if (count($datas) > 0) {
            foreach ($datas as $key => $value) {
                $e = array();
                $e['object_id'] = $value->object_id;
                $e['broca'] = $value->broca;
                $e['broca_fecha'] = $value->broca_fecha;
                $e['broca_zona_afectada'] = $value->broca_zona_afectada;
                $e['broca_incidencia'] = $value->broca_incidencia;
                $e['broca_control'] = $value->broca_control;
                $e['cepe'] = $value->cepe;
                $e['cepe_fecha'] = $value->cepe_fecha;
                $e['cepe_zona_afectada'] = $value->cepe_zona_afectada;
                $e['cepe_incidencia'] = $value->cepe_incidencia;
                $e['cepe_control'] = $value->cepe_control;
                $e['grillo'] = $value->grillo;
                $e['grillo_fecha'] = $value->grillo_fecha;
                $e['grillo_zona_afectada'] = $value->grillo_zona_afectada;
                $e['grillo_incidencia'] = $value->grillo_incidencia;
                $e['grillo_control'] = $value->grillo_control;
                $e['cochinilla'] = $value->cochinilla;
                $e['cochinilla_fecha'] = $value->cochinilla_fecha;
                $e['cochinilla_zona_afectada'] = $value->cochinilla_zona_afectada;
                $e['cochinilla_incidencia'] = $value->cochinilla_incidencia;
                $e['cochinilla_control'] = $value->cochinilla_control;
                $e['escamas'] = $value->escamas;
                $e['escamas_fecha'] = $value->escamas_fecha;
                $e['escamas_zona_afectada'] = $value->escamas_zona_afectada;
                $e['escamas_incidencia'] = $value->escamas_incidencia;
                $e['escamas_control'] = $value->escamas_control;
                $e['minador'] = $value->minador;
                $e['minador_fecha'] = $value->minador_fecha;
                $e['minador_zona_afectada'] = $value->minador_zona_afectada;
                $e['minador_incidencia'] = $value->minador_incidencia;
                $e['minador_control'] = $value->minador_control;
                $e['barrenador'] = $value->barrenador;
                $e['barrenador_fecha'] = $value->barrenador_fecha;
                $e['barrenador_zona_afectada'] = $value->barrenador_zona_afectada;
                $e['barrenador_incidencia'] = $value->barrenador_incidencia;
                $e['barrenador_control'] = $value->barrenador_control;
                $e['nematodos'] = $value->nematodos;
                $e['nematodos_fecha'] = $value->nematodos_fecha;
                $e['nematodos_zona_afectada'] = $value->nematodos_zona_afectada;
                $e['nematodos_incidencia'] = $value->nematodos_incidencia;
                $e['nematodos_control'] = $value->nematodos_control;
                $e['created_at'] = $value->created_at;
                $e['updated_at'] = $value->updated_at;
                $e['activo'] = $value->activo;
                if($this->encuestas->guardar_data($e, $url)){
                    \DB::table('enc_plagas')->where('id_plaga', $value->id_plaga)
                    ->update(['activo' => 0]);
                }
            }
        }
    }

    public function cliente_cosechas_guardar(){
        $url = 'servicio_cosechas_guardar';
        $datas = \DB::table('enc_cosechas')->where('activo', 1)->get();
        if (count($datas) > 0) {
            foreach ($datas as $key => $value) {
                $e['object_id'] = $value->object_id;
                $e['fecha'] = $value->fecha;
                $e['manual'] = $value->manual;
                $e['mecanica'] = $value->mecanica;
                $e['peso_bruto'] = $value->peso_bruto;
                $e['created_at'] = $value->created_at;
                $e['updated_at'] = $value->updated_at;
                $e['activo'] = $value->activo;
                if($this->encuestas->guardar_data($e, $url)){
                    \DB::table('enc_cosechas')->where('id_cosecha', $value->id_cosecha)
                    ->update(['activo' => 0]);
                }
            }
        }
    }

    public function cliente_post_cosechas_guardar(){
        $url = 'servicio_post_cosechas_guardar';
        $datas = \DB::table('enc_post_cosechas')->where('activo', 1)->get();
        if (count($datas) > 0) {
            foreach ($datas as $key => $value) {
                $e['object_id'] = $value->object_id;
                $e['cosecha'] = $value->cosecha;
                $e['cosecha_fecha'] = $value->cosecha_fecha;
                $e['cosecha_p_bruto'] = $value->cosecha_p_bruto;
                $e['cosecha_p_descarte'] = $value->cosecha_p_descarte;
                $e['cosecha_p_efectivo'] = $value->cosecha_p_efectivo;
                $e['limpieza'] = $value->limpieza;
                $e['limpieza_fecha'] = $value->limpieza_fecha;
                $e['limpieza_p_bruto'] = $value->limpieza_p_bruto;
                $e['limpieza_p_descarte'] = $value->limpieza_p_descarte;
                $e['limpieza_p_efectivo'] = $value->limpieza_p_efectivo;
                $e['despulpado'] = $value->despulpado;
                $e['despulpado_fecha'] = $value->despulpado_fecha;
                $e['despulpado_p_bruto'] = $value->despulpado_p_bruto;
                $e['despulpado_p_descarte'] = $value->despulpado_p_descarte;
                $e['despulpado_p_efectivo'] = $value->despulpado_p_efectivo;
                $e['created_at'] = $value->created_at;
                $e['updated_at'] = $value->updated_at;
                $e['activo'] = $value->activo;
                if($this->encuestas->guardar_data($e, $url)){
                    \DB::table('enc_post_cosechas')->where('id_post_cosecha', $value->id_post_cosecha)
                    ->update(['activo' => 0]);
                }
            }
        }
    }

    public function cliente_secados_guardar(){
        $url = 'servicio_secados_guardar';
        $datas = \DB::table('enc_secados')->where('activo', 1)->get();
        if (count($datas) > 0) {
            foreach ($datas as $key => $value) {
                $e['object_id'] = $value->object_id;
                $e['secado'] = $value->secado;
                $e['secado_fecha'] = $value->secado_fecha;
                $e['secado_p_total'] = $value->secado_p_total;
                $e['secado_humedad'] = $value->secado_humedad;
                $e['secado_p_efectivo'] = $value->secado_p_efectivo;
                $e['lavado'] = $value->lavado;
                $e['lavado_fecha'] = $value->lavado_fecha;
                $e['lavado_p_total'] = $value->lavado_p_total;
                $e['lavado_humedad'] = $value->lavado_humedad;
                $e['lavado_p_efectivo'] = $value->lavado_p_efectivo;
                $e['miel'] = $value->miel;
                $e['miel_fecha'] = $value->miel_fecha;
                $e['miel_p_total'] = $value->miel_p_total;
                $e['miel_humedad'] = $value->miel_humedad;
                $e['miel_p_efectivo'] = $value->miel_p_efectivo;
                $e['created_at'] = $value->created_at;
                $e['updated_at'] = $value->updated_at;
                $e['activo'] = $value->activo;
                if($this->encuestas->guardar_data($e, $url)){
                    \DB::table('enc_secados')->where('id_secado', $value->id_secado)
                    ->update(['activo' => 0]);
                }
            }
        }
    }

    public function cliente_fertilizaciones_guardar(){
        $url = 'servicio_fertilizaciones_guardar';
        $datas = \DB::table('enc_fertilizaciones')->where('activo', 1)->get();
        // dd($datas);
        if (count($datas) > 0) {
            foreach ($datas as $key => $value) {
                $e['object_id'] = $value->object_id;
                $e['vegetativo'] = $value->vegetativo;
                $e['vegetativo_fecha'] = $value->vegetativo_fecha;
                $e['vegetativo_fecha_aplicacion'] = $value->vegetativo_fecha_aplicacion;
                $e['vegetativo_bioles_producto'] = $value->vegetativo_bioles_producto;
                $e['vegetativo_bioles_dosis'] = $value->vegetativo_bioles_dosis;
                $e['vegetativo_purines_producto'] = $value->vegetativo_purines_producto;
                $e['vegetativo_purines_dosis'] = $value->vegetativo_purines_dosis;
                $e['reproductivo'] = $value->reproductivo;
                $e['reproductivo_fecha'] = $value->reproductivo_fecha;
                $e['reproductivo_fecha_aplicacion'] = $value->reproductivo_fecha_aplicacion;
                $e['reproductivo_producto'] = $value->reproductivo_producto;
                $e['reproductivo_dosis'] = $value->reproductivo_dosis;
                $e['floracion'] = $value->floracion;
                $e['floracion_fecha'] = $value->floracion_fecha;
                $e['floracion_fecha_aplicacion'] = $value->floracion_fecha_aplicacion;
                $e['floracion_producto'] = $value->floracion_producto;
                $e['floracion_dosis'] = $value->floracion_dosis;
                $e['fructificacion'] = $value->fructificacion;
                $e['fructificacion_fecha'] = $value->fructificacion_fecha;
                $e['fructificacion_fecha_aplicacion'] = $value->fructificacion_fecha_aplicacion;
                $e['fructificacion_producto'] = $value->fructificacion_producto;
                $e['fructificacion_dosis'] = $value->fructificacion_dosis;
                $e['created_at'] = $value->created_at;
                $e['updated_at'] = $value->updated_at;
                $e['activo'] = $value->activo;
                if($this->encuestas->guardar_data($e, $url)){
                    \DB::table('enc_fertilizaciones')->where('id_fertilizacion', $value->id_fertilizacion)
                    ->update(['activo' => 0]);
                }
            }
        }
    }

    public function cliente_deficiencias_guardar(){
        $url = 'servicio_deficiencias_guardar';
        $datas = \DB::table('enc_deficiencias')->where('activo', 1)->get();
        if (count($datas) > 0) {
            foreach ($datas as $key => $value) {
                $e['object_id'] = $value->object_id;
                $e['p'] = $value->p;
                $e['p_fecha'] = $value->p_fecha;
                $e['p_deficiencia'] = $value->p_deficiencia;
                $e['p_severidad'] = $value->p_severidad;
                $e['p_producto'] = $value->p_producto;
                $e['p_fecha_aplicacion'] = $value->p_fecha_aplicacion;
                $e['p_foto'] = $value->p_foto;
                $e['k'] = $value->k;
                $e['k_fecha'] = $value->k_fecha;
                $e['k_deficiencia'] = $value->k_deficiencia;
                $e['k_severidad'] = $value->k_severidad;
                $e['k_producto'] = $value->k_producto;
                $e['k_fecha_aplicacion'] = $value->k_fecha_aplicacion;
                $e['k_foto'] = $value->k_foto;
                $e['ca'] = $value->ca;
                $e['ca_fecha'] = $value->ca_fecha;
                $e['ca_deficiencia'] = $value->ca_deficiencia;
                $e['ca_severidad'] = $value->ca_severidad;
                $e['ca_producto'] = $value->ca_producto;
                $e['ca_fecha_aplicacion'] = $value->ca_fecha_aplicacion;
                $e['ca_foto'] = $value->ca_foto;
                $e['mg'] = $value->mg;
                $e['mg_fecha'] = $value->mg_fecha;
                $e['mg_deficiencia'] = $value->mg_deficiencia;
                $e['mg_severidad'] = $value->mg_severidad;
                $e['mg_producto'] = $value->mg_producto;
                $e['mg_fecha_aplicacion'] = $value->mg_fecha_aplicacion;
                $e['mg_foto'] = $value->mg_foto;
                $e['s'] = $value->s;
                $e['s_fecha'] = $value->s_fecha;
                $e['s_deficiencia'] = $value->s_deficiencia;
                $e['s_severidad'] = $value->s_severidad;
                $e['s_producto'] = $value->s_producto;
                $e['s_fecha_aplicacion'] = $value->s_fecha_aplicacion;
                $e['s_foto'] = $value->s_foto;
                $e['fe'] = $value->fe;
                $e['fe_fecha'] = $value->fe_fecha;
                $e['fe_deficiencia'] = $value->fe_deficiencia;
                $e['fe_severidad'] = $value->fe_severidad;
                $e['fe_producto'] = $value->fe_producto;
                $e['fe_fecha_aplicacion'] = $value->fe_fecha_aplicacion;
                $e['fe_foto'] = $value->fe_foto;
                $e['zc'] = $value->zc;
                $e['zc_fecha'] = $value->zc_fecha;
                $e['zc_deficiencia'] = $value->zc_deficiencia;
                $e['zc_severidad'] = $value->zc_severidad;
                $e['zc_producto'] = $value->zc_producto;
                $e['zc_fecha_aplicacion'] = $value->zc_fecha_aplicacion;
                $e['zc_foto'] = $value->zc_foto;
                $e['cu'] = $value->cu;
                $e['cu_fecha'] = $value->cu_fecha;
                $e['cu_deficiencia'] = $value->cu_deficiencia;
                $e['cu_severidad'] = $value->cu_severidad;
                $e['cu_producto'] = $value->cu_producto;
                $e['cu_fecha_aplicacion'] = $value->cu_fecha_aplicacion;
                $e['cu_foto'] = $value->cu_foto;
                $e['b'] = $value->b;
                $e['b_fecha'] = $value->b_fecha;
                $e['b_deficiencia'] = $value->b_deficiencia;
                $e['b_severidad'] = $value->b_severidad;
                $e['b_producto'] = $value->b_producto;
                $e['b_fecha_aplicacion'] = $value->b_fecha_aplicacion;
                $e['b_foto'] = $value->b_foto;
                $e['created_at'] = $value->created_at;
                $e['updated_at'] = $value->updated_at;
                $e['activo'] = $value->activo;
                if($this->encuestas->guardar_data($e, $url)){
                    \DB::table('enc_deficiencias')->where('id_deficiencia', $value->id_deficiencia)
                    ->update(['activo' => 0]);
                }
            }
        }
    }

}
