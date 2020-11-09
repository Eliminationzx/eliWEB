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
            <li>
                News
            </li>
            <li class="active">
                <strong>News Editing</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>News editing form</h5>
				</div>
                <div class="ibox-content">

                    <form action="{{ route('admin.launcher.news.update') }}" method="POST" role="form" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" class="form-control" name="newsid" value="{{$news->id}}">

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" value="{{$news->title}}" placeholder="Title...">
                        </div>
                        
                        <div class="form-group">
                            <label for="body">Content</label>
                            <textarea type="text" class="form-control" name="body" placeholder="Content...">{{$news->body}}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="thumbnail_source">Image file</label>
                            <input type="file" class="form-control" name="thumbnail_source" placeholder="Image file...">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>


                </div>

            </div>

        </div>
    </div>


</div>
@endsection