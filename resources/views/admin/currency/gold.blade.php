@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Oro</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('personal') }}">Inicio</a>
                </li> 
                <li>
                   Moneda del juego
                </li>  
                <li class="active">
                    <strong>Oro</strong>
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
						<h5>Formulario de compra de oro</h5>
					</div>
                    <div class="ibox-content">

                        <div class="project-list">
                                <div class="col-lg-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                           <i class="fa fa-info-circle"></i> Información útil
                                        </div>
                                        <div class="panel-body">
                                            <p>Para el período de tiempo actual, puede comprar oro de juego a razón de <b>{{ $price->value }}:1</b></p>
                                        </div>
                                    </div>
                                </div>
                            <form method="POST" action="{{ route('currency.gold') }}" class="form-horizontal" enctype="multipart/form-data">

                                <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
                                <input type="hidden" id="price" value="{{ $price->value }}" type="text">
                                
                                <div class="form-group">
                                    <label class="col-sm-3">Recibir:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group col-sm-12">
                                            <div>
                                                <input type="text" onfocus="calculate(this)" class="form-control" name="cur_count" id="cur_count" value="" placeholder="Ingrese el número de oro ...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Puntos de donación:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group col-sm-12">
                                            <div>
                                                <input type="text" onfocus="calculate(this)" class="form-control" name="bp_count" id="bp_count" value="" placeholder="Ingrese el número de puntos de donación ...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Personaje:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group col-sm-12">
                                            <div>
                                                <select name="guid" data-placeholder="Selecciona un personaje ..." class="chosen-select"  tabindex="2">
                                                    @if($userinfo != null)
														@foreach($userinfo as $userinf)
															<option value="{{ $userinf->guid.','.$userinf->realm_id }}">{{ $userinf->name }} ({{ $userinf->realm_name }})</option>
														@endforeach
													@endif
                                                    @if ($recruiterinfo != null)
                                                         <option disabled>_________Characters of the linked account_________</option>
                                                        @foreach($recruiterinfo as $recruiterinf)
                                                            <option value="{{ $recruiterinf->guid.','.$recruiterinf->realm_id }}">{{ $recruiterinf->name }} ({{ $recruiterinf->realm_name }})</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-block btn-outline btn-primary">Confirmar compra</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

<script>
function calculate(elem) {
   var input = document.querySelectorAll('#' + elem.id);
   var res;
   for (let i = 0; i < input.length; i++) {
        input[i].addEventListener('input', function() {
           if (elem.id === 'cur_count') {
               if (cur_count.value !== '') {
                   res = cur_count.value * price.value;
                   bp_count.value = Math.round(res);                                                           
               }
           } else if (elem.id === 'bp_count') {
               if (bp_count.value !== '') {
                   res = bp_count.value / price.value;
                   cur_count.value = Math.round(res);
               }
           }
       })
   }
}
</script>
@endsection
