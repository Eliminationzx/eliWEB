@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Categorías de Producto</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('personal') }}">Inicio</a>
            </li> 
            <li>
                Sistema
            </li>
            <li class="active">
                <strong>Categorías de Producto</strong>
            </li> 
         </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    @if ( session('status'))
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-info alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <span class="alert-link">{{ session('status') }}</span>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">
                <div class="ibox">
                    <div class="ibox-title">
					    <h5>Lista de categorías de productos</h5>
                        @permission('create-shopcategories')
                        <div class="ibox-tools">
                            <a href="{{ route('admin.shopcategories.create') }}" class="btn btn-primary btn-xs"><i
                                        class="fa fa-plus"></i> Añadir categoría
                            </a>
                        </div>
                        @endpermission
                    </div>
                    <div class="ibox-content">

                        <div class="project-list">

                            <table class="table table-hover">
                                <tr>
                                    <th style="border-top: 1px solid #ffffff;">ID</th>
                                    <th style="border-top: 1px solid #ffffff;">Nombre</th>
                                    <th style="border-top: 1px solid #ffffff;">Variable</th>
                                    <th style="border-top: 1px solid #ffffff;">Fecha de creación / actualización</th>
                                </tr>
                                <tbody>
                                @foreach ($shopcategories as $shopcategory)
                                    <tr id="{{ $shopcategory->id }}">
                                    
                                        <td class="project-title">
                                            {{ $shopcategory->id }}
                                        </td>

                                        <td class="project-title">
                                            {{ $shopcategory->local }}
                                        </td>

                                        <td class="project-title">
                                            {{ $shopcategory->name }}
                                        </td>

                                        <td class="project-title">
                                            <small>@if($shopcategory->updated_at == $shopcategory->created_at)
                                                    Creado el {{ $shopcategory->created_at }}
                                                @else
                                                    Actualizado {{ $shopcategory->updated_at }}
                                                @endif
                                            </small>
                                        </td>


                                        <td class="project-actions">
                                            <form action="editnews" method="POST" role="form">

                                                <input type="hidden" name="url" value="{{ $shopcategory->id }}">
                                                <input type="hidden" name="_token" id="token"
                                                       value="<?php echo csrf_token(); ?>">
                                                @permission('update-shopcategories')
                                                <a href="{{ route('admin.shopcategories.id', ['id' => $shopcategory->id]) }}"
                                                   class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> Editar
                                                </a>
                                                @endpermission
                                                @permission('delete-shopcategories')
                                                <button class="btn btn-danger btn-sm delete"
                                                        data-element-id="{{ $shopcategory->id }}" data-method-post="deleteshopcategories"
                                                        onclick="return false;"><i class="fa fa-times"></i> Eliminar
                                                </button>
                                                @endpermission
                                            </form>

                                        </td>
                                    </tr>

                                @endforeach


                                </tbody>
                            </table>
                            <div class="pagination">
                                {{ $shopcategories->links('vendor.pagination.admin') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection