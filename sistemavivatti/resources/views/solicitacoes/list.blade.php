@extends('app')

@section('content')
  <!-- page content -->
  <div class="right_col" role="main" id="app">
    <div class="col-md-3">
      <div class="page-title">
        <div class="title_left">
          <h3>Solicitação</h3>
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
            {{-- incluindo POST --}}
            {!! Form::open(['url' => 'solicitacao/novo', 'class' => 'form-horizontal form-label-left']) !!}

            <div class="form-group">
              {!! Form::label('tipo', 'Tipo:',['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
              {!! Form::select('tipo',['1' => 'Outros', '2' => 'Reclamações', '3' => 'Problemas'], null, ['class'=>'form-control col-md-12 ','autofocus']) !!}
            </div>

            <div class="form-group">
              {!! Form::label('prioridade', 'Prioridade:',['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
              {!! Form::select('prioridade',['0' => 'Normal', '1' => 'Média', '2' => 'Alta'], null, ['class'=>'form-control col-md-12 ','autofocus']) !!}
            </div>

            <div class="form-group">
              {!! Form::label('anonimo', 'Anônimo:',['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
              {!! Form::select('anonimo',['0' => 'Não', '1' => 'Sim'], null, ['class'=>'form-control col-md-12 ','autofocus']) !!}
            </div>

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

      </div>
    </div>
  </div>

  <div class="col-md-9">
    <div class="page-title">
      <div class="title_left">
        <h3>Mural de Solicitações</h3>
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
                      @forelse($solicitacoes as $solicitacao)
                        <li>
                          <div class="block">
                            <div class="block_content">
                              <h2 class="title">
                                {{$solicitacao->titulo}}({{$solicitacao->tipo}})
                                <div class="pull-right">
                                  @if($solicitacao->prioridade == 0)
                                    <button type="button" class="btn btn-info btn-xs">Normal</button>
                                  @elseif($solicitacao->prioridade == 1)
                                    <button type="button" class="btn btn-warning btn-xs">Média</button>
                                  @else
                                    <button type="button" class="btn btn-danger btn-xs">Alta</button>
                                  @endif

                                  @if(!$solicitacao->finalizado_em)
                                    <a @click.prevent="finalizar('{{$solicitacao->id}}')" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Está em Aberto clique para Finalizar">Finalizar</a>
                                  @else
                                    <button type="button" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Encerrado em {{$solicitacao->finalizado_em}}">Finalizado</button>
                                  @endif

                                  @if( auth()->user()->permissao == 'a' || auth()->user()->permissao == 's' || auth()->user()->id == $solicitacao->usuario->id )
                                    <a class="btn btn-xs btn-default" @click.prevent="excluir('{{$solicitacao->id}}')" href="#"  data-toggle="confirmation" data-placement="bottom" data-original-title="" title="Excluir">
                                      <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Excluir"></i>
                                    </a>
                                  @endif
                                </div>

                              </h2>
                              <div class="byline">
                                {{$solicitacao->usuario->id != auth()->user()->id }}
                                <span>{{$solicitacao->criado_em}}</span> por
                                <a>
                                  @if($solicitacao->usuario->id == auth()->user()->id )
                                    Mim
                                  @elseif($solicitacao->anonimo)
                                    Anônimo
                                  @else
                                    {{$solicitacao->usuario->dados_pessoais->nome}}
                                  @endif
                                </a>
                              </div>
                              <p class="excerpt">{{$solicitacao->descricao}}
                              </p>
                            </div>
                          </div>
                        </li>
                      @empty
                        <h3>Não há solicitações com esses parametros</h3>
                      @endforelse
                    </ul>
                  </div>
                </div>
              </div>

              <span class="pull-right"> {{ $solicitacoes->links() }} </span>
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
      finalizar:function(solicitacao_id){
        swal({
          title: "A solicitação foi atendida?",
          text: "Gostaria de alterar para encerrado essa solicitação ?",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Sim, pode alterar!",
          cancelButtonText: "Cancelar",
          closeOnConfirm: false
        },function(){
          window.location.href =  "/solicitacao/"+solicitacao_id+"/finalizar";
        });
      },
      excluir:function(solicitacao_id){
        swal({
          title: "Tem certeza?",
          text: "Este solicitacao será permanentemente excluido, deseja prosseguir?",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Sim, pode excluir!",
          cancelButtonText: "Cancelar",
          closeOnConfirm: false
        },function(){
          window.location.href =  "/solicitacao/"+solicitacao_id+"/excluir";
        });
      }
    }

  });
  </script>
@endpush
