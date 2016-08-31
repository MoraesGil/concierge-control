@extends('app')
@section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Gerenciamento de Moradores</h3>
        </div>

      </div>
      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Cadastro</h2>
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

            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Cod</th>
                  <th>Nome</th>
                  <th>CPF</th>
                  <th>Telefone</th>
                  <th style="text-align:center;">Quantidade Dependentes</th>
                  <th> status </th>
                  <th> Opções </th>
                </tr>
              </thead>
              <tbody>
                @foreach($moradores as  $morador)
                  <tr>
                    <td scope="row">{{$morador->id}}</td>
                    <td>{{$morador->nome}}</td>
                    <td>{{$morador->cpf}}</td>
                    <td>{{$morador->contatos->telefone }}</td>
                    <td style="text-align:center"><a href="#" data-toggle="tooltip" data-placement="top" title="Ver dependentes"> 10</a> </td>
                    <td style="text-align:center"><a class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Ativo"> <i class="fa fa-thumbs-o-up"></i></a> </td>
                    <td style="text-align:center">
                      <a class="btn btn-default btn-xs"> <i class="fa fa-bars" data-toggle="tooltip" data-placement="top" title="Informações"></i></a>
                      <a class="btn btn-default btn-xs"> <i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="top" title="Alterar"></i></a>                    </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /page content -->

@endsection
