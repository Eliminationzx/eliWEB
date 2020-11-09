@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Creando roles</h2>
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
                <strong>Creando roles</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    @if (isset($data['result']))
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-info alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <span class="alert-link">{{ $data['result'] }}</span>
                    .
                </div>
            </div>
        </div>
    @endif


    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Formulario de creación de roles</h5>
				</div>
                <div class="ibox-content">
                    <form action="{{ route('admin.roles.create') }}" method="POST" role="form">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" name="name" id="" placeholder="Nombre...">
                        </div>
                        <div class="form-group">
                            <label for="display_name">Nombre para mostrar</label>
                            <input type="text" class="form-control" name="display_name" id="" placeholder="Nombre para mostrar...">
                        </div>
                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <input type="text" class="form-control" name="description" id="" placeholder="Descripción...">
                        </div>
						
                        <div class="form-group text-left">
                            <h3>Privilegios</h3>
                            @foreach($permissions as $permission)
                                <div class="i-checks"><label> <input type="checkbox"   name="permission[]" value="{{$permission->id}}"> <i></i> {{$permission->display_name}} </label></div>
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