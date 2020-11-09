@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>News</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('personal') }}">Home</a>
            </li> 
            <li>
                Launcher
            </li>
            <li class="active">
                <strong>News</strong>
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
						<h5>News list</h5>
                        @permission('create-launcher-news')
                        <div class="ibox-tools">
                            <a href="{{ route('admin.launcher.news.create') }}" class="btn btn-primary btn-xs"><i
                                        class="fa fa-plus"></i> Add news
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
									<th style="border-top: 1px solid #ffffff;">Image</th>
                                    <th style="border-top: 1px solid #ffffff;">Date of creation / update</th>
                                </tr>
                                <tbody>
                                @foreach ($news_list as $news)
                                    <tr id="{{ $news->id }}">
                                    
                                        <td class="project-title">
                                            {{ $news->id }}
                                        </td>

                                        <td class="project-title">
                                            {{ $news->title }}
                                        </td>
										
										<td class="project-title">
                                           <a href="{{ $news->thumbnail_url }}" target="_blank">{{ mb_substr($news->thumbnail_url, 0, 40).'...' }}</a>
                                        </td>
                                        
                                        <td class="project-title">
                                            <small>@if($news->updated_at == $news->created_at)
                                                    Created {{ $news->created_at }}
                                                @else
                                                    Updated {{ $news->updated_at }}
                                                @endif
                                            </small>
                                        </td>


                                        <td class="project-actions">
                                            <form action="editnews" method="POST" role="form">

                                                <input type="hidden" name="url" value="{{ $news->id }}">
                                                <input type="hidden" name="_token" id="token"
                                                       value="<?php echo csrf_token(); ?>">
                                                @permission('update-launcher-news')
                                                <a href="{{ route('admin.launcher.news.id', ['id' => $news->id]) }}"
                                                   class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> Edit
                                                </a>
                                                @endpermission
                                                @permission('delete-launcher-news')
                                                <button class="btn btn-danger btn-sm delete"
                                                        data-element-id="{{ $news->id }}" data-method-post="{{ route('admin.launcher.news.delete') }}"
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
                                {{ $news_list->links('vendor.pagination.admin') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection