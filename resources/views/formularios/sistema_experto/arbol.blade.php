@extends('layouts.app')

@section('htmlheader_title')
	Diagnóstico
@endsection

@section('main-content')
<section  id="contenido_principal">
<section  id="content">

    <div class="" >
        <div class="container"> 
            <div class="row">

                <!-- /.col -->

                <div class="col-md-12">
                  <!-- Box Comment -->
                  <div class="box box-widget">
                    <div class="box-header with-border">
                      <h3>Sistema Experto</h3>
                      {{-- <div class="user-block">
                        <img class="img-circle" src="{{ url('img/arbol.png') }}" alt="User Image">
                        <span class="username"><a href="#">Jonathan Burke Jr.</a></span>
                        <span class="description">Shared publicly - 7:30 PM Today</span>
                      </div> --}}
                      <!-- /.user-block -->
                      <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                      </div>
                      <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" style="">
                      <img class="img-responsive pad" src="{{ url('img/arbol.png') }}" alt="Arbol">
        
                      {{-- <p>I took this photo this morning. What do you guys think?</p>
                      <button type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> Share</button>
                      <button type="button" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i> Like</button>
                      <span class="pull-right text-muted">127 likes - 3 comments</span> --}}
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer box-comments" style="">

                      <!-- /.box-comment -->
                      <div class="box-comment">
                        <!-- User image -->

                      <!-- /.box-comment -->
                    </div>
                    <!-- /.box-footer -->
                    <div class="box-footer" style="">

                    </div>
                    <!-- /.box-footer -->
                  </div>
                  <!-- /.box -->
                </div>
                <!-- /.col -->
              </div>

        </div>
      </div>
 
</section>

</section>
@endsection

@section('scripts')
	
@parent



@endsection