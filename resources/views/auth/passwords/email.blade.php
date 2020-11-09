@extends('layouts.admin')

@section('content')
@section('bodyclass')
    <body class="gray-bg">
@endsection
    <div class="middle-box text-center loginscreen animated fadeInDown ">
         <div>
            <div>

                <h3 class="logo-name">{{config('app.name_short')}}</h3>

            </div>
            <h3>Solicitud de recuperación de contraseña</h3>
            
            @if ( session('status'))
                <div class="row">
                      <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                </div>
            @endif
            
            <form class="m-t" method="POST" action="{{ url('/password/email') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                           placeholder="E-mail" required autofocus>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif

                </div>
                
                <button type="submit" class="btn btn-primary block full-width m-b">Enviar</button>

                <p class="text-muted text-center">
                    <small>¿No tienes una cuenta?</small>
                </p>
                <a class="btn btn-sm btn-white btn-block" href="{{ url('/register') }}">Crea una cuenta</a>
				<p class="text-muted text-center">
                    <small>Ya tienes una cuenta?</small>
                </p>
                <a class="btn btn-sm btn-white btn-block" href="{{ url('/login') }}">Iniciar sesión</a>
            </form>
            <p class="m-t">
                <small>&copy; {{now()->year.' '.config('app.name_prj')}}</small>
            </p>
        </div>
    </div>
@endsection