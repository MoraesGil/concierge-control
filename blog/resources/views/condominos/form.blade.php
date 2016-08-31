@extends('app')

@section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Gerenciamento de Condôminos</h3>
        </div>

      </div>
      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Cadastro</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li class="list"><a class="collapse-link" title="Listar" href="{{url('moradores')}}"><i class="fa fa-list"></i></a></li>
                <!--<li class="del"><a class="close-link" title="Remover" href="?p=del-condominos"><i class="fa fa-minus-square-o"></i></a>-->
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"> 

            <form class="form-horizontal form-label-left" method="post"  action="{{url('novo/morador')}}">
              {!! csrf_field() !!}
              <input type="hidden" name="METHOD" value="_POST">
              <p>Para listar os moradores cadastrados, clique no botão na barra acima</p>
              <span class="section">Dados pessoais</span>

              {{-- DADOS PESSOAIS --}}
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pes_nome">Nome
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="pes_nome" class="form-control col-md-7 col-xs-12" >
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pes_nome">RG
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="pes_rg" class="form-control col-md-7 col-xs-12" >
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pes_nome">CPF
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="pes_cpf" class="form-control col-md-7 col-xs-12" >
                </div>
              </div>

              {{-- CONTATO --}}
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="con_telefone">Telefone
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="con_telefone" class="form-control col-md-7 col-xs-12" >
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="con_celular">Celular
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="con_celular" class="form-control col-md-7 col-xs-12" >
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="con_email">Email
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="con_email" class="form-control col-md-7 col-xs-12" >
                </div>
              </div>


              {{-- ENDERECO --}}
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="end_logradouro">Logradouro
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="end_logradouro" class="form-control col-md-7 col-xs-12" >
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="end_numero">Numero
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="end_numero" class="form-control col-md-7 col-xs-12" >
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="end_bairro">Bairro
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="end_bairro" class="form-control col-md-7 col-xs-12" >
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pes_nome">CEP
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="end_cep" class="form-control col-md-7 col-xs-12" >
                </div>
              </div>
              <div class="item form-group">
                <label for="password" class="control-label col-md-3">Condomínio</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="condominio" class="form-control col-md-7 col-xs-12" required="required">
                    @foreach($condominios as $condominio )
                      <option value="{{$condominio->id}}">{{ $condominio->nome}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                  <button type="reset" class="btn btn-primary">Limpar</button>
                  <button id="send" type="submit" name="send" class="btn btn-success">Gravar</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->

@endsection
