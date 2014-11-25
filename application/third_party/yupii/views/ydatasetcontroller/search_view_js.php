<script type="text/javascript">
    var t = $("#<?= $t ?>_table");

    $("#<?= $t ?>admin_div").hide();

    var <?= $t ?>_idactivo = '';

    function <?= $t ?>refreshAjax() {
        var oTable = $("#<?= $t ?>_table").dataTable();
        var sel = $('.yupii_selected_row').index();
        ;
        <?= $t ?>_preselect = sel;
        oTable.fnStandingRedraw();
    }

    $("#<?= $t ?>btn_search_admin").click(function (e) {
        e.preventDefault();
        $("#<?= $t ?>").hide('slide');
        $("#<?= $t ?>admin_container").html(getValue('<?= $tc ?>/tableByAjax/', yupii_csrf));
        $("#<?= $t ?>admin_div").show('slide');
    });

    $("#<?= $t ?>btn_search_admin_back").click(function (e) {
        e.preventDefault();
        $("#<?= $t ?>").show('slide');
        $("#<?= $t ?>admin_div").hide('slide');
        ;
        <?= $t ?>refreshAjax();
    });

    $("#<?= $t ?>btn_ok_search").click(function (e) {
        e.preventDefault();
        var tds = $("#<?= $t ?>_table tbody tr.yupii_selected_row").first().find("td");
        var fid = tds.last().attr('idr');
        var fname = tds.first().text();
        if (fid == undefined) {
            ResultData = {id: fid, name: undefined};
        }
        else {
            ResultData = {id: fid, name: fname};
        }
        $(this).parents('.yupii-widget').first().remove();
        var t = stacksearches.pop();
        if (t) {
            t.val(ResultData.name);
            t.data('id', ResultData.id);
            t.next().next('input[type=hidden]').val(ResultData.id);
        }
        stackwidgets.pop().show();
        //ponemos el foco en el siguiente control de input...
        t.parents('li').nextAll('li').first().find('input').first().focus();
    });

    $("#<?= $t ?>btn_cancel_search").click(function (e) {
        e.preventDefault();
        ResultData = {};
        $(this).parents('.yupii-widget').first().remove();
        stackwidgets.pop().show('slide');
    });

    <?php echo $this->load->view('ydatasetcontroller/datatable_init', array('t' => $t, 'tc' => $tc), TRUE); ?>

    $('#<?= $t ?>_table_filter').append($('#<?= $t ?>_combo'));

    var bodytable = $("#<?= $t ?>_table tbody");

    bodytable.delegate('tr', 'dblclick',
        function (ev) {
            ev.preventDefault();
            var op = $(this).find("td").last();
            if (op.attr('idr')) {
                ;
                <?= $t ?>_idactivo = op.attr('idr');
            } else {
                ;
                <?= $t ?>_idactivo = '';
            }
            //devolvemos los datos del registro(s) seleccionado(s)
            $("#<?= $t ?>btn_ok_search").trigger('click');
            return false;
        });

    bodytable.delegate('tr', 'mousedown',
        function (ev) {
            ev.preventDefault();
            var op = $(this).find("td").last();
            if (op.attr('idr')) {
                ;
                <?= $t ?>_idactivo = op.attr('idr');
            } else {
                ;
                <?= $t ?>_idactivo = '';
            }
            $("#<?= $t ?>_table tbody tr").removeClass('yupii_selected_row');
            $(this).addClass('yupii_selected_row');
            ResultData = {id: op.attr('idr'), name: $(this).find("td").first().text()};
        });

    //event for search on enter keyup or on blur

    $('#<?= $t ?>_Tablediv .dataTables_filter input').data('objtable', t).unbind('keyup').bind('keyup',function (e) {
        if (e.keyCode != 13)
            return;
        $('#<?= $t ?>_sel').focus();
    }).bind('change', function () {
        $(this).data('objtable').fnFilter($(this).val());
    });

    function fnData<?= $t ?>(sSource, aoData, fnCallback) {
        /* se agregan datos extras a la petición ajax */
        <?php if (config_item('csrf_protection')) : ?>
        aoData.push({
            "name": "<?= config_item('csrf_token_name') ?>",
            "value": "<?= $this->security->get_csrf_hash(); ?>"
        });
        <?php endif; ?>

        var sonlyfield = $('#<?= $t ?>_sel').val();
        if (sonlyfield != '') {
            aoData.push({
                "name": "sOnlyField",
                "value": sonlyfield
            });
        }

        var lookingfor = "<?= htmlspecialchars($this->input->post('sSearch', TRUE)); ?>";
        if ((lookingfor != '') && ($("#<?= $t ?>_table_filter input[type='text']").val() == '')) {
            aoData.push({
                "name": "sSearch",
                "value": lookingfor
            });
        }

        var sfilter = "<?= $this->input->post('sFilter', TRUE); ?>";
        if (sfilter != '') {
            aoData.push({
                "name": "sFilter",
                "value": sfilter
            });
        }

        $.ajax({
            "dataType": 'json',
            "type": "POST",
            "url": sSource,
            "data": aoData,
            "cache": false,
            "success": function (json) {
                fnCallback(json);
                ;
                <?= $t ?>_idactivo = '';
                if (json.aaData.length > 0) {
                    $("#<?= $t ?>_table tbody tr").each(
                        function () {
                            var op = $(this).find("td").last();
                            var id = op.text();
                            op.attr('idr', id);
                            op.html('');
                        });
                }
                if (json.sSearch != '') {
                    $("#<?= $t ?>_searching_title").text("<?= $this->lang->line('yupii_searching') ?>" + " (" + json.sSearch + ") ...").show();
                    ;
                } else {
                    $("#<?= $t ?>_searching_title").text("").hide();
                }

                var primerodelatabla = $("#<?= $t ?>_table tbody tr").first();
                primerodelatabla.addClass('yupii_selected_row');

                if ((json.aaData.length == 1) && (json.iTotalRecords == 1) && (json.sSearch != '')) {
                    //devolvemos los datos del registro(s) seleccionado(s)
                    $("#<?= $t ?>btn_ok_search").trigger('click');
                }

                $("#<?= $t ?>_Tablediv").find('.paginate_button, .paginate_active').addClass('btn btn-xs btn-info').removeClass('disabled').filter('.paginate_button_disabled, .paginate_active').addClass('disabled');
            }
        });
    }
</script>