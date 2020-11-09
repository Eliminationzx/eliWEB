@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Agregar un nuevo artículo de la tienda</h2>
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
    @if (isset($data['result']))
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-info alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <span class="alert-link">{{ $data['result'] }}</span>.
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Agregar un nuevo formulario de artículo de tienda</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form method="POST" action="{{ route('admin.shop.create') }}" class="form-horizontal" enctype="multipart/form-data">

                        <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">

                        <div class="form-group">
                            <label class="col-sm-12 b-r-xl">Nombre:</label>
                            <div class="col-sm-12 b-r-xl" > <input type="text" class="form-control" name="name" id="name"
                                                                   value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 b-r-xl">Precio:</label>
                            <div class="col-sm-12 b-r-xl" > <input type="text" class="form-control" name="price" id="price"
                                                                   value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12">Item ID:</label>
                            <div class="col-sm-12"><input type="text" class="form-control" name="itemid"
                                                          id="itemid"
                                                          value="" required></div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12">Cantidad:</label>
                            <div class="col-sm-12"><input type="text" class="form-control" name="count"
                                                          id="count"
                                                          value="" required></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">Categoria:</label>
                            <div class="col-sm-12"><select name="categoryid" data-placeholder="Select a category..." class="chosen-select"  tabindex="2">
                                    @foreach($categories as $category )
                                        <option value="{{ $category->id }}">{{ $category->local }}</option>
                                    @endforeach
                                </select></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">Realm:</label>
                            <div class="col-sm-12"><select name="realmid" data-placeholder="Select a server..." class="chosen-select"  tabindex="2">
                                    @foreach($realminfos as $realminfo )
                                        <option value="{{ $realminfo->realmid }}">{{ $realminfo->name }}</option>
                                    @endforeach
                                </select></div>
                        </div>
                        <div class="form-group ">
                            <div class="col-sm-12">
                                <button class="btn btn-block btn-outline btn-primary">Añadir artículo</button>
                            </div>
                        </div>


                    </form>


                </div>

            </div>

        </div>
    </div>
</div>
@endsection