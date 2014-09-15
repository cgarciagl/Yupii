
    t.dataTable({
        "sPaginationType": "full_numbers",
        "sDom": '<"H"lfr>t<"F"ip>',
        "bProcessing": true,
        "bFilter": true,
        "aaSorting": [], //no se requiere ordenar al principio
        "bJQueryUI": false,
        "bLengthChange": true,
        "bServerSide": true,
        "sAjaxSource": "<?= site_url($tc . '/getAjaxGridData') ?>",
        "bDeferRender": true,
        "oLanguage": {
            "sProcessing": "<?= $this->lang->line('yupii_processing') ?>",
            "sLengthMenu": "<?= $this->lang->line('yupii_show_n_records') ?>",
            "sZeroRecords": "<?= $this->lang->line('yupii_no_records_found') ?>",
            "sInfo": "<?= $this->lang->line('yupii_showing_from_to') ?>",
            "sInfoEmpty": "<?= $this->lang->line('yupii_info_empty') ?>",
            "sInfoFiltered": "",
            "sInfoPostFix": "",
            "sSearch": "<?= $this->lang->line('yupii_search') ?>:",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "<?= $this->lang->line('yupii_first') ?>",
                "sPrevious": "<?= $this->lang->line('yupii_prior') ?>",
                "sNext": "<?= $this->lang->line('yupii_next') ?>",
                "sLast": "<?= $this->lang->line('yupii_last') ?>"
            }
        },
        "fnServerData": fnData<?= $t ?>
    });
