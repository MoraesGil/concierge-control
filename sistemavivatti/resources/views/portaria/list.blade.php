@extends('app')

@section('content')
  <!-- page content -->
  <div class="right_col" role="main" id="app">

    <div class="col-md-12">
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h3>Livro de Acesso</h3>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="row">
                <input type="hidden" name="_token" v-model="token_form" value="{{ csrf_token() }}">

                <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                  <input id="visitante" @click.prevent v-on:keyup="fetchVisitante" v-on:blur="setVisitante"  v-model="visitante.nome"  type="text" class="form-control typeahead" name="visitante"  placeholder="Visitante">
                  <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                </div>

                <div   class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                  <input id="morador"  autocomplete="off" v-on:keyup="fetchMorador" v-on:blur="setMorador"  v-model="morador.nome"  type="text" class="form-control typeahead" name="morador"  placeholder="Morador">
                  <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                </div>


                <div class="col-md-2 col-sm-4 col-xs-12 form-group has-feedback">
                  <input id="placa" v-on:keyup="fetchPlaca" v-on:blur="setPlaca" v-model="veiculo.placa"  type="text" class="form-control placa_mask typeahead" name="placa"  placeholder="Placa">
                  <span class="fa fa-car form-control-feedback right" aria-hidden="true"></span>
                </div>

                <div v-show="showGravar"  class="col-md-2 col-sm-12 col-xs-12 form-group has-feedback">
                  <button @click.prevent="lancarVisita" name="button" class="btn btn-block btn-success"><i class="fa fa-check"></i> Registrar</button>
                </div>
                <div v-if="showCpf"   class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                  <input  v-model="visitante.cpf"  type="text" class="form-control cpf_mask" name="cpf"  placeholder="CPF : ___.___.___-__">
                  <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                  <div class="alert alert-warning" v-if="showErro">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <ul v-for="erro in erros">
                      <li>
                        <h4> @{{erro}} </h4>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- REGISTROS --}}
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Lista de Visitas</h2>
                  <div class="clearfix">
                  </div>
                </div>
                <div class="x_content">
                  <div class="row">
                    <form>
                      <div class="col-md-10 col-sm-8 col-xs-6 form-group has-feedback">
                        <input value="{{ isset($_GET['busca']) ? $_GET['busca'] : "" }}" type="text" class="form-control" name="busca" id="busca" placeholder="Buscar por Nome, CPF, Placa, Morador ou Visitante">
                        <span class="fa fa-list-ul form-control-feedback right" aria-hidden="true"></span>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-6 form-group has-feedback">
                        <button type="submit" name="button" class="btn btn-block btn-default"><i class="fa fa-search"></i> Filtrar</button>
                      </div>
                    </form>
                  </div>

                  <div class="row">
                    <div class="x_panel">
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
                          <hr>
                        @endif
                        <div class="dashboard-widget-content">
                          <ul class="list-unstyled timeline widget col-md-6 col-sm-6 col-xs-12">
                            @foreach($visitas as $key => $visita)
                              @if($key %5 == 0 && $key>0)
                              </ul><ul class="list-unstyled timeline widget col-md-6 col-sm-6 col-xs-12">
                              @endif
                              <li>
                                <div class="block">
                                  <div class="block_content">
                                    <h2 class="title">
                                      {{$visita->visitante->nome}}
                                      @if($visita->veiculo!=null)
                                        - <i class="fa fa-car" data-toggle="tooltip" data-placement="top" title="Placa: {{$visita->veiculo->placa}}"></i>
                                      @endif

                                      @if(auth()->user()->permissao == 'a')
                                        <div class="pull-right">
                                          <a class="btn btn-xs btn-default" @click.prevent="excluir('{{$visita->id}}')" href="#"  data-toggle="confirmation" data-placement="bottom" data-original-title="" title="Excluir">
                                            <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Excluir"></i>
                                          </a>
                                        </div>
                                      @endif
                                    </h2>
                                    <div class="byline">
                                      Residencia de:  <a> {{$visita->morador->nome}}</a> <span>{{$visita->criado_em}}</span>
                                    </div>
                                  </div>
                                </div>
                              </li>

                            @endforeach
                          </ul>
                        </div>
                      </div>
                    </div>
                    <span class="pull-right"> {{ $visitas->links() }} </span>
                  </div>
                </div>
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
      visitante:{
        id:'0',
        nome:'',
        cpf:''
      },
      morador:{
        id:'0',
        nome:''
      },
      veiculo:{
        id:'0',
        placa:''
      },
      moradores:[],
      visitantes:[],
      placas:[],
      erros:[]
    },

    ready:function(){

    },
    computed: {
      showGravar: function () {
        // return true;
        return (this.morador.id>0 && this.visitante.nome.length >= 4);
      },
      showCpf: function () {
        return (this.visitante.nome.length > 2 && this.visitante.id == 0);
      },
      showErro: function(){
        return (this.erros.length > 0);
      }

    },
    methods:{
      // prudentedpvat.angela@hotmail.com
      fetchMorador:function(){
        this.$http.get('/portaria/getmoradores?busca='+this.morador.nome).then((response) => {
          $("#morador").data('typeahead').source = response.data;
        });
      },

      fetchVisitante:function(){
        this.$http.get('/portaria/getvisitantes?busca='+this.visitante.nome).then((response) => {
          $("#visitante").data('typeahead').source = response.data;
        });
      },

      fetchPlaca:function(){
        this.$http.get('/portaria/getplacas?busca='+this.veiculo.placa).then((response) => {
          $("#placa").data('typeahead').source = response.data;
        });
      },

      setMorador:function(){
        current = $("#morador").typeahead("getActive");
        if (current) {
          this.morador.id = current.name == this.morador.nome ? current.id : 0;
        }
      },
      setVisitante:function(){
        current = $("#visitante").typeahead("getActive");
        if (current) {
          this.visitante.id = current.name == this.visitante.nome ? current.id : 0;
        }
        if (this.visitante.id > 0) {
          this.visitante.cpf = '';
          this.erros = [];
        }else if (this.visitante.nome.length < 4){
          this.erros = ['Nome do visitante precisa ter no minimo 10 caracteres'];
        }
      },
      setPlaca:function(){
        current = $("#placa").typeahead("getActive");
        if (current) {
          this.veiculo.id = current.name == this.veiculo.placa ? current.id : 0;
        }
      },

      lancarVisita:function(){
        var parametros = {
          _token: this.token_form,
          visitante:this.visitante,
          veiculo:this.veiculo,
          morador:this.morador
        };

        this.$http.post('/visita/novo',parametros).then((response) => {
          location.reload();
        },(response) => {
          tempArray = [];
          $.each( response.data, function( key, value ) {
            tempArray.push(value[0]);
          });
          this.erros = tempArray;
        });
      },

      excluir:function(visita_id){
        swal({
          title: "Tem certeza?",
          text: "Essa ação não pode ser desfeita, deseja prosseguir?",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Sim, pode excluir!",
          cancelButtonText: "Cancelar",
          closeOnConfirm: false
        },function(){
          window.location.href =  "/visita/"+visita_id+"/excluir";
        });
      }
    }

  });
  </script>
@endpush
