@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Estado premium</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('personal') }}">Inicio</a>
                </li> 
                <li class="active">
                    <strong>Estado premium</strong>
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
               <div class="alert alert-danger" role="alert">
                    EL SISTEMA NO ESTÁ DISPONIBLE. 
                </div>
                <div class="ibox">
					<div class="ibox-title">
						<h5>Comprar estado premium (NO DISPONIBLE)</h5>
					</div>
                    <div class="ibox-content">
                        <div class="project-list">                                                    
							<div class="panel panel-primary">
								<div class="panel-heading">
								<i class="fa fa-info-circle"></i> Información útil
								</div>
								<div class="panel-body">
									<p>Estado premium: privilegio especial en el proyecto {{config('app.name_prj')}}</p>
									<h5>Este privilegio ofrece los siguientes beneficios:</h5>
									<ol>
                                        <li>Acceso a un elemento especial que solo está disponible para jugadores premium: "Libro del poder":</li>
                                            <ul> 
                                                <li>Banco móvil (rango 1-3)</li>
                                                <li>Buzón móvil (rango 1-3)</li>
                                                <li>Efectos separados que refuerzan el personaje (bafa) (rango 3)</li>
                                                <li>Tasa de retorno sin tiempo de recuperación (1-3 grados)</li>
                                                <li>Abrir todas las rutas de vuelo (rango 1-3)</li>
                                                <li>Descuentos diarios en productos aleatorios en gabinete personal (rango 1-3)</li>
                                                <li>Reparación gratuita de equipos (rango 1-3)</li>
                                                <li>Restablecimiento de habilidades (3 rangos)</li>
                                                <li>Mejora de las habilidades con armas (2-3 rangos)</li>
                                                <li>Eliminación del aura de debilidad después de la resurrección (2-3 rangos)</li>
                                                <li>Elimina el aura de desertor (rango 2-3)</li>
                                            </ul> 
                                        <li>Vuelos de bombeo X2 elevados desde vuelos regulares</li>
                                        <li>Vuelos superiores X2 desde regulares</li>
                                        <li>Vuelos superiores a la reputación X2 de ordinaria</li>
									</ol>
									Por cada compra de estado premium, recibe puntos especiales que aumentan su tarifa premium.
								</div>
							</div>
							@if ($premiuminfo != null and $premiuminfo[0]['active'] == 1)
							<form method="POST" action="/personal/premium/senditem"
							  class="form-horizontal" enctype="multipart/form-data">

							<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
							 <div class="form-group">
								<div class="col-sm-3">
									<div class="input-group col-sm-12">
										<div>
											<select name="guid" data-placeholder="Selecciona un personaje ..." class="chosen-select"  tabindex="2">
												@foreach($userinfo as $userinf )
													<option value="{{ $userinf->guid.','.$userinf->realm_id }}">{{ $userinf->name }} ({{ $userinf->realm_name }})</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-primary">Envía un libro de poder (NO DISPONIBLE)</button>
								</div>
							</div>
							</form>    
								<div class="alert alert-success">
								   {{ $premiuminfo[0]['unsetdate'] < 0 ? 'Unlimited premium status ' . $premiuminfo[0]['premium_type'] . ' rank active' : 
									 'Premium status ' . $premiuminfo[0]['premium_type'] . ' rank active until ' . date("d.m.Y", $premiuminfo[0]['unsetdate'])}}
								</div>
							   <div class="form-group">
									 <div class="progress progress-mini">
										@if ($premiuminfo[0]['premium_type'] == 1)
											<div style="width: {{ $premiuminfo[0]['score'] / 100 * 100 }}%;" class="progress-bar"></div>
										@elseif ($premiuminfo[0]['premium_type'] == 2)
											<div style="width: {{ $premiuminfo[0]['score'] / 180 * 100 }}%;" class="progress-bar"></div>
										@elseif ($premiuminfo[0]['premium_type'] == 3)
											<div style="width: 100%;" class="progress-bar"></div>
										@endif    
									 </div>
								</div>                                                              
						@else
							<div class="alert alert-danger">
								 Estado premium no activado
							</div>
						@endif
							<div class="row">						
									<form method="POST" action="/personal/premium"
									  class="form-horizontal" enctype="multipart/form-data">

										<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
										<input type="hidden" name="premium" value="day">
											<div class="col-sm-4">
												<button type="submit" class="btn btn-block btn-outline btn-primary">Comprar un dia por {{ $price_day->value }} D</button>
											</div>
									 </form>
									<form method="POST" action="/personal/premium"
									  class="form-horizontal" enctype="multipart/form-data">


										<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
										<input type="hidden" name="premium" value="month">
											<div class="col-sm-4">
												<button type="submit" class="btn btn-block btn-outline btn-primary">Comprar un mes por  {{ $price_month->value }} D</button>
											</div>
									 </form>
									<form method="POST" action="/personal/premium"
									  class="form-horizontal" enctype="multipart/form-data">


										<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
										<input type="hidden" name="premium" value="year">
											<div class="col-sm-4">
												<button type="submit" class="btn btn-block btn-outline btn-primary">Comprar un año por  {{ $price_year->value }} D</button>
											</div>
									 </form>
							</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>


@endsection
