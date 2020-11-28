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

Route::group(['middleware' => 'auth'], function () {

    Route::get('home_encuestas', 'FormEncuestasController@home_encuestas');


    Route::get('/listado_personas', function (){
        return view('listado.listado_personas');
    })->name('admin.listado_personas');

    Route::get('/home', 'HomeController@index');


    Route::get('form_agregar_persona', 'PersonasController@form_agregar_persona');


    Route::get('form_agregar_persona', 'PersonasController@form_agregar_persona');
    Route::post('agregar_persona', 'PersonasController@agregar_persona');

    Route::get('form_editar_persona/{id_persona}', 'PersonasController@form_editar_persona');
    Route::post('editar_persona', 'PersonasController@editar_persona');
    Route::post('editar_asignacion_persona', 'PersonasController@editar_asignacion_persona');
    Route::post('editar_evidencia_persona', 'PersonasController@editar_evidencia_persona');

    Route::get('form_baja_persona/{id_persona}', 'PersonasController@form_baja_persona');

    Route::get('listado_personas', 'PersonasController@listado_personas');
    Route::resource('buscar_persona', 'PersonasController@buscar_persona');

    Route::post('baja_persona', 'PersonasController@baja_persona');

    Route::get('listado_personas_asignacion', 'PersonasController@listado_personas_asignacion');
    Route::resource('buscar_persona_asignacion', 'PersonasController@buscar_persona_asignacion');





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
    Route::get('reporte_usuarios', 'UsuariosController@reporte_usuarios');



});
