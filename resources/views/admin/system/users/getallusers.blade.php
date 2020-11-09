@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Usuarios</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('personal') }}">Inicio</a>
            </li> 
            <li>
                Sistema
            </li>
            <li class="active">
                <strong>Usuarios</strong>
            </li> 
         </ol>
    </div>
</div>

<div class="chat-message">
	<form method="POST" action="{{ route('admin.users.search') }}"
		  class="form-horizontal" enctype="multipart/form-data">
		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
			<div class="input-group">
				<input type="text" name="searchstr" class="form-control" value="" placeholder="Ingrese nombre de usuario o correo electrónico ...">
				<span class="input-group-btn">
					<button type="submit" class="btn btn-primary">Buscar
					</button>
				</span>
			</div>
	</form>
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
						<h5>Lista de usuarios</h5>
					</div>
                    <div class="ibox-content">

                        <div class="project-list">

                            <table class="table table-hover">
                                <tr>
									<th style="border-top: 1px solid #ffffff;">Estado</th>
                                    <th style="border-top: 1px solid #ffffff;">Nombre de usuario</th>
                                    <th style="border-top: 1px solid #ffffff;">Grupo de usuario</th>
                                    <th style="border-top: 1px solid #ffffff;">Email</th>
									<th style="border-top: 1px solid #ffffff;">Puntos de donación</th>
									<th style="border-top: 1px solid #ffffff;">Puntos de votación</th>
                                    <th style="border-top: 1px solid #ffffff;">Fecha de creación / actualización</th>
                                </tr>
                                <tbody>
                                @foreach ($users as $user)
                                    <tr id="{{ $user->id }}">
									
										<td class="project-status">
                                            @if ($user->status == 1)
                                                <span class="label label-primary">Activo</span>
                                            @else
                                                <span class="label label-danger">No activo</span>
                                            @endif
                                        </td>
									
                                        <td class="project-status">
                                            {{ $user->name }}
                                        </td>

                                        <td class="project-title">

                                            @forelse ($user->roles as $role)
                                                {{ $role->name }}
                                            @empty
                                                Без группы
                                            @endforelse
                                        </td>

                                        <td class="project-title">
                                            {{ $user->email }}
                                        </td>
										
										<td class="project-title">
                                            {{ $user->donate }}
                                        </td>
										
										<td class="project-title">
                                            {{ $user->vote }}
                                        </td>
										
                                        <td class="project-title">
                                            <small>
                                                    Creado el: {{ $user->created_at }}
<br>
                                                    Actualizado: {{ $user->updated_at }}

                                            </small>
                                        </td>


                                        <td class="project-actions">
                                            <form action="editnews" method="POST" role="form">

                                                <input type="hidden" name="url" value="{{ $user->id }}">
                                                <input type="hidden" name="_token" id="token"
                                                       value="<?php echo csrf_token(); ?>">
                                                @permission('update-users')
                                                <a href="{{ route('admin.users.id', ['id' => $user->id]) }}"
                                                   class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> Editar
                                                </a>
                                                @endpermission
                                                @permission('delete-users')
                                                <button class="btn btn-danger btn-sm delete"
                                                        data-element-id="{{ $user->id }}" data-method-post="{{ route('admin.users') }}"
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
                                {{ $users->links('vendor.pagination.admin') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection