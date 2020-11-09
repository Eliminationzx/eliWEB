@extends('layouts.admin')
@section('content')
@section('bodyclass')
<body>
@endsection
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-12">
            <h2>Bienvenido {{ $data->name }}</h2>
        </div>
        <div class="col-lg-6">
            @if ($ipbaninfo != null)
            <div class="widget style1 red-bg">
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-desktop fa-5x"></i>
                    </div>

                    <div class="col-xs-10 text-right">
                        <h3>IP:</h3>
                        <h2 class="font-bold">{{ $ip }}</h2>
                        <h3 class="font-bold">{{$ipbaninfo[0]['unbandate'] > 0 ? 'until '. date("d.m.Y", $ipbaninfo[0]['unbandate']) : 'permamentally'}}</h3>
                    </div>

                </div>
            </div>
            @else
                <div class="widget style1 gray-bg">
                    <div class="row">
                        <div class="col-xs-2">
                            <i class="fa fa-desktop fa-5x"></i>
                        </div>

                        <div class="col-xs-10 text-right">
                            <h3>IP</h3>
                            <h2 class="font-bold">{{ $ip }}</h2>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-lg-6">
            <div class="widget style1 gray-bg">
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-money fa-5x"></i>
                    </div>
                    
                    <div class="col-xs-10 text-right">
                        <h3>Saldo actual</h3>   
                        <h2 class="font-bold">{{$data->donate}} PD /  {{$data->vote}} PV</h2>
                        <a href="{{ route('donate') }}" class="btn btn-xs btn-outline btn-white"> Donar </a>
                        <a href="{{ route('votes') }}" class="btn btn-xs btn-outline btn-white"> Votar </a>
                    </div>

                </div>
            </div>
        </div>
        @if ($recruiterdata != null)
        <div class="col-lg-6">
            <div class="widget style1 gray-bg">
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-compress fa-5x"></i>
                    </div>

                    <div class="col-xs-10 text-right">
                        <h3>Linked account</h3>           
                        <h2 class="font-bold">{{ $recruiterdata->name }}</h2>
                    </div>

                </div>
            </div>
        </div>
        @endif
		@if ($accountbaninfo != null)
        <div class="col-lg-6">
	        @if ($accountbaninfo[0]['active'] == 1)
            <div class="widget style1 red-bg">
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-ban fa-5x"></i>
                    </div>

                    <div class="col-xs-10 text-right">
                        <h3>Account status</h3>
                        <h2 class="font-bold">blocked</h2>
                        <h3 class="font-bold">{{$accountbaninfo[0]['unbandate'] > 0 ? 'until '. date("d.m.Y", $accountbaninfo[0]['unbandate']) : 'permamentally'}}</h3>
                    </div>

                </div>
            </div>
            @else
            <div class="widget style1 navy-bg">
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-check fa-5x"></i>
                    </div>

                    <div class="col-xs-10 text-right">
                        <h3>Account status</h3>
                        <h2 class="font-bold">not blocked</h2>
                    </div>

                </div>
            </div>
            @endif
        </div>
        @endif
        <!--		
        <div class="col-lg-6">
            @if ($premiuminfo != null AND $premiuminfo[0]['active'] == 1)
            <div class="widget style1 yellow-bg">
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-star-o fa-5x"></i>
                    </div>

                    <div class="col-xs-10 text-right">
                        <h3>Estado premium rango {{$premiuminfo[0]['premium_type']}}</h3>
                        <h2 class="font-bold">Activo</h2>
                        <h3 class="font-bold">Hasta {{date("d-m-Y H:i:s", $premiuminfo[0]['unsetdate'])}} </h3>
                    </div>

                </div>
            </div>
            @else
            <div class="widget style1 lazur-bg">
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-star-o fa-5x"></i>
                    </div>

                    <div class="col-xs-10 text-right">
                        <h3>Estado premium</h3>
                        <h2 class="font-bold">Inactivo</h2>
                    </div>

                </div>
            </div>
            @endif
        </div>
        -->   
        @if ($accgameinfo != null)		
        <div class="col-lg-6">
            @if ($accgameinfo[0]['mutetime'] == 0)
            <div class="widget style1 navy-bg">
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>

                    <div class="col-xs-10 text-right">
                        <h3>Estado del chat del juego</h3>
                        <h2 class="font-bold">Disponible</h2>
                    </div>
                </div>

            </div>
            @else
            <div class="widget style1 red-bg">
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-ban fa-5x"></i>
                    </div>

                    <div class="col-xs-10 text-right">
                        <h3>Estado del chat del juego</h3>
                        <h2 class="font-bold">Silenciado</h2>
                        <h3 class="font-bold">{{$accgameinfo[0]['mutetime'] < 0 ? 'forever' : 'for '. date("Hh im ss", $accgameinfo[0]['mutetime'])}}<h3>
                    </div>

                </div>
            </div>
            @endif
        </div>
		@endif
		@if ($accgameinfo != null AND 
		     $sumplaytime != null AND
			 $accgameinfo[0]['last_login'] != null AND 
			 $accgameinfo[0]['last_ip'] != null)
        <div class="col-lg-6">
            <div class="widget style1 gray-bg">
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-clock-o fa-5x"></i>
                    </div>

                    <div class="col-xs-10 text-right">
						 <h3>Tiempo pasado en el juego.</h3>
						 <h2 class="font-bold">{{ $sumplaytime }}</h2>
						 <h4 class="font-bold">Último acceso {{ $accgameinfo[0]['last_login'] }} IP {{ $accgameinfo[0]['last_ip'] }}</h4>
                    </div>

                </div>
            </div>
        </div>
		@endif
    </div>	
	
    <div class="chat-message left">
        <div class="message">
            <h2>Tu enlace de referencia</h2>
            <span class="message-content">
                    <div class="alert alert-success alert-dismissable" id="copytext">{{ config('app.url').'/register/'.$data->name }}</div>
                <button class="btn btn-block btn-outline btn-primary" data-clipboard-target="#copytext"><i class="fa fa-copy"></i> Copiar link</button>
                <a href="{{ route('referals') }}" class="btn btn-block btn-outline btn-primary">Términos del sistema de referencia</a>
            </span>
        </div>
    </div>
	
	@if ($realminfos != null)
	<div class="chat-message left">
        <div class="message">
            <h2>Estadísticas del mundo</h2>
            <span class="message-content">
                @foreach($realminfos as $realminfo)
				<b class="left">{{ $realminfo->name.' ('.$realminfo->online.' / '.$realminfo->plr_max.')'}}</b>
				<div class="progress progress-large">
				    @if ($realminfo->status == 'offline')
						<div style="width: 100%" class="{{ ($realminfo->status == 'online') ? 'progress-bar' : 'progress-bar progress-bar-danger'}}"></div>
					@else
						<div style="width:{{ $realminfo->online / $realminfo->plr_max * 100 }}%" class="progress-bar"></div>
				    @endif
				</div>
				@endforeach
            </span>
        </div>
    </div>
	@endif
	
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <h5 style="color: #333234">Lista de personajes ({{$userinfo == null ? 0 : count($userinfo)}})</h5>
                                </a>
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
						
                        <div class="ibox-content" style="display: yes;">
							<div class="project-list">
								<div class="row">
								@if ($userinfo != null)
								  @foreach($userinfo as $userinfos) 
										<div class="col-md-3" id="{{ $userinfos->guid }}">
											<div class="ibox">
												<div class="ibox-content product-box">
													<div class="dropdown">												
															<a data-toggle="dropdown" class="btn dropdown-toggle" href="#"><i class="fa fa-cogs fa-2x"></i></a>
																<ul class="dropdown-menu animated fadeInLeft m-t-xs">
																	@if($server != 'vanilla')
																	<form method="POST" action="{{ route('characters.race') }}"
																		  class="form-horizontal" enctype="multipart/form-data">
																		  
																		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
																		<input type="hidden" name="guid" id="guid" value="{{$userinfos->guid.','.$userinfos->realm_id}}">
																		<button type="submit" class="btn btn-link btn-sm">Cambio de raza</button>
																	</form>
																	<form method="POST" action="{{ route('characters.faction') }}"
																		  class="form-horizontal" enctype="multipart/form-data">

																		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
																		<input type="hidden" name="guid" id="guid" value="{{$userinfos->guid.','.$userinfos->realm_id}}">
																		<button type="submit" class="btn btn-link btn-sm">Cambiar fracción</button>
																	</form>
																	<form method="POST" action="{{ route('characters.name') }}"
																		  class="form-horizontal" enctype="multipart/form-data">

																		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
																		<input type="hidden" name="guid" id="guid" value="{{$userinfos->guid.','.$userinfos->realm_id}}">
																		<button type="submit" class="btn btn-link btn-sm">Cambiar nombre</button>
																	</form>
																	<form method="POST" action="{{ route('characters.repair') }}"
																		  class="form-horizontal" enctype="multipart/form-data">

																		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
																		<input type="hidden" name="guid" id="guid" value="{{$userinfos->guid.','.$userinfos->realm_id}}">
																		<button type="submit" class="btn btn-link btn-sm">Reparar</button>
																	</form>
																	@endif
																</ul>
													 </div>
													<div class="product-imitation" style="background: url({{ URL::asset('admin/img/faction/'.$userinfos->factionid.'.png') }}) left top no-repeat;"> 
                                                        <wow-tooltip-charinfo-content 
															data-charinfo-faction="{{ 'Faction: '.($userinfos->factionid == 0 ? 'Alliance' : 'Horde')}}"
															data-charinfo-race="{{ 'Race: '.$userinfos->race_name }}"
															data-charinfo-class="{{ 'Class: '.$userinfos->class_name }}"
															data-charinfo-level="{{ 'Level: '.$userinfos->level.' / '.$userinfos->realm_maxlvl }}"
															data-charinfo-gold="{{ 'Money: '.round($userinfos->money / 10000, 2) }}"
															data-charinfo-playtime="{{ 'Playing Time: '.$userinfos->play_time}}">
                                                            <div class="tooltip-icon">
                                                                <img alt="image" class="tooltip-icon-large-prev" src="{{ URL::asset('admin/img/race/'.$userinfos->race.'_'.$userinfos->gender.'.png') }}">
                                                                <img alt="image" class="tooltip-icon-adt" src="{{ URL::asset('admin/img/class/'.$userinfos->class.'.png') }}">
                                                            </div>
														</wow-tooltip-charinfo-content>
													</div>
													<div class="product-desc">
														<span class="product-price">
															<h2 class="font-bold">
																{{$userinfos->name}} 
															</h2>
																{{$userinfos->level}} level
														</span>
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
                </div>
            </div>
        @if ($recruiterdata != null)
        <div class="row">
        <div class="col-lg-12">
                <div class="ibox">
                        <div class="ibox-title">
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <h5 style="color: #333234">List of characters in a linked account {{ $recruiterdata->name }} ({{$recruiterinfo == null ? 0 : count($recruiterinfo)}})</h5>
                                </a>
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
						<div class="ibox-content" style="display: yes;">
							<div class="project-list">
								<div class="row">
								@if ($recruiterinfo != null)
								  @foreach($recruiterinfo as $recruiterinfos) 
										<div class="col-md-3" id="{{ $recruiterinfos->guid }}">
											<div class="ibox">
												<div class="ibox-content product-box">
													<div class="product-imitation" style="background: url({{ URL::asset('admin/img/faction/'.$recruiterinfos->factionid.'.png') }}) left top no-repeat;"> 
													<div class="dropdown">
															<a data-toggle="dropdown" class=" btn dropdown-toggle" href="#"><i class="fa fa-cogs fa-2x"></i></a>
																<ul class="dropdown-menu animated fadeInLeft m-t-xs">
																	@if($server != 'vanilla')
																	<form method="POST" action="{{ route('characters.race') }}"
																		  class="form-horizontal" enctype="multipart/form-data">

																		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
																		<input type="hidden" name="guid" id="guid" value="{{$recruiterinfos->guid.','.$recruiterinfos->realm_id}}">
																		<button type="submit" class="btn btn-link btn-sm">Cambio de raza</button>
																	</form>
																	<form method="POST" action="{{ route('characters.faction') }}"
																		  class="form-horizontal" enctype="multipart/form-data">

																		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
																		<input type="hidden" name="guid" id="guid" value="{{$recruiterinfos->guid.','.$recruiterinfos->realm_id}}">
																		<button type="submit" class="btn btn-link btn-sm">Cambiar fracción</button>
																	</form>
																	<form method="POST" action="{{ route('characters.name') }}"
																		  class="form-horizontal" enctype="multipart/form-data">

																		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
																		<input type="hidden" name="guid" id="guid" value="{{$recruiterinfos->guid.','.$recruiterinfos->realm_id}}">
																		<button type="submit" class="btn btn-link btn-sm">Cambiar nombre</button>
																	</form>
																	<form method="POST" action="{{ route('characters.repair') }}"
																		  class="form-horizontal" enctype="multipart/form-data">

																		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
																		<input type="hidden" name="guid" id="guid" value="{{$recruiterinfos->guid.','.$recruiterinfos->realm_id}}">
																		<button type="submit" class="btn btn-link btn-sm">Reparar</button>
																	</form>
																	@endif
																</ul>
													    </div>
                                                        <wow-tooltip-charinfo-content 
															data-charinfo-faction="{{ 'Faction: '.($recruiterinfos->factionid == 0 ? 'Alliance' : 'Horde')}}"
															data-charinfo-race="{{ 'Race: '.$recruiterinfos->race_name }}"
															data-charinfo-class="{{ 'Class: '.$recruiterinfos->class_name }}"
															data-charinfo-level="{{ 'Level: '.$recruiterinfos->level.' / '.$recruiterinfos->realm_maxlvl }}"
															data-charinfo-gold="{{ 'Money: '.round($recruiterinfos->money / 10000, 2) }}"
															data-charinfo-playtime="{{ 'Playing time: '.$recruiterinfos->play_time}}">	
                                                            <div class="tooltip-icon">                                                            
                                                                <img alt="image" class="tooltip-icon-large-prev" src="{{ URL::asset('admin/img/race/'.$recruiterinfos->race.'_'.$recruiterinfos->gender.'.png') }}">
                                                                <img alt="image" class="tooltip-icon-adt" src="{{ URL::asset('admin/img/class/'.$userinfos->class.'.png') }}">
                                                            </div>
														</wow-tooltip-charinfo-content>
													</div>
													<div class="product-desc">
														<span class="product-price">
															<h2 class="font-bold">
														    {{$recruiterinfos->name}}
															</h2>
															{{$recruiterinfos->level}} level
														</span>
														<span class="label label">{{ $recruiterinfos->realm_name }}</span>
														<span class="label label-{{ ($recruiterinfos->online == '1') ? 'primary' : 'danger'}}">{{ ($recruiterinfos->online == '1') ? 'Online' : 'Offline'}}</span>
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
        </div>
    </div>
    @endif
    </div>
@endsection
