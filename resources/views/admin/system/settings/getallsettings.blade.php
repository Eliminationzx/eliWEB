@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Configuraciones</h2>
            <ol class="breadcrumb">
            <li>
                <a href="{{ route('personal') }}">Inicio</a>
            </li> 
            <li>
                Sistema
            </li>
            <li class="active">
                <strong>Configuraciones</strong>
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
						<h5>Lista de ajustes</h5>
					</div>
                    <div class="ibox-content">

                        <div class="project-list">
                            <form method="POST" action="{{ route('admin.settings') }}"
                                  class="form-horizontal" enctype="multipart/form-data">

                                <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
                                @foreach($settings as $setting)
                                <div class="form-group">
                                    <label class="col-sm-12 b-r-xl">{{ $setting->local }}</label>
                                    <div class="col-sm-12 b-r-xl" > <input type="text" class="form-control" name="{{ $setting->key }}" id="{{ $setting->key }}"
                                                                           value="{{ $setting->value }}" required>
                                    </div>
                                </div>
								@endforeach

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
