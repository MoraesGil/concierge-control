@extends('app')

@section('content')
  <!-- page content -->
  <div class="right_col" role="main" id="app">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Gerenciamento de Moradores </h3>
        </div>
      </div>
      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Relação</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li class="list"><a href="{{url('morador/novo')}}">NOVO <i class="fa fa-plus"></i></a></li>
                {{-- <li class="list"><a class="collapse-link" title="Voltar" href="?p=condominos"><i class="fa fa-reply-all"></i></a></li> --}}
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
              <input type="text" class="form-control" id="search" placeholder="Buscar">
              <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
            </div>
            @if(count($moradores)>0)
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Cod</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                    <th style="text-align:center;">Quantidade Dependentes</th>
                    <th style="text-align:center"> status </th>
                    <th style="text-align:center"> Opções </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($moradores as  $morador)
                    <tr>
                      <td scope="row">{{$morador->id}}</td>
                      <td>{{$morador->nome}}</td>
                      <td>{{$morador->cpf}}</td>
                      <td>{{$morador->contatos->telefone }}</td>
                      <td style="text-align:center">
                        <a href="{{url('morador/'.$morador->id.'/dependentes')}}" data-toggle="tooltip" data-placement="top" title="Ver dependentes">
                          {{$morador->total_dependentes}}
                        </a>
                      </td>
                      <td style="text-align:center">
                        @if(!$morador->usuario->desativado_em)
                          <a href="{{url('morador/'.$morador->id.'/alterarStatus')}}" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Ativo">
                            <i class="fa fa-thumbs-o-up"></i>
                          </a>
                        @else
                          <a href="{{url('morador/'.$morador->id.'/alterarStatus')}}" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Desativado">
                            <i class="fa fa-thumbs-o-down"></i>
                          </a>
                        @endif
                      </td>
                      <td style="text-align:center">
                        <a href="" class="btn btn-default btn-xs"> <i class="fa fa-bars" data-toggle="tooltip" data-placement="top" title="Informações"></i></a>
                        <a href="{{url('morador/'.$morador->id.'/editar')}}" class="btn btn-default btn-xs"> <i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="top" title="Alterar"></i></a>

                        <a @click.prevent="excluir('{{$morador->id}}')" href="#" class="btn btn-default btn-xs delete_row" data-toggle="confirmation" data-placement="bottom" data-original-title="" title="">
                          <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Excluir"></i>
                        </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

              <span class="pull-right"> {{ $moradores->links() }} </span>
            @else
              <br>
              <br>
              <h3 class="text-center">Não há moradores cadastrados</h3>
            @endif
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
      paginate:{
        total: 2,
        per_page: 3,
        current_page: 1,
        last_page: 1,
        next_page_url: null,
        prev_page_url: null,
        from: 1,
        to: 2,
        data: [
          {
            id: 5,
            usuario_id: 2,
            nome: "Teste1",
            rg: "67890",
            cpf: "4567890",
            cnpj: null,
            foto_url: null,
            data_nascimento: null,
            responsavel_id: null,
            total_dependentes: 0
          },
          {
            id: 6,
            usuario_id: 3,
            nome: "teste 2",
            rg: "543532",
            cpf: "345678909",
            cnpj: null,
            foto_url: null,
            data_nascimento: null,
            responsavel_id: null,
            total_dependentes: 0
          }
        ]
      }//fim paginate

    },

    methods:{
      carregaLista:function(){
        
      }
      excluir:function(morador_id){
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
          window.location.href =  "/morador/"+morador_id+"/excluir";
        });
      }
    }

  });
  </script>

@endpush
