@extends('app')

@section('content')
  <!-- page content -->


  <div class="right_col" role="main" id="app">
    <div class="row top_tiles" style="margin: 10px 0;">
      <div class="col-md-3 col-sm-3 col-xs-6 tile">
        <span>Total Pessoas</span>
        <h2>{{$total_pessoas}}</h2>
        <span class="sparkline_one" style="height: 160px;">
          <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
        </span>
      </div>
      <div class="col-md-3 col-sm-3 col-xs-6 tile">
        <span>Moradores</span>
        <h2>{{$total_moradores}}</h2>
        <span class="sparkline_one" style="height: 160px;">
          <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
        </span>
      </div>
      <div class="col-md-3 col-sm-3 col-xs-6 tile">
        <span>Prestador de Serviços</span>
        <h2>{{$total_prestadores}}</h2>
        <span class="sparkline_one" style="height: 160px;">
          <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
        </span>
      </div>
      <div class="col-md-3 col-sm-3 col-xs-6 tile">
        <span>Seviços</span>
        <h2>{{$total_servicos}}</h2>
        <span class="sparkline_one" style="height: 160px;">
          <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
        </span>
      </div>
    </div>

    <div class="page-title">
      <div class="title_left">
        <h3>Bem vindo</h3>
      </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <ul class="nav navbar-right panel_toolbox">
              <li class="list"><a href="{{url('eventos')}}">Fazer Reserva <i class="fa fa-calendar"></i></a></li>
              <li class="list"><a href="{{url('recados')}}">Deixar Recado <i class="fa fa-list"></i></a></li>
            </ul>
            <div class="clearfix">
            </div>
          </div>
          <div class="x_content">
            <div class="row">
              <div class="col-md-8 col-sm-8 col-xs-12">
                {!! $calendar->calendar() !!}
              </div>
              <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Ultimos Recados<small><a href="{{url('recados')}}"> Ver Todos</a></small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="dashboard-widget-content">

                      <ul class="list-unstyled timeline widget">
                        @foreach($recados as $recado)
                          <li>
                            <div class="block">
                              <div class="block_content">
                                <h2 class="title">
                                  {{$recado->titulo}}
                                </h2>
                                <div class="byline">
                                  <span>{{$recado->criado_em}}</span> por
                                  <a>
                                    @if($recado->usuario->id == auth()->user()->id )
                                      Mim
                                    @elseif($recado->anonimo)
                                      Anônimo
                                    @else
                                      {{$recado->usuario->dados_pessoais->nome}}
                                    @endif
                                  </a>
                                </div>
                                <p class="excerpt">{{$recado->detalhes}}
                                </p>
                              </div>
                            </div>
                          </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="fullCalModal" class="modal fade">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                  <h4 id="modalTitle" class="modal-title"></h4>
              </div>
              <div id="modalBody" class="modal-body"></div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                  <button class="btn btn-default"><a id="eventUrl" href="{{url('/eventos')}}" target="_blank">Ver nos eventos</a></button>
              </div>
          </div>
      </div>
  </div>
@endsection


@push('script_level')
  {!! $calendar->script() !!}

@endpush
