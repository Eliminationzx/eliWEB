@extends('layouts.admin')

@section('content')
@section('bodyclass')
@endsection
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Historial de actividad</h2>
         <ol class="breadcrumb">
            <li>
                <a href="{{ route('personal') }}">Inicio</a>
            </li> 
            <li>
                Cuenta
            </li>  
            <li class="active">
                <strong>Historial de actividad</strong>
            </li>   
         </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
				<div class="ibox-title">
					<h5>Historial de tu cuenta</h5>
				</div>
                <div class="ibox-content">
                    <div class="project-list">
                        <table class="table table-hover">
                            <tr>
                                <td class="project-title">
                                   <b>Evento</b>
                                </td>
                                <td class="project-title">
                                   <b>IP</b>
                                </td>
                                <td class="project-title">
                                   <b>Hora</b>
                                </td>
                            </tr>
                            <tbody>
                            @foreach ($activities as $activity)
                                <tr id="{{ $activity->id }}">

                                    <td class="project-title">
                                        {{ $activity->comment}}
                                    </td>

                                    <td class="project-title">
                                        {{ $activity->ip }}
                                    </td>

                                    <td class="project-title">
                                        <small>{{ $activity->created_at }}</small>
                                    </td>
                                </tr>

                            @endforeach


                            </tbody>
                        </table>
                        <div class="pagination">
                            {{ $activities->links('vendor.pagination.admin') }}
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
</div>
@endsection