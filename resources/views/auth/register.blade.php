 @extends('layouts.auth')
  
@section('content')

  <body class="mybody">      
    <div class="mytop-content" >
        <div class="container" > 
          
                <div class="col-sm-12" style="background-color:#296dc0; height: 60px;">
                   {{-- <a class="mybtn-social pull-right" href="{{ url('/register') }}">
                       Register
                  </a> --}}

                  <a class="mybtn-social pull-right" href="{{ url('/login') }}">
                       Login
                  </a>
               
                </div>
            
                <div class="row">
                  <div class="col-sm-6 col-sm-offset-3 myform-cont" >
                        <div class="myform-top-login">
                          <br>
                          <img  src="{{ url('img/avatar.png') }} " class="img-responsive myform-img-top-center"/>

                  <div class="col-md-12" >
                    @if (count($errors) > 0)
                     
                        <div class="alert alert-danger">
                            <strong>UPPS!</strong> Error al Registrar<br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    
                    @endif
                   </div  >

                    <div class="myform-bottom-login">
                      
                        <form action="{{ url('agregar_persona') }}"  method="post" id="f_enviar_agregar_persona" class="" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            @include('formularios.persona.form_agregar')

                        <button type="submit" class="mybtn">Registrarme</button>
                      </form>
                    
                    </div>
              </div>
            </div>
        </div>
      </div>
 
 </body>
@endsection
@section('scripts')
    @include('layouts.partials.scripts')
@show

@include('formularios.persona.scripts')

