@extends('app')

@section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="container">
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

      <div class="row">

        <div class="col-md-5 col-sm-5 col-xs-12">
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
                            <span>{{$recado->criado_em}}</span> por <a>  {{$recado->usuario->dados_pessoais->nome}}</a>
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
  <!-- /page content -->
@endsection
