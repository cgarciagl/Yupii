<script type="text/javascript">
    var t = $("#<?php echo  $t ?>_table");

    $("#<?php echo  $t ?>admin_div").hide();

    var <?php echo  $t ?>_idactivo = '';

    function <?php echo  $t ?>refreshAjax() {
        var oTable = $("#<?php echo  $t ?>_table").dataTable();
        var sel = $('.yupii_selected_row').index();
        ;
        <?php echo  $t ?>_preselect = sel;
        oTable.fnStandingRedraw();
    }

    $("#<?php echo  $t ?>btn_search_admin").click(function (e) {
        e.preventDefault();
        $("#<?php echo  $t ?>").hide('slide');
        getValue('<?php echo  $tc ?>/tableByAjax/', yupii_csrf,
            function (s) {
                $("#<?php echo  $t ?>admin_container").html(s);
                $("#<?php echo  $t ?>admin_div").show('slide');
            });
    });

    $("#<?php echo  $t ?>btn_search_admin_back").click(function (e) {
        e.preventDefault();
        $("#<?php echo  $t ?>").show('slide');
        $("#<?php echo  $t ?>admin_div").hide('slide');
        ;
        <?php echo  $t ?>refreshAjax();
    });

    $("#<?php echo  $t ?>btn_ok_search").click(function (e) {
        e.preventDefault();
        var tds = $("#<?php echo  $t ?>_table tbody tr.yupii_selected_row").first().find("td");
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

    $("#<?php echo  $t ?>btn_cancel_search").click(function (e) {
        e.preventDefault();
        ResultData = {};
        $(this).parents('.yupii-widget').first().remove();
        stackwidgets.pop().show('slide');
    });

    <?php echo $this->load->view('ydatasetcontroller/datatable_init', array('t' => $t, 'tc' => $tc), TRUE); ?>

    $('#<?php echo  $t ?>_table_filter').append($('#<?php echo  $t ?>_combo'));

    var bodytable = $("#<?php echo  $t ?>_table tbody");

    bodytable.delegate('tr', 'dblclick',
        function (ev) {
            ev.preventDefault();
            var op = $(this).find("td").last();
            if (op.attr('idr')) {
                ;
                <?php echo  $t ?>_idactivo = op.attr('idr');
            } else {
                ;
                <?php echo  $t ?>_idactivo = '';
            }
            //devolvemos los datos del registro(s) seleccionado(s)
            if (!op.hasClass('dataTables_empty')) {
                $("#<?php echo  $t ?>btn_ok_search").trigger('click');
            }
            return false;
        });

    bodytable.delegate('tr', 'mousedown',
        function (ev) {
            ev.preventDefault();
            var op = $(this).find("td").last();
            if (op.attr('idr')) {
                ;
                <?php echo  $t ?>_idactivo = op.attr('idr');
            } else {
                ;
                <?php echo  $t ?>_idactivo = '';
            }
            $("#<?php echo  $t ?>_table tbody tr").removeClass('yupii_selected_row');
            $(this).addClass('yupii_selected_row');
            ResultData = {id: op.attr('idr'), name: $(this).find("td").first().text()};
        });

    //event for search on enter keyup or on blur

    $('#<?php echo  $t ?>_Tablediv .dataTables_filter input').data('objtable', t).unbind('keyup').bind('keyup', function (e) {
        if (e.keyCode != 13)
            return;
        $('#<?php echo  $t ?>_sel').focus();
    }).bind('change', function () {
        $(this).data('objtable').fnFilter($(this).val());
    });

    function fnData<?php echo  $t ?>(sSource, aoData, fnCallback) {
        /* se agregan datos extras a la petición ajax */
        <?php if (config_item('csrf_protection')) : ?>
        aoData.push({
            "name": "<?php echo  config_item('csrf_token_name') ?>",
            "value": "<?php echo  $this->security->get_csrf_hash(); ?>"
        });
        <?php endif; ?>

        var sonlyfield = $('#<?php echo  $t ?>_sel').val();
        if (sonlyfield != '') {
            aoData.push({
                "name": "sOnlyField",
                "value": sonlyfield
            });
        }

        var lookingfor = "<?php echo  htmlspecialchars($this->input->post('sSearch', TRUE)); ?>";
        if ((lookingfor != '') && ($("#<?php echo  $t ?>_table_filter input[type='text']").val() == '')) {
            aoData.push({
                "name": "sSearch",
                "value": lookingfor
            });
        }

        var sfilter = "<?php echo  $this->input->post('sFilter', TRUE); ?>";
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
            "error": function (xhr, textStatus, error) {
                if (textStatus === 'timeout') {
                    alert('<?php echo  $this->lang->line('yupii_timeout_error') ?>');
                }
                else {
                    console.log(xhr.responseText);
                    alert('<?php echo  $this->lang->line('yupii_server_error') ?>');
                }
                t.fnProcessingIndicator(false);
            },
            "success": function (json) {
                fnCallback(json);
                ;
                <?php echo  $t ?>_idactivo = '';
                if (json.aaData.length > 0) {
                    $("#<?php echo  $t ?>_table tbody tr").each(
                        function () {
                            var op = $(this).find("td").last();
                            var id = op.text();
                            op.attr('idr', id);
                            op.html('');
                        });
                }
                if (json.sSearch != '') {
                    $("#<?php echo  $t ?>_searching_title").text("<?php echo  $this->lang->line('yupii_searching') ?>" + " (" + json.sSearch + ") ...").show();
                    ;
                } else {
                    $("#<?php echo  $t ?>_searching_title").text("").hide();
                }

                var primerodelatabla = $("#<?php echo  $t ?>_table tbody tr").first();
                primerodelatabla.addClass('yupii_selected_row');

                if ((json.aaData.length == 1) && (json.iTotalRecords == 1) && (json.sSearch != '')) {
                    //devolvemos los datos del registro(s) seleccionado(s)
                    $("#<?php echo  $t ?>btn_ok_search").trigger('click');
                }

                $("#<?php echo  $t ?>_Tablediv").find('.paginate_button, .paginate_active').addClass('btn btn-xs btn-info').removeClass('disabled').filter('.paginate_button_disabled, .paginate_active').addClass('disabled');
            }
        });
    }
</script>