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
        $persona->telefono_celular=$request->input("telefono_celular");
        $persona->edad=$request->input("edad");
        $persona->sexo=$request->input("sexo");
        $persona->especialidad=$request->input("especialidad");
        $persona->institucion=$request->input("institucion");
        $persona->id_medico=$request->input("medico");
        $persona->foto=$foto;
        $persona->activo=1;

        if($persona->save()){
            $id = 0;
            $username = $this->ObtieneUsuario($id, $request->input("nombre"), $request->input("paterno"), $request->input("materno"));
            $usuario=new User;
            $usuario->name=$username;
        
            $usuario->email = $request->input("cedula_identidad");
            $usuario->password= bcrypt($request->input("cedula_identidad"));
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
        // dd($personas);

        if (Auth::guest()) {
            $roles = \DB::table('roles')
            ->where('id', '>', 1)
            ->get();
        } else {
            $roles = \DB::table('roles')->get();
        }
        $rol = $data->usuario->roles[0];

        // dd($rol);

        return view("formularios.form_editar_persona")
        ->with('personas', $personas)
        ->with('roles', $roles)
        ->with('data', $data)
        ->with('rol', $rol);
    }

    public function editar_persona(ValidacionPersona $request, $id){
        
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
        $persona->telefono_celular=$request->input("telefono_celular");
        $persona->edad=$request->input("edad");
        $persona->sexo=$request->input("sexo");
        $persona->especialidad=$request->input("especialidad");
        $persona->institucion=$request->input("institucion");
        $persona->id_medico=$request->input("medico");
        $persona->foto=$foto;
        $persona->activo=1;

        if($persona->save()){
            $usuario= User::findOrFail($persona->usuario->id);
            if($usuario->name != $this->ObtieneUsuario($usuario->id, $request->input("nombre"), $request->input("paterno"), $request->input("materno"))){
                $username = $this->ObtieneUsuario($usuario->id, $request->input("nombre"), $request->input("paterno"), $request->input("materno"));
                $usuario->name=$username;
            }

            if($usuario->email != $request->input("cedula_identidad")){

                $usuario->email = $request->input("cedula_identidad");
                $usuario->password= bcrypt($request->input("cedula_identidad"));
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
                return redirect()->route('opciones_persona', ['id' => $persona->id_persona]);
            }else{
                return view("mensajes.mensaje_error")->with("msj","...Hubo un error al agregar ;...") ;
            }

        }else{
            return view("mensajes.mensaje_error")->with("msj","...Hubo un error al agregar ;...") ;
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

    public function listado_personas(){

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

        return view("listados.listado_personas")
        ->with('personas', $personas);
    }

    public function ObtieneUsuario ($id, $nombre, $paterno, $materno)
    {
        $nombre = ltrim($nombre);
        $paterno = ltrim($paterno);
        $materno = ltrim($materno);
    
        $primer_nombre = explode(" ", $nombre);
    
        if($paterno == ""){
            $apellido = $materno;
        }else{
            $apellido = $paterno;
        }
    
        $numero = 0;
        $Nick = strtolower($primer_nombre[0]." ".$apellido);
        
        while (User::where('name', '=', $Nick)->where('id', '!=', $id)->exists()){ // nombre de usuario encontrado 
            $Nick=$Nick.$numero;
            $numero++;
        }
        return $Nick;
    }
}
