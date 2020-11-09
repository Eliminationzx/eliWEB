@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Edición de roles</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('personal') }}">Inicio</a>
            </li>
            <li>
                Sistema
            </li>
            <li>
                Roles
            </li>
            <li class="active">
                <strong>Edición de roles</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Formulario de edición de roles</h5>
				</div>
                <div class="ibox-content">

                    <form action="{{ route('admin.roles.update') }}" method="POST" role="form">
                        {{csrf_field()}}
                        <input type="hidden" class="form-control" name="roleid" value="{{$role->id}}">

                        <div class="form-group">
                            <label for="display_name">Nombre para mostrar</label>
                            <input type="text" class="form-control" name="display_name" id=""
                                   value="{{$role->display_name}}" placeholder="Nombre para mostrar...">
                        </div>

                        <div class="form-group">
                            <label for="name">Variable</label>
                            <input type="text" class="form-control" name="name" id="" placeholder="Variable..."
                                   value="{{$role->name}}">
                        </div>

                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <input type="text" class="form-control" name="description" id="" placeholder="Descripción..."
                                   value="{{$role->description}}">
                        </div>

                        <div class="form-group text-left">
                            <h3>Privilegios</h3>
                            @foreach($permissions as $permission)
                                <div class="i-checks"><label>
                                        <input type="checkbox"
                                               {{in_array($permission->id,$role_permissions)?"checked":""}}   name="permission[]"
                                               value="{{$permission->id}}">
                                        <i></i> {{$permission->display_name}} </label></div>

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