@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Códigos promocionales</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('personal') }}">Inicio</a>
            </li>
            <li>
                Sistema
            </li>
            <li>
                Códigos promocionales
            </li>
            <li class="active">
                <strong>Crea un nuevo código promocional</strong>
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
					<h5>Formulario de código promocional</h5>
				</div>
                <div class="ibox-content">
                    <form action="{{ route('admin.promocodes.create') }}" method="POST" role="form">
                        {{csrf_field()}}
                        
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" name="name" placeholder="Nombre...">
                        </div>

                        <div class="form-group">
                            <label for="typeid">Un tipo:</label>
                            <select name="typeid" data-placeholder="Elige tipo..." class="chosen-select"  tabindex="2">
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="code">Código</label>
                            <input type="text" class="form-control" name="code" placeholder="Código...">
                        </div>
                        
                        <div class="form-group">
                            <label for="data0">data0</label>
                            <input type="text" class="form-control" name="data0" value="0" placeholder="data0...">
                        </div>
                        
                        <div class="form-group">
                            <label for="data1">data1</label>
                            <input type="text" class="form-control" name="data1" value="0" placeholder="data1...">
                        </div>
                        
                        <div class="form-group">
                            <label for="usage_count">Numero de usos</label>
                            <input type="text" class="form-control" name="usage_count" value="-1" placeholder="Numero de usos...">
                        </div>
                        
                        <div class="form-group">
                            <label for="unused_date">Tiempo de acción</label>
                            <input type="datetime-local" class="form-control" name="unused_date">
                        </div>
                        
                        <div class="form-group">
                            <label for="realmid">Реалм:</label>
                            <select name="realmid" data-placeholder="Выберите сервер..." class="chosen-select"  tabindex="2">
                                    @foreach($realminfos as $realminfo )
                                        <option value="{{ $realminfo->realmid }}">{{ $realminfo->name }}</option>
                                    @endforeach
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection