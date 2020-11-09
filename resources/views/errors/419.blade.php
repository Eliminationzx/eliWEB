<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{config('app.name_prj')}} | 419 Page Expired</title>

    <link href="{{ URL::asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('admin/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ URL::asset('admin/css/animate.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('admin/css/style.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">


<div class="middle-box text-center animated fadeInDown">
    <h1>419</h1>
    <h3 class="font-bold">Page has expired due to inactivity</h3>
	
	<div class="error-desc">
		<small>You will be redirected to the home page automatically in 5 seconds</small>
	</div>
</div>

<!-- Mainly scripts -->
<script src="{{ URL::asset('admin/js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ URL::asset('admin/js/bootstrap.min.js') }}"></script>

</body>

</html>

<script>
setTimeout(function () {
   window.location.href= "{{ route('home') }}"; // the redirect goes here

},5000);
</script>
