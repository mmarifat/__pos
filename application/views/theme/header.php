<?php
/**
 * Author Minhaz Ahamed<mma.rifat66@gmail.com>
 * Email: mma.rifat66@gmail.com
 * Web: https://mma.champteks.us
 * Do not edit file without permission of author
 * All right reserved by Minhaz Ahamed<mma.rifat66@gmail.com>
 * Created on: 10/30/2019 7:49 PM
 */
?>

<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Developer:mmarifat, mma.rifat66@gmail.com">
    <meta name="keywords"
          content="mmarifat,mma rifat, md. minhaz ahamed rifat, minhaz ahamed rifat, minhaz, rifat, mmarifat developer">
    <meta name="author" content="mmarifat">
    <title><?= isset($navMeta["pageTitle"]) && $navMeta["pageTitle"] ? ($navMeta["pageTitle"] . " | " . $title) : $title ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= favicon() ?>">

    <!-- START VENDOR CSS-->
    <link href="<?= propertyUrl() ?>css/core/googleapisFont.css" rel="stylesheet">

    <script src="<?= propertyUrl() ?>js/jquery/jquery-3.4.1.min.js"></script>

    <link rel="stylesheet" type="text/css" href="<?= propertyUrl() ?>css/core/app.css">
    <link rel="stylesheet" type="text/css" href="<?= propertyUrl() ?>css/core/style.css">

    <link rel="stylesheet" type="text/css" href="<?= propertyUrl() ?>css/jquery/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="<?= propertyUrl() ?>css/jquery/jquery-confirm.min.css">
    <link rel="stylesheet" type="text/css" href="<?= propertyUrl() ?>css/jquery/jquery.fancybox.css"/>
    <link rel="stylesheet" type="text/css" href="<?= propertyUrl() ?>css/jquery/raty/jquery.raty.css">

    <link rel="stylesheet" type="text/css" href="<?= propertyUrl() ?>css/charts/morris.css">
    <link rel="stylesheet" type="text/css" href="<?= propertyUrl() ?>css/animate/animate.css">

    <link rel="stylesheet" type="text/css" href="<?= propertyUrl() ?>css/forms/login-register.css"/>
    <link rel="stylesheet" type="text/css" href="<?= propertyUrl() ?>css/forms/selects/select2.min.css"/>

    <link rel="stylesheet" type="text/css" href="<?= propertyUrl() ?>css/pickers/daterange/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="<?= propertyUrl() ?>css/pickers/datetime/bootstrap-datetimepicker.css">
    <link rel="stylesheet" type="text/css" href="<?= propertyUrl() ?>css/pickers/spectrum/spectrum.css">

    <link href="<?= propertyUrl() ?>css/extensions/redactor.css" rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="<?= propertyUrl() ?>css/extensions/toastr.css">

    <link rel="stylesheet" type="text/css" href="<?= propertyUrl() ?>css/tables/datatable/datatables.min.css"/>

    <link rel="stylesheet" type="text/css" href="<?= propertyUrl() ?>fonts/font-awesome/css/all.min.css">
    <!--    END VENDOR CSS-->
</head>
<body class="vertical-layout pace-done <?= sideBarAlignment() ?> <?= !$showNavBar ? "" : "vertical-menu 2-columns menu-collapsed fixed-navbar ";
echo $showNavBar ?>" data-open="hover" data-menu="vertical-menu" data-col="2-columns">
