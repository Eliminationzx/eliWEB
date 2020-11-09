@extends('layouts.admin')

@section('content')
@section('bodyclass')
<body>
@endsection
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Video</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('personal') }}">Home</a>
            </li>
            <li>
                Launcher
            </li>
            <li>
                Video
            </li>
            <li class="active">
                <strong>Video creation</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    @if (isset($data['result']))
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-info alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <span class="alert-link">{{ $data['result'] }}</span>
                    .
                </div>
            </div>
        </div>
    @endif


    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Video creation form</h5>
				</div>
                <div class="ibox-content">
                    <form action="{{ route('admin.launcher.videos.create') }}" method="POST" role="form" enctype="multipart/form-data">
                        {{csrf_field()}}
                        
                        <div class="form-group">
                            <label for="name">Title</label>
                            <input type="text" class="form-control" name="name" placeholder="Title...">
                        </div>
                        
                        <div class="form-group">
						    <label for="video_source">Video file</label>
                            <input type="file" class="form-control" name="video_source">
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" name="description" placeholder="Description...">
                        </div>
						
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection