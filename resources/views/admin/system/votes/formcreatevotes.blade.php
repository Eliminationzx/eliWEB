@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Crea un top de votación</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('personal') }}">Inicio</a>
            </li>
            <li>
                Sistema
            </li>
            <li>
                Tops de votación
            </li>
            <li class="active">
                <strong>Crea un top de votación</strong>
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
					<h5>Formulario de votación superior</h5>
				</div>
                <div class="ibox-content">
                    <form action="{{ route('admin.votes.create') }}" method="POST" role="form" enctype="multipart/form-data">
                        {{csrf_field()}}
                        
                        <div class="form-group">
                            <label for="vote_name">Nombre</label>
                            <input type="text" class="form-control" name="vote_name" placeholder="Nombre...">
                        </div>

                        <div class="form-group">
                            <label for="vote_descr">Descripción</label>
                            <input type="text" class="form-control" name="vote_descr" placeholder="Descripción...">
                        </div>
						
                        <div class="form-group">
                            <label for="vote_img">Imagen</label>
                            <input type="file" class="form-control" name="vote_img">
                        </div>

                        <div class="form-group">
                            <label for="vote_reward">Recompensa</label>
                            <input type="text" class="form-control" name="vote_reward" placeholder="Recompensa..." value="0">
                        </div>
						
						<div class="form-group">
                            <label for="vote_url">Enlace de votación </label>
                            <input type="text" class="form-control" name="vote_url" placeholder="Enlace de votación...">
                        </div>
                                                                       
                        <div class="form-group">
                            <label for="hostname">Hostname</label>
                            <input type="text" class="form-control" name="hostname" id="" placeholder="Hostname...">
                        </div>
						
					    @for($i = 1; $i <= 5; $i++)
					    <div class="form-group">
                            <label for="{{'vote_log'.$i}}">vote log {{'#'.$i}}</label>
                            <input type="text" class="form-control" name="{{'vote_log'.$i}}" placeholder="{{'Enlace para registro de votación #'.$i.'...'}}">
                        </div>
						@endfor
                        
                        <div class="form-group">
                            <label for="inputs">Inputs</label>
                            <input type="text" class="form-control" name="inputs" placeholder="Inputs...">
                        </div>
                        
                        <div class="form-group text-left">
						    <h3>Estado de activación</h3>
                            <div class="i-checks">
							<label>
                                    <input type="checkbox" "" name="status">
							</label>
							</div>

                        </div>
                        
                        <div class="form-group text-left">
						    <h3>Clickable only</h3>
                            <div class="i-checks">
							<label>
                                    <input type="checkbox" "" name="clickable_only">
							</label>
							</div>

                        </div>
                        
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection