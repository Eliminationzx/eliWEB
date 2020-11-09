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
            <h3>Password reset form</h3>
            
            @if ( session('status'))
                <div class="row">
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                </div>
            @endif
            
            <form class="m-t" method="POST" action="{{ url('/password/reset') }}">
                {{ csrf_field() }}
				<input type="hidden" name="token" value="{{ $token }}">
				   
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}"
                           placeholder="E-mail" required autofocus>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif

                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input id="password" type="password" class="form-control" name="password" placeholder="Enter password"
                           required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
				
				<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password"
                           required>

                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                
                <button type="submit" class="btn btn-primary block full-width m-b">Reset Password</button>
            </form>
            <p class="m-t">
                <small>&copy; {{now()->year.' '.config('app.name_prj')}}</small>
            </p>
        </div>
    </div>
@endsection