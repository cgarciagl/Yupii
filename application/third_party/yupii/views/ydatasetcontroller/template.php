<!DOCTYPE html>
<html lang="es">
<head>
    <base href="<?= config_item('base_url') ?>">
    <title>Yupii</title>
    <meta name="author" content="CGT">
    <meta http-equiv="content-type" CONTENT="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php Yupii::getHeaderAll(); ?>

    <style type="text/css">
        body, .container {
            padding: 0 !important;
        }
    </style>
</head>
<body class="">
<div class="container">
    <noscript>
        <h1 class='error'>Para utilizar las funcionalidades completas de este sitio es necesario tener JavaScript
            habilitado.</h1>

        <h1>Aquí están las <a href="http://www.enable-javascript.com/es/" target="_blank"> instrucciones para habilitar
                JavaScript en tu navegador web</a>.</h1>
    </noscript>
    <div>
        <div>
            <?php
            if (isset($content) && ($content != '')) {
                echo $content . PHP_EOL;
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>