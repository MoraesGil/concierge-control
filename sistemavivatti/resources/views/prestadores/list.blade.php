@extends('app')

@section('content')
  <!-- page content -->
  <div class="right_col" role="main" id="app">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Lista de Prestadores de Serviço </h3>
        </div>
      </div>
      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Relação</h2>
              <ul class="nav navbar-right panel_toolbox">
                @if( auth()->user()->permissao != 'm')
                <li class="list"><a href="{{url('prestador/novo')}}">NOVO <i class="fa fa-plus"></i></a></li>
                @endif                
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
                      <th>CPF/CNPJ</th>
                      <th>Telefone</th>
                      <th>Serviços</th>
                      <th style="text-align:center;">Qtd. Funcionarios</th>
                      <th style="text-align:center;">Média</th>
                      @if( auth()->user()->permissao == 'a' || auth()->user()->permissao == 's' )
                      <th style="text-align:center"> Opções </th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($prestadores as  $prestador)
                      <tr>
                        <td scope="row">{{$prestador->id}}</td>
                        <td>{{$prestador->nome}}</td>
                        <td>
                          @if($prestador->cpf != null)
                            <span class="cpf_mask">{{$prestador->cpf}}</span>
                          @else
                            <span class="cnpj_mask">{{$prestador->cnpj}}</span>
                          @endif
                        </td>
                        <td>
                          <span class="fone_mask">{{$prestador->contatos->telefone }}</span>
                        </td>

                        <td class="text-center">
                          <span data-toggle="tooltip" data-placement="top"
                          title="
                          @foreach($prestador->servicos_prestados as $servico)
                            {{$servico->nome}},
                          @endforeach
                          ">{{$prestador->total_servicos}} </span>

                        </td>
                        <td style="text-align:center">
                          @if($prestador->total_dependentes>0)
                            <a href="{{url('prestador/'.$prestador->id.'/funcionarios')}}" data-toggle="tooltip" data-placement="right" title="Ver funcionarios">
                              {{$prestador->total_dependentes}} <i class="fa fa-mail-reply"></i>
                            </a>
                          @else
                            <a href="{{url('prestador/'.$prestador->id.'/funcionario/novo')}}" data-toggle="tooltip" data-placement="top" title="Adicionar Funcionario">
                              N/A <i class="fa fa-plus-square-o"></i>
                            </a>
                          @endif
                        </td>

                        <td style="text-align:center">
                          <a @click.prevent="loadAvaliacao('{{$prestador->id}}')"  data-toggle="tooltip" data-placement="top" title="Clique para dar sua nota">
                            @for($i=0; $i < 5 ; $i++)
                              @if($prestador->media_avaliacoes - ($i + 0.5)== 0)
                                <i class="fa fa-star-half-o"></i>
                              @elseif($prestador->media_avaliacoes - $i > 0)
                                <i class="fa fa-star"></i>
                              @else
                                <i class="fa fa-star-o"></i>
                              @endif
                            @endfor
                          </a>
                        </td>

                        @if( auth()->user()->permissao == 'a' || auth()->user()->permissao == 's' )
                          <td style="text-align:center">
                            <a href="{{url('prestador/'.$prestador->id.'/editar')}}" class="btn btn-default btn-xs"> <i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="top" title="Alterar"></i></a>
                            <a @click.prevent="excluir('{{$prestador->id}}')" href="#" class="btn btn-default btn-xs delete_row" data-toggle="confirmation" data-placement="bottom" data-original-title="" title="">
                              <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Excluir"></i>
                            </a>
                          </td>
                        @endif

                      </tr>
                    @empty
                      <h3 class="text-center"> Nenhum prestador encontrado com termo '{{$_GET["busca"]}}'</h3>
                    @endforelse


                  </tbody>
                </table>
                <span class="pull-right"> {{ $prestadores->links() }} </span>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="modalNota" class="modal  fade ">
      <div class="modal-dialog modal-sm" >
        <div class="modal-content">
          <div class="modal-header text-center">
            <h4>@{{prestador.nome}}</h4>
          </div>
          <div class="modal-body text-center">
            <h5>Sua nota</h5>
            <template v-for="n in 5">
              <a @click="atualizaNota(n+1)">
                <i class="fa fa-3x fa-star" v-if="prestador.nota - n > 0"></i>
                <i class="fa fa-3x fa-star-o" v-else></i>
              </a>
            </template>
            <input type="hidden" name="_token" v-model="token_form" value="{{ csrf_token() }}">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Pronto</button>
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
      prestador : {
        id : 0,
        nome : "GILBERTO VUE",
        nota : 4,
      }
    },

    ready:function(){
      $(document).on('hide.bs.modal','#modalNota', function () {
        location.reload();
      });
    },

    methods:{
      loadAvaliacao:function(prestador_id){
        // GET /someUrl
        this.$http.get('/prestador/'+prestador_id+'/nota').then((response) => {
          $('#modalNota').modal('show');
          this.prestador.id =  response.data.id;
          this.prestador.nome =  response.data.nome;
          this.prestador.nota =  response.data.nota;
          this.prestador.token =  response.data.token;
        });
        console.log(this.prestador);
      },
      atualizaNota:function(nota){
        prestador_id = this.prestador.id;

        var parametros = {
          nota :  this.prestador.nota = nota,
          _token: this.token_form
        };

        this.$http.put('/prestador/'+prestador_id+'/nota',parametros).then((response) => {
          console.log(response.data)
        });

      },
      excluir:function(prestador_id){
        swal({
          title: "Tem certeza?",
          text: "Isso ira deletar permanentemente este prestador e todos registros relacionados a ele.",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Sim, pode excluir!",
          cancelButtonText: "Cancelar",
          closeOnConfirm: false
        },function(){
          window.location.href =  "/prestador/"+prestador_id+"/excluir";
        });
      },
      excluirContrato:function(prestador_id){
        swal({
          title: "Tem certeza?",
          text: "Isso ira excluir permanentemente este contrato",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Sim, pode excluir!",
          cancelButtonText: "Cancelar",
          closeOnConfirm: false
        },function(){
          window.location.href =  "/prestador/"+prestador_id+"/excluir";
        });
      }
    }

  });
  </script>
@endpush
