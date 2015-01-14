<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <base href="<?php echo config_item('base_url'); ?>">
    <link rel="icon" href="./images/favicon.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="CGT">

    <?php Yupii::getHeaderAll(); ?>
    <title><?php echo get_instance()->config->item('yupii_application_title') ?></title>
    <style type="text/css">
        body {
            padding-top: 60px;
            padding-bottom: 40px;
        }
    </style>
    <link rel="stylesheet" href="./css/custom.css" type="text/css"/>

</head>
<body>
<div class="navbar navbar-default navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <span class="navbar-brand"></span>
            <h4 class="navbar-text navbar-right"><?php echo get_instance()->config->item('yupii_application_title') ?></h4>
        </div>
    </div>
</div>