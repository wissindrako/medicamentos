<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ValidacionPersona;
use App\Models\Historial;
use Illuminate\Support\Facades\Validator;
use Datatables;
use DateTime;
use Image;
use Auth;
use App\User;
use App\Persona;


class PersonasController extends Controller
{
    
    public function form_agregar_persona(){
        //carga el formulario para agregar un nueva persona

        // if(\Auth::user()->isRole('registrador')==false && \Auth::user()->isRole('admin')==false && \Auth::user()->isRole('responsable_circunscripcion')==false){
        //     return view("mensajes.mensaje_error")->with("msj",'<div class="box box-danger col-xs-12"><div class="rechazado" style="margin-top:70px; text-align: center">    <span class="label label-success">#!<i class="fa fa-check"></i></span><br/>  <label style="color:#177F6B">  Acceso restringido </label>   </div></div> ') ;
        // }
        $roles = [];

        $personas = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('activo', 1)
        ->get();

        if (Auth::guest()) {
            $roles = \DB::table('roles')
            ->where('id', '>', 1)
            ->get();
        } else {
            $roles = \DB::table('roles')->get();
        }

        return view("formularios.form_agregar_persona")
        ->with('roles', $roles)
        ->with('personas', $personas);
    }

    public function agregar_persona(ValidacionPersona $request){

        // if(\Auth::user()->isRole('registrador')==false && \Auth::user()->isRole('admin')==false && \Auth::user()->isRole('responsable_circunscripcion')==false){
        //     return view("mensajes.mensaje_error")->with("msj",'<div class="box box-danger col-xs-12"><div class="rechazado" style="margin-top:70px; text-align: center">    <span class="label label-success">#!<i class="fa fa-check"></i></span><br/>  <label style="color:#177F6B">  Acceso restringido </label>   </div></div> ') ;
        // }
        $foto = "";

        if($request->file('archivo') != ""){
            $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));
            $archivo = $request->file('archivo');
            $mime = $archivo->getMimeType();
            $extension=strtolower($archivo->getClientOriginalExtension());

            $nuevo_nombre=$request->input("cedula_identidad")."-".$tiempo_actual->getTimestamp();

            $file = $request->file('archivo');

            $image = Image::make($file->getRealPath());
            
            //reducimos la calidad y cambiamos la dimensiones de la nueva instancia.
            $image->resize(1280, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
            });
            $image->orientate();

            $rutadelaimagen="../storage/media/fotos/".$nuevo_nombre;

            if ($image->save($rutadelaimagen)){
                $foto=$rutadelaimagen;

            }else{
                $foto = "";
            }
        }

        $persona=new Persona;
                                
        $persona->nombre=ucwords(strtolower($request->input("nombre")));
        $persona->paterno=ucwords(strtolower($request->input("paterno")));
        $persona->materno=ucwords(strtolower($request->input("materno")));
        $persona->cedula_identidad=$request->input("cedula_identidad");
        $persona->edad=$request->input("edad");
        $persona->sexo=$request->input("sexo");
        $persona->especialidad=$request->input("especialidad");
        $persona->institucion=$request->input("institucion");
        $persona->id_medico=$request->input("medico");
        $persona->foto=$foto;
        $persona->activo=1;

        if($persona->save()){
            $username = $this->ObtieneUsuario($persona->id_persona);
            $usuario=new User;
            $usuario->name=$username;
        
            $usuario->email = $username;
            $usuario->password= bcrypt($username);
            $usuario->id_persona=$persona->id_persona;
            $usuario->activo=1;

            if($usuario->save()){
                $usuario->assignRole($request->input("rol"));

                if ($request->input("rol") == 4) {
                    $historial = new Historial;
                    $historial->id_persona = $persona->id_persona;
                    $historial->save();
                } 
                
                return redirect('/listado_personas')->with('mensaje_exito', 'Agregado exitosamente');
            }else{
                return view("mensajes.mensaje_error")->with("msj","...Hubo un error al agregar ;...") ;
            }

        }else{
            return view("mensajes.mensaje_error")->with("msj","...Hubo un error al agregar ;...") ;
        }

    }


    public function form_editar_persona($id){
        //carga el formulario para agregar un nueva persona
        // if(\Auth::user()->isRole('registrador')==false && \Auth::user()->isRole('admin')==false && \Auth::user()->isRole('responsable_circunscripcion')==false){
        //     return view("mensajes.mensaje_error")->with("msj",'<div class="box box-danger col-xs-12"><div class="rechazado" style="margin-top:70px; text-align: center">    <span class="label label-success">#!<i class="fa fa-check"></i></span><br/>  <label style="color:#177F6B">  Acceso restringido </label>   </div></div> ') ;
        // }

        $roles = [];

        $data = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('id_persona', $id)
        ->first();

        $personas = Persona::with('usuario')
        ->with('usuario.roles')
        ->where('activo', 1)
        ->where('id_persona', '!=', $id)
        ->get();

        if (Auth::guest()) {
            $roles = \DB::table('roles')
            ->where('id', '>', 1)
            ->get();
        } else {
            $roles = \DB::table('roles')->get();
        }

        return view("formularios.form_editar_persona")
        ->with('personas', $personas)
        ->with('roles', $roles)
        ->with('data', $data);
    }

    public function editar_persona(ValidacionPersona $request, $id){
        // if(\Auth::user()->isRole('registrador')==false && \Auth::user()->isRole('admin')==false && \Auth::user()->isRole('responsable_circunscripcion')==false){
        //     return view("mensajes.mensaje_error")->with("msj",'<div class="box box-danger col-xs-12"><div class="rechazado" style="margin-top:70px; text-align: center">    <span class="label label-success">#!<i class="fa fa-check"></i></span><br/>  <label style="color:#177F6B">  Acceso restringido </label>   </div></div> ') ;
        // }
        
        $foto = "";

        if($request->file('archivo') != ""){
            $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));
            $archivo = $request->file('archivo');
            $mime = $archivo->getMimeType();
            $extension=strtolower($archivo->getClientOriginalExtension());

            $nuevo_nombre=$request->input("cedula_identidad")."-".$tiempo_actual->getTimestamp();

            $file = $request->file('archivo');

            $image = Image::make($file->getRealPath());
            
            //reducimos la calidad y cambiamos la dimensiones de la nueva instancia.
            $image->resize(1280, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
            });
            $image->orientate();

            $rutadelaimagen="../storage/media/fotos/".$nuevo_nombre;

            if ($image->save($rutadelaimagen)){
                $foto=$rutadelaimagen;

            }else{
                $foto = "";
            }
        }

        $persona= Persona::findOrFail($id);
                                
        $persona->nombre=ucwords(strtolower($request->input("nombre")));
        $persona->paterno=ucwords(strtolower($request->input("paterno")));
        $persona->materno=ucwords(strtolower($request->input("materno")));
        $persona->cedula_identidad=$request->input("cedula_identidad");
        $persona->edad=$request->input("edad");
        $persona->sexo=$request->input("sexo");
        $persona->especialidad=$request->input("especialidad");
        $persona->institucion=$request->input("institucion");
        $persona->id_medico=$request->input("medico");
        $persona->foto=$foto;
        $persona->activo=1;

        if($persona->save()){
            $usuario= User::findOrFail($persona->usuario->id);
            if($usuario->email != $request->input("cedula_identidad")){
                $username = $this->ObtieneUsuario($persona->id_persona);
                
                $usuario->name=$username;
            
                $usuario->email = $username;
                $usuario->password= bcrypt($username);
            }

            if($usuario->save()){

                if($usuario->roles[0]->id != $request->input("rol")){
                    $usuario->revokeRole($usuario->roles[0]->id);
                    $usuario->assignRole($request->input("rol"));
                }

                if ($request->input("rol") != $usuario->roles[0]->id) {
                    if($request->input("rol") == 4){
                        $historial = new Historial;
                        $historial->id_persona = $persona->id_persona;
                        $historial->save();
                    }else{
                        $historial = Historial::where('id_persona', $persona->id_persona)->first();
                        if($historial != null){
                            $historial->delete();
                        }
                    }
                }

                return redirect('/listado_personas')->with('mensaje_exito', 'Agregado exitosamente');
            }else{
                return view("mensajes.mensaje_error")->with("msj","...Hubo un error al agregar ;...") ;
            }

        }else{
            return view("mensajes.mensaje_error")->with("msj","...Hubo un error al agregar ;...") ;
        }
    }

    public function editar_asignacion_persona(Request $request){
        if(\Auth::user()->isRole('registrador')==false && \Auth::user()->isRole('admin')==false && \Auth::user()->isRole('responsable_circunscripcion')==false){
            return view("mensajes.mensaje_error")->with("msj",'<div class="box box-danger col-xs-12"><div class="rechazado" style="margin-top:70px; text-align: center">    <span class="label label-success">#!<i class="fa fa-check"></i></span><br/>  <label style="color:#177F6B">  Acceso restringido </label>   </div></div> ') ;
        }

        $id_persona = $request->input("id_persona");
        $persona = Persona::find($id_persona);
        
        if ($request->input("rol_slug") == '') {
            return 'rol';
        // }elseif ($request->input("grado_compromiso") == "") {
        //     return "grado_compromiso";
        }elseif ($request->input("recinto") == "") {
            return "recinto";
        }elseif($request->input("rol_slug") == 'conductor' && $request->input("id_vehiculo") == ""){
            return "id_vehiculo";
        }elseif ($request->input("rol_slug") == 'registrador' && $request->input("id_casa_campana") == "") {
            return "id_casa_campana";
        }elseif ($request->input("rol_slug") == 'responsable_mesa' && !$request->has("mesas")) {
            return "mesas";
        }elseif ($request->input("rol_slug") == 'responsable_recinto' && $request->input("recinto") == "") {
            return "recinto";
        }elseif ($request->input("rol_slug") == 'responsable_distrito' && $request->input("recinto") == "") {
            return "recinto";
        }elseif ($request->input("rol_slug") == 'responsable_circunscripcion' && $request->input("recinto") == "") {
            return "recinto";
        }else {
            # code...
        }
      
        if($request->recinto != ""){

            $persona->grado_compromiso=$request->input("grado_compromiso");
            
            $persona->id_origen=$request->input("id_origen");
            $persona->id_sub_origen=$request->input("id_sub_origen");
            $persona->id_responsable_registro=Auth::user()->id;
            // $persona->informatico=$request->input("informatico");
            $persona->titularidad=$request->input("titularidad");
            $recinto = Recinto::find($request->input("recinto"));
            $persona->evidencia=$request->input("evidencia");
            // Obteniendo los datos del Usuario segun el id_persona
            $usuario = \DB::table('users')
            ->where('id_persona', $request->input('id_persona'))
            ->first();
            //Cambiando el metodo de identificar usuario para usar el revoke
            $usuario=User::find($usuario->id);

            $rol = \DB::table('roles')
            ->where('roles.slug', $request->input("rol_slug"))
            ->first();

            $rol_actual = \DB::table('roles')
            ->where('id', $persona->id_rol)
            ->first();
             
            if ($persona->id_rol != $rol->id) {
                // si el rol cambia


                //Revocando el Rol de la tabla role_user
                $usuario->revokeRole($rol_actual->id);

                //Rol Actual a liberar
                if ($rol_actual->slug == 'productor') {
                 
                }elseif ($rol_actual->slug == 'militante') {
                    # militantes...
                }elseif ($rol_actual->slug == 'conductor') {
                    # conductor

                    //Quitando el rol de la relacion usuario_transporte
                    if (\DB::table('rel_usuario_transporte')
                    ->where('id_usuario', $usuario->id)
                    ->delete()) {}
                }elseif ($rol_actual->slug == 'registrador') {
                    # Registrador

                    //Quitando el rol de la relacion usuario_casa_campaña
                    if (\DB::table('rel_usuario_campana')
                    ->where('id_usuario', $usuario->id)
                    ->delete()) {}
                }elseif ($rol_actual->slug == 'call_center') {
                    # Call center
                }elseif ($rol_actual->slug == 'responsable_mesa') {
                    # ResponsableMesa
                    if (UsuarioMesa::where('id_usuario', $usuario->id)->delete()){}
                }elseif ($rol_actual->slug == 'responsable_recinto') {
                    # ResponsableRecinto
                    if (\DB::table('rel_usuario_recinto')
                    ->where('id_usuario', $usuario->id)
                    ->delete()) {}
                }elseif ($rol_actual->slug == 'responsable_distrito') {
                    # ResponsableDistrito
                    if (\DB::table('rel_usuario_distrito')
                    ->where('id_usuario', $usuario->id)
                    ->delete()) {}
                }elseif ($rol_actual->slug == 'responsable_circunscripcion') {
                    # ResponsableCircunscripcion
                    if (\DB::table('rel_usuario_circunscripcion')
                    ->where('id_usuario', $usuario->id)
                    ->delete()) {}
                }  else {
                    # code...
                }

                $persona->id_recinto = $request->input("recinto");

                if($request->input("rol_slug") == 'productor'){
                    //rol delegado del MAS
                    $persona->id_rol = $rol->id;
                    if ($persona->save()) {
                        return view("mensajes.msj_enviado")->with("msj","enviado_editar_persona");
                    }
                }elseif($request->input("rol_slug") == 'militante'){
                    //rol delegado del MAS
                    $persona->id_rol = $rol->id;
                    if ($persona->save()) {
                        return view("mensajes.msj_enviado")->with("msj","enviado_editar_persona");
                    }
                }elseif ($request->input("rol_slug") == 'conductor') {
                    // rol Conductor
                    if ($request->input("id_vehiculo") != "") {
                        //Si el usuario es creado correctamente modificamos su rol

                        if ($usuario->save()) {
            
                            $rol = \DB::table('roles')
                            ->where('roles.slug', $request->input("rol_slug"))
                            ->first();
                                // agregando el rol conductor a persona;
                            $persona->id_rol = $rol->id;
                            //Asignando rol el rol conductor al usuario
                            $usuario->assignRole($rol->id);
                            if ($persona->save()) {
                                // creamos las relaciones usuario - transporte
                                $usuario_transporte = new UsuarioTransporte();
                                $usuario_transporte->id_usuario = $usuario->id;
                                $usuario_transporte->id_transporte = $request->input("id_vehiculo");
                                $usuario_transporte->activo = 1;
                                if ($usuario_transporte->save()) {
                                    return view("mensajes.msj_enviado")->with("msj","enviado_editar_persona");
                                } else {
                                    # code...
                                }
                            } else {
                                // si no se guarda el update
                            }
                            
                        } else {
                            //si el usuario no se guarda
                            return "failed usuario;";
                        }
                        
                    } else {
                        return "id_vehiculo";
                    }
                    // fin Conductor
                }elseif ($request->input("rol_slug") == 'registrador') {
                    // rol Registrador
                    if ($request->input("id_casa_campana") != "") {
        
                        //Si el usuario es creado correctamente modificamos su rol
                        if ($usuario->save()) {
            
                            $rol = \DB::table('roles')
                            ->where('roles.slug', $request->input("rol_slug"))
                            ->first();

                            // agregando el rol registrador en la tabla persona
                            $persona->id_rol = $rol->id;

                            //Asignando rol registrador en la tabla users
                            $usuario->assignRole($rol->id);
        
                            if ($persona->save()) {
                                // creamos las relaciones usuario - casa de campaña
                                $usuario_casa_campana = new UsuarioCasaCampana();
                                $usuario_casa_campana->id_usuario = $usuario->id;
                                $usuario_casa_campana->id_casa_campana = $request->input("id_casa_campana");
                                $usuario_casa_campana->activo = 1;
                                if ($usuario_casa_campana->save()) {
                                    return view("mensajes.msj_enviado")->with("msj","enviado_editar_persona");
                                } else {
                                    return "failed usuario;";
                                }
                            } else {
                                // si no se guarda el update
                            }
                            
                        } else {
                            //si el usuario no se guarda
                            return "failed usuario;";
                        }
                        
                    } else {
                        return "id_casa_campana";
                    }
                    // fin Registrador
                }elseif ($request->input("rol_slug") == 'call_center') {
                    //rol Call Center
                    //Si el usuario es creado correctamente modificamos su rol
                    if ($usuario->save()) {

                        $rol = \DB::table('roles')
                        ->where('roles.slug', $request->input("rol_slug"))
                        ->first();

                        // Cambiando el rol de persona
                        $persona->id_rol = $rol->id;
                        //Asignando rol
                        $usuario->assignRole($rol->id);
    
                        if ($persona->save()) {
                            return view("mensajes.msj_enviado")->with("msj","enviado_editar_persona");
                        } else {
                            // si no se guarda el update
                        }
                        
                    } else {
                        //si el usuario no se guarda
                        return "failed usuario;";
                    }
                }elseif ($request->input("rol_slug") == 'responsable_mesa'){
                    //rol responsable_mesa
                    if ($request->has("mesas")) {
        
                        //Si el usuario es creado correctamente modificamos su rol
                        if ($usuario->save()) {
            
                            $rol = \DB::table('roles')
                            ->where('roles.slug', $request->input("rol_slug"))
                            ->first();
            
                            $persona->id_rol =$rol->id;
                            //Asignando rol
                            $usuario->assignRole($rol->id);
            
                            if ($persona->save()) {
                                // creamos las relaciones usuario - mesas
                                foreach ($request->mesas as $value) {
                                    $usuario_mesa = new UsuarioMesa;
                                    $usuario_mesa->id_usuario = $usuario->id;
                                    $usuario_mesa->id_mesa = $value;
                                    $usuario_mesa->activo = 1;
                                    $usuario_mesa->save();
                                }
                                return view("mensajes.msj_enviado")->with("msj","enviado_editar_persona");
                            } else {
                                // si no se guarda el update
                            }
                            
                        } else {
                            //si el usuario no se guarda
                            return "failed usuario;";
                        }
                        
                    } else {
                        return "mesas";
                    }
                //fin rol informarico
                }elseif ($request->input("rol_slug") == 'responsable_recinto') {

                    // rol responsable recinto
                    if ($request->input("recinto") != "") {
                            
                        //Si el usuario es creado correctamente modificamos su rol
                        if ($usuario->save()) {
            
                            $rol = \DB::table('roles')
                            ->where('roles.slug', $request->input("rol_slug"))
                            ->first();

                            // $persona->id_rol =$request->input("id_rol");
                            $persona->id_rol =$rol->id;
                            //Asignando rol
                            $usuario->assignRole($rol->id);
        
                            if ($persona->save()) {
                                // creamos las relaciones usuario - recinto
                                $usuario_recinto = new UsuarioRecinto;
                                $usuario_recinto->id_usuario = $usuario->id;
                                $usuario_recinto->id_recinto = $request->input("recinto");
                                $usuario_recinto->activo = 1;
                                if ($usuario_recinto->save()) {
                                    return view("mensajes.msj_enviado")->with("msj","enviado_editar_persona");
                                } else {
                                    # code...
                                }
                            } else {
                                // si no se guarda el update
                            }
                            
                        } else {
                            //si el usuario no se guarda
                            return "failed usuario;";
                        }
                        
                    } else {
                        return "recinto";
                    }
                    // finresponsable recinto
                }elseif ($request->input("rol_slug") == 'responsable_distrito') {
                    //rol Responsable de Distrito
                    if ($request->input("recinto") != "") {
        
                        //Si el usuario es creado correctamente modificamos su rol
                        if ($usuario->save()) {
            
                            $rol = \DB::table('roles')
                            ->where('roles.slug', $request->input("rol_slug"))
                            ->first();
                                // $persona->id_rol =$request->input("id_rol");
                            $persona->id_rol =$rol->id;
                            //Asignando rol
                            $usuario->assignRole($rol->id);
            
                            if ($persona->save()) {
                                // creamos las relaciones usuario - recinto
                                $usuario_distrito = new UsuarioDistrito;
                                $usuario_distrito->id_usuario = $usuario->id;
                                $usuario_distrito->id_distrito = $recinto->distrito;
                                $usuario_distrito->activo = 1;
                                if ($usuario_distrito->save()) {
                                    return view("mensajes.msj_enviado")->with("msj","enviado_editar_persona");
                                } else {
                                    # code...
                                }
                            } else {
                                // si no se guarda el update
                            }
                            
                        } else {
                            //si el usuario no se guarda
                            return "failed usuario;";
                        }
                        
                    } else {
                        return "distrito";
                    }
                    //fin Responsable de Distrito
                }elseif ($request->input("rol_slug") == 'responsable_circunscripcion') {
                    //rol Responsable Circunscripcion
                    if ($request->input("recinto") != "") {
            
                        //Si el usuario es creado correctamente modificamos su rol
                        if ($usuario->save()) {

                            $rol = \DB::table('roles')
                            ->where('roles.slug', $request->input("rol_slug"))
                            ->first();
                                // $persona->id_rol =$request->input("id_rol");
                            $persona->id_rol =$rol->id;
                            //Asignando rol
                            $usuario->assignRole($rol->id);
        
                            if ($persona->save()) {
                                // creamos las relaciones usuario - circ
                                $usuario_circunscripcion = new UsuarioCircunscripcion;
                                $usuario_circunscripcion->id_usuario = $usuario->id;
                                $usuario_circunscripcion->id_circunscripcion = $recinto->circunscripcion;
                                $usuario_circunscripcion->activo = 1;
                                if ($usuario_circunscripcion->save()) {
                                    return view("mensajes.msj_enviado")->with("msj","enviado_editar_persona");
                                } else {
                                    # code...
                                }
                            } else {
                                // si no se guarda el update
                            }
                            
                        } else {
                            //si el usuario no se guarda
                            return "failed usuario;";
                        }
                        
                    } else {
                        return "circunscripcion";
                    }
                    // fin Responsable Circunscripcion
                }else{
        
                }


            } else {
                // Si el rol no cambia
                if ($persona->id_recinto != $request->input("recinto")) {
                    //Si el recinto cambia
                    
                    //Rol Actual a liberar
                if ($request->input("rol_slug") == 'militante') {
                    # militantes...
                    $persona->id_recinto = $request->input("recinto");

                }elseif ($request->input("rol_slug") == 'conductor') {
                    # conductor
                    $persona->id_recinto = $request->input("recinto");

                }elseif ($request->input("rol_slug") == 'registrador') {
                    # Registrador
                    $usuario_casa_campana = new UsuarioCasaCampana();
                    $usuario_casa_campana->id_usuario = $usuario->id;
                    $usuario_casa_campana->id_casa_campana = $request->input("id_casa_campana");
                    $usuario_casa_campana->activo = 1;
                    
                    if ($usuario_casa_campana->save()) {
                        $persona->id_recinto = $request->input("recinto");
                    }

                }elseif ($request->input("rol_slug") == 'call_center') {
                    # Call center
                    $persona->id_recinto = $request->input("recinto");

                }elseif ($request->input("rol_slug") == 'responsable_mesa') {
                    if (UsuarioMesa::where('id_usuario', $usuario->id)->delete()){}
                    # ResponsableMesa
                    foreach ($request->mesas as $value) {
                        $usuario_mesa = new UsuarioMesa;
                        $usuario_mesa->id_usuario = $usuario->id;
                        $usuario_mesa->id_mesa = $value;
                        $usuario_mesa->activo = 1;
                        $usuario_mesa->save();
                    }
                    $persona->id_recinto = $request->input("recinto");

                }elseif ($request->input("rol_slug") == 'responsable_recinto') {
                    # ResponsableRecinto
                    if (\DB::table('rel_usuario_recinto')
                    ->where('id_usuario', $usuario->id)
                    ->delete()) {}

                    $usuario_recinto = new UsuarioRecinto;
                    $usuario_recinto->id_usuario = $usuario->id;
                    $usuario_recinto->id_recinto = $request->input("recinto");
                    $usuario_recinto->activo = 1;
                    if ($usuario_recinto->save()) {
                        $persona->id_recinto = $request->input("recinto");
                    }

                }elseif ($request->input("rol_slug") == 'responsable_distrito') {
                    # ResponsableDistrito
                    if (\DB::table('rel_usuario_recinto')
                    ->where('id_usuario', $usuario->id)
                    ->delete()) {}

                    $usuario_distrito = new UsuarioDistrito;
                    $usuario_distrito->id_usuario = $usuario->id;
                    $usuario_distrito->id_distrito = $recinto->distrito;
                    $usuario_distrito->activo = 1;
                    if ($usuario_distrito->save()) {
                        $persona->id_recinto = $request->input("recinto");
                    }

                }elseif ($request->input("rol_slug") == 'responsable_circunscripcion') {
                    # ResponsableCircunscripcion
                    if (\DB::table('rel_usuario_circunscripcion')
                    ->where('id_usuario', $usuario->id)
                    ->delete()) {}
                    // creamos las relaciones usuario - circ
                    $usuario_circunscripcion = new UsuarioCircunscripcion;
                    $usuario_circunscripcion->id_usuario = $usuario->id;
                    $usuario_circunscripcion->id_circunscripcion = $recinto->circunscripcion;
                    $usuario_circunscripcion->activo = 1;
                    if ($usuario_circunscripcion->save()) {
                        $persona->id_recinto = $request->input("recinto");
                    }
                }  else {
                    # code...
                }

                $persona->id_recinto=$request->input("recinto");
                if($persona->save())
                {
                    return view("mensajes.msj_enviado")->with("msj","enviado_editar_persona");
                }else{
                    return "failed";
                }

                } else {
                    //Si el recinto no cambia

                    if ($request->input("rol_slug") == 'registrador') {
                        # Registrador
                        //Quitando la relacion usuario casa de campaña
                        if (\DB::table('rel_usuario_campana')
                        ->where('id_usuario', $usuario->id)
                        ->delete()) {}
                        //Agregando la relacion usuario casa de campaña
                        $usuario_casa_campana = new UsuarioCasaCampana();
                        $usuario_casa_campana->id_usuario = $usuario->id;
                        $usuario_casa_campana->id_casa_campana = $request->input("id_casa_campana");
                        $usuario_casa_campana->activo = 1;
                        
                        if ($usuario_casa_campana->save()) {
                            $persona->id_recinto = $request->input("recinto");
                        }
    
                    }elseif ($request->input("rol_slug") == 'conductor') {
                        # Call center
                        //Revocando relacion usuario transporte
                        if (\DB::table('rel_usuario_transporte')
                        ->where('id_usuario', $usuario->id)
                        ->delete()) {}

                        // Agregando relacion usuario transporte
                        $usuario_transporte = new UsuarioTransporte();
                        $usuario_transporte->id_usuario = $usuario->id;
                        $usuario_transporte->id_transporte = $request->input("id_vehiculo");
                        $usuario_transporte->activo = 1;
                        if ($usuario_transporte->save()) {
                            return view("mensajes.msj_enviado")->with("msj","enviado_editar_persona");
                        }
    
                    }elseif ($request->input("rol_slug") == 'responsable_mesa') {
                        if (UsuarioMesa::where('id_usuario', $usuario->id)->delete()){}
                        # ResponsableMesa
                        foreach ($request->mesas as $value) {
                            $usuario_mesa = new UsuarioMesa;
                            $usuario_mesa->id_usuario = $usuario->id;
                            $usuario_mesa->id_mesa = $value;
                            $usuario_mesa->activo = 1;
                            $usuario_mesa->save();
                        }
                        $persona->id_recinto = $request->input("recinto");
                    }


                    if($persona->save())
                    {
                        return view("mensajes.msj_enviado")->with("msj","enviado_editar_persona");
                    }else{
                        return "failed";
                    }

                }
                
            }

        }
        else{
            return "recinto";
        }
    }

    
    public function editar_evidencia_persona(Request $request){

        // return $request->input("id_persona");
            
        $id_persona = $request->input("id_persona");
        $persona = Persona::find($id_persona);
    
        //Primero validamos el archivo
        $reglas=[ 
            'archivo'  => 'mimes:jpg,jpeg,gif,png,bmp | max:2048000'
            ];
            
        $mensajes=[
        'archivo.mimes' => 'El archivo debe ser un archivo con formato: jpg, jpeg, gif, png, bmp.',
        'archivo.max' => 'El archivo Supera el tamaño máximo permitido',
        ];

        $validator = Validator::make( $request->all(),$reglas,$mensajes );
        if( $validator->fails() ){ 

          return view("formularios.form_votar_presidencial_subir_imagen")
          ->with("persona",$persona)
          ->withErrors($validator)
          ->withInput($request->flash());
        }
    
        
        //Subimos el archivo
        if($request->file('archivo') != ""){
            $tiempo_actual = new DateTime(date('Y-m-d H:i:s'));
            $archivo = $request->file('archivo');
            $mime = $archivo->getMimeType();
            $extension=strtolower($archivo->getClientOriginalExtension());

            $nuevo_nombre="R-".$persona->id_recinto."-CI-".$persona->cedula_identidad."-".$tiempo_actual->getTimestamp();

            $file = $request->file('archivo');

            $image = Image::make($file->getRealPath());
            
            //reducimos la calidad y cambiamos la dimensiones de la nueva instancia.
            $image->resize(1280, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
            });
            $image->orientate();

            $rutadelaimagen="../storage/media/evidencias/".$nuevo_nombre;

            if ($image->save($rutadelaimagen)){


            //Redirigimos a la vista f

            $persona->archivo_evidencia=$rutadelaimagen;
            $persona->save();

            }
            else{
                return view("mensajes.msj_error")->with("msj","Ocurrio un error al subir la imagen");
            }
        }
        else{
            return $request->file('archivo');
        }
      }

    public function form_baja_persona($id_persona){
        if(\Auth::user()->isRole('admin')==false){
            return view("mensajes.mensaje_error")->with("msj",'<div class="box box-danger col-xs-12"><div class="rechazado" style="margin-top:70px; text-align: center">    <span class="label label-success">#!<i class="fa fa-check"></i></span><br/>  <label style="color:#177F6B">  Acceso restringido </label>   </div></div> ') ;
        }
        //carga el formulario para agregar un nueva persona

        $persona = Persona::find($id_persona);

        return view("formularios.form_baja_persona")
        ->with('persona', $persona);
    }

    public function baja_persona(Request $request){
        if(\Auth::user()->isRole('admin')==false){
            return view("mensajes.mensaje_error")->with("msj",'<div class="box box-danger col-xs-12"><div class="rechazado" style="margin-top:70px; text-align: center">    <span class="label label-success">#!<i class="fa fa-check"></i></span><br/>  <label style="color:#177F6B">  Acceso restringido </label>   </div></div> ') ;
        }
        $id_persona = $request->input("id_persona");
        $persona = Persona::find($id_persona);
        $persona->activo = 0;

        if ($persona->save()) {
            return "ok";
        } else {
            return "failed";
        }
    }

    public function listado_personas_asignacion(){
        if(\Auth::user()->isRole('super_admin')==false){
            return view("mensajes.mensaje_error")->with("msj",'<div class="box box-danger col-xs-12"><div class="rechazado" style="margin-top:70px; text-align: center">    <span class="label label-success">#!<i class="fa fa-check"></i></span><br/>  <label style="color:#177F6B">  Acceso restringido </label>   </div></div> ') ;
        }
        $personas = [];
        return view("listados.listado_personas_asignacion")
        ->with('personas', $personas);
    }
    
    // public function buscar_persona_asignacion(Request $request){
    //     $dato = $request->input("dato_buscado");
    //     $personas = Persona::join('recintos', 'personas.id_recinto', 'recintos.id_recinto')
    //     ->leftjoin('users', 'personas.id_persona', 'users.id_persona')
    //     ->join('origen', 'personas.id_origen', 'origen.id_origen')
    //     ->leftjoin('sub_origen', 'personas.id_sub_origen', 'sub_origen.id_sub_origen')
    //     ->leftjoin('roles', 'personas.id_rol', 'roles.id')
    //     ->where("personas.nombre","like","%".$dato."%")
    //     ->orwhere("paterno","like","%".$dato."%")
    //     ->orwhere("materno","like","%".$dato."%")
    //     ->orwhere("cedula_identidad","like","%".$dato."%")
    //     ->orwhere("roles.slug","like","%".$dato."%")
    //     ->select('personas.*', 'recintos.id_recinto', 'recintos.nombre as nombre_recinto', 'recintos.circunscripcion', 'recintos.distrito',
    //     'recintos.zona', 'recintos.direccion as direccion_recinto',
    //     'origen.origen', 'sub_origen.nombre as sub_origen',
    //     'roles.name as nombre_rol',
    //     'users.activo as usuario_activo', 'users.name as codigo_usuario'
    //     )
    //     ->orderBy('id_persona', 'desc')
    //     // ->paginate(30);
    //     // return view('listados.listado_personas_asignacion')->with("personas",$personas);
    //     ->get();
    //     return $personas;
    // }

    public function buscar_persona_asignacion(){
        if(\Auth::user()->isRole('admin')==false){
            return view("mensajes.mensaje_error")->with("msj",'<div class="box box-danger col-xs-12"><div class="rechazado" style="margin-top:70px; text-align: center">    <span class="label label-success">#!<i class="fa fa-check"></i></span><br/>  <label style="color:#177F6B">  Acceso restringido </label>   </div></div> ') ;
        }
        return Datatables::of(Persona::join('recintos', 'personas.id_recinto', 'recintos.id_recinto')
        ->leftjoin('users', 'personas.id_persona', 'users.id_persona')
        ->join('origen', 'personas.id_origen', 'origen.id_origen')
        ->leftjoin('sub_origen', 'personas.id_sub_origen', 'sub_origen.id_sub_origen')
        ->leftjoin('roles', 'personas.id_rol', 'roles.id')
        ->select('personas.*', 'recintos.id_recinto', 'recintos.nombre as nombre_recinto', 'recintos.circunscripcion', 'recintos.distrito',
        'recintos.zona', 'recintos.direccion as direccion_recinto',
        'origen.origen', 'sub_origen.nombre as sub_origen',
        'roles.name as nombre_rol',
        'users.activo as usuario_activo', 'users.name as codigo_usuario'
        )
        ->get())->make(true);
    }

    public function listado_personas(){
        // if(\Auth::user()->isRole('registrador')==false && \Auth::user()->isRole('admin')==false && \Auth::user()->isRole('responsable_circunscripcion')==false){
        //     return view("mensajes.mensaje_error")->with("msj",'<div class="box box-danger col-xs-12"><div class="rechazado" style="margin-top:70px; text-align: center">    <span class="label label-success">#!<i class="fa fa-check"></i></span><br/>  <label style="color:#177F6B">  Acceso restringido </label>   </div></div> ') ;
        // }
        // dd(\Auth::user()->getRoles());
        // dd(\Auth::user()->isRole('super_admin'));

        $personas = [];

        if(\Auth::user()->isRole('super_admin')){
            $personas = Persona::with('usuario')
            ->with('usuario.roles')
            ->where('activo', 1)
            ->get();
        }

        if(\Auth::user()->isRole('medico')){
            $personas = Persona::with('usuario')
            ->with('usuario.roles')
            ->where('id_medico', \Auth::user()->id_persona)
            ->get();
        }

        if(\Auth::user()->isRole('paciente')){
            $personas = Persona::with('usuario')
            ->with('usuario.roles')
            ->where('id_persona', \Auth::user()->id_persona)
            ->get();
        }






        // dd($personas);
        return view("listados.listado_personas")
        ->with('personas', $personas);
    }
    
    // public function buscar_persona(Request $request){
    //     $dato = $request->input("dato_buscado");
    //     $personas = Persona::join('recintos', 'personas.id_recinto', 'recintos.id_recinto')
    //     ->join('origen', 'personas.id_origen', 'origen.id_origen')
    //     ->leftjoin('sub_origen', 'personas.id_sub_origen', 'sub_origen.id_sub_origen')
    //     ->leftjoin('roles', 'personas.id_rol', 'roles.id')
    //     ->where("personas.nombre","like","%".$dato."%")
    //     ->orwhere("paterno","like","%".$dato."%")
    //     ->orwhere("materno","like","%".$dato."%")
    //     ->orwhere("cedula_identidad","like","%".$dato."%")
    //     ->select('personas.*', 'recintos.id_recinto', 'recintos.nombre as nombre_recinto', 'recintos.circunscripcion', 'recintos.distrito',
    //     'recintos.zona', 'recintos.direccion as direccion_recinto',
    //     'origen.origen', 'sub_origen.nombre as sub_origen',
    //     'roles.name as nombre_rol'
    //     )
    //     ->orderBy('fecha_registro', 'desc')
    //     ->orderBy('id_persona', 'desc')
    //     ->paginate(100);
    //     return view('listados.listado_personas')->with("personas",$personas);
    // }

    public function buscar_persona(){
        // return Datatables::of(Persona::join('recintos', 'personas.id_recinto', 'recintos.id_recinto')
        // ->join('origen', 'personas.id_origen', 'origen.id_origen')
        // ->leftjoin('sub_origen', 'personas.id_sub_origen', 'sub_origen.id_sub_origen')
        // ->leftjoin('roles', 'personas.id_rol', 'roles.id')
        // ->leftjoin('tipo_evidencias', 'personas.evidencia', 'tipo_evidencias.id')
        // ->select('personas.*', 'recintos.id_recinto', 'recintos.nombre as nombre_recinto', 'recintos.circunscripcion', 'recintos.distrito', 'recintos.distrito_referencial',
        // 'recintos.zona', 'recintos.direccion as direccion_recinto',
        // 'origen.origen', 'sub_origen.nombre as sub_origen',
        // 'roles.name as nombre_rol', 'roles.description',
        // 'tipo_evidencias.nombre as nombre_evidencia',
        // \DB::raw('CONCAT(personas.telefono_celular," - ", personas.telefono_referencia) as contacto'),
        // \DB::raw('CONCAT(personas.paterno," ",personas.materno," ",personas.nombre) as nombre_completo'),
        // \DB::raw('CONCAT(personas.telefono_celular," - ", personas.telefono_referencia) as contacto'),
        // \DB::raw('CONCAT(personas.cedula_identidad," - ", personas.complemento_cedula) as ci')
        // )
        // ->get())->make(true);

        return Datatables::of(Persona::with('usuario')
        ->with('usuario.roles')->get())->make(true);

    }

    public function ConsultaSubOrigen($id_origen){
        $sub_origenes = \DB::table('sub_origen')
        ->where('id_origen', $id_origen)
        ->where('activo', 1)
        // ->distinct()
        ->orderBy('nombre')
        ->get();
        return $sub_origenes;
    }

    public function consultaUsuarioRegistrado($cedula){
        // if(\Auth::user()->isRole('registrador')==false && \Auth::user()->isRole('admin')==false && \Auth::user()->isRole('responsable_circunscripcion')==false){
        //     return view("mensajes.mensaje_error")->with("msj",'<div class="box box-danger col-xs-12"><div class="rechazado" style="margin-top:70px; text-align: center">    <span class="label label-success">#!<i class="fa fa-check"></i></span><br/>  <label style="color:#177F6B">  Acceso restringido </label>   </div></div> ') ;
        // }
        $personas = \DB::table('personas')
        ->join('recintos', 'personas.id_recinto', 'recintos.id_recinto')
        ->join('origen', 'personas.id_origen', 'origen.id_origen')
        ->leftjoin('sub_origen', 'personas.id_sub_origen', 'sub_origen.id_sub_origen')
        ->leftjoin('roles', 'personas.id_rol', 'roles.id')
        ->select('personas.*', 'recintos.id_recinto', 'recintos.nombre as nombre_recinto', 'recintos.circunscripcion', 'recintos.distrito',
                 'recintos.zona', 'recintos.direccion as direccion_recinto',
                 'origen.origen', 'sub_origen.nombre as sub_origen',
                 'roles.name as nombre_rol', 'roles.description',
                 \DB::raw('CONCAT(personas.paterno," ",personas.materno," ",personas.nombre) as nombre_completo'),
                 \DB::raw('CONCAT(personas.telefono_celular," - ", personas.telefono_referencia) as contacto'),
                 \DB::raw('CONCAT(personas.cedula_identidad," - ", personas.complemento_cedula) as ci'),
                 \DB::raw('CONCAT("C: ", recintos.circunscripcion," - Dist. Municipal: ", recintos.distrito," - Dist. OEP: ", recintos.distrito_referencial," - R: ", recintos.nombre) as recinto')
        )
        ->where('cedula_identidad', $cedula)
        ->orderBy('fecha_registro', 'desc')
        ->orderBy('id_persona', 'desc')
        ->get();

        return $personas;
    }

    public function ObtieneUsuario($id_persona){
        $persona = Persona::find($id_persona);
    
        $ci = $persona->cedula_identidad.$persona->complemento_cedula;
        $numero = 0;
        $username = $ci;
        while (User::where('name', '=', $username)->exists()) { // user found 
            $username=$username+$numero;
            $numero++;
        }
    
        //Quitar espacios en blanco
        $username = str_replace(' ', '', $username); 
        return $username;
    }
}
