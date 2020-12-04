@extends('layouts.auth')

@section('content')

<body class="mybody">
    <div class="mytop-content" >
        <div class="container" >

            <div class="col-sm-12" style="background-color:#296dc0; height: 60px;">
              {{-- <a class="mybtn-social pull-right" href="{{ url('/login') }}">
                  Login
              </a> --}}

              <a class="mybtn-social pull-right" href="{{ url('/register') }}">
                  Registro
              </a>

            </div>

            <div class="row">
              <div class="col-sm-6 col-sm-offset-3 myform-cont" >
                    <div class="myform-top-login">
                      <br>
                      <img  src="{{ url('img/avatar.png') }} " class="img-responsive myform-img-top-center"/>

                    </div>

            @if (count($errors) > 0)
                 <div class="col-sm-12" >
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> Error de Accesso
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                </div>
                @endif
                    <div class="myform-bottom-login">
                      <br>
                      <form role="form" action="{{ url('/login') }}" method="post" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <input type="text" name="email" value="{{ old('email') }}" placeholder="Nombre" class="form-control" id="form-username">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" placeholder="Clave" class="form-control" id="form-password">
                        </div>

                        {{-- <div class="form-group">
                          {!! Recaptcha::render() !!}
                        </div> --}}

                        <button type="submit" class="mybtn">Ingresar</button>
                      </form>

                    </div>
              </div>
            </div>
        </div>
      </div>

    <!-- Enlazamos el js de Bootstrap, y otros plugins que usemos siempre al final antes de cerrar el body -->
    <script src="{{ url('js/bootstrap.min.js') }}"></script>
  </body>

@endsection
