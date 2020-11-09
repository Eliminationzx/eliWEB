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
                <strong>Edición de código promocional</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Formulario de edición de código promocional</h5>
				</div>
                <div class="ibox-content">

                    <form action="{{ route('admin.promocodes.update') }}" method="POST" role="form">
                        {{csrf_field()}}
                        <input type="hidden" class="form-control" name="codeid" value="{{$promocode->id}}">

                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" name="name" id=""
                                   value="{{$promocode->name}}" placeholder="Nombre...">
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
                            <input type="text" class="form-control" name="code" id="" placeholder="Código..." value="{{$promocode->code}}">
                        </div>
                        
                        <div class="form-group">
                            <label for="data0">data0</label>
                            <input type="text" class="form-control" name="data0" id="" placeholder="data0..." value="{{$promocode->data0}}">
                        </div>
                        
                        <div class="form-group">
                            <label for="data1">data1</label>
                            <input type="text" class="form-control" name="data1" id="" placeholder="data1..." value="{{$promocode->data1}}">
                        </div>
                        
                        <div class="form-group">
                            <label for="usage_count">Numero de usos</label>
                            <input type="text" class="form-control" name="usage_count" id="" placeholder="Numero de usos..." value="{{$promocode->usage_count}}">
                        </div>
                        
                        <div class="form-group">
                            <label for="unused_date">Tiempo de acción</label>
                            <input type="datetime-local" class="form-control" name="unused_date" id="">
                        </div>
                        
                        <div class="form-group">
                            <label for="realmid">Reino:</label>
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