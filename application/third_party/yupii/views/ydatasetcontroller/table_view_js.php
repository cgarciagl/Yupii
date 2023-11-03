<script type="text/javascript">
    var t = $("#<?php echo  $t ?>_table");

    var <?php echo  $t ?>_preselect = 0;
    var <?php echo  $t ?>_idactivo = '';

    function <?php echo  $t ?>refreshAjax() {
        var oTable = $("#<?php echo  $t ?>_table").dataTable();
        var sel = $('.yupii_selected_row').index();
        <?php echo  $t ?>_preselect = sel;
        if (oTable && oTable.fnStandingRedraw) {
            oTable.fnStandingRedraw();
        }
    }


    $("#<?php echo  $t ?>btn_cancel").click(function(e) {
        e.preventDefault();
        $('#<?php echo  $t ?>tabs li:eq(1) a').tab('show');
        <?php echo  $t ?>refreshAjax();
    });


    $("#<?php echo  $t ?>btn_ok").click(function(e) {
        e.preventDefault();
        var forma = $('#<?php echo  $t ?>_FormContent form');
        var a = forma.first().serializeObject();
        /* get the previous values for the controls*/
        var f = forma.first().find('[data-valueant]');
        $.each(f, function() {
            var s = 'yupii_value_ant_' + $(this).attr('name');
            a[s] = $(this).attr('data-valueant');
        });
        $.extend(a, yupii_csrf);
        /*limpiamos los errores anteriores*/
        forma.find('.ui-state-error').remove();
        $('.has-error').removeClass('has-error');
        getObject('<?php echo  $tc ?>/formProcess', a, function(obj) {
            if (obj.result != 'ok') {
                $.each(obj.errors, function(i, val) {
                    var gi = forma.find(" #group_" + i);
                    gi.find('.ui-state-error').remove();
                    gi.append('<span class="ui-state-error label label-danger">' +
                        val + '</span>');
                    $('#' + i).focus();
                    gi.addClass('has-error').shake();
                });
            } else {
                <?php if ($hasdetails) : ?>
                    if (obj.insertedid) {
                        <?php echo  $t ?>getform(obj.insertedid);
                    } else {
                        $('#<?php echo  $t ?>tabs li:eq(1) a').tab('show');
                        <?php echo  $t ?>refreshAjax();
                    }
                <?php else : ?>
                    $('#<?php echo  $t ?>tabs li:eq(1) a').tab('show');
                    <?php echo  $t ?>refreshAjax();
                <?php endif; ?>
            }
        });
    });

    function <?php echo  $t ?>getform(id) {
        $("#<?php echo  $t ?>_FormContent").html('');
        getValue('<?php echo  $tc ?>/getFormData/' + id, yupii_csrf, function(s) {
            $("#<?php echo  $t ?>_FormContent").hide();
            $("#<?php echo  $t ?>_FormContent").html(s);
            $("#<?php echo  $t ?>_FormContent").fadeIn();
        });
    }

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        if ($(e.target).attr('href') == "#<?php echo  $t ?>_Form") {
            if (<?php echo  $t ?>_idactivo == '') {
                var op = $("#<?php echo  $t ?>_table tbody").find('tr').first().find('td').last();
                if (op.attr('idr') != undefined) {
                    ;
                    <?php echo  $t ?>_idactivo = op.attr('idr');
                } else {
                    ;
                    <?php echo  $t ?>_idactivo = '';
                }
            };
            <?php echo  $t ?>getform(<?php echo  $t ?>_idactivo);
        }
    });

    <?php echo $this->load->view('ydatasetcontroller/datatable_init', array('t' => $t, 'tc' => $tc), TRUE); ?>

    $('#<?php echo  $t ?>_table_filter').append($('#<?php echo  $t ?>_combo'));

    var bodytable = $("#<?php echo  $t ?>_table tbody");

    bodytable.delegate('tr', 'dblclick',
        function(ev) {
            var op = $(this).find("td").last();
            if (op.attr('idr')) {
                ;
                <?php echo  $t ?>_idactivo = op.attr('idr');
            } else {
                ;
                <?php echo  $t ?>_idactivo = '';
            }
            if (!op.hasClass('dataTables_empty')) {
                $('#<?php echo  $t ?>tabs a:first').tab('show');
            }
            return false;
        });

    bodytable.delegate('tr', 'mousedown',
        function(ev) {
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
        });


    bodytable.delegate('.<?php echo  $t ?>deleteme', 'click',
        function(ev) {
            var r = $(this).parent('tr');
            var todelete = $(this).attr('idr');
            r.addClass('todelete');
            var y = $('#<?php echo  $t ?>myModal');
            y.find('.diverror').html('');
            y.modal({
                keyboard: false
            }).on('hidden.bs.modal', function() {
                $(' #<?php echo  $t ?>_table').find('.todelete').removeClass('todelete');
                r.removeData('deleting');
            });
            return false;
        });


    $('#<?php echo  $t ?>btndelete').click(function() {
        var y = $(' #<?php echo  $t ?>_table').find('.todelete').first();
        var todelete = y.find('td').last().attr('idr');
        y.removeClass('borrar');
        obj = {
            id: todelete
        };
        $.extend(obj, yupii_csrf);
        getObject('<?php echo  $tc . '/getRecordByAjax' ?>', obj, function(j) {
            <?php foreach ($fieldlist as $f) : ?>
                obj.yupii_value_ant_<?php echo $f->getFieldName(); ?> = j.<?php echo $f->getFieldName(); ?>;
            <?php endforeach; ?>

            getObject('<?php echo  $tc . '/delete' ?>', obj, function(obj) {
                if (obj.result != 'ok') {
                    $('#<?php echo  $t ?>myModal').find('.diverror').html(obj.errors['general_error']);
                } else {
                    ;
                    <?php echo  $t ?>refreshAjax();
                    $('#<?php echo  $t ?>myModal').modal('hide');
                }
            });
        });
    });


    //event for search on enter keyup or on blur
    $('#<?php echo  $t ?>_Tablediv .dataTables_filter input').data('objtable', t).unbind().bind('keyup', function(e) {
        if (e.keyCode != 13)
            return;
        $('#<?php echo  $t ?>_sel').focus();
    }).bind('change', function() {
        $(this).data('objtable').fnFilter($(this).val());
    });

    $('#btn_<?php echo  $t ?>_New').click(
        function(e) {
            e.preventDefault();;
            <?php echo  $t ?>_idactivo = 'new';
            $('#<?php echo  $t ?>tabs a:first').tab('show')
        });

    $('#btn_<?php echo  $t ?>_Refresh').click(
        function(e) {
            e.preventDefault();
            $("#<?php echo  $t ?>_table").dataTable().fnDraw();
        });

    $('#btn_<?php echo  $t ?>_Print').click(
        function(e) {
            e.preventDefault();
            var widget = $(this).closest('.yupii-widget').first();
            var widget_container = widget.parent();
            widget.hide();
            stackwidgets.push(widget);
            stacksearches.push(t);
            getValue('<?php echo  $tc ?>/reportByAjax', yupii_csrf,
                function(r) {
                    $(r).appendTo(widget_container).show('slide');
                });
        });


    $('#<?php echo  $t ?>_sel').change(function() {
        $('#btn_<?php echo  $t ?>_Refresh').click();
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

        $.ajax({
            "dataType": 'json',
            "type": "POST",
            "url": sSource,
            "data": aoData,
            "cache": false,
            "error": function(xhr, textStatus, error) {
                if (textStatus === 'timeout') {
                    alert('<?php echo  $this->lang->line('yupii_timeout_error') ?>');
                } else {
                    console.log(xhr.responseText);
                    alert('<?php echo  $this->lang->line('yupii_server_error') ?>');
                }
                t.fnProcessingIndicator(false);
            },
            "success": function(json) {
                fnCallback(json);;
                <?php echo  $t ?>_idactivo = '';
                if (json.aaData.length > 0) {
                    $("#<?php echo  $t ?>_table tbody tr").each(
                        function() {
                            var op = $(this).find("td").last();
                            var id = op.text();
                            op.attr('idr', id);
                            <?php if (Yupii::get_CI()->activeYupiiObject->modelo->canDelete) : ?>
                                op.html('<i class="fa fa-trash fa-lg ybtndelete"></i>');
                                op.addClass('<?php echo  $t ?>deleteme');
                            <?php else : ?>
                                op.html('');
                            <?php endif; ?>
                        });
                }
                if (json.sSearch != '') {
                    $("#<?php echo  $t ?>_searching_title").text("<?php echo  $this->lang->line('yupii_searching') ?>" +
                        " (" + json.sSearch + ") ...").show();
                } else {
                    $("#<?php echo  $t ?>_searching_title").text("").hide();
                }
                if (<?php echo  $t ?>_preselect > 0) {
                    var r = $("#<?php echo  $t ?>_table tbody tr").get(<?php echo  $t ?>_preselect);
                    if (r) {
                        var op = $(r).find("td").last();
                        if (op.attr('idr')) {
                            ;
                            <?php echo  $t ?>_idactivo = op.attr('idr');
                        } else {
                            ;
                            <?php echo  $t ?>_idactivo = '';
                        }
                        $(r).addClass('yupii_selected_row');
                    }
                } else {
                    $("#<?php echo  $t ?>_table tbody tr").first().addClass('yupii_selected_row');
                }
                $("#<?php echo  $t ?>_Tablediv").find('.paginate_button, .paginate_active').addClass('').removeClass('disabled').filter('.paginate_button_disabled, .paginate_active').addClass('disabled');
            }
        });
    }
</script>