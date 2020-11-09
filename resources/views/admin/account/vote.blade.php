@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Votación</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('personal') }}">Inicio</a>
                </li> 
                <li>
                    Cuenta
                </li>  
                <li class="active">
                    <strong>Votación</strong>
                </li> 
            </ol>
        </div>
    </div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox">
				<div class="ibox-title">
					<h5>Sistema de votación</h5>
				</div>
                    <div class="ibox-content">
                        <div class="project-list">
                            <div class="row">
                                <div class="col-lg-12">
								    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                        <i class="fa fa-info-circle"></i> Información útil
                                        </div>
                                        <div class="panel-body">
                                           Estimado {{$data->name}}, para que nuestro proyecto sea conocido por la mayor cantidad de personas posible, es necesaria su promoción en diferentes TopSites. Apoya al servidor votando por él y se le otorgará la recompensa correspondiente.
                                           <b>Note:</b> 
                                           <ul>
                                               <li>Su nombre de cuenta debe especificarse al votar - <b>{{$data->name}}</b>, de lo contrario no se le cobrará la recompensa.</li>
                                               <li>Los últimos votos se actualizan y las recompensas se acreditan cada hora.</li>
                                               <li>Para los jugadores que se encuentran entre los 5 primeros por número de votos, el premio de votación aumenta x2.</li>
                                           </ul>
                                        </div>
                                    </div>
                                    @if ($data->vote > 0)                                
                                    <div class="alert alert-success">                            
                                        <p>Ya has realizado {{$data->vote}} voto(s).</p>
                                    </div>
                                    @else
                                    <div class="alert alert-danger">                            
                                        Aún no has votado por nuestro proyecto, ¡Pues hacerlo ahora!
                                    </div> 
                                    @endif        
                                </div>
                                <div class="col-lg-4">
                                    <table class="table table-bordered">
                                        <tbody>
                                            @foreach($votes as $vote)
                                            <tr>
                                                <td class="project-title">
                                                {{$vote->name}}                                     
                                                </td>
                                                <td class="project-title">
                                                {{$vote->descr}}                                     
                                                </td>
                                                <td class="project-title">
                                                    <div class="vote-info-block">
                                                        @if ($vote->isvoted == 1)
                                                            <img class="vote-info-banner" src="{{$vote->img}}"/>
                                                            <span class="vote-info-voted">Votado</span>
                                                        @else                                                         
                                                            <a href="{{$vote->url}}" target="_blank">
                                                            <img class="vote-info-banner" src="{{$vote->img}}"/>
                                                            <span class="vote-info-reward">{{$topusers->contains('id', $data->id) && $vote->clickable_only == 0 ? $vote->reward * 2 : $vote->reward}} PD</span>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
								</div>
							    <div class="col-lg-4">
                                        <h2>Los 5 mejores votantes</h2>
										<div class="alert alert-info alert-dismissable">
											<table class="table table-hover">
												<tbody>
													@foreach($topusers as $topuser)
													@if ($loop->index == 0)
													<tr>
														<td class="project-title">
														   &#128081;                                      
														</td>
														<td class="project-title">
														  <b>{{ $topuser->name }}</b>                                     
														</td>
														<td class="project-title">
														  <b>{{ $topuser->vote }} PV</b>                               
														</td>
													</tr>
													@else
													<tr>
														<td class="project-title">
														   {{ ($loop->index + 1) }}                                       
														</td>
														<td class="project-title">
														   {{ $topuser->name }}                                       
														</td>
														<td class="project-title">
														   {{ $topuser->vote }} PV                              
														</td>
													</tr>
													@endif
													@endforeach
												</tbody>
											</table>
										</div>
                                </div>
                                <div class="col-lg-4">
                                        <h2>Ultimos votos</h2>
										<div class="alert alert-info alert-dismissable">
											<table class="table table-hover">
												<tbody>
													@foreach($logs as $log)
													<tr>
														<td class="project-title">
														   {{ $log->player_name }}                           
														</td>
														<td class="project-title">
														   {{ $log->vote_name }}                                       
														</td>
														<td class="project-title">
														   {{ $log->vote_time }}                                          
														</td>
														<td class="project-title">
														   {{ $log->vote_count }} PV                                
														</td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
                                </div>
                            </div>
                    </div>
                </div>
        </div>
        </div>
    </div>
</div>

@endsection
