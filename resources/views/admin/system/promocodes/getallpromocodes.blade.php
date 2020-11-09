@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Códigos promocionales</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('personal') }}">Inicio</a>
            </li> 
            <li>
                Sistema
            </li>
            <li class="active">
                <strong>Códigos promocionales</strong>
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
						<h5>Lista de códigos de promoción</h5>
                        @permission('create-promocodes')
                        <div class="ibox-tools">
                            <a href="{{ route('admin.promocodes.create') }}" class="btn btn-primary btn-xs"><i
                                        class="fa fa-plus"></i> Agregar código promocional
                            </a>
                        </div>
                        @endpermission
                    </div>
                    <div class="ibox-content">

                        <div class="project-list">

                            <table class="table table-hover">
                                <tr>
                                    <th style="border-top: 1px solid #ffffff;">ID</th>
                                    <th style="border-top: 1px solid #ffffff;">Reino</th>
                                    <th style="border-top: 1px solid #ffffff;">Nombre</th>
                                    <th style="border-top: 1px solid #ffffff;">Un tipo</th>
                                    <th style="border-top: 1px solid #ffffff;">Código</th>
                                    <th style="border-top: 1px solid #ffffff;">Numero de usos</th>
                                    <th style="border-top: 1px solid #ffffff;">Tiempo de acción</th>
                                    <th style="border-top: 1px solid #ffffff;">Fecha de creación / actualización</th>
                                </tr>
                                <tbody>
                                @foreach ($promocodes as $promocode)
                                    <tr id="{{ $promocode->id }}">
                                    
                                        <td class="project-title">
                                            {{ $promocode->id }}
                                        </td>
                                        
                                        <td class="project-title">
                                            {{ $promocode->realm_name }}
                                        </td>

                                        <td class="project-title">
                                            {{ $promocode->name }}
                                        </td>
                                        
                                        <td class="project-title">
                                            {{ $promocode->type_name }}
                                        </td>

                                        <td class="project-title">
                                            {{ $promocode->code }}
                                        </td>
                                        
                                        <td class="project-title">
                                            @if ($promocode->usage_count > -1)
                                               @if ($promocode->usage_count == 0)
                                                    Agotado
                                               @else
                                                    {{ $promocode->usage_count }}
                                                @endif
                                            @else
                                               Sin limitaciones
                                            @endif
                                        </td>

                                        <td class="project-title">
                                            @if ($promocode->unused_date > 0)
                                                a {{date("d-m-Y H:i:s", $promocode->unused_date)}}
                                            @else
                                                sin limitaciones
                                            @endif
                                        </td>
                                        
                                        <td class="project-title">
                                            <small>@if($promocode->updated_at == $promocode->created_at)
                                                    Creado el {{ $promocode->created_at }}
                                                @else
                                                    Actualizado {{ $promocode->updated_at }}
                                                @endif
                                            </small>
                                        </td>


                                        <td class="project-actions">
                                            <form action="editnews" method="POST" role="form">

                                                <input type="hidden" name="url" value="{{ $promocode->id }}">
                                                <input type="hidden" name="_token" id="token"
                                                       value="<?php echo csrf_token(); ?>">
                                                @permission('update-promocodes')
                                                <a href="{{ route('admin.promocodes.id', ['id' => $promocode->id]) }}"
                                                   class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> Editar
                                                </a>
                                                @endpermission
                                                @permission('delete-promocodes')
                                                <button class="btn btn-danger btn-sm delete"
                                                        data-element-id="{{ $promocode->id }}" data-method-post="{{ route('admin.promocodes.delete') }}"
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
                                {{ $promocodes->links('vendor.pagination.admin') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection