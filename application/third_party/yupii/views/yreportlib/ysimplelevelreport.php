<?php echo $this->load->view('process/partial_header', NULL, TRUE); ?>
<link href="<?php echo base_url(); ?>/assets/css/forprint.min.css" rel="stylesheet" media="all">
<?php
$totalrecords = 0;
$grouprecords = 0; ?>

<div class="container">

    <div class="row hidden-print navbar-fixed-top" id="barradebotones">
        <div class="col-md-1"></div>
        <?php echo anchor($rutadevuelta, '<i class="fa fa-home"></i> Volver', 'class="btn btn-primary span2 offset9"'); ?>
        <button id="imprimirbtn" class="btn btn-primary"><?php echo $this->lang->line('yupii_print') ?></button>
        <button id="exporttoexcel" class="btn btn-primary">
            Guardar como Documento de Excel
        </button>
    </div>
    <br />

    <?php $this->ysimplelevelreport->generate(); ?>

</div>

<script src="<?php echo base_url(); ?>/assets/js/printThis.min.js" type="text/javascript"></script>

<script>
    $(document).ready(function() {
        $('#imprimirbtn').click(function() {
            $('#imprimible').printThis({
                debug: false,
                importCSS: true,
                importStyle: false,
                printContainer: false,
                removeInline: true,
                loadCSS: "<?php echo  base_url(); ?>/assets/css/forprint.min.css",
                pageTitle: "<?php echo $this->ysimplelevelreport->getTitle() ?> <?php echo  uniqid() ?>"
            });
        });

        $('#exporttoexcel').click(function() {
            // window.open('data:application/vnd.ms-excel,'+$('#imprimible').html());
            var dt = new Date();
            var day = dt.getDate();
            var month = dt.getMonth() + 1;
            var year = dt.getFullYear();
            var hour = dt.getHours();
            var mins = dt.getMinutes();
            var postfix = day + "." + month + "." + year + "_" + hour + "." + mins;
            //creating a temporary HTML link element (they support setting file names)
            var a = document.createElement('a');
            //getting data from our div that contains the HTML table
            var data_type = 'data:application/vnd.ms-excel';
            var table_div = $('#imprimible');
            var table_html = $('#imprimible').html().replace(/ /g, '%20');
            a.href = data_type + ', ' + table_html;
            //setting the file name
            a.download = 'exportado_' + postfix + '.xls';
            //triggering the function
            a.click();
            //just in case, prevent default behaviour
            e.preventDefault();
        });
    });
</script>