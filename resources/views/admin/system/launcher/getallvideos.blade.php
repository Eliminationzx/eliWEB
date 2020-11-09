@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Videos</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('personal') }}">Home</a>
            </li> 
            <li>
                Launcher
            </li>
            <li class="active">
                <strong>Videos</strong>
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
						<h5>Список видео</h5>
                        @permission('create-launcher-videos')
                        <div class="ibox-tools">
                            <a href="{{ route('admin.launcher.videos.create') }}" class="btn btn-primary btn-xs"><i
                                        class="fa fa-plus"></i> Add video
                            </a>
                        </div>
                        @endpermission
                    </div>
                    <div class="ibox-content">

                        <div class="project-list">

                            <table class="table table-hover">
                                <tr>
                                    <th style="border-top: 1px solid #ffffff;">ID</th>
                                    <th style="border-top: 1px solid #ffffff;">Title</th>
                                    <th style="border-top: 1px solid #ffffff;">Video</th>
                                    <th style="border-top: 1px solid #ffffff;">Date of creation / update</th>
                                </tr>
                                <tbody>
                                @foreach ($videos as $video)
                                    <tr id="{{ $video->id }}">
                                    
                                        <td class="project-title">
                                            {{ $video->id }}
                                        </td>
                                        
                                        <td class="project-title">
                                            {{ $video->name }}
                                        </td>

                                        <td class="project-title">
                                            <a href="{{ $video->source_url }}" target="_blank">{{ mb_substr($video->source_url, 0, 40).'...' }}</a>
                                        </td>
                                        
                                        
                                        <td class="project-title">
                                            <small>@if($video->updated_at == $video->created_at)
                                                    Created {{ $video->created_at }}
                                                @else
                                                    Updated {{ $video->updated_at }}
                                                @endif
                                            </small>
                                        </td>


                                        <td class="project-actions">
                                            <form action="editnews" method="POST" role="form">

                                                <input type="hidden" name="url" value="{{ $video->id }}">
                                                <input type="hidden" name="_token" id="token"
                                                       value="<?php echo csrf_token(); ?>">
                                                @permission('update-launcher-videos')
                                                <a href="{{ route('admin.launcher.videos.id', ['id' => $video->id]) }}"
                                                   class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> Edit
                                                </a>
                                                @endpermission
                                                @permission('delete-launcher-videos')
                                                <button class="btn btn-danger btn-sm delete"
                                                        data-element-id="{{ $video->id }}" data-method-post="{{ route('admin.launcher.videos.delete') }}"
                                                        onclick="return false;"><i class="fa fa-times"></i> Delete
                                                </button>
                                                @endpermission
                                            </form>

                                        </td>
                                    </tr>

                                @endforeach


                                </tbody>
                            </table>
                            <div class="pagination">
                                {{ $videos->links('vendor.pagination.admin') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection