<div class="col-md-12">
    <div class="form-group">
        <label >Nombre</label>
        <input type="input" name="nombre" placeholder="" class="form-control" value="{{ old('nombre', $data->nombre ?? '') }}"/>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label >Apellido Paterno</label>
        <input type="input" name="paterno" placeholder="" class="form-control" value="{{ old('paterno', $data->paterno ?? '') }}" />
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label >Apellido Materno</label>
        <input type="input" name="materno" placeholder="" class="form-control" value="{{ old('materno', $data->materno ?? '') }}" />
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label >Carnet</label>
        <input type="input" name="cedula_identidad" id="input_cedula" placeholder="" class="form-control" value="{{ old('cedula_identidad', $data->cedula_identidad ?? '') }}" pattern="[0-9]{6,9}"/>
    </div>
</div>
{{-- <div class="col-md-4">
    <div class="form-group">
        <label >Complemento SEGIP</label>
        <input type="input" name="complemento" placeholder="" class="form-control" value="{{ old('complemento') }}" />
    </div>
</div> --}}
<div class="col-md-12">
    <div class="form-group">
        <label >Celular</label>
        <input type="input" name="telefono_celular" placeholder="" class="form-control" value="{{ old('telefono_celular', $data->telefono_celular ?? '') }}" pattern="[0-9]{6,9}"/>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label class="text-black">Rol</label>
        <div class="form-group bg-gray">
            @role('paciente')
            <select  class="form-control" name="rol" id="rol_slug" readonly>
                <option value={{$rol->id}}>{{$rol->description}}</option>
            </select>
            @endrole
            @role('medico')
            <select  class="form-control" name="rol" id="rol_slug" readonly>
                <option value={{$rol->id}}>{{$rol->description}}</option>
            </select>
        </select>
            @endrole
            @role('super_admin')
            <select  class="form-control" name="rol" id="rol_slug">
                @if(!isset($data) && !old('rol'))
                    <option value="" selected> --- SELECCIONE UN ROL --- </option>
                    @foreach ($roles as $rol)
                        <option value={{$rol->id}}>{{$rol->description}}</option>                                                
                    @endforeach
                @else
                    @if (isset($data))
                        <option value=""> --- SELECCIONE UN ROL --- </option>
                        @foreach ($roles as $rol)
                        <option value="{{$rol->id}}" {{ $rol->id == $data->usuario->roles[0]->id ? 'selected' : '' }}>{{$rol->description}}</option>
                        @endforeach
                    @else
                        <option value=""> --- SELECCIONE UN ROL --- </option>
                        @foreach ($roles as $rol)
                        <option value="{{$rol->id}}" {{ old('rol', $rol->id) == $rol->id ? 'selected' : '' }}>{{$rol->description}}</option>
                        @endforeach
                    @endif
                @endif
                
            </select>
            @endrole

        </div>
    </div>
</div>
<div class="col-md-6" id="div_edad">
    <div class="form-group">
        <label >Edad</label>
        @role('paciente')
        <input style='line-height: initial;' type="number" name="edad" id="edad" placeholder="" min="60" max="110" class="form-control" value="{{ old('edad', $data->edad ?? '') }}" required/>
        @endrole
        @role('medico')
        <input style='line-height: initial;' type="number" name="edad" id="edad" placeholder="" min="20" max="110" class="form-control" value="{{ old('edad', $data->edad ?? '') }}" required/>
        @endrole
        @role('super_admin')
        <input style='line-height: initial;' type="number" name="edad" id="edad" placeholder="" min="20" max="110" class="form-control" value="{{ old('edad', $data->edad ?? '') }}" required/>
        @endrole
    </div>
</div>
<div class="col-md-6" id="div_sexo">
    <div class="form-group">
        <label class="text-black">Sexo</label>
        <div class="form-group bg-gray">
            <select class="form-control" name="sexo" id="sexo" required>
                @if(!isset($data) && !old('sexo'))
                    <option value="" selected> --- SELECCIONE SU GENERO --- </option>
                    <option value="MASCULINO">MASCULINO</option>
                    <option value="FEMENINO">FEMENINO</option>
                @else
                    @if (isset($data))
                        <option value=""> --- SELECCIONE SU GENERO --- </option>
                        <option value="MASCULINO" {{ old('sexo', $data->sexo) == 'MASCULINO' ? 'selected' : '' }}>MASCULINO</option>
                        <option value="FEMENINO" {{ old('sexo', $data->sexo) == 'FEMENINO' ? 'selected' : '' }}>FEMENINO</option>
                    @else
                        <option value=""> --- SELECCIONE SU GENERO --- </option>
                        <option value="MASCULINO" {{ old('sexo') == 'MASCULINO' ? 'selected' : '' }}>MASCULINO</option>
                        <option value="FEMENINO" {{ old('sexo') == 'FEMENINO' ? 'selected' : '' }}>FEMENINO</option>
                    @endif
required
                @endif

            </select>
        </div>
    </div>
</div>


<div class="col-md-12" id="div_institucion">
    <div class="form-group">
        <label >Institucion</label>
        <input type="input" name="institucion" id="institucion" placeholder="" class="form-control" value="{{ old('institucion') }}"/>
    </div>
</div>
<div class="col-md-12" id="div_especialidad">
    <div class="form-group">
        <label >Especialidad</label>
        <input type="input" name="especialidad" id="especialidad" placeholder="" class="form-control" value="{{ old('especialidad') }}"/>
    </div>
</div>

<div class="col-md-12" id="div_medico">
    <div class="form-group">
        <label class="text-black">Médico de Cabecera</label>
        <div class="form-group bg-gray">
            <select  class="form-control" name="medico" id="medico">
                @if(!isset($data) && !old('medico'))
                    <option value="" selected> --- SELECCIONE UN MEDICO --- </option>
                    @foreach ($personas as $item)
                        @if ($item->usuario->roles[0]->slug == 'medico')
                            <option value={{$item->id_persona}}>{{ $item->nombre}} {{$item->paterno}} {{$item->materno}}</option>                                                
                        @endif
                    @endforeach
                @else
                    @if (isset($data))
                        <option value=""> --- SELECCIONE UN MEDICO --- </option>
                        @foreach ($personas as $item)
                            @if ($item->usuario->roles[0]->slug == 'medico')
                            <option value="{{$item->id_persona}}" {{ old('medico', $data->id_medico) == $item->id_persona ? 'selected' : '' }}>{{ $item->nombre}} {{$item->paterno}} {{$item->materno}}</option>
                            @endif
                        @endforeach
                    @else
                        <option value=""> --- SELECCIONE UN MEDICO --- </option>
                        @foreach ($personas as $item)
                            @if ($item->usuario->roles[0]->slug == 'medico')
                            <option value="{{$item->id_persona}}" {{ old('medico') == $item->id_persona ? 'selected' : '' }}>{{ $item->nombre}} {{$item->paterno}} {{$item->materno}}</option>
                            @endif
                        @endforeach
                    @endif
                @endif
            </select>
        </div>
    </div>
</div>



{{-- <div class="col-md-6">
    <div class="form-group">
        <label class="text-black ">Subir </label>
        <input name="archivo" id="archivo" type="file" class="text-white" accept="image/*"/>
    </div>
</div> --}}
<div class="col-md-12">
    <br>
</div>