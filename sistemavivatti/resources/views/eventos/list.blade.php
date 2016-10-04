@extends('app')

@section('content')

<style media="screen">
.scroll tr {
  width: 100%;
  display: inline-table;
}

.scroll table {
  height:300px;
}
.scroll tbody {
  overflow-y: scroll;
  height: 200px;
  width: 95%;
  position: absolute;
}
.tableScroll{
  height: 220px;
}
</style>

<!-- page content -->
<div class="right_col" role="main" id="app">
  <input type="hidden" v-model="usuario.id"  value="{{auth()->user()->id}}">
  <input type="hidden" v-model="usuario.permissao" value="{{auth()->user()->permissao}}">

  <div id="modalConvidados" class="modal  fade ">
    <div class="modal-dialog" >
      <div class="modal-content">
        <div class="modal-header text-center">
          <h4>Convidados para o evento</h4>
          @{{evento.data_entrada}} - @{{evento.data_saida}}
        </div>
        <div class="modal-body">
          {{-- alterarConvidadosPermissao --}}
          <template v-if="alterarConvidadosPermissao">
            <form class='form-horizontal'>
              <input id="convidado" @click.prevent v-on:keyup="fetchVisitante" v-on:blur="setVisitante" v-model="convidado.nome" type='text' class='form-control input-lg typeahead' placeholder='Nome do Convidado'>
              <a @click.prevent="addConvidado()" class='btn btn-lg btn-default btn-block' style="margin-top: 5px;">Adicionar </a>
            </form>

            <div class="alert alert-success" v-show="showSuccess">
              <ul>
                <li>@{{success_message}}</li>
              </ul>
            </div>

            <div class="alert alert-warning" v-show="showErro">
              <ul v-for="erro in erros">
                <li>
                  @{{erro}}
                </li>
              </ul>
            </div>
          </template>
          <div class="tableScroll">
            <table class="table table-striped scroll ">
              <thead>
                <tr>
                  <th>Nome</th>
                </tr>
              </thead>
              <tbody class="scroll ">
                <tr v-for="convidado in convidados">
                  <td>@{{convidado.nome}}
                    <span class="pull-right" v-if="alterarConvidadosPermissao">
                      <i v-if="convidado.pessoa_id>0" class="fa fa-user"></i>
                      <a @click.prevent="removeConvidado(convidado)" class="btn btn-default btn-xs delete_row" data-toggle="confirmation" data-placement="bottom" data-original-title="" title="">
                        <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Excluir"></i>
                      </a>
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Pronto</button>
        </div>
      </div>
    </div>
  </div>

  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Lista de Reservas/eventos</h3>
      </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Registros</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li class="list"><a href="{{url('evento/novo')}}">NOVO <i class="fa fa-plus"></i></a></li>
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
                    <th>Data Inicio</th>
                    <th>Data Final</th>
                    <th class="text-center"> Qtd. Convidados </th>
                    @if(auth()->user()->permissao == 'a' || auth()->user()->permissao == 's')
                      <th>Agendado Por</th>
                      <th class="text-center"> Opções </th>
                    @endif
                  </tr>
                </thead>
                <tbody  >
                  @foreach($eventos as  $evento)
                    <tr>
                      <td>{{$evento->id}}</td>
                      <td>{{$evento->data_entrada}}</td>
                      <td>{{$evento->data_saida}}</td>
                      <td class="text-center">
                        @if(count($evento->convidados) > 0)
                          <a @click.prevent="loadConvidados('{{$evento}}')"  data-toggle="tooltip" data-placement="top" title="Exibir Convidados">
                            {{count($evento->convidados)}} <i class="fa fa-user"></i>
                          </a>
                        @else
                          <a @click.prevent="loadConvidados('{{$evento}}')"  data-toggle="tooltip" data-placement="top" title="Adicionar Convidados">
                            0 <i class="fa fa-user"></i>
                          </a>
                        @endif
                      </td>
                      @if(auth()->user()->permissao == 'a' || auth()->user()->permissao == 's')
                        <td>{{$evento->getTitle()}}</td>

                        <td class="text-center">
                          <a href="{{url('evento/'.$evento->id.'/editar')}}" class="btn btn-default btn-xs"> <i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="top" title="Alterar"></i></a>

                          <a @click.prevent="excluir('{{$evento->id}}')" href="#" class="btn btn-default btn-xs delete_row" data-toggle="confirmation" data-placement="bottom" data-original-title="" title="">
                            <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Excluir"></i>
                          </a>
                        </td>
                      @endif

                    </tr>
                  @endforeach
                </tbody>
              </table>

              <span class="pull-right"> {{ $eventos->links() }} </span>
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

  Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
  var vm = new Vue({
    el: '#app',

    data: {
      usuario : {
        id : 0,
        permissao:''
      },
      convidados:[],
      convidado : {
        id : null,
        nome :'',
        pessoa_id : null
      },
      erros:[],
      success_message:''
    },

    computed: {
      alterarConvidadosPermissao:function(){
        return (this.usuario.permissao == 'a' || this.usuario.id == this.evento.usuario_id);
      },
      showErro: function(){
        return (this.erros.length > 0);
      },
      showSuccess: function(){
        return (this.success_message.length > 0);
      }
    },

    ready:function(){
      $(document).on('hide.bs.modal','#modalConvidados', function () {
        location.reload();
      });

    },

    methods:{
      fetchVisitante:function(){
        this.$http.get('/portaria/getvisitantes?busca='+this.convidado.nome).then((response) => {
          var autocomplete = $("#convidado").typeahead();
          autocomplete.data('typeahead').source = response.data;
        });
      },
      loadConvidados:function(evento){
        // GET /someUrl
        $('#modalConvidados').modal('show');
        this.fetchConvidados(evento);
      },
      fetchConvidados : function(evento){
        this.success_message = '';
        this.erros = [];

        this.$set('evento', JSON.parse(evento)); //set evento
        // console.log(this.evento.usuario_id);
        this.$http.get('/evento/'+this.evento.id+'/convidados').then((response) => {
          this.$set('convidados', response.data);
        });
        this.convidados;
      },
      addConvidado : function(){
        this.success_message = '';
        this.erros = [];

        current = $("#convidado").typeahead("getActive");
        if (current) {
          this.convidado.pessoa_id = current.name == this.convidado.nome ? current.id : null;
        }
        var parametros = {
          nome:this.convidado.nome,
          pessoa_id:this.convidado.pessoa_id
        };
        this.$http.post('/evento/'+this.evento.id+'/convidado/novo',parametros).then((response) => {
          this.convidado.id = response.data.data.id;
          this.convidados.unshift(this.convidado);
          this.convidado = { id : null, nome :'',pessoa_id : null};
          this.success_message = response.data.log;
        },(response) => {//error

          tempArray = [];
          $.each( response.data, function( key, value ) {
            tempArray.push(value[0]);
          });
          this.erros = tempArray;
        });
      },
      removeConvidado : function(convidado){
        this.success_message = '';
        this.erros = [];

        this.$http.delete('/evento/'+this.evento.id+'/convidado/'+convidado.id+'/excluir').then((response) => {           
          this.convidados.$remove(convidado);
          this.success_message = response.data.log;
        },(erro_response) => {
          tempArray = [];
          $.each( erro_response.data, function( key, value ) {
            tempArray.push(value[0]);
          });
          this.erros = tempArray;
        });
      },
      excluir:function(evento_id){
        swal({
          title: "Tem certeza?",
          text: "Você está prestes a excluir um evento e a lista de visitantes relacionada a ela. continuar?",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Sim, pode excluir!",
          cancelButtonText: "Cancelar",
          closeOnConfirm: false
        },function(){
          window.location.href =  "/evento/"+evento_id+"/excluir";
        });
      }
    }

  });
  </script>
@endpush
