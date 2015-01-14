<script src="<?= base_url(); ?>/assets/js/jquery.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>/assets/js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript"
        src="<?= base_url(); ?>/assets/js/dataTables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/assets/js/utiles.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>/assets/js/yupii.js" type="text/javascript"></script>

<link rel="stylesheet" href="<?= base_url(); ?>/assets/css/bootstrap.min.css" type="text/css" media="all"/>
<link href="<?= base_url(); ?>/assets/css/font-awesome.min.css" rel="stylesheet">
<?php if (get_instance()->config->item('yupii_theme')): ?>
    <link rel="stylesheet"
          href="<?= base_url(); ?>/assets/css/themes/<?= get_instance()->config->item('yupii_theme') ?>/bootstrap.min.css"
          type="text/css"/>
<?php endif; ?>
<link rel="stylesheet" href="<?= base_url(); ?>/assets/css/yupii.css" type="text/css"/>