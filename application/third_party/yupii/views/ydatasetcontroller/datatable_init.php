
    t.dataTable({
        "sPaginationType": "full_numbers",
        "sDom": '<"H"lfr>t<"F"ip>',
        "bProcessing": true,
        "bFilter": true,
        "aaSorting": [], //no se requiere ordenar al principio
        "bJQueryUI": false,
        "bLengthChange": true,
        "bServerSide": true,
        "sAjaxSource": "<?php echo  site_url($tc . '/getAjaxGridData') ?>",
        "bDeferRender": true,
        "oLanguage": {
            "sProcessing": "<?php echo  $this->lang->line('yupii_processing') ?>",
            "sLengthMenu": "<?php echo  $this->lang->line('yupii_show_n_records') ?>",
            "sZeroRecords": "<?php echo  $this->lang->line('yupii_no_records_found') ?>",
            "sInfo": "<?php echo  $this->lang->line('yupii_showing_from_to') ?>",
            "sInfoEmpty": "<?php echo  $this->lang->line('yupii_info_empty') ?>",
            "sInfoFiltered": "",
            "sInfoPostFix": "",
            "sSearch": "<?php echo  $this->lang->line('yupii_search') ?>:",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "<?php echo  $this->lang->line('yupii_first') ?>",
                "sPrevious": "<?php echo  $this->lang->line('yupii_prior') ?>",
                "sNext": "<?php echo  $this->lang->line('yupii_next') ?>",
                "sLast": "<?php echo  $this->lang->line('yupii_last') ?>"
            }
        },
        "fnServerData": fnData<?php echo  $t ?>
    });
