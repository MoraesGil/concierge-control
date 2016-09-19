<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Vivatti Systema</title>

  <!-- Bootstrap -->
  <link href="{{url('/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="{{url('/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="{{url('/build/css/custom.min.css')}}" rel="stylesheet">

  <link href="{{url('/assets/css/sweetalert.css')}}" rel="stylesheet">
  <link href="{{url('/assets/css/bootstrap-select.min.css')}}" rel="stylesheet">
</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="index.html" class="site_title"><i class="fa fa-home"></i> <span>Vivatti</span></a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile">
            <div class="profile_pic">
              @if(auth()->user()->dados_pessoais->foto_url)
                <img src="{{url('uploads/pessoas') .  auth()->user()->dados_pessoais->foto_url }}" alt="..." class="img-circle profile_img">
              @else
                <img src="{{url('uploads/pessoas/default.png')}}" alt="..." class="img-circle profile_img">
              @endif
            </div>
            <div class="profile_info">
              <span>Bem vindo,</span>
              <h2>{{auth()->user()->dados_pessoais->nome }}</h2>
            </div>
          </div>
          <!-- /menu profile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <div class="clearfix"></div>
              <ul class="nav side-menu">
                <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="{{url('/home')}}">Inicio</a></li>
                    <li><a href="{{url('/sindicos')}}">Sindícos</a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-male"></i> Síndico <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="{{url('/moradores')}}">Moradores</a></li>
                    <li><a href="{{url('/porteiros')}}">Porteiros</a></li>
                    <li><a href="{{url('/reservas')}}">Reserva de Salão</a></li>
                    <li><a href="{{url('/portaria')}}">Livro de Acesso</a></li>
                    <li><a href="{{url('/recados')}}">Mural de Recados</a></li>
                    <li><a href="{{url('/eventos')}}">Calendário Eventos</a></li>
                    <li><a href="{{url('/servicos')}}">Serviços</a></li>
                    <li><a href="{{url('/prestadores')}}">Prestadores de Serviços</a></li>
                    <li><a href="{{url('/solicitacoes')}}">Solicitacoes</a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-map-marker"></i> Portaria <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="{{url('/eventos')}}">Calendário Eventos</a></li>
                    <li><a href="{{url('/portaria')}}">Livro de Acesso</a></li>
                    <li><a href="{{url('/recados')}}">Mural de Recados</a></li>
                    <li><a href="{{url('/servicos')}}">Serviços</a></li>
                    <li><a href="{{url('/prestadores')}}">Prestadores de Serviços</a></li>
                    <li><a href="{{url('/solicitacoes')}}">Solicitacoes</a></li>
                  </ul>
                </li>
                <li>
                  <a><i class="fa fa-table"></i> Condôminos <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="{{url('/reservas')}}">Reserva de Salão</a></li>
                    <li><a href="{{url('/portaria')}}">Livro de Acesso</a></li>
                    <li><a href="{{url('/contrato')}}">Download Contrato</a></li>
                    <li><a href="{{url('/solicitacoes')}}">Solicitacoes</a></li>
                    <li><a href="javascript:;">2ª via Boleto (OFF)</a></li>
                  </ul>
                </li>
              </ul>
            </div>
            <div class="menu_section">
              <ul class="nav side-menu">
                <li><a href="{{url('/logout')}}"><i class="fa fa-close"></i> Sair </a></li>
              </ul>
            </div>

          </div>
          <!-- /sidebar menu -->

        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu">
          <nav class="" role="navigation">
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  @if(auth()->user()->dados_pessoais->foto_url)
                    <img src="{{url('uploads/pessoas') .  auth()->user()->dados_pessoais->foto_url }}" alt="...">
                  @else
                    <img src="{{url('uploads/pessoas/default.png')}}" alt="..." >
                  @endif
                  {{auth()->user()->dados_pessoais->nome }}
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="javascript:;"> Perfil</a></li>

                  <li><a href="{{url('/logout')}}"><i class="fa fa-sign-out pull-right"></i> Sair</a></li>
                </ul>
              </li>

            </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->

      <!-- page content -->
      @yield('content')
      <!-- /page content -->

      <!-- footer content -->
      <footer>
        <div class="pull-right">
          Desenvolvido por: <a href="https://www.agenciaativa.com.br">Agência Ativa</a>
        </div>
        <div class="clearfix"></div>
      </footer>
      <!-- /footer content -->
    </div>
  </div>

  <!-- jQuery -->
  <script src="{{url('/vendors/jquery/dist/jquery.min.js')}}"></script>
  <!-- Bootstrap -->
  <script src="{{url('/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>

  <!-- Custom Theme Scripts -->
  <script src="{{url('/build/js/custom.min.js')}}"></script>
  <script src="{{url('/assets/js/sweetalert.min.js')}}"></script>
  <script src="{{url('/assets/js/bootstrap-select.min.js')}}"></script>
  <script src="{{url('/assets/js/jquery.mask.min.js')}}"></script>

  <!-- VUE JS Sripts -->
  <script src="{{url('/assets/js/vue.min.js')}}"></script>
  <script src="{{url('/assets/js/vue-resource.min.js')}}"></script>
  <script src="{{url('/assets/js/vue-strap.min.js')}}"></script>


  <script type="text/javascript">
  $('.data_mask').mask('00/00/0000');
  $('.cpf_mask').mask('000.000.000-00', {reverse: true});
  $('.cnpj_mask').mask('00.000.000/0000-00', {reverse: true});
  $('.cep_mask').mask('00000-000');
  $('.placa_mask').mask('AAA-0000');
  $('.fone_mask').mask('(00)0000-0000');
  var maskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
  },
  options = {onKeyPress: function(val, e, field, options) {
    field.mask(maskBehavior.apply({}, arguments), options);
  }};

  $('.cel_mask').mask(maskBehavior, options);
  </script>

  @stack('script_level')

</script>
<!-- /Starrr -->
</body>
</html>
