<a href="{{route('antecedentes_persona', ['id' => $persona[0]->id_persona])}}" class="small-box-footer">
    <div class="col-md-12 col-lg-6 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-aqua">
        <div class="inner">
            <h2><b>Antecedentes</b></h2>
            <br>
        </div>
        <div class="icon">
            <i class="fa fa-ambulance"></i>
        </div>
        <br>
        </div>
    </div>
</a>
</div>
<div class="row">
<a href="{{route('enfermedades_persona', ['id' => $persona[0]->id_persona])}}" class="small-box-footer">
    <div class="col-md-12 col-lg-6 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-red">
        <div class="inner">
            <h2><b>Falencias</b></h2>
            <br>
            {{-- <p>User Registrations</p> --}}
        </div>
        <div class="icon">
            <i class="fa fa-heartbeat"></i>
        </div>
        <br>
        </div>
    </div>
</a>
<a href="{{route('alergias_persona', ['id' => $persona[0]->id_persona])}}" class="small-box-footer">
    <div class="col-md-12 col-lg-6 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-yellow">
        <div class="inner">
            <h2><b>Alergias</b></h2>
            <br>
        </div>
        <div class="icon">
            <i class="fa fa-medkit"></i>
        </div>
        <br>
        </div>
    </div>
</a>
</div>

<div class="row">
<a href="{{route('familiares_persona', ['id' => $persona[0]->id_persona])}}" class="small-box-footer">
    <div class="col-md-12 col-lg-6 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-green">
        <div class="inner">
            <h2><b>Familiares</b></h2>
            <br>
        </div>
        <div class="icon">
            <i class="fa fa-users"></i>
        </div>
        <br>
        </div>
    </div>
</a>
<a href="{{route('recetas_persona', ['id' => $persona[0]->id_persona])}}" class="small-box-footer">
    <div class="col-md-12 col-lg-6 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-purple">
        <div class="inner">
            <h2><b>Recetas</b></h2>
            <br>
        </div>
        <div class="icon">
            <i class="fa fa-list-alt"></i>
        </div>
        <br>
        </div>
    </div>
</a>
</div>

<div class="row">
<a href="{{route('experto', ['id' => $persona[0]->id_persona])}}" class="small-box-footer">
    <div class="col-md-12 col-lg-12 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-maroon">
        <div class="inner">
            <h2><b>Sistema Experto</b></h2>
            <br>
        </div>
        <div class="icon">
            <i class="fa fa-desktop"></i>
        </div>
        <br>
        </div>
    </div>
</a>
</div>