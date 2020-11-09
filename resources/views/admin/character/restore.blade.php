@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Restore</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('personal') }}">Inicio</a>
                </li> 
                <li>
                    Personaje
                </li>  
                <li class="active">
                    <strong>Restore</strong>
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
						<h5>Character restoration form</h5>
					</div>
                    <div class="ibox-content">

                        <div class="project-list">
                            <form method="POST" action="{{ route('characters.repair') }}"
                                  class="form-horizontal" enctype="multipart/form-data">

                                <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">

                                <div class="form-group">
                                    <label class="col-sm-3">Personajes:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group col-sm-12">
                                            <div>
                                                <select name="guid" data-placeholder="Elige un personaje ..." class="chosen-select"  tabindex="2">
													@if($deletedcharinfo != null)
														@foreach($deletedcharinfo as $deletedcharinf)
															<option value="{{ $deletedcharinf->guid.','.$deletedcharinf->realm_id }}">{{ $deletedcharinf->name }} ({{ $deletedcharinf->realm_name }})</option>
														@endforeach
													@endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-block btn-outline btn-primary">Restore</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>


@endsection
