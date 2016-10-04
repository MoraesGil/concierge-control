@extends('app')

@section('content')
  <!-- page content -->
  <div class="right_col" role="main" id="app">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Lista de Serviços </h3>
        </div>
      </div>
      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Relação</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li class="list"><a href="{{url('servico/novo')}}">NOVO <i class="fa fa-plus"></i></a></li>
              </ul>
              <div class="clearfix">
              </div>
            </div>
            <div class="x_content">
              <div class="row">
                <form>
                  <div class="col-md-10 col-sm-8 col-xs-6 form-group has-feedback">
                    <input value="{{ isset($_GET['busca']) ? $_GET['busca'] : "" }}" type="text" class="form-control" name="busca" id="busca" placeholder="Buscar">
                    <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                  </div>
                  <div class="col-md-2 col-sm-4 col-xs-6 form-group has-feedback">
                    <button type="submit" name="button" class="btn btn-block btn-default"><i class="fa fa-search"></i> Filtrar</button>
                  </div>
                </form>
              </div>

              <div class="row">
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

                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Cod</th>
                      <th>Nome</th>
                      <th class="text-center"> Qtd. Prestadores </th>
                      @if( auth()->user()->permissao == 'a' || auth()->user()->permissao == 's')
                        <th class="text-center"> Opções </th>
                      @endif

                    </tr>
                  </thead>
                  <tbody>
                    @foreach($servicos as  $servico)
                      <tr>
                        <td>{{$servico->id}}</td>
                        <td>{{$servico->nome}}</td>
                        <td class="text-center">
                          @if($servico->fornecedores_total > 0)
                            <a href="{{url('prestadores?busca='.$servico->nome)}}" data-toggle="tooltip" data-placement="top" title="Ver Prestadores">
                              {{$servico->fornecedores_total}} <i class="fa fa-external-link"></i>
                            </a>
                          @else
                            <a href="{{url('prestadores')}}" data-toggle="tooltip" data-placement="top" title="Adicionar Prestador">
                              0 <i class="fa fa-external-link"></i>
                            </a>
                          @endif
                        </td>
                        @if( auth()->user()->permissao == 'a' || auth()->user()->permissao == 's')
                          <td class="text-center">
                            <a href="{{url('servico/'.$servico->id.'/editar')}}" class="btn btn-default btn-xs"> <i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="top" title="Alterar"></i></a>

                            <a @click.prevent="excluir('{{$servico->id}}')" href="#" class="btn btn-default btn-xs delete_row" data-toggle="confirmation" data-placement="bottom" data-original-title="" title="">
                              <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Excluir"></i>
                            </a>
                          </td>  
                        @endif

                      </tr>
                    @endforeach
                  </tbody>
                </table>

                <span class="pull-right"> {{ $servicos->links() }} </span>
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
      excluir:function(servico_id){
        swal({
          title: "Tem certeza?",
          text: "Você só pode excluir um serviço se não houver prestadores vomculados ao serviço, Isso ira deletar permanentemente este serviço",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Sim, pode excluir!",
          cancelButtonText: "Cancelar",
          closeOnConfirm: false
        },function(){
          window.location.href =  "/servico/"+servico_id+"/excluir";
        });
      }
    }

  });
  </script>
@endpush
