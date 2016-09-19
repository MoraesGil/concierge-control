@extends('app')

@section('content')
  <!-- page content -->
  <div class="right_col" role="main" id="appvue">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Gerenciamento de Prestadores</h3>
        </div>

      </div>
      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>{{  Request::is('*/editar') ? "Alteração": "Cadastro" }}</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li class="list"><a data-toggle="tooltip" data-placement="left" title="Listar" class="collapse-link" title="Listar" href="{{url('prestadores')}}"><i class="fa fa-list"></i> prestadores</a></li>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">

            <p>Para listar os prestadores de seriço cadastrados, clique no botão na barra acima</p>
            <span class="section">Dados pessoais</span>

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


            @if(Request::is('*/editar'))
              {{-- editando PUT --}}
              {!! Form::model($prestador, ['url' => 'prestador/'.$prestador->id.'/editar','class' => 'form-horizontal form-label-left', 'method' => 'PUT']) !!}
            @else
              {{-- incluindo POST --}}
              {!! Form::open(['url' => 'prestador/novo', 'class' => 'form-horizontal form-label-left']) !!}
            @endif

            {{-- DADOS PESSOAIS --}}

            <!-- Nome Form Input -->
            <div class="form-group">
              {!! Form::label('nome', 'Nome:',['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
              <div class="col-md-6 col-sm-6 col-xs-12">
                {!! Form::text('nome', null, ['class'=>'form-control col-md-7 ','autofocus']) !!}
              </div>
            </div>

            <!-- RG Form Input -->
            <div class="form-group">
              {!! Form::label('rg', 'RG:',['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
              <div class="col-md-6 col-sm-6 col-xs-12">
                {!! Form::text('rg', null, ['class'=>'form-control col-md-7 ']) !!}
              </div>
            </div>

            <!-- CPF Form Input -->
            <div class="form-group">
              {!! Form::label('cpf', 'CPF:',['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
              <div class="col-md-6 col-sm-6 col-xs-12">
                {!! Form::text('cpf', null, ['class'=>'form-control col-md-7 cpf_mask']) !!}
              </div>
            </div>

            {{-- CONTATO --}}

            <!-- telefone Form Input -->
            <div class="form-group">
              {!! Form::label('telefone', 'Telefone:',['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
              <div class="col-md-6 col-sm-6 col-xs-12">
                {!! Form::text('telefone', null, ['class'=>'form-control col-md-7 fone_mask']) !!}
              </div>
            </div>

            <!-- celular Form Input -->
            <div class="form-group">
              {!! Form::label('celular', 'Celular:',['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
              <div class="col-md-6 col-sm-6 col-xs-12">
                {!! Form::text('celular', null, ['class'=>'form-control col-md-7 cel_mask']) !!}
              </div>
            </div>

            <!-- celular Form Input -->
            <div class="form-group">
              {!! Form::label('email', 'E-Mail:',['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
              <div class="col-md-6 col-sm-6 col-xs-12">
                {!! Form::text('email', null, ['placeholder'=>'Opicional','class'=>'form-control col-md-7 ']) !!}
              </div>
            </div>

            {{-- ENDERECO --}}
            <!-- cep Form Input -->
            <div class="form-group">
              {!! Form::label('cep', 'CEP:',['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
              <div class="col-md-4 col-sm-4 col-xs-8">
                {!! Form::text('cep', null, ['class'=>'form-control col-md-7 cep_mask','v-model'=>"cep"]) !!}
              </div>
              <div class="col-md-2 col-sm-2 col-xs-4">
                <button type="button" @click.prevent="consultaCep"  class="btn" name="button">Consultar</button>
              </div>
            </div>

            <!-- Logradouro Form Input -->
            <div class="form-group">
              {!! Form::label('logradouro', 'Logradouro:',['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
              <div class="col-md-6 col-sm-6 col-xs-12">
                {!! Form::text('logradouro', null, ['class'=>'form-control col-md-7','v-model'=>"logradouro"]) !!}
              </div>
            </div>

            <!-- numero Form Input -->
            <div class="form-group">
              {!! Form::label('numero', 'Nº:',['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
              <div class="col-md-6 col-sm-6 col-xs-12">
                {!! Form::text('numero', null, ['class'=>'form-control col-md-7']) !!}
              </div>
            </div>

            <!-- bairro Form Input -->
            <div class="form-group">
              {!! Form::label('bairro', 'Bairro:',['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
              <div class="col-md-6 col-sm-6 col-xs-12">
                {!! Form::text('bairro', null, ['class'=>'form-control col-md-7','v-model'=>"bairro"]) !!}
              </div>
            </div>

            <!-- cidade Form Input -->
            <div class="form-group">
              {!! Form::label('cidade', 'Cidade:',['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
              <div class="col-md-6 col-sm-6 col-xs-12">
                {!! Form::text('cidade', null, ['class'=>'form-control col-md-7','v-model'=>"cidade"]) !!}
              </div>
            </div>

            <!-- Condominio Form Input -->
            <div class="item form-group">
              {!! Form::label('servicos_id', 'Serviços:',['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
              <div class="col-md-6 col-sm-6 col-xs-12">
                {{ Form::select('servicos_id', $servicos, Request::is('*/editar') ? $prestador->servicos_id->toArray(): null , ['name'=>'servicos_id[]',
                  'class' => 'select_picker form-control col-md-7 col-xs-12',
                  'data-live-search'=>true,'multiple' => true,'title'=>'Serviços'])
                }}
              </div>
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
</div>
<!-- /page content -->

@endsection

@push('script_level')
  <script type="text/javascript">

  $('.select_picker').selectpicker({
    size: 5
  });

  var vm = new Vue({
    el: '#appvue',

    data: {
      logradouro:'',
      bairro:'',
      cidade:'',
    },

    methods: {
      consultaCep: function () {
        var endereco_cep;
        this.$http.get('/cep/'+(this.cep)).then((r) => {
          if (r.data !=undefined) {
            this.logradouro = r.data.logradouro;
            this.bairro = r.data.bairro;
            this.cidade = r.data.cidade+"/"+r.data.uf;
          }
        });
      }
    }

  });
  </script>
@endpush
