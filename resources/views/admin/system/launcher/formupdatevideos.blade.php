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
            <li>
                Videos
            </li>
            <li class="active">
                <strong>Video editing</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Video editing form</h5>
				</div>
                <div class="ibox-content">

                    <form action="{{ route('admin.launcher.videos.update') }}" method="POST" role="form" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" class="form-control" name="videoid" value="{{$video->id}}">

                          <div class="form-group">
                            <label for="name">Title</label>
                            <input type="text" class="form-control" name="name" value="{{$video->name}}" placeholder="Title...">
                        </div>
                        
                        <div class="form-group">
						    <label for="video_source">Video</label>
                            <input type="file" class="form-control" name="video_source">
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" name="description" value="{{$video->description}}" placeholder="Description...">
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>


                </div>

            </div>

        </div>
    </div>


</div>
@endsection