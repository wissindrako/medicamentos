<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }



     /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        // $this->validate($request, [
        //     $this->username() => 'required', 'password' => 'required', 'g-recaptcha-response' => 'required|recaptcha',
        // ]);
        $this->validate($request, [
            $this->username() => 'required', 'password' => 'required',
        ]);
    }

    public function username()
    {
        $login = request()->input('email');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        request()->merge([$field => $login]);
        return $field;
    }

    public function authenticated($request , $user){
        // @role('super_admin')
        // <a href="{{ url('listado_personas') }}" class="navbar-brand">
        // @endrole
        // @role('medico')
        // <a href="{{ url('listado_personas') }}" class="navbar-brand">
        // @endrole
        // @role('paciente')
        // <a href="{{route('opciones_persona', ['id' => Auth::user()->id_persona])}}" class="navbar-brand">
        // @endrole

        if(\Auth::user()->isRole('super_admin')==true){
            return redirect()->intended('listado_personas');
        }
        if(\Auth::user()->isRole('medico')==true){
            return redirect()->intended('listado_personas');
        }
        if(\Auth::user()->isRole('paciente')==true){
            return redirect()->intended('persona/'.Auth::user()->id_persona.'/opciones');
        }

    }



  




    
}
