<a href="{{route('form_editar_persona', ['id' => $persona[0]->id_persona])}}" class="small-box-footer">
    @if($persona[0]->usuario->roles[0]->slug == 'medico' || $persona[0]->usuario->roles[0]->slug == 'super_admin')
    <div class="col-md-12 col-lg-12 col-xs-12">
    @else
    <div class="col-md-12 col-lg-6 col-xs-12">
    @endif
        <!-- small box -->
        <div class="small-box bg-primary">
        <div class="inner">
            <h2><b>Datos Personales</b></h2>
            <br>
            {{-- <p>User Registrations</p> --}}
        </div>
        <div class="icon">
            <i class="fa fa-user"></i>
        </div>
        <br>
        {{-- href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i> --}}
        </div>
    </div>
</a>