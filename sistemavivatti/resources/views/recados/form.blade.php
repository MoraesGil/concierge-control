@extends('app')

@section('content')
  <!-- page content -->
  <div class="right_col" role="main" id="appvue">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Gerenciamento de servicos</h3>
        </div>

      </div>
      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>{{  Request::is('*/editar') ? "Alteração": "Cadastro" }}</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li class="list"><a data-toggle="tooltip" data-placement="left" title="Listar" class="collapse-link" title="Listar" href="{{url('servicos')}}"><i class="fa fa-list"></i> servicos</a></li>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">

            <p>Para listar os servicos cadastrados, clique no botão na barra acima</p>
            <span class="section">Nome do serviço/atividade</span>

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
              {!! Form::model($servico, ['url' => 'servico/'.$servico->id.'/editar','class' => 'form-horizontal form-label-left', 'method' => 'PUT']) !!}
            @else
              {{-- incluindo POST --}}
              {!! Form::open(['url' => 'servico/novo', 'class' => 'form-horizontal form-label-left']) !!}
            @endif

            {{-- DADOS PESSOAIS --}}

            <!-- Nome Form Input -->
            <div class="form-group">
              {!! Form::label('nome', 'Nome:',['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
              <div class="col-md-6 col-sm-6 col-xs-12">
                {!! Form::text('nome', null, ['class'=>'form-control col-md-7 ','autofocus']) !!}
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
