@extends('app')

@section('content')
  <style media="screen">
  .fc-event-time {
display: none;
}
  </style>
  <!-- page content -->
  <div class="right_col" role="main" id="appvue">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Gerenciamento de Eventos</h3>
        </div>

      </div>
      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>{{  Request::is('*/editar') ? "Alteração": "Cadastro" }}</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li class="list"><a data-toggle="tooltip" data-placement="left" title="Listar" class="collapse-link" title="Listar" href="{{url('eventos')}}"><i class="fa fa-list"></i> eventos</a></li>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">

            <p>Para listar os eventos cadastrados, clique no botão na barra acima</p>
            <span class="section">Data da reserva do Evento</span>

            <div class="row">
              <div class="col-md-4 col-sm-4 col-xs-12">
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
                  {!! Form::model($evento, ['url' => 'evento/'.$evento->id.'/editar','class' => 'form-horizontal  ', 'method' => 'PUT']) !!}
                @else
                  {{-- incluindo POST --}}
                  {!! Form::open(['url' => 'evento/novo', 'class' => 'form-horizontal  ']) !!}
                @endif

                <div class="form-group">
                  {!! Form::label('data_entrada', 'Data Entrada:',['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    {!! Form::text('data_entrada', null, ['class'=>'form-control  data_mask ','autofocus']) !!}
                  </div>
                </div>

                <div class="form-group">
                  {!! Form::label('data_saida', 'Data Saída:',['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    {!! Form::text('data_saida', null, ['class'=>'form-control  data_mask ']) !!}
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-md-6 col-md-offset-3">
                    <button id="send" type="submit" name="send" class="btn btn-success">Gravar</button>
                  </div>
                </div>

                {!! Form::close() !!}
              </div>
              <div class="col-md-8 col-sm-8 col-xs-12">
                  {!! $calendar->calendar() !!}
              </div>
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
  {!! $calendar->script() !!}
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
