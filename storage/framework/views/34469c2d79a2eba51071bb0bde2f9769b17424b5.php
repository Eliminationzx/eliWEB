<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.title')); ?></title>
    <link href="<?php echo e(URL::asset('admin/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/font-awesome/css/font-awesome.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/css/animate.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/css/plugins/dropzone/dropzone.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/css/plugins/codemirror/codemirror.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/css/plugins/summernote/summernote.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/css/plugins/summernote/summernote-bs3.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/css/style.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/css/plugins/iCheck/custom.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/css/plugins/chosen/bootstrap-chosen.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/css/plugins/colorpicker/bootstrap-colorpicker.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/css/plugins/cropper/cropper.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/css/plugins/switchery/switchery.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/css/plugins/nouslider/jquery.nouislider.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/css/plugins/datapicker/datepicker3.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/css/plugins/ionRangeSlider/ion.rangeSlider.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/css/plugins/clockpicker/clockpicker.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/css/plugins/daterangepicker/daterangepicker-bs3.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/css/plugins/select2/select2.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/css/plugins/dualListbox/bootstrap-duallistbox.min.css')); ?>" rel="stylesheet">
    <!-- Toastr style -->
    <link href="<?php echo e(URL::asset('admin/css/plugins/toastr/toastr.min.css')); ?>" rel="stylesheet">
    <!-- Gritter -->
    <link href="<?php echo e(URL::asset('admin/js/plugins/gritter/jquery.gritter.css')); ?>" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="<?php echo e(URL::asset('admin/css/plugins/sweetalert/sweetalert.css')); ?>" rel="stylesheet">

    <link href="<?php echo e(URL::asset('admin/css/plugins/jasny/jasny-bootstrap.min.css')); ?>" rel="stylesheet">
</head>
<body>