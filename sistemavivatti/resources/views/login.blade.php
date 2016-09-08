<!DOCTYPE HTML>
<html lang="">
<head>
  <meta charset="UTF-8">
  <title>Vitatti - Sistema de Condomínios</title>
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/estilo.css')}}">
</head>

<body>
  <h2>Sistema Inteligente para Gestão de condomínios</h2>

  <div class="bg-blue">
    <form name="log" method="post" action="{{url('/login')}}">
      {{ csrf_field() }}
      <input id="login" type="text" name="login" placeholder="Login" maxlength="12" value="{{ old('login') }}">
      <input id="senha" type="password" name="senha" placeholder="******" maxlength="8">
      <input type="submit" name="envia" value="Entrar">
      <a href="" title="Esqueci minha senha">Esqueceu a senha? <i>Clique aqui</i></a>
    </form>
  </div>

  <img src="{{asset('assets/img/logo.png')}}" width="200" class="logo">
</body>
</html>
