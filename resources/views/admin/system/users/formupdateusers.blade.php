@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Edición de usuario</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('personal') }}">Inicio</a>
            </li>
            <li>
                Sistema
            </li>
            <li>
                Usuarios
            </li>
            <li class="active">
                <strong>Edición de usuario</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    @if ( session('status'))
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-info alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <span class="alert-link">{{ session('status') }}</span>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Formulario de edición del usuario</h5>
				</div>
                <div class="ibox-content">
                    <form action="{{ route('admin.users.update') }}" method="POST" role="form">
                        {{csrf_field()}}
                        <input type="hidden" class="form-control" name="usersid" value="{{$user->id}}">

                        <div class="form-group">
                            <label for="username">Usuario</label>
                            <input type="text" class="form-control" name="username" id=""
                                   value="{{$user->name}}" placeholder="Usuario...">
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="text" class="form-control" name="email" id="" placeholder="E-mail..."
                                   value="{{$user->email}}">
                        </div>
						
                        <div class="form-group">
                            <label for="password">Nueva contraseña</label>
                            <input type="password" class="form-control" name="password" id="" placeholder="Nueva contraseña..."
                                   value="">
                        </div>

                        <div class="form-group">
                            <label for="repeatpassword">Confirma la contraseña</label>
                            <input type="password" class="form-control" name="repeatpassword" id="" placeholder="Confirmación de contraseña..."
                                   value="">
                        </div>
						 
						@foreach (explode(',', env('APP_GAME_SERVER_LIST')) as $server)
							<div class="form-group">
								<label for="{{ 'userid_'.$server }}">{{$server.' id'}}</label>
								<input type="text" class="form-control" name="{{ 'userid_'.$server }}" id="" placeholder="ID de la cuenta ..."
									   value="{{$user['userid_'.$server]}}">
							</div>
						@endforeach
						
						<div class="form-group">
                            <label for="donate">Puntos de donación</label>
                            <input type="text" class="form-control" name="donate" id="" placeholder="Número de donación...."
                                   value="{{$user->donate}}">
                        </div>
						
						<div class="form-group">
                            <label for="vote">Puntos de votación</label>
                            <input type="text" class="form-control" name="vote" id="" placeholder="Numero de votos...."
                                   value="{{$user->vote}}">
                        </div>
						
						<div class="form-group text-left">
						    <h3>Estado de activación</h3>
                            <div class="i-checks">
							<label>
                                    <input type="checkbox" {{$user->status == 1 ? "checked":""}} name="status" value="{{$user->status}}">
							</label>
							</div>

                        </div>

                        <div class="form-group text-left">
                            <h3>Grupo</h3>
                            @foreach($roles as $role)
                                <div class="i-checks">
								<label>
                                        <input type="checkbox"
                                               {{in_array($role->id,$role_permissions)?"checked":""}} name="role[]"
                                               value="{{$role->id}}">
                                        {{$role->display_name}} </label>
							    </div>

                            @endforeach
                        </div>
						
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>

                </div>

            </div>

        </div>
    </div>


</div>
@endsection