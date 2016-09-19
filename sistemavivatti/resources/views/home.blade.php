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

        <!-- start of weather widget -->
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Daily active users <small>Sessions</small></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Settings 1</a>
                    </li>
                    <li><a href="#">Settings 2</a>
                    </li>
                  </ul>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="row">
                <div class="col-sm-12">
                  <div class="temperature"><b>Monday</b>, 07:30 AM
                    <span>F</span>
                    <span><b>C</b></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-4">
                  <div class="weather-icon">
                    <canvas height="84" width="84" id="partly-cloudy-day"></canvas>
                  </div>
                </div>
                <div class="col-sm-8">
                  <div class="weather-text">
                    <h2>Texas <br><i>Partly Cloudy Day</i></h2>
                  </div>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="weather-text pull-right">
                  <h3 class="degrees">23</h3>
                </div>
              </div>

              <div class="clearfix"></div>

              <div class="row weather-days">
                <div class="col-sm-2">
                  <div class="daily-weather">
                    <h2 class="day">Mon</h2>
                    <h3 class="degrees">25</h3>
                    <canvas id="clear-day" width="32" height="32"></canvas>
                    <h5>15 <i>km/h</i></h5>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="daily-weather">
                    <h2 class="day">Tue</h2>
                    <h3 class="degrees">25</h3>
                    <canvas height="32" width="32" id="rain"></canvas>
                    <h5>12 <i>km/h</i></h5>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="daily-weather">
                    <h2 class="day">Wed</h2>
                    <h3 class="degrees">27</h3>
                    <canvas height="32" width="32" id="snow"></canvas>
                    <h5>14 <i>km/h</i></h5>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="daily-weather">
                    <h2 class="day">Thu</h2>
                    <h3 class="degrees">28</h3>
                    <canvas height="32" width="32" id="sleet"></canvas>
                    <h5>15 <i>km/h</i></h5>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="daily-weather">
                    <h2 class="day">Fri</h2>
                    <h3 class="degrees">28</h3>
                    <canvas height="32" width="32" id="wind"></canvas>
                    <h5>11 <i>km/h</i></h5>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="daily-weather">
                    <h2 class="day">Sat</h2>
                    <h3 class="degrees">26</h3>
                    <canvas height="32" width="32" id="cloudy"></canvas>
                    <h5>10 <i>km/h</i></h5>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
          </div>

        </div>
        <!-- end of weather widget -->
      </div>

    </div>
  </div>
  <!-- /page content -->
@endsection
