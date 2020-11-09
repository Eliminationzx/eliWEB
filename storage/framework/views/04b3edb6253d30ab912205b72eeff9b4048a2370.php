<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo e(config('app.name_prj')); ?> | 403 Forbidden</title>

    <link href="<?php echo e(URL::asset('admin/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/font-awesome/css/font-awesome.css')); ?>" rel="stylesheet">

    <link href="<?php echo e(URL::asset('admin/css/animate.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/css/style.css')); ?>" rel="stylesheet">

</head>

<body class="gray-bg">


<div class="middle-box text-center animated fadeInDown">
    <h1>403</h1>
    <h3 class="font-bold">Вы не имеете прав доступа к данному разделу, обратитесь к администратору сайта.</h3>

</div>

<!-- Mainly scripts -->
<script src="<?php echo e(URL::asset('admin/js/jquery-3.1.1.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('admin/js/bootstrap.min.js')); ?>"></script>

</body>

</html>
