@extends('app')

@section('content')
  <!-- page content -->
  <div class="right_col" role="main" id="app">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Funcionarios de {{$prestador->nome}} </h3>

        </div>
      </div>
      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Relação</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li class="list"><a href="{{url('prestadores')}}"class="collapse-link" title="Voltar" ><i class="fa fa-reply-all"></i> Prestadores de Serviço</a></li>
                <li class="divider"></li>
                <li class="list"><a href="{{url('prestador/'.$prestador->id.'/funcionario/novo')}}">NOVO <i class="fa fa-plus"></i></a></li>
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
                      <th>CPF</th>
                      <th>RG</th>
                      <th>Telefone</th>
                      <th>Celular</th>
                      <th >Cidade </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($funcionarios as  $funcionario)
                      <tr>
                        <td scope="row">{{$funcionario->id}}</td>
                        <td>{{$funcionario->nome}}</td>
                        <td>{{$funcionario->cpf}}</td>
                        <td>{{$funcionario->rg}}</td>
                        <td><span class="fone_mask">{{$funcionario->contatos->telefone }}</span> </td>
                        <td><span class="cel_mask">{{$funcionario->contatos->celular }}</span> </td>
                        <td>
                          {{$funcionario->endereco->cidade}}
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                <span class="pull-right"> {{ $funcionarios->links() }} </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="modalNota" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header text-center">
          <h4>Gilberto Prudêncio Vaz de Moraes</h4>
        </div>
        <div class="modal-body text-center">
          <h5>Sua nota</h5>
          @for($i=0; $i < 5 ; $i++)
            <i class="fa fa-3x fa-star-o"></i>
          @endfor
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Pronto</button>
        </div>
      </div>
    </div>
  </div>

  <!-- /page content -->
@endsection


@push('script_level')
   
@endpush
