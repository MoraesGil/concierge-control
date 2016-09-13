@extends('app')

@section('content')
  <!-- page content -->
  <div class="right_col" role="main" id="app">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Dependentes de {{$morador->nome}} </h3>
        </div>
      </div>
      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Relação</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li class="list"><a href="{{url('moradores')}}"class="collapse-link" title="Voltar" ><i class="fa fa-reply-all"></i> Moradores</a></li>
                <li class="divider"></li>
                <li class="list"><a href="{{url('morador/'.$morador->id.'/dependente/novo')}}">Dependente<i class="fa fa-plus"></i></a></li>

              </li>
            </ul>
            <div class="clearfix"></div>
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
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Cod</th>
                    <th>Nome</th>
                    <th>RG</th>
                    <th>Data Nasc</th>
                    <th class="text-center">Responsavel</th>
                    <th class="text-center">Opções</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($dependentes as  $dependente)
                    <tr>
                      <td scope="row">{{$dependente->id}}</td>
                      <td>{{$dependente->nome}}</td>
                      <td>{{$dependente->rg}}</td>
                      <td>{{$dependente->data_nascimento}}</td>
                      <td style="text-align:center">
                        {{$dependente->responsavel->nome}}
                      </td>

                      <td style="text-align:center">
                        <a href="{{url('morador/'.$morador->id.'/dependente/'.$dependente->id.'/editar')}}" class="btn btn-default btn-xs"> <i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="top" title="Alterar"></i></a>

                        <a @click.prevent="excluir('{{$morador->id}}','{{$dependente->id}}')" href="#" class="btn btn-default btn-xs delete_row" data-toggle="confirmation" data-placement="bottom" data-original-title="" title="">
                          <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Excluir"></i>
                        </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              <span class="pull-right"> {{ $dependentes->links() }} </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->
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
      carregaLista:function(){

      },
      excluir:function(morador_id,dependente_id){
        swal({
          title: "Tem certeza?",
          text: "Isso ira deletar permanentemente este morador e todos registros relacionados a ele.",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Sim, pode excluir!",
          cancelButtonText: "Cancelar",
          closeOnConfirm: false
        },function(){
          window.location.href =  "/morador/"+morador_id+"/dependente/"+dependente_id+"/excluir";
        });
      }
    }
  });
  </script>
@endpush
