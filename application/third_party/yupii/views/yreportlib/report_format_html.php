<html>
<head>

    <base href="<?= config_item('base_url') ?>">
    <meta http-equiv="content-type" CONTENT="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte</title>

    <?php if (in_array($this->input->post('typeofreport', TRUE), array('htm'))) : ?>
        <link rel="stylesheet" href="./assets/css/bootstrap.min.css" type="text/css"/>

        <?php if (config_item('yupii_theme')): ?>
            <link rel="stylesheet"
                  href="./assets/css/themes/<?= config_item('yupii_theme') ?>/bootstrap.min.css"
                  type="text/css"/>
        <?php endif; ?>

        <link rel="stylesheet" href="./assets/css/yupii.css" type="text/css"/>
    <?php endif; ?>

    <style type="text/css">
        h1 {
            padding: 5px;
            text-align: center;
            margin-bottom: 5px;
        }

        h2 {
            padding: 5px;
            text-align: center;
            margin-bottom: 5px;
        }

        h3 {
            margin-left: 0;
        }

        h4 {
            margin-left: 15px;
        }

        table {
            width: 100%;
            border-collapse: inherit;
        }

        <?php if ($this->input->post('typeofreport', TRUE) == 'pdf') : ?>
        thead {
            font-weight: bolder;
        }

        <?php endif; ?>
    </style>

</head>
<body>
<div class="container">
    <div class="ui-widget ui-widget-content ui-corner-all">
        <?= $tabla ?>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('table').width('100%').addClass('ui-widget-content');
        $('thead').addClass('ui-widget-header');
        $('tfoot').addClass('ui-widget-header');
        $('h1').addClass('ui-widget-header ui-corner-all');
        $('h2').addClass('ui-state-highlight ui-corner-all');
    });
</script>
</body>
</html>