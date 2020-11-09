@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Tops de votación</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('personal') }}">Inicio</a>
            </li> 
            <li>
                Sistema
            </li>
            <li class="active">
                <strong>Tops de votación</strong>
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
						<h5>Lista de tapas de votación</h5>
                        @permission('create-votes')
                        <div class="ibox-tools">
                            <a href="{{ route('admin.votes.create') }}" class="btn btn-primary btn-xs"><i
                                        class="fa fa-plus"></i> Agregar Topsite
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
                                    <th style="border-top: 1px solid #ffffff;">Descripción</th>
                                    <th style="border-top: 1px solid #ffffff;">Imagen</th>
                                    <th style="border-top: 1px solid #ffffff;">Recompensa</th>
									<th style="border-top: 1px solid #ffffff;">Fecha de creación / actualización</th>
                                </tr>
                                <tbody>
                                @foreach ($votes as $vote)
                                    <tr id="{{ $vote->id }}">

										<td class="project-title">
                                            {{ $vote->id }}
                                        </td>
										
                                        <td class="project-title">
                                            {{ $vote->name }}
                                        </td>

                                        <td class="project-title">
											{{ $vote->descr }}
                                        </td>

                                        <td class="project-title">
                                           	<img src="{{$vote->img}}"/>
                                        </td>
										
										<td class="project-title">
                                            {{ $vote->reward }} PD
                                        </td>

                                        <td class="project-title">
                                            <small>
                                                    Creado el: {{ $vote->created_at }}
<br>
                                                    Actualizado: {{ $vote->updated_at }}

                                            </small>
                                        </td>
										
										
                                        <td class="project-actions">
                                            <form action="editnews" method="POST" role="form">

                                                <input type="hidden" name="url" value="{{ $vote->id }}">
                                                <input type="hidden" name="_token" id="token"
                                                       value="<?php echo csrf_token(); ?>">
                                                @permission('update-votes')
                                                <a href="{{ route('admin.votes.id', ['id' => $vote->id]) }}"
                                                   class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> Editar
                                                </a>
                                                @endpermission
                                                @permission('delete-votes')
                                                <button class="btn btn-danger btn-sm delete"
                                                        data-element-id="{{ $vote->id }}" data-method-post="{{ route('admin.votes.delete') }}"
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
                                {{ $votes->links('vendor.pagination.admin') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection