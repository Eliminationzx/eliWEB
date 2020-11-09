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
            @if ( session('status'))
                <div class="row">
                        <div class="alert alert-{{ session('type') }}">
                            {{ session('status') }}
                        </div>
                </div>
            @endif
            
            <form class="m-t" method="POST" action="{{ url('/login') }}">
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

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input id="password" type="password" class="form-control" name="password" placeholder="Introducir la contraseña"
                           required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                
                <button type="submit" class="btn btn-primary block full-width m-b">Iniciar sesión</button>

                <a href="{{ url('/password/reset') }}">
                    <small>¿Olvidaste tu contraseña?</small>
                </a>
                <p class="text-muted text-center">
                    <small>¿No tienes una cuenta?</small>
                </p>
                <a class="btn btn-sm btn-white btn-block" href="{{ url('/register') }}">Crea una cuenta</a>
            </form>
            <p class="m-t">
                <small>&copy; {{now()->year.' '.config('app.name_prj')}}</small>
            </p>
        </div>
    </div>
@endsection
