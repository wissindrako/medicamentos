<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Encuestas\Deficiencia;
use App\Models\Encuestas\Fertilizacion;
use App\Models\Encuestas\Agroforestal;
use App\Models\Encuestas\ControlMaleza;
use App\Models\Encuestas\Cosecha;
use App\User;
use App\Models\Encuestas\Densidad;
use App\Models\Encuestas\Enfermedad;
use App\Models\Encuestas\InformacionBasica;
use App\Models\Encuestas\Plaga;
use App\Models\Encuestas\Poda;
use App\Models\Encuestas\PostCosecha;
use App\Models\Encuestas\Preparacion;
use App\Models\Encuestas\Secado;

class ApiEncuestasController extends Controller
{

    public function datas_informacion_basica(){
        $datas = InformacionBasica::orderBy('created_at', 'desc')->get();
        $datas->makeHidden(['geom']);
        // dd($datas[0]->geom);
        return $datas;
    }

    public function datas_preparacion(){
        $datas = Preparacion::orderBy('created_at', 'desc')->get();
        return $datas;
    }

    public function datas_densidad(){
        $datas = Densidad::orderBy('created_at', 'desc')->get();
        return $datas;
    }

    public function datas_agroforestales(){
        $datas = Agroforestal::orderBy('created_at', 'desc')->get();
        return $datas;
    }

    public function datas_podas(){
        $datas = Poda::orderBy('created_at', 'desc')->get();
        return $datas;
    }

    public function datas_control_malezas(){
        $datas = ControlMaleza::orderBy('created_at', 'desc')->get();
        return $datas;
    }

    public function datas_enfermedades(){
        return Enfermedad::orderBy('created_at', 'desc')->get();
    }

    public function datas_plagas(){
        return Plaga::orderBy('created_at', 'desc')->get();
    }

    public function datas_cosechas(){
        return Cosecha::orderBy('created_at', 'desc')->get();
    }

    public function datas_post_cosechas(){
        return PostCosecha::orderBy('created_at', 'desc')->get();
    }

    public function datas_secados(){
        return Secado::orderBy('created_at', 'desc')->get();
    }

    public function datas_fertilizaciones(){
        return Fertilizacion::orderBy('created_at', 'desc')->get();
    }

    public function datas_deficiencias(){
        return Deficiencia::orderBy('created_at', 'desc')->get();
    }

    public function servicio_informacion_basica_guardar(Request $request){
        //Establecemos el tipo de cultipo id
        $dato = \DB::table('enc_productores')->where('object_id', $request->object_id)->where('activo', 1)->first();

        if ($dato == null) {
            \DB::table('enc_productores')->insert([
                ['object_id' => $request->object_id,
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
                 'tipo_cultivo_id' => $request->tipo_cultivo_id,
                 'created_at' => $request->created_at,
                 'updated_at' => $request->updated_at,
                 'activo' => 1]
            ]);
        } else {
            \DB::table('enc_productores')
            ->where('object_id', $request->object_id)
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
                       'tipo_cultivo_id' => $request->tipo_cultivo_id,
                       'updated_at' => $request->updated_at]);
        }
    }

    public function servicio_preparacion_guardar(Request $request){

        \DB::table('enc_preparaciones')->insert([
            [
                // 'id_preparacion' => $request->id_preparacion,
                'object_id' => $request->object_id,
                'fecha' => $request->fecha,
                'con_quema' => $request->con_quema,
                'sin_quema' => $request->sin_quema,
                'created_at' => $request->created_at,
                'updated_at' => $request->updated_at,
                'activo' => $request->activo
            ]
        ]);
    }

    public function servicio_densidad_guardar(Request $request){

        \DB::table('enc_densidad')->insert([
            [
                // 'id_densidad' => $request->id_densidad,
                'object_id' => $request->object_id,
                'ano' => $request->ano,
                'densidad' => $request->densidad,
                'superficie' => $request->superficie,
                'cantidad_plantas' => $request->cantidad_plantas,
                'plantas_muertas' => $request->plantas_muertas,
                'plantas_efectivas' => $request->plantas_efectivas,
                'created_at' => $request->created_at,
                'updated_at' => $request->updated_at,
                'activo' => $request->activo
            ]
        ]);
    }

    public function servicio_agroforestales_guardar(Request $request){

        \DB::table('enc_sist_agroforestales')->insert([
            [
                // 'id_sist_agroforestal' => $request->id_sist_agroforestal,
                'object_id' => $request->object_id,
                'ano' => $request->ano,
                'pacay' => $request->pacay,
                'pacay_cantidad' => $request->pacay_cantidad,
                'pacay_permanente' => $request->pacay_permanente,
                'pacay_fecha_siembra' => $request->pacay_fecha_siembra,
                'platano' => $request->platano,
                'platano_cantidad' => $request->platano_cantidad,
                'platano_permanente' => $request->platano_permanente,
                'platano_fecha_siembra' => $request->platano_fecha_siembra,
                'citricos' => $request->citricos,
                'citricos_cantidad' => $request->citricos_cantidad,
                'citricos_permanente' => $request->citricos_permanente,
                'citricos_fecha_siembra' => $request->citricos_fecha_siembra,
                'maderables' => $request->maderables,
                'maderables_cantidad' => $request->maderables_cantidad,
                'maderables_permanente' => $request->maderables_permanente,
                'maderables_fecha_siembra' => $request->maderables_fecha_siembra,
                'frutas_amazonicas' => $request->frutas_amazonicas,
                'frutas_amazonicas_cantidad' => $request->frutas_amazonicas_cantidad,
                'frutas_amazonicas_permanente' => $request->frutas_amazonicas_permanente,
                'frutas_amazonicas_fecha_siembra' => $request->frutas_amazonicas_fecha_siembra,
                'otros' => $request->otros,
                'otros_descripcion' => $request->otros_descripcion,
                'otros_cantidad' => $request->otros_cantidad,
                'otros_permanente' => $request->otros_permanente,
                'otros_fecha_siembra' => $request->otros_fecha_siembra,
                'created_at' => $request->created_at,
                'updated_at' => $request->updated_at,
                'activo' => $request->activo,
            ]
        ]);
    }

    public function servicio_podas_guardar(Request $request){
        \DB::table('enc_podas')->insert([
            [
                // 'id_poda' => $request->id_poda,
                'object_id' => $request->object_id,
                'form_planta' => $request->form_planta,
                'form_planta_fecha' => $request->form_planta_fecha,
                'form_planta_fecha_final' => $request->form_planta_fecha_final,
                'form_planta_foto' => $request->form_planta_foto,
                'mantenimiento' => $request->mantenimiento,
                'mantenimiento_fecha' => $request->mantenimiento_fecha,
                'mantenimiento_fecha_final' => $request->mantenimiento_fecha_final,
                'mantenimiento_foto' => $request->mantenimiento_foto,
                'sel_brotes' => $request->sel_brotes,
                'sel_brotes_fecha' => $request->sel_brotes_fecha,
                'sel_brotes_fecha_final' => $request->sel_brotes_fecha_final,
                'sel_brotes_foto' => $request->sel_brotes_foto,
                'rehabilitacion' => $request->rehabilitacion,
                'rehabilitacion_fecha' => $request->rehabilitacion_fecha,
                'rehabilitacion_fecha_final' => $request->rehabilitacion_fecha_final,
                'rehabilitacion_foto' => $request->rehabilitacion_foto,
                'renovacion' => $request->renovacion,
                'renovacion_fecha' => $request->renovacion_fecha,
                'renovacion_fecha_final' => $request->renovacion_fecha_final,
                'renovacion_foto' => $request->renovacion_foto,
                'deshoje_despunte' => $request->deshoje_despunte,
                'deshoje_despunte_fecha' => $request->deshoje_despunte_fecha,
                'deshoje_despunte_fecha_final' => $request->deshoje_despunte_fecha_final,
                'deshoje_despunte_foto' => $request->deshoje_despunte_foto,
                'created_at' => $request->created_at,
                'updated_at' => $request->updated_at,
                'activo' => $request->activo,
            ]
        ]);
    }

    public function servicio_control_malezas_guardar(Request $request){
        \DB::table('enc_controles_maleza')->insert([
            [
                // 'id_control_maleza' => $request->id_control_maleza,
                'object_id' => $request->object_id,
                'biologico' => $request->biologico,
                'biologico_fecha' => $request->biologico_fecha,
                'biologico_producto' => $request->biologico_producto,
                'quimico' => $request->quimico,
                'quimico_fecha' => $request->quimico_fecha,
                'quimico_producto' => $request->quimico_producto,
                'mecanico' => $request->mecanico,
                'mecanico_fecha' => $request->mecanico_fecha,
                'mecanico_producto' => $request->mecanico_producto,
                'created_at' => $request->created_at,
                'updated_at' => $request->updated_at,
                'activo' => $request->activo,
            ]
        ]);
    }

    public function servicio_enfermedades_guardar(Request $request){
        \DB::table('enc_enfermedades')->insert([
            [
                // 'id_enfermedad' => $request->id_enfermedad,
                'object_id' => $request->object_id,
                'cercospora' => $request->cercospora,
                'cercospora_fecha' => $request->cercospora_fecha,
                'cercospora_area_afectada' => $request->cercospora_area_afectada,
                'cercospora_incidencia' => $request->cercospora_incidencia,
                'cercospora_recomendacion' => $request->cercospora_recomendacion,
                'cercospora_foto' => $request->cercospora_foto,
                'roya' => $request->roya,
                'roya_fecha' => $request->roya_fecha,
                'roya_area_afectada' => $request->roya_area_afectada,
                'roya_incidencia' => $request->roya_incidencia,
                'roya_recomendacion' => $request->roya_recomendacion,
                'roya_foto' => $request->roya_foto,
                'gallo' => $request->gallo,
                'gallo_fecha' => $request->gallo_fecha,
                'gallo_area_afectada' => $request->gallo_area_afectada,
                'gallo_incidencia' => $request->gallo_incidencia,
                'gallo_recomendacion' => $request->gallo_recomendacion,
                'gallo_foto' => $request->gallo_foto,
                'antracnosis' => $request->antracnosis,
                'antracnosis_fecha' => $request->antracnosis_fecha,
                'antracnosis_area_afectada' => $request->antracnosis_area_afectada,
                'antracnosis_incidencia' => $request->antracnosis_incidencia,
                'antracnosis_recomendacion' => $request->antracnosis_recomendacion,
                'antracnosis_foto' => $request->antracnosis_foto,
                'marchites' => $request->marchites,
                'marchites_fecha' => $request->marchites_fecha,
                'marchites_area_afectada' => $request->marchites_area_afectada,
                'marchites_incidencia' => $request->marchites_incidencia,
                'marchites_recomendacion' => $request->marchites_recomendacion,
                'marchites_foto' => $request->marchites_foto,
                'gotera' => $request->gotera,
                'gotera_fecha' => $request->gotera_fecha,
                'gotera_area_afectada' => $request->gotera_area_afectada,
                'gotera_incidencia' => $request->gotera_incidencia,
                'gotera_recomendacion' => $request->gotera_recomendacion,
                'gotera_foto' => $request->gotera_foto,
                'mancha' => $request->mancha,
                'mancha_fecha' => $request->mancha_fecha,
                'mancha_area_afectada' => $request->mancha_area_afectada,
                'mancha_incidencia' => $request->mancha_incidencia,
                'mancha_recomendacion' => $request->mancha_recomendacion,
                'mancha_foto' => $request->mancha_foto,
                'pudricion' => $request->pudricion,
                'pudricion_fecha' => $request->pudricion_fecha,
                'pudricion_area_afectada' => $request->pudricion_area_afectada,
                'pudricion_incidencia' => $request->pudricion_incidencia,
                'pudricion_recomendacion' => $request->pudricion_recomendacion,
                'pudricion_foto' => $request->pudricion_foto,
                'rosado' => $request->rosado,
                'rosado_fecha' => $request->rosado_fecha,
                'rosado_area_afectada' => $request->rosado_area_afectada,
                'rosado_incidencia' => $request->rosado_incidencia,
                'rosado_recomendacion' => $request->rosado_recomendacion,
                'rosado_foto' => $request->rosado_foto,
                'moho' => $request->moho,
                'moho_fecha' => $request->moho_fecha,
                'moho_area_afectada' => $request->moho_area_afectada,
                'moho_incidencia' => $request->moho_incidencia,
                'moho_recomendacion' => $request->moho_recomendacion,
                'moho_foto' => $request->moho_foto,
                'created_at' => $request->created_at,
                'updated_at' => $request->updated_at,
                'activo' => $request->activo,
            ]
        ]);
    }

    public function servicio_plagas_guardar(Request $request){
        \DB::table('enc_plagas')->insert([
            [
                // 'id_plaga' => $request->id_plaga,
                'object_id' => $request->object_id,
                'broca' => $request->broca,
                'broca_fecha' => $request->broca_fecha,
                'broca_zona_afectada' => $request->broca_zona_afectada,
                'broca_incidencia' => $request->broca_incidencia,
                'broca_control' => $request->broca_control,
                'cepe' => $request->cepe,
                'cepe_fecha' => $request->cepe_fecha,
                'cepe_zona_afectada' => $request->cepe_zona_afectada,
                'cepe_incidencia' => $request->cepe_incidencia,
                'cepe_control' => $request->cepe_control,
                'grillo' => $request->grillo,
                'grillo_fecha' => $request->grillo_fecha,
                'grillo_zona_afectada' => $request->grillo_zona_afectada,
                'grillo_incidencia' => $request->grillo_incidencia,
                'grillo_control' => $request->grillo_control,
                'cochinilla' => $request->cochinilla,
                'cochinilla_fecha' => $request->cochinilla_fecha,
                'cochinilla_zona_afectada' => $request->cochinilla_zona_afectada,
                'cochinilla_incidencia' => $request->cochinilla_incidencia,
                'cochinilla_control' => $request->cochinilla_control,
                'escamas' => $request->escamas,
                'escamas_fecha' => $request->escamas_fecha,
                'escamas_zona_afectada' => $request->escamas_zona_afectada,
                'escamas_incidencia' => $request->escamas_incidencia,
                'escamas_control' => $request->escamas_control,
                'minador' => $request->minador,
                'minador_fecha' => $request->minador_fecha,
                'minador_zona_afectada' => $request->minador_zona_afectada,
                'minador_incidencia' => $request->minador_incidencia,
                'minador_control' => $request->minador_control,
                'barrenador' => $request->barrenador,
                'barrenador_fecha' => $request->barrenador_fecha,
                'barrenador_zona_afectada' => $request->barrenador_zona_afectada,
                'barrenador_incidencia' => $request->barrenador_incidencia,
                'barrenador_control' => $request->barrenador_control,
                'nematodos' => $request->nematodos,
                'nematodos_fecha' => $request->nematodos_fecha,
                'nematodos_zona_afectada' => $request->nematodos_zona_afectada,
                'nematodos_incidencia' => $request->nematodos_incidencia,
                'nematodos_control' => $request->nematodos_control,
                'created_at' => $request->created_at,
                'updated_at' => $request->updated_at,
                'activo' => $request->activo,
            ]
        ]);
    }

    public function servicio_cosechas_guardar(Request $request){
        \DB::table('enc_cosechas')->insert([
            [
                // 'id_cosecha' => $request->id_cosecha,
                'object_id' => $request->object_id,
                'fecha' => $request->fecha,
                'manual' => $request->manual,
                'mecanica' => $request->mecanica,
                'peso_bruto' => $request->peso_bruto,
                'created_at' => $request->created_at,
                'updated_at' => $request->updated_at,
                'activo' => $request->activo,
            ]
        ]);
    }

    
    public function servicio_post_cosechas_guardar(Request $request){
        \DB::table('enc_post_cosechas')->insert([
            [
                // 'id_post_cosecha' => $request->id_post_cosecha,
                'object_id' => $request->object_id,
                'cosecha' => $request->cosecha,
                'cosecha_fecha' => $request->cosecha_fecha,
                'cosecha_p_bruto' => $request->cosecha_p_bruto,
                'cosecha_p_descarte' => $request->cosecha_p_descarte,
                'cosecha_p_efectivo' => $request->cosecha_p_efectivo,
                'limpieza' => $request->limpieza,
                'limpieza_fecha' => $request->limpieza_fecha,
                'limpieza_p_bruto' => $request->limpieza_p_bruto,
                'limpieza_p_descarte' => $request->limpieza_p_descarte,
                'limpieza_p_efectivo' => $request->limpieza_p_efectivo,
                'despulpado' => $request->despulpado,
                'despulpado_fecha' => $request->despulpado_fecha,
                'despulpado_p_bruto' => $request->despulpado_p_bruto,
                'despulpado_p_descarte' => $request->despulpado_p_descarte,
                'despulpado_p_efectivo' => $request->despulpado_p_efectivo,
                'created_at' => $request->created_at,
                'updated_at' => $request->updated_at,
                'activo' => $request->activo,
            ]
        ]);
    }
    
    public function servicio_secados_guardar(Request $request){
        \DB::table('enc_secados')->insert([
            [
                // 'id_secado' => $request->id_secado,
                'object_id' => $request->object_id,
                'secado' => $request->secado,
                'secado_fecha' => $request->secado_fecha,
                'secado_p_total' => $request->secado_p_total,
                'secado_humedad' => $request->secado_humedad,
                'secado_p_efectivo' => $request->secado_p_efectivo,
                'lavado' => $request->lavado,
                'lavado_fecha' => $request->lavado_fecha,
                'lavado_p_total' => $request->lavado_p_total,
                'lavado_humedad' => $request->lavado_humedad,
                'lavado_p_efectivo' => $request->lavado_p_efectivo,
                'miel' => $request->miel,
                'miel_fecha' => $request->miel_fecha,
                'miel_p_total' => $request->miel_p_total,
                'miel_humedad' => $request->miel_humedad,
                'miel_p_efectivo' => $request->miel_p_efectivo,
                'created_at' => $request->created_at,
                'updated_at' => $request->updated_at,
                'activo' => $request->activo,
            ]
        ]);
    }
    
    public function servicio_fertilizaciones_guardar(Request $request){
        \DB::table('enc_fertilizaciones')->insert([
            [
                // 'id_fertilizacion' => $request->id_fertilizacion,
                'object_id' => $request->object_id,
                'vegetativo' => $request->vegetativo,
                'vegetativo_fecha' => $request->vegetativo_fecha,
                'vegetativo_fecha_aplicacion' => $request->vegetativo_fecha_aplicacion,
                'vegetativo_bioles_producto' => $request->vegetativo_bioles_producto,
                'vegetativo_bioles_dosis' => $request->vegetativo_bioles_dosis,
                'vegetativo_purines_producto' => $request->vegetativo_purines_producto,
                'vegetativo_purines_dosis' => $request->vegetativo_purines_dosis,
                'reproductivo' => $request->reproductivo,
                'reproductivo_fecha' => $request->reproductivo_fecha,
                'reproductivo_fecha_aplicacion' => $request->reproductivo_fecha_aplicacion,
                'reproductivo_producto' => $request->reproductivo_producto,
                'reproductivo_dosis' => $request->reproductivo_dosis,
                'floracion' => $request->floracion,
                'floracion_fecha' => $request->floracion_fecha,
                'floracion_fecha_aplicacion' => $request->floracion_fecha_aplicacion,
                'floracion_producto' => $request->floracion_producto,
                'floracion_dosis' => $request->floracion_dosis,
                'fructificacion' => $request->fructificacion,
                'fructificacion_fecha' => $request->fructificacion_fecha,
                'fructificacion_fecha_aplicacion' => $request->fructificacion_fecha_aplicacion,
                'fructificacion_producto' => $request->fructificacion_producto,
                'fructificacion_dosis' => $request->fructificacion_dosis,
                'created_at' => $request->created_at,
                'updated_at' => $request->updated_at,
                'activo' => $request->activo,
            ]
        ]);
    }
    
    public function servicio_deficiencias_guardar(Request $request){
        \DB::table('enc_deficiencias')->insert([
            [
                // 'id_deficiencia' => $request->id_deficiencia,
                'object_id' => $request->object_id,
                'p' => $request->p,
                'p_fecha' => $request->p_fecha,
                'p_deficiencia' => $request->p_deficiencia,
                'p_severidad' => $request->p_severidad,
                'p_producto' => $request->p_producto,
                'p_fecha_aplicacion' => $request->p_fecha_aplicacion,
                'p_foto' => $request->p_foto,
                'k' => $request->k,
                'k_fecha' => $request->k_fecha,
                'k_deficiencia' => $request->k_deficiencia,
                'k_severidad' => $request->k_severidad,
                'k_producto' => $request->k_producto,
                'k_fecha_aplicacion' => $request->k_fecha_aplicacion,
                'k_foto' => $request->k_foto,
                'ca' => $request->ca,
                'ca_fecha' => $request->ca_fecha,
                'ca_deficiencia' => $request->ca_deficiencia,
                'ca_severidad' => $request->ca_severidad,
                'ca_producto' => $request->ca_producto,
                'ca_fecha_aplicacion' => $request->ca_fecha_aplicacion,
                'ca_foto' => $request->ca_foto,
                'mg' => $request->mg,
                'mg_fecha' => $request->mg_fecha,
                'mg_deficiencia' => $request->mg_deficiencia,
                'mg_severidad' => $request->mg_severidad,
                'mg_producto' => $request->mg_producto,
                'mg_fecha_aplicacion' => $request->mg_fecha_aplicacion,
                'mg_foto' => $request->mg_foto,
                's' => $request->s,
                's_fecha' => $request->s_fecha,
                's_deficiencia' => $request->s_deficiencia,
                's_severidad' => $request->s_severidad,
                's_producto' => $request->s_producto,
                's_fecha_aplicacion' => $request->s_fecha_aplicacion,
                's_foto' => $request->s_foto,
                'fe' => $request->fe,
                'fe_fecha' => $request->fe_fecha,
                'fe_deficiencia' => $request->fe_deficiencia,
                'fe_severidad' => $request->fe_severidad,
                'fe_producto' => $request->fe_producto,
                'fe_fecha_aplicacion' => $request->fe_fecha_aplicacion,
                'fe_foto' => $request->fe_foto,
                'zc' => $request->zc,
                'zc_fecha' => $request->zc_fecha,
                'zc_deficiencia' => $request->zc_deficiencia,
                'zc_severidad' => $request->zc_severidad,
                'zc_producto' => $request->zc_producto,
                'zc_fecha_aplicacion' => $request->zc_fecha_aplicacion,
                'zc_foto' => $request->zc_foto,
                'cu' => $request->cu,
                'cu_fecha' => $request->cu_fecha,
                'cu_deficiencia' => $request->cu_deficiencia,
                'cu_severidad' => $request->cu_severidad,
                'cu_producto' => $request->cu_producto,
                'cu_fecha_aplicacion' => $request->cu_fecha_aplicacion,
                'cu_foto' => $request->cu_foto,
                'b' => $request->b,
                'b_fecha' => $request->b_fecha,
                'b_deficiencia' => $request->b_deficiencia,
                'b_severidad' => $request->b_severidad,
                'b_producto' => $request->b_producto,
                'b_fecha_aplicacion' => $request->b_fecha_aplicacion,
                'b_foto' => $request->b_foto,
                'created_at' => $request->created_at,
                'updated_at' => $request->updated_at,
                'activo' => $request->activo,
            ]
        ]);
    }
}
