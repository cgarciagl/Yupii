<?php echo $this->load->view('process/partial_header', null, true); ?>
<link href="<?= base_url(); ?>/assets/css/forprint.css" rel="stylesheet" media="all">
<?php
$totalrecords = 0;
$grouprecords = 0;?>

<div class="container">

    <div class="row hidden-print navbar-fixed-top" id="barradebotones">
        <div class="col-md-1"></div>
        <?php echo anchor('admin/index', '<i class="fa fa-home"></i> Volver al panel', 'class="btn btn-primary span2 offset9"'); ?>
        <button id="imprimirbtn" class="btn btn-primary"><?= $this->lang->line('yupii_print') ?></button>
    </div>
    <br/>

    <?php $this->ysimplelevelreport->generate(); ?>

</div>

<script src="<?= base_url(); ?>/assets/js/printThis.js" type="text/javascript"></script>

<script>
    $(document).ready(function () {
        $('#imprimirbtn').click(function () {
            $('#imprimible').printThis({
                debug: false,
                importCSS: true,
                importStyle: false,
                printContainer: false,
                removeInline: true,
                loadCSS: "<?= base_url(); ?>/assets/css/forprint.css",
                pageTitle: "<?=$this->ysimplelevelreport->getTitle()?> <?= uniqid() ?>"
            });
        });
    });
</script>