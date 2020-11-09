@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Roles</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('personal') }}">Inicio</a>
            </li> 
            <li>
                Sistema
            </li>
            <li class="active">
                <strong>Roles</strong>
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
						<h5>Lista de roles</h5>
                        @permission('create-roles')
                        <div class="ibox-tools">
                            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-xs"><i
                                        class="fa fa-plus"></i> Agregar rol
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
                                @foreach ($roles as $role)
                                    <tr id="{{ $role->id }}">

                                        <td class="project-status">
                                            @forelse ($role->users as $user)
                                                <span class="label label-primary">Es usado</span>
                                                @break
                                            @empty
                                                <span class="label label-danger">No utilizado</span>
                                            @endforelse
                                        </td>

                                        <td class="project-title">
                                            {{ $role->display_name }}
                                        </td>

                                        <td class="project-title">
                                            {{ $role->name }}
                                        </td>

                                        <td class="project-title">
                                            <small>@if($role->updated_at == $role->created_at)
                                                    Creado el {{ $role->created_at }}
                                                @else
                                                    Actualizado {{ $role->updated_at }}
                                                @endif
                                            </small>
                                        </td>


                                        <td class="project-actions">
                                            <form action="editnews" method="POST" role="form">

                                                <input type="hidden" name="url" value="{{ $role->id }}">
                                                <input type="hidden" name="_token" id="token"
                                                       value="<?php echo csrf_token(); ?>">
                                                @permission('update-roles')
                                                <a href="{{ route('admin.roles.id', ['id' => $role->id]) }}"
                                                   class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> Editar
                                                </a>
                                                @endpermission
                                                @permission('delete-roles')
                                                <button class="btn btn-danger btn-sm delete"
                                                        data-element-id="{{ $role->id }}" data-method-post="deleteroles"
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
                                {{ $roles->links('vendor.pagination.admin') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection