@extends('app')

@section('content')
  <!-- page content -->
  <div class="right_col" role="main" id="appvue">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Gerenciamento de Dependentes</h3>
        </div>

      </div>
      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>{{  Request::is('*/editar') ? "Alteração": "Cadastro" }}</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li class="list"><a href="{{url('moradores')}}" class="collapse-link" title="Voltar" ><i class="fa fa-reply-all"></i> Moradores</a></li>
                <li class="divider"></li>
                <li class="list">
                  <a href="{{ url('morador/'.$morador->id.'/dependentes') }}" data-toggle="tooltip" data-placement="left" title="Listar" class="collapse-link" title="Listar" >
                    <i class="fa fa-list"></i> Dependentes
                  </a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">

              <p>Para listar os dependentes cadastrados de <b>{{$morador->nome}}</b>, clique no botão na barra acima</p>
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
                {!! Form::model($dependente, ['url' => 'morador/'.$morador->id.'/dependente/'.$dependente->id.'/editar','class' => 'form-horizontal form-label-left', 'method' => 'PUT']) !!}
              @else
                {{-- incluindo POST --}}
                {!! Form::open(['url' => 'morador/'.$morador->id.'/dependente/novo', 'class' => 'form-horizontal form-label-left']) !!}
              @endif

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

              <!-- DtNasc Form Input -->
              <div class="form-group">
                {!! Form::label('data_nascimento', 'Data Nascimento:',['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
                <div class="col-md-6 col-sm-6 col-xs-12">
                  {!! Form::text('data_nascimento', null, ['class'=>'form-control col-md-7  data_mask']) !!}
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

  </script>
@endpush
