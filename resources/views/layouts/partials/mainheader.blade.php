<!-- Main Header -->
<header class="main-header">
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        {{-- <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ trans('adminlte_lang::message.togglenav') }}</span>

        </a> --}}
<div class="container">

    <div class="navbar-header">
        <a href="{{ url('home_encuestas') }}" class="navbar-brand"><i class="fa fa-wpforms"></i> <b>Encuestas</b></a>
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
          <i class="fa fa-bars"></i>
        </button>
      </div>
    <!-- Logo -->

        @include('layouts.partials.navbar_top')

        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <!-- Menu toggle button -->
                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">1</span>
                    </a>--}}
                    <ul class="dropdown-menu">
                        {{-- <li class="header">{{ trans('adminlte_lang::message.tabmessages') }}</li> --}}
                        <li class="header">Mensajes</li>
                        <li>
                            <!-- inner menu: contains the messages -->
                            <ul class="menu">
                                <li><!-- start message -->
                                    {{-- <a href="#"> --}}
                                        <div class="pull-left">
                                            <!-- User Image -->
                                            {{-- <img src="/img/user2-160x160.jpg" class="img-circle" alt="User Image"/> --}}
                                        </div>
                                        <!-- Message title and timestamp -->
                                        <h3 style="background-color:#31a65a; text-align:center; color:white" id="clock"></h3>
                                        {{-- <h4>
                                            Faltan
                                            <H3><i class="fa fa-clock-o"></i> 5 mins</H3>
                                        </h4> --}}
                                        <!-- The message -->
                                        {{-- <p>{{ trans('adminlte_lang::message.awesometheme') }}</p> --}}
                                    {{-- </a> --}}
                                </li><!-- end message -->
                            </ul><!-- /.menu -->
                        </li>
                        {{-- <li class="footer"><a href="#">c</a></li> --}}
                    </ul>
                </li>
                <!-- /.messages-menu -->


                <!-- Tasks Menu -->
                {{-- <li class="dropdown tasks-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag-o"></i>
                        <span class="label label-danger">9</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">{{ trans('adminlte_lang::message.tasks') }}</li>
                        <li>
                            <!-- Inner menu: contains the tasks -->
                            <ul class="menu">
                                <li><!-- Task item -->
                                    <a href="#">
                                        <!-- Task title and progress text -->
                                        <h3>
                                            {{ trans('adminlte_lang::message.tasks') }}
                                            <small class="pull-right">20%</small>
                                        </h3>
                                        <!-- The progress bar -->
                                        <div class="progress xs">
                                            <!-- Change the css width attribute to simulate progress -->
                                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">20% {{ trans('adminlte_lang::message.complete') }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </li><!-- end task item -->
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#">{{ trans('adminlte_lang::message.alltasks') }}</a>
                        </li>
                    </ul>
                </li> --}}
                @if (Auth::guest())
                    <li><a href="{{ url('/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li>
                    <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                @else
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                          <a href="{{ url('/logout') }}"
                                   onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                            <!-- The user image in the navbar-->
                            <img src="{{asset('/img/on_off.png')}}" class="user-image" alt="User Image"/>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            {{-- <span class="hidden-xs">{{ Auth::user()->name }}</span> --}}
                            <label class="text-black "> Salir</label>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                {{-- @foreach ($personas as $persona)
                                @if ( $persona->ci == Auth::user()->ci)
                                            <!-- Status -->
                                    <p> {{ $persona->unidad }}</p>
                                        @endif
                                @endforeach --}}
                                <p>
                                    {{ Auth::user()->name }}
                                    <small><script>
                                        var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                                        var f=new Date();
                                        document.write(f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
                                    </script></small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            {{-- <li class="user-body">
                                <div class="col-xs-4 text-center">
                                    <a href="#">{{ trans('adminlte_lang::message.followers') }}</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">{{ trans('adminlte_lang::message.sales') }}</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">{{ trans('adminlte_lang::message.friends') }}</a>
                                </div>
                            </li> --}}
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                {{-- <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">{{ trans('adminlte_lang::message.profile') }}</a>
                                </div> --}}
                                <div class="">

                                   <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();"  class="btn btn-primary btn-flat btn-block"  >
                                            <label class="text-black "><i class="fa fa-power-off text-black"></i> Salir</label>
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>


                                </div>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- Control Sidebar Toggle Button -->
                {{-- <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li> --}}
            </ul>
        </div>
    </div>
    </nav>
</header>
