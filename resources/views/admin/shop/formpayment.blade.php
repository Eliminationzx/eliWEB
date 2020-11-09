@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Confirmación de compra</h2>
             <ol class="breadcrumb">
                <li>
                    <a href="{{ route('personal') }}">Inicio</a>
                </li>  
                <li class="active">
                    <strong>Tienda</strong>
                </li> 
             </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-lg-12">

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Formulario de confirmación de compra</h5>
                    </div>
                    <div class="ibox-content">

                        <div class="project-list">
                            @if ( session('status'))
                                <div class="alert alert-{{ session('type') }}">
                                    {{ session('status') }}
                                </div>
                            @endif
                                <div class="alert alert-success">
                                 Vas a comprar
                                 <a>
								 <wow-tooltip-content   
                                   data-id="{{ $shopitem->id }}" 
                                   data-shopitem-quality-color="{{empty($shopitem->quality) ? '#9D9D9D' : $shopitem->quality['color']}}"
                                   data-shopitem-name="{{$shopitem->name}}"
                                   data-shopitem-bonding="{{empty($shopitem->bonding) ? '' : $shopitem->bonding}}"
                                   data-shopitem-invtype="{{empty($shopitem->invtype) ? '' : $shopitem->invtype}}"
                                   data-shopitem-armor="{{$shopitem->armor == 0 ? '' : 'Armadura: '.$shopitem->armor}}"
                                   data-shopitem-dmg_min1="{{$shopitem->dmg_min1 == 0 ? '' : 'Daño: '.$shopitem->dmg_min1}} {{$shopitem->dmg_max1 == 0 ? '' : '- '.$shopitem->dmg_max1}}"
                                   data-shopitem-dmg_min2="{{$shopitem->dmg_min2 == 0 ? '' : 'Daño: '.$shopitem->dmg_min2}} {{$shopitem->dmg_max2 == 0 ? '' : '- '.$shopitem->dmg_max2}}"
                                   data-shopitem-delay="{{$shopitem->delay == 0 ? '' : 'Скорость '.$shopitem->delay}}"
                                   data-shopitem-dmgpersec="{{$shopitem->dmg_persec == 0 ? '' : '('.$shopitem->dmg_persec.' daño por segundo)'}}"
                                   data-shopitem-main-statvalue1="{{ !empty($shopitem->main_stat_value1) ? '+'.$shopitem->main_stat_value1.' '.$shopitem->main_stat_type1 : '' }}"
                                   data-shopitem-main-statvalue2="{{ !empty($shopitem->main_stat_value2) ? '+'.$shopitem->main_stat_value2.' '.$shopitem->main_stat_type2 : '' }}"    
                                   data-shopitem-main-statvalue3="{{ !empty($shopitem->main_stat_value3) ? '+'.$shopitem->main_stat_value3.' '.$shopitem->main_stat_type3 : '' }}"
                                   data-shopitem-main-statvalue4="{{ !empty($shopitem->main_stat_value4) ? '+'.$shopitem->main_stat_value4.' '.$shopitem->main_stat_type4 : '' }}"
                                   data-shopitem-main-statvalue5="{{ !empty($shopitem->main_stat_value5) ? '+'.$shopitem->main_stat_value5.' '.$shopitem->main_stat_type5 : '' }}"
                                   data-shopitem-main-statvalue6="{{ !empty($shopitem->main_stat_value6) ? '+'.$shopitem->main_stat_value6.' '.$shopitem->main_stat_type6 : '' }}"
                                   data-shopitem-main-statvalue7="{{ !empty($shopitem->main_stat_value7) ? '+'.$shopitem->main_stat_value7.' '.$shopitem->main_stat_type7 : '' }}"
                                   data-shopitem-main-statvalue8="{{ !empty($shopitem->main_stat_value8) ? '+'.$shopitem->main_stat_value8.' '.$shopitem->main_stat_type8 : '' }}"
                                   data-shopitem-main-statvalue9="{{ !empty($shopitem->main_stat_value9) ? '+'.$shopitem->main_stat_value9.' '.$shopitem->main_stat_type9 : '' }}"
                                   data-shopitem-main-statvalue10="{{ !empty($shopitem->main_stat_value10) ? '+'.$shopitem->main_stat_value10.' '.$shopitem->main_stat_type10 : '' }}"
                                   data-shopitem-bonus-statvalue1="{{ !empty($shopitem->bonus_stat_value1) ? 'Equipar: '.$shopitem->bonus_stat_type1.' +'.$shopitem->bonus_stat_value1 : '' }}"       
                                   data-shopitem-bonus-statvalue2="{{ !empty($shopitem->bonus_stat_value2) ? 'Equipar: '.$shopitem->bonus_stat_type2.' +'.$shopitem->bonus_stat_value2 : '' }}"       
                                   data-shopitem-bonus-statvalue3="{{ !empty($shopitem->bonus_stat_value3) ? 'Equipar: '.$shopitem->bonus_stat_type3.' +'.$shopitem->bonus_stat_value3 : '' }}"       
                                   data-shopitem-bonus-statvalue4="{{ !empty($shopitem->bonus_stat_value4) ? 'Equipar: '.$shopitem->bonus_stat_type4.' +'.$shopitem->bonus_stat_value4 : '' }}"       
                                   data-shopitem-bonus-statvalue5="{{ !empty($shopitem->bonus_stat_value5) ? 'Equipar: '.$shopitem->bonus_stat_type5.' +'.$shopitem->bonus_stat_value5 : '' }}"
                                   data-shopitem-bonus-statvalue6="{{ !empty($shopitem->bonus_stat_value6) ? 'Equipar: '.$shopitem->bonus_stat_type6.' +'.$shopitem->bonus_stat_value6 : '' }}"       
                                   data-shopitem-bonus-statvalue7="{{ !empty($shopitem->bonus_stat_value7) ? 'Equipar: '.$shopitem->bonus_stat_type7.' +'.$shopitem->bonus_stat_value7 : '' }}"
                                   data-shopitem-bonus-statvalue8="{{ !empty($shopitem->bonus_stat_value8) ? 'Equipar: '.$shopitem->bonus_stat_type8.' +'.$shopitem->bonus_stat_value8 : '' }}"
                                   data-shopitem-bonus-statvalue9="{{ !empty($shopitem->bonus_stat_value9) ? 'Equipar: '.$shopitem->bonus_stat_type9.' +'.$shopitem->bonus_stat_value9 : '' }}"       
                                   data-shopitem-bonus-statvalue10="{{ !empty($shopitem->bonus_stat_value10) ? 'Equipar: '.$shopitem->bonus_stat_type10.' +'.$shopitem->bonus_stat_value10 : '' }}"
                                   data-shopitem-skill="{{empty($shopitem->skill) ? '' : $shopitem->skill}}"
                                   data-shopitem-maxdurability="{{$shopitem->maxdurability == 0 ? '' : 'Durabilidad: '.$shopitem->maxdurability.' / '.$shopitem->maxdurability}}"
                                   data-shopitem-itemlevel="{{$shopitem->itemlevel == 0 ? '' : 'Nivel de objeto: '.$shopitem->itemlevel}}"
                                   data-shopitem-requiredlevel="{{$shopitem->requiredlevel == 0 ? '' : 'Nivel requerido: '.$shopitem->requiredlevel}}"
                                   data-shopitem-allowableclass="{{!empty($shopitem->allowableclass) ? 'Классы: '.$shopitem->allowableclass : ''}}"
                                   data-shopitem-allowablerace="{{!empty($shopitem->allowablerace) ? 'Расы: '.$shopitem->allowablerace : ''}}"
                                   data-shopitem-spell1="{{empty($shopitem->spell_1) ? '' : $shopitem->spell_1->Description_en_gb}}"
                                   data-shopitem-spell2="{{empty($shopitem->spell_2) ? '' : $shopitem->spell_2->Description_en_gb}}"
                                   data-shopitem-spell3="{{empty($shopitem->spell_3) ? '' : $shopitem->spell_3->Description_en_gb}}"
                                   data-shopitem-spell4="{{empty($shopitem->spell_4) ? '' : $shopitem->spell_4->Description_en_gb}}"
                                   data-shopitem-spell5="{{empty($shopitem->spell_5) ? '' : $shopitem->spell_5->Description_en_gb}}">
                                       {{$shopitem->name}}
                                   </wow-tooltip-content>
								   </a>
                                   <tre> 1</tre> Por <trc>{{$shopitem->price }}</trc> PD
                                </div>
                                
                            <form method="POST" action="{{ route('shop.payments') }}"
                                  class="form-horizontal" enctype="multipart/form-data">

                                <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
                                <input type="hidden" name="itemid" id="itemid" value="{{ $shopitem->id }}">
                                <input type="hidden" id="price" value="{{ $shopitem->price }}" type="text">

                                <div class="form-group">
                                      <label class="col-sm-3">Cantidad:</label>
                                      <div class="col-sm-9">
                                            <div class="input-group col-sm-12">
                                                <div>
                                                   <input type="text" id="itemcount" name="itemcount" class="form-control" value="" placeholder="Especifique la cantidad de 1 a 100 ...">
                                                </div>
                                            </div>
                                      </div>
                                 </div>
                                                            
                                <div class="form-group">
                                    <label class="col-sm-3">Selecciona un personaje:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group col-sm-12">
                                            <div>
                                                <select name="guid" data-placeholder="Selecciona un personaje ..." class="chosen-select"  tabindex="2">
                                                    @if($userinfo != null)
														@foreach($userinfo as $userinf )
															<option value="{{ $userinf->guid }}">{{ $userinf->name }} ({{ $userinf->realm_name }})</option>
														@endforeach
													@endif
                                                    @if ($recruiterinfo != null)
                                                         <option disabled>_________Characters of the linked account_________</option>
                                                        @foreach($recruiterinfo as $recruiterinf)
                                                            <option value="{{ $recruiterinf->guid }}">{{ $recruiterinf->name }} ({{ $recruiterinf->realm_name }})</option>
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
   var input = document.querySelectorAll('#itemcount');
   var div_trc = document.querySelector('trc');
   var div_tre = document.querySelector('tre');
   var res;
   for (let i = 0; i < input.length; i++) {
        input[i].addEventListener('input', function() {
            if (itemcount.value !== '') {
                res = itemcount.value * price.value;
                div_tre.textContent = Math.ceil(itemcount.value);
                div_trc.textContent = Math.ceil(res);
            }
        })
   }
</script>
@endsection