@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Tienda</h2>
             <ol class="breadcrumb">
                <li>
                    <a href="{{ route('personal') }}">Inicio</a>
                </li>
                <li>
                    <a href="{{ route('shop') }}">Tienda</a>
                </li>                 
                <li class="active">
                    <strong>{{$shopcategory->local}}</strong>
                </li> 
             </ol>
        </div>
    </div>
	
    <div class="chat-message">
       <form method="POST" action="{{ route('shop.search') }}"
              class="form-horizontal" enctype="multipart/form-data">
            <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">

                    <div class="input-group">
                        <input type="text" name="searchstr" class="form-control" value="" placeholder="Ingrese el nombre o ID del artículo">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary">Buscar
                            </button>
                        </span>
                    </div>
        </form>
    </div>
    
    <div class="chat-message message">
        <ul class="nav nav-tabs">
            @foreach($shopcategories as $category)
                <li class="{{ (url()->current() == route('shop').'/'.$category->name) ? 'active' : null}}">
                    <a href="{{ route('shop').'/'.$category->name }}">{{ mb_strlen($category->local) > 25 ? mb_substr($category->local, 0, 25).'...' : $category->local}} ({{$category->item_count}})</a>
                </li>
            @endforeach
        </ul>
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
                        <h5>{{$shopcategory->local}}</h5>
                        <div class="ibox-tools">
                            <a href="{{ route('shop').'/'.$shopcategory->name }}" class="btn btn-primary btn-xs"><i class="fa fa-dot-circle-o"></i>
                            All realms
                            </a>
                            @foreach($realminfos as $realminfo)
                                <a href="{{ route('shop').'/'.$shopcategory->name.'/'.$realminfo->realmid }}" class="btn btn-primary btn-xs"><i class="fa fa-dot-circle-o"></i>
                                    {{$realminfo->name}}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="project-list">
                            <div class="row">

                            @foreach($shopitems as $shopitem)
                                    <div class="col-md-4" id="{{ $shopitem->id }}">
                                        <div class="ibox">
                                            <div class="ibox-content product-box">

                                                <div class="product-imitation">
                                                        <wow-tooltip-content 
                                                           data-id="{{ $shopitem->id }}" 
                                                           data-shopitem-quality-color="{{empty($shopitem->quality) ? '#9D9D9D' : $shopitem->quality['color']}}"
                                                           data-shopitem-name="{{$shopitem->name}}"
                                                           data-shopitem-bonding="{{empty($shopitem->bonding) ? '' : $shopitem->bonding}}"
                                                           data-shopitem-invtype="{{empty($shopitem->invtype) ? '' : $shopitem->invtype}}"
                                                           data-shopitem-armor="{{$shopitem->armor == 0 ? '' : 'Armadura: '.$shopitem->armor}}"
                                                           data-shopitem-dmg_min1="{{$shopitem->dmg_min1 == 0 ? '' : 'Daño: '.$shopitem->dmg_min1}} {{$shopitem->dmg_max1 == 0 ? '' : '- '.$shopitem->dmg_max1}}"
                                                           data-shopitem-dmg_min2="{{$shopitem->dmg_min2 == 0 ? '' : 'Daño: '.$shopitem->dmg_min2}} {{$shopitem->dmg_max2 == 0 ? '' : '- '.$shopitem->dmg_max2}}"
                                                           data-shopitem-delay="{{$shopitem->delay == 0 ? '' : 'Velocidad '.$shopitem->delay}}"
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
                                                           data-shopitem-maxdurability="{{$shopitem->maxdurability == 0 ? '' : 'Fuerza: '.$shopitem->maxdurability.' / '.$shopitem->maxdurability}}"
                                                           data-shopitem-itemlevel="{{$shopitem->itemlevel == 0 ? '' : 'Nivel de objeto: '.$shopitem->itemlevel}}"
                                                           data-shopitem-requiredlevel="{{$shopitem->requiredlevel == 0 ? '' : 'Nivel requerido: '.$shopitem->requiredlevel}}"
                                                           data-shopitem-allowableclass="{{!empty($shopitem->allowableclass) ? 'Clases: '.$shopitem->allowableclass : ''}}"
                                                           data-shopitem-allowablerace="{{!empty($shopitem->allowablerace) ? 'Clases: '.$shopitem->allowablerace : ''}}"
                                                           data-shopitem-spell1="{{empty($shopitem->spell_1) ? '' : $shopitem->spell_1->Description_en_gb}}"
                                                           data-shopitem-spell2="{{empty($shopitem->spell_2) ? '' : $shopitem->spell_2->Description_en_gb}}"
                                                           data-shopitem-spell3="{{empty($shopitem->spell_3) ? '' : $shopitem->spell_3->Description_en_gb}}"
                                                           data-shopitem-spell4="{{empty($shopitem->spell_4) ? '' : $shopitem->spell_4->Description_en_gb}}"
                                                           data-shopitem-spell5="{{empty($shopitem->spell_5) ? '' : $shopitem->spell_5->Description_en_gb}}">
                                                                <img class="tooltip-icon-prev"src="https://wow.zamimg.com/images/wow/icons/large/{{ $shopitem->icon }}.jpg"/>
                                                        </wow-tooltip-content>
                                                </div>
                                                <div class="product-desc">
                                                    <span class="product-price">
                                                        @if ($shopitem->rnd_discount > 0)
                                                          {{ '-'.$shopitem->rnd_discount.'% ' }}<del>{{ $shopitem->price }} D</del> {{ ceil($shopitem->price * (100 - $shopitem->rnd_discount) / 100) }} D {{ $shopitem->count > 1 ? 'for '.$shopitem->count : '' }}
                                                        @else
                                                          {{ $shopitem->price }} PD {{ $shopitem->count > 1 ? 'for '.$shopitem->count : '' }}  
                                                        @endif
                                                    </span>
                                                    <span class="product-name">{{ mb_strlen($shopitem->name) > 20 ? mb_substr($shopitem->name, 0, 20).'...' : $shopitem->name }}</span>
                                                    <span class="label label"> {{ $shopitem->realm_name }}</span>
                                                    <div class="m-t text-righ">
                                                        <form action="{{ route('admin.shop.formupdate') }}" method="POST" role="form">
                                                            <input type="hidden" name="id" value="{{ $shopitem->id }}">
                                                            <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
                                                           
                                                            @permission('update-shop')
                                                            <button class="btn btn-xs btn-outline btn-primary ">Editar <i
                                                                        class="fa fa-long-arrow-right"></i></button>
                                                            @endpermission

                                                            @permission('delete-shop')
                                                            <button class="btn btn-xs btn-outline btn-danger pull-right delete" data-element-id="{{ $shopitem->id }}" data-method-post="{{ route('admin.shop.delete') }}" onclick="return false;" >Eliminar <i
                                                                        class="fa fa-times"></i></button>
                                                            @endpermission                                                          
                                                        </form>
                                                        <br>
                                                        <form action="{{ route('shop.formpayment') }}" method="POST" role="form">
                                                            <input type="hidden" name="id" value="{{ $shopitem->id }}">
                                                            <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">

                                                            <button class="btn btn-xs btn-outline btn-block btn-primary ">Comprar</button>


                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="pagination">
                            {{ $shopitems->links('vendor.pagination.admin') }}
                        </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
@endsection
