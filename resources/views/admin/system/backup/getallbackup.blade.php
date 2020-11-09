@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Backups</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('personal') }}">Home</a>
            </li> 
            <li>
                System
            </li>             
            <li class="active">
                <strong>Backups</strong>
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

        <div class="modal inmodal" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated flipInY">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Backup copy is being created</h4>
                        <small class="font-bold">It may take some time.</small>
                    </div>
                    <div class="modal-body">
                        <p>You can close this window, the backup will be created in the background and will appear after a while..</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">
                <div class="ibox">
					<div class="ibox-title">
						<h5>Backup list</h5>
                        @permission('create-backups')
                        <div class="ibox-tools">

                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal2" onclick="createbackup({{ route('admin.backups.create') }})"><i
                                        class="fa fa-plus"></i> Create a back-up copy
                            </button>
                        </div>
                        @endpermission
                    </div>
                    <div class="ibox-content">

                        <div class="project-list">

                            <table class="table table-hover">
                                <tr>
                                    <th style="border-top: 1px solid #ffffff;">Date of creation</th>
                                </tr>
                                <tbody>
                                @foreach ($backups as $backup )
                                    <tr id="{{ $backup }}">



                                        <td class="project-title">
                                            {{ $backup }}
                                        </td>


										{{var_dump(route('personal'))}}
                                        <td class="project-actions">
                                            <form action="editnews" method="POST" role="form">

                                                <input type="hidden" name="url" value="{{ $backup }}">

                                                @permission('downloads-backups')
                                                <a href="{{ route('admin.backups.file', ['file' => $backup]) }}"
                                                   class="btn btn-success btn-sm" target="_blank"><i class="fa fa-arrow-down"></i> Download
                                                </a>
                                                @endpermission
                                                @permission('delete-backups')
                                                <button class="btn btn-danger btn-sm delete"
                                                        data-element-id="{{ $backup }}" data-method-post="deletebackups"
                                                        onclick="return false;"><i class="fa fa-times"></i> Delete
                                                </button>
                                                @endpermission
                                            </form>

                                        </td>
                                    </tr>

                                @endforeach
                                <input type="hidden" name="_token" id="token"
                                       value="<?php echo csrf_token(); ?>">

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function createbackup(post_method) {
        var token = document.getElementById('token').value; // Считываем значение b
        var xhr = new XMLHttpRequest(); // Создаём объект XMLHTTP
        xhr.open('POST', post_method, true); // Открываем асинхронное соединение
        xhr.timeout = 20000000;
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); // Отправляем кодировку
        xhr.send('&_token=' + encodeURIComponent(token)); // Отправляем POST-запрос
        xhr.onreadystatechange = function () { // Ждём ответа от сервера
            if (xhr.readyState == 4) { // Ответ пришёл
                if (xhr.status == 200) { // Сервер вернул код 200 (что хорошо)
                    location.reload();
                }
            }
        };
    }
</script>
@endsection