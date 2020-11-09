@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Cambio de contraseña</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('personal') }}">Inicio</a>
                </li> 
                <li>
                    Cuenta
                </li>  
                <li class="active">
                    <strong>Cambio de contraseña</strong>
                </li> 
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
	  @if ( session('status'))
			<div class="row">
				<div class="col-lg-12">
					<div class="alert alert-{{ session('type') }} alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						<span class="alert-link">{{ session('status') }}</span>
					</div>
				</div>
			</div>
		@endif
		
        <div class="row">
            <div class="col-lg-12">

                <div class="ibox">
					<div class="ibox-title">
						<h5>Formulario de cambio de contraseña</h5>
					</div>
                    <div class="ibox-content">

                        <div class="project-list">
                            <form method="POST" action="{{ route('accounts.passwords') }}"
                                  class="form-horizontal" enctype="multipart/form-data">

                                <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">

                                <div class="form-group">
                                    <label class="col-sm-12 b-r-xl">Contraseña anterior:</label>
                                    <div class="col-sm-12 b-r-xl" > <input type="password" class="form-control" name="OldPassword" id="OldPassword"
                                                                           value="" required>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-12">Nueva contraseña:</label>
                                    <div class="col-sm-12"><input type="password" class="form-control" name="NewPassword"
                                                                  id="NewPassword"
                                                                  value="" required></div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12">Confirmar contraseña:</label>
                                    <div class="col-sm-12"><input type="password" class="form-control" name="ConfrimPassword"
                                                                  id="ConfrimPassword"
                                                                  value="" required></div>
                                </div>

                                <div class="form-group ">
                                    <div class="col-sm-12">
                                        <button class="btn btn-block btn-outline btn-primary">Guardar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>


@endsection
