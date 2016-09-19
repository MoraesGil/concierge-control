@extends('app')

@section('content')
  <!-- page content -->
  <div class="right_col" role="main" id="app">
    <div class="col-md-3">
      <div class="page-title">
        <div class="title_left">
          <h3>Recado</h3>
        </div>

      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Novo</h2>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            {{-- incluindo POST --}}
            {!! Form::open(['url' => 'recado/novo', 'class' => 'form-horizontal form-label-left']) !!}

            <div class="form-group">
              {!! Form::label('titulo', 'Titulo:',['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
              {!! Form::text('titulo', null, ['class'=>'form-control col-md-12 ','autofocus']) !!}
            </div>

            <div class="form-group">
              {!! Form::label('descricao', 'Detalhes:',['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
              {!! Form::textarea('descricao', null, ['class'=>'form-control col-md-12 ']) !!}
            </div>

            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-3">
                <button id="send" type="submit" name="send" class="btn btn-success">Gravar</button>
              </div>
            </div>

            {!! Form::close() !!}
          </div>
        </div>
        @if(Session::has('success_message'))
          <div class="alert alert-success">
            {{Session::get('success_message')}}
          </div>
        @endif

        @if ($errors->any())
          <div class="alert alert-warning">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            @foreach($errors->all() as $error)
              <ul>
                <li>
                  <h4> {{ $error }}</h4>
                </li>
              </ul>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </div>

  <div class="col-md-9">
    <div class="page-title">
      <div class="title_left">
        <h3>Mural de Recados</h3>
      </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Relação</h2>

            <div class="clearfix">
            </div>
          </div>
          <div class="x_content">
            <div class="row">
              <form>
                <div class="col-md-10 col-sm-8 col-xs-6 form-group has-feedback">
                  <input value="{{ isset($_GET['busca']) ? $_GET['busca'] : "" }}" type="text" class="form-control" name="busca" id="busca" placeholder="Buscar">
                  <span class="fa fa-envelope-o form-control-feedback right" aria-hidden="true"></span>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 form-group has-feedback">
                  <button type="submit" name="button" class="btn btn-block btn-default"><i class="fa fa-search"></i> Filtrar</button>
                </div>
              </form>
            </div>

            <div class="row">
              <div class="x_panel">
                <div class="x_content">
                  <div class="dashboard-widget-content">

                    <ul class="list-unstyled timeline widget">
                      @foreach($recados as $recado)
                        <li>
                          <div class="block">
                            <div class="block_content">
                              <h2 class="title">
                                {{$recado->titulo}}
                                @if( auth()->user()->permissao == 'a' || auth()->user()->permissao == 's' || auth()->user()->id == $recado->usuario->id )
                                  <a @click.prevent="excluir('{{$recado->id}}')" href="#" class=" pull-right " data-toggle="confirmation" data-placement="bottom" data-original-title="" title="Excluir">
                                    <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Excluir"></i>
                                  </a>
                                @endif
                              </h2>
                              <div class="byline">
                                <span>{{$recado->criado_em}}</span> por <a>  {{ $recado->usuario->id == auth()->user()->id ? 'Mim' : $recado->usuario->dados_pessoais->nome}}</a>
                              </div>

                              <p class="excerpt">{{$recado->descricao}}
                              </p>
                            </div>
                          </div>
                        </li>
                      @endforeach
                    </ul>
                  </div>
                </div>
              </div>

              <span class="pull-right"> {{ $recados->links() }} </span>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection


@push('script_level')
  <script type="text/javascript">
  var vm = new Vue({
    el: '#app',

    data: {


    },

    ready:function(){

    },

    methods:{
      excluir:function(recado_id){
        swal({
          title: "Tem certeza?",
          text: "Este recado será permanentemente excluido, deseja prosseguir?",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Sim, pode excluir!",
          cancelButtonText: "Cancelar",
          closeOnConfirm: false
        },function(){
          window.location.href =  "/recado/"+recado_id+"/excluir";
        });
      }
    }

  });
  </script>
@endpush
