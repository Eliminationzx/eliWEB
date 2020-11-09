@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Privilegios</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('personal') }}">Inicio</a>
            </li> 
            <li>
                Sistema
            </li>
            <li class="active">
                <strong>Privilegios</strong>
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
					    <h5>Lista de privilegios</h5>
                        @permission('create-permissions')
                        <div class="ibox-tools">
                            <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary btn-xs"><i
                                        class="fa fa-plus"></i> Añadir privilegios
                            </a>
                        </div>
                        @endpermission
                    </div>
                    <div class="ibox-content">

                        <div class="project-list">
                            <table class="table table-hover">
                                <tr>
                                    <th style="border-top: 1px solid #ffffff;">Estado</th>
                                    <th style="border-top: 1px solid #ffffff;">Nombre</th>
                                    <th style="border-top: 1px solid #ffffff;">Variable</th>
                                    <th style="border-top: 1px solid #ffffff;">Fecha de creación / actualización</th>
                                </tr>
                                <tbody>


                                @foreach ($permissions as $permission)
                                    <tr id="{{ $permission->id }}">

                                        <td class="project-status">
                                            @forelse ($permission->roles as $role)
                                                <span class="label label-primary">Es usado</span>
                                                @break
                                            @empty
                                                <span class="label label-danger">No utilizado</span>
                                            @endforelse
                                        </td>

                                        <td class="project-title">
                                            {{ $permission->display_name }}
                                        </td>

                                        <td class="project-title">
                                            {{ $permission->name }}
                                        </td>

                                        <td class="project-title">
                                            <small>
                                                    Creado por {{ $permission->created_at }}
                                                       <br>
                                                    Actualizado {{ $permission->updated_at }}

                                            </small>
                                        </td>

                                        <td class="project-actions">
                                            <form action="#" method="POST" role="form">

                                                <input type="hidden" name="url" value="{{ $permission->id }}">
                                                <input type="hidden" name="_token" id="token"
                                                       value="<?php echo csrf_token(); ?>">
                                                @permission('update-permissions')
                                                <a href="{{ route('admin.permissions.id', ['id' => $permission->id]) }}"
                                                   class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> Editar
                                                </a>
                                                @endpermission

                                                @permission('delete-permissions')
                                                <button class="btn btn-danger btn-sm delete вф"
                                                        data-element-id="{{ $permission->id }}" data-method-post="deletepermissions"
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
                                {{ $permissions->links('vendor.pagination.admin') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection