<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('/login');
});


//REDIRECCIONA AL FORMULARIO DE CONSULTA DESDE UN INICIO

// Route::get('/', function () {
//     return redirect('form_consulta');
// });

Route::get('form_consulta', 'ConsultasController@form_consulta');

Route::get('test_page', 'ExcelController@test_page');

Route::get('form_pruebas', 'PruebasController@form_pruebas');
Route::get('log_conexiones', 'PruebasController@log_conexiones');

Auth::routes();
Route::get('form_agregar_persona', 'PersonasController@form_agregar_persona')->name('form_agregar_persona');
Route::post('agregar_persona', 'PersonasController@agregar_persona');

Route::group(['middleware' => 'auth'], function () {


    Route::get('persona/{id}/opciones', 'ExpertoController@form_opciones')->name('opciones_persona');
    Route::get('persona/{id}/antecedentes', 'HistorialController@form_antecedentes')->name('antecedentes_persona');
    Route::post('guardar_antecedentes', 'HistorialController@guardar_antecedentes');
    Route::get('persona/{id}/enfermedades', 'HistorialController@form_enfermedades')->name('enfermedades_persona');
    Route::post('guardar_enfermedades', 'HistorialController@guardar_enfermedades');
    Route::get('persona/{id}/alergias', 'HistorialController@form_alergias')->name('alergias_persona');
    Route::post('guardar_alergias', 'HistorialController@guardar_alergias');
    Route::get('persona/{id}/familiares', 'HistorialController@form_familiares')->name('familiares_persona');
    Route::post('guardar_familiares', 'HistorialController@guardar_familiares');
    Route::get('persona/{id}/recetas', 'HistorialController@form_recetas')->name('recetas_persona');
    Route::post('guardar_recetas', 'HistorialController@guardar_recetas');

    Route::get('form_borrado_medico_cabecera/{id_paciente}', 'HistorialController@form_borrado_medico_cabecera');
    Route::post('borrar_medico_cabecera', 'HistorialController@borrar_medico_cabecera');

    Route::get('persona/{id}/experto', 'ExpertoController@index')->name('experto');
    Route::get('arbol', 'ExpertoController@arbol')->name('arbol');

    Route::get('medicamentos', 'MedicamentoController@index')->name('medicamentos');
    Route::get('form_agregar_medicamento', 'MedicamentoController@form_agregar_medicamento')->name('form_agregar_medicamento');
    Route::post('guardar_medicamento', 'MedicamentoController@guardar_medicamento');

    Route::get('persona/{id}/motorInferencia/{datos}', 'ExpertoController@motorInferencia')->name('motor_inferencia');

    // Route::get('/home', 'HomeController@index');
    Route::get('/home', [function(){
        if(\Auth::user()->isRole('super_admin')==true){
            return redirect()->intended('listado_personas');
        }
        if(\Auth::user()->isRole('medico')==true){
            return redirect()->intended('listado_personas');
        }
        if(\Auth::user()->isRole('paciente')==true){
            return redirect()->intended('persona/'.Auth::user()->id_persona.'/opciones');
        }
      }]);


    Route::get('form_editar_persona/{id}', 'PersonasController@form_editar_persona')->name('form_editar_persona');
    Route::post('editar_persona/{id}', 'PersonasController@editar_persona')->name('editar_persona');

    Route::get('form_eliminar_paciente_medico/{id}', 'PersonasController@form_eliminar_paciente_medico');
    Route::post('eliminar_paciente_medico', 'PersonasController@eliminar_paciente_medico');


    Route::post('editar_asignacion_persona', 'PersonasController@editar_asignacion_persona');
    Route::post('editar_evidencia_persona', 'PersonasController@editar_evidencia_persona');

    Route::get('form_baja_persona/{id_persona}', 'PersonasController@form_baja_persona');

    Route::get('listado_personas', 'PersonasController@listado_personas')->name('listado_personas');
    Route::resource('buscar_persona', 'PersonasController@buscar_persona');

    Route::post('baja_persona', 'PersonasController@baja_persona');


    Route::get('/listado_usuarios', 'UsuariosController@listado_usuarios');
    Route::post('crear_usuario', 'UsuariosController@crear_usuario');
    Route::post('editar_usuario', 'UsuariosController@editar_usuario');
    Route::post('buscar_usuario', 'UsuariosController@buscar_usuario');
    Route::post('borrar_usuario', 'UsuariosController@borrar_usuario');
    Route::post('editar_acceso', 'UsuariosController@editar_acceso');


    Route::post('crear_rol', 'UsuariosController@crear_rol');
    Route::post('crear_permiso', 'UsuariosController@crear_permiso');
    Route::post('asignar_permiso', 'UsuariosController@asignar_permiso');
    Route::get('quitar_permiso/{idrol}/{idper}', 'UsuariosController@quitar_permiso');

    Route::get('form_nuevo_usuario', 'UsuariosController@form_nuevo_usuario');
    Route::get('form_nuevo_rol', 'UsuariosController@form_nuevo_rol');
    Route::get('form_nuevo_permiso', 'UsuariosController@form_nuevo_permiso');
    Route::get('form_editar_usuario/{id}', 'UsuariosController@form_editar_usuario');
    Route::get('confirmacion_borrado_usuario/{idusuario}', 'UsuariosController@confirmacion_borrado_usuario');
    Route::get('asignar_rol/{idusu}/{idrol}', 'UsuariosController@asignar_rol');
    Route::get('quitar_rol/{idusu}/{idrol}', 'UsuariosController@quitar_rol');
    Route::get('form_borrado_usuario/{idusu}', 'UsuariosController@form_borrado_usuario');
    Route::get('borrar_rol/{idrol}', 'UsuariosController@borrar_rol');


    //Usuarios
    Route::get('form_agregar_usuario', 'UsuariosController@form_agregar_usuario');

});
