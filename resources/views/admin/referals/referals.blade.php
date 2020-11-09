@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-12">
            <h2>Reclutar amigo </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('personal') }}">Inicio</a>
                </li>  
                <li class="active">
                    <strong>Reclutar amigo </strong>
                </li> 
            </ol>
        </div>
    </div>
    <div class="chat-message left">
        <div class="message">
			<h2>Términos del sistema de Reclutar amigo</h2>
            <div class="alert alert-info" >
            Estimado {{$data->name}}, para obtener {{ $reward->value }} D en su cuenta, debe cumplir 3 condiciones:
            <ol>
                <li> Su amigo debe registrarse utilizando su enlace de referencia o ingresar manualmente el nombre de su cuenta cuando se registre. </li>
                <li> Tu amigo debe alcanzar el nivel máximo por cualquier personaje </li>
                <li> Tu amigo debe pasar al menos 12 horas en el juego </li>
            </ol>
            Después de la confirmación del cumplimiento de todas las condiciones en el gabinete personal, su cuenta será acreditada con {{ $reward->value }} D.<br/>
            <b>Nota</b>: Las bonificaciones del sistema se aplican a las cuentas vinculadas. <a href="#" target="_blank"> Invitar a un amigo</a>.
            </div>
            <h2>Tu enlace de referencia</h2>
            <span class="message-content">
                <div class="alert alert-success alert-dismissable" id="copytext">{{ config('app.url').'/register/'.$data->name }}</div>
                <button class="btn btn-block btn-outline btn-primary" data-clipboard-target="#copytext"><i class="fa fa-copy"></i> Copiar link</button>
            </span>
        </div>
    </div>

    @if($referalsinfo != null)
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
                        <h5>Your referrals ({{ count($referalsinfo) }})</h5>
                    </div>
                    <div class="ibox-content">

                    <div class="project-list">
                    @foreach($referalsinfo as $referalsinf)
                    <div class="ibox">
                        <div class="ibox-title">
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <h5 style="color: #333234">{{ $referalsinf['names'] }}</h5>
                                </a>
                                @if($referalsinf['complete'])
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                        <button type="submit" class="btn btn-success btn-xs">The system conditions are fulfilled, donation points have been calculated.</button>
                                    </a>
                                @endif
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content" style="display: none;">

                            <div class="project-list">
                               <div class="row">
								@if ($referalsinf['userinfo'] != null)
								  @foreach($referalsinf['userinfo'] as $userinfos)
										<div class="col-md-3" id="{{ $userinfos->guid }}">
											<div class="ibox">
												<div class="ibox-content product-box">
													<div class="product-imitation" style="background: url({{ URL::asset('admin/img/faction/'.$userinfos->factionid.'.png') }}) left top no-repeat;"> 
                                                        <wow-tooltip-charinfo-content 
															data-charinfo-faction="{{ 'Fraction: '.($userinfos->factionid == 0 ? 'Alliance' : 'Horde')}}"
															data-charinfo-race="{{ 'Race: '.$userinfos->race_name }}"
															data-charinfo-class="{{ 'Class: '.$userinfos->class_name }}"
															data-charinfo-level="{{ 'Level: '.$userinfos->level.' / '.$userinfos->realm_maxlvl }}"
															data-charinfo-gold="{{ 'Money: '.round($userinfos->money / 10000, 2) }}"
															data-charinfo-playtime="{{ 'Playing time: '.$userinfos->play_time}}">												
															<img alt="image" class="tooltip-icon-large-prev" src="{{ URL::asset('admin/img/race/'.$userinfos->race.'_'.$userinfos->gender.'.png') }}">
														</wow-tooltip-charinfo-content>
													</div>
													<div class="product-desc">
														<span class="product-price">
															{{$userinfos->level}} level
														</span>
														<img alt="image" class="product-adt" src="{{ URL::asset('admin/img/class/'.$userinfos->class.'.png') }}">
														<div class="dropdown product-name-simple">
														{{$userinfos->name}}
															<a data-toggle="dropdown" class=" btn dropdown-toggle" href="#"><i class="fa fa-cogs"></i></a>
																<ul class="dropdown-menu animated fadeInLeft m-t-xs">
																	@if($server != 'vanilla')
																	<form method="POST" action="{{ route('characters.race') }}"
																		  class="form-horizontal" enctype="multipart/form-data">

																		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
																		<input type="hidden" name="guid" id="guid" value="{{$userinfos->guid.','.$userinfos->realm_id}}">
																		<button type="submit" class="btn btn-w-m btn-link btn-sm">Change race</button>
																	</form>
																	<form method="POST" action="{{ route('characters.faction') }}"
																		  class="form-horizontal" enctype="multipart/form-data">

																		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
																		<input type="hidden" name="guid" id="guid" value="{{$userinfos->guid.','.$userinfos->realm_id}}">
																		<button type="submit" class="btn btn-w-m btn-link btn-sm">Change fraction</button>
																	</form>
																	<form method="POST" action="{{ route('characters.name') }}"
																		  class="form-horizontal" enctype="multipart/form-data">

																		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
																		<input type="hidden" name="guid" id="guid" value="{{$userinfos->guid.','.$userinfos->realm_id}}">
																		<button type="submit" class="btn btn-w-m btn-link btn-sm">Change name</button>
																	</form>
																	<form method="POST" action="{{ route('characters.repair') }}"
																		  class="form-horizontal" enctype="multipart/form-data">

																		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
																		<input type="hidden" name="guid" id="guid" value="{{$userinfos->guid.','.$userinfos->realm_id}}">
																		<button type="submit" class="btn btn-w-m btn-link btn-sm">Repair</button>
																	</form>
																	@endif
																</ul>
													    </div>
														<span class="label label">{{ $userinfos->realm_name }}</span>
														<span class="label label-{{ ($userinfos->online == '1') ? 'primary' : 'danger'}}">{{ ($userinfos->online == '1') ? 'Online' : 'Offline'}}</span>
													</div>
												</div>
											</div>
										</div>
									@endforeach
									@endif
								</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
