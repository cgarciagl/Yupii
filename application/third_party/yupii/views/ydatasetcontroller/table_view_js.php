<script type="text/javascript">
var t = $("#<?= $t ?>_table");

var <?= $t ?>_preselect = 0;
var <?= $t ?>_idactivo = '';

function <?= $t ?>refreshAjax() {
    var oTable = $("#<?= $t ?>_table").dataTable();
    var sel = $('.yupii_selected_row').index();
    ;
    <?= $t ?>_preselect = sel;
    oTable.fnStandingRedraw();
}


$("#<?= $t ?>btn_cancel").click(function (e) {
    e.preventDefault();
    $('#<?= $t ?>tabs li:eq(1) a').tab('show');
    ;
    <?= $t ?>refreshAjax();
});


$("#<?= $t ?>btn_ok").click(function (e) {
    e.preventDefault();
    var forma = $('#<?= $t ?>_FormContent form');
    var a = forma.first().serializeObject();
    /* get the previous values for the controls*/
    var f = forma.first().find('[data-valueant]');
    $.each(f, function () {
        var s = 'yupii_value_ant_' + $(this).attr('name');
        a[s] = $(this).attr('data-valueant');
    });
    $.extend(a, yupii_csrf);
    /*limpiamos los errores anteriores*/
    forma.find('.ui-state-error').remove();
    $('.has-error').removeClass('has-error');
    var obj = getObject('<?= $tc ?>/formProcess', a);
    if (obj.result != 'ok') {
        $.each(obj.errors, function (i, val) {
            var gi = $("#group_" + i);
            gi.append('<span class="ui-state-error label label-danger">'
                + val + '</span>');
            $('#' + i).focus();
            gi.addClass('has-error').shake();
        });
    } else {
        $('#<?= $t ?>tabs li:eq(1) a').tab('show');
        ;
        <?= $t ?>refreshAjax();
    }
});

function <?= $t ?>getform(id) {
    $("#<?= $t ?>_FormContent").html(getValue('<?= $tc ?>/getFormData/' + id, yupii_csrf));
}

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    if ($(e.target).attr('href') == "#<?= $t ?>_Form") {
        if (<?= $t ?>_idactivo == '') {
            var op = $("#<?= $t ?>_table tbody").find('tr').first().find('td').last();
            if (op.attr('idr') != undefined) {
                ;
                <?= $t ?>_idactivo = op.attr('idr');
            } else {
                ;
                <?= $t ?>_idactivo = '';
            }
        }
        ;
        <?= $t ?>getform(<?= $t ?>_idactivo);
    }
});

<?php echo $this->load->view('ydatasetcontroller/datatable_init', array('t' => $t, 'tc' => $tc), TRUE); ?>

$('#<?= $t ?>_table_filter').append($('#<?= $t ?>_combo'));

var bodytable = $("#<?= $t ?>_table tbody");

bodytable.delegate('tr', 'dblclick',
    function (ev) {
        var op = $(this).find("td").last();
        if (op.attr('idr')) {
            ;
            <?= $t ?>_idactivo = op.attr('idr');
        } else {
            ;
            <?= $t ?>_idactivo = '';
        }
        $('#<?= $t ?>tabs a:first').tab('show');
        return false;
    });

bodytable.delegate('tr', 'mousedown',
    function (ev) {
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
    });


bodytable.delegate('.<?= $t ?>deleteme', 'click',
    function (ev) {
        var r = $(this).parent('tr');
        var todelete = $(this).attr('idr');
        r.addClass('todelete');
        var y = $('#<?= $t ?>myModal');
        y.find('.diverror').html('');
        y.modal({
            keyboard: false
        }).on('hidden.bs.modal', function () {
            $(' #<?= $t ?>_table').find('.todelete').removeClass('todelete');
            r.removeData('deleting');
        });
        return false;
    });


$('#<?= $t ?>btndelete').click(function () {
    var y = $(' #<?= $t ?>_table').find('.todelete').first();
    var todelete = y.find('td').last().attr('idr');
    y.removeClass('borrar');
    obj = {id: todelete};
    $.extend(obj, yupii_csrf);
    j = getObject('<?= $tc . '/getRecordByAjax' ?>', obj);
    <?php foreach($fieldlist as $f): ?>
      obj.yupii_value_ant_<?php echo $f->getFieldName(); ?> = j.<?php echo $f->getFieldName(); ?>;
    <?php endforeach; ?>
    var obj = getObject('<?= $tc . '/delete' ?>', obj);
    if (obj.result != 'ok') {
        $('#<?= $t ?>myModal').find('.diverror').html(obj.errors['general_error']);
    } else {
        ;
        <?= $t ?>refreshAjax();
        $('#<?= $t ?>myModal').modal('hide');
    }
});


//event for search on enter keyup or on blur
$('#<?= $t ?>_Tablediv .dataTables_filter input').data('objtable', t).unbind('keyup').bind('keyup',function (e) {
    if (e.keyCode != 13)
        return;
    $('#<?= $t ?>_sel').focus();
}).bind('change', function () {
    $(this).data('objtable').fnFilter($(this).val());
});

$('#btn_<?= $t ?>_New').click(
    function (e) {
        e.preventDefault();
        ;
        <?= $t ?>_idactivo = 'new';
        $('#<?= $t ?>tabs a:first').tab('show')
    });

$('#btn_<?= $t ?>_Refresh').click(
    function (e) {
        e.preventDefault();
        $("#<?= $t ?>_table").dataTable().fnDraw();
    });

$('#btn_<?= $t ?>_Print').click(
    function (e) {
        e.preventDefault();
        var widget = $(this).parents('.yupii-widget').first();
        var widget_container = widget.parent();
        widget.hide();
        stackwidgets.push(widget);
        stacksearches.push(t);
        var r = getValue('<?= $tc ?>/reportByAjax', yupii_csrf);
        $(r).appendTo(widget_container).show('slide');
    });


$('#<?= $t ?>_sel').change(function () {
    $('#btn_<?= $t ?>_Refresh').click();
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
                        <?php if ($this->modelo->canDelete): ?>
                        op.html('<i class="fa fa-trash fa-lg ybtndelete"></i>');
                        op.addClass('<?= $t ?>deleteme');
                        <?php else: ?>
                        op.html('');
                        <?php endif; ?>
                    });
            }
            if (json.sSearch != '') {
                $("#<?= $t ?>_searching_title").text("<?= $this->lang->line('yupii_searching') ?>" +
                    " (" + json.sSearch + ") ...").show();
            } else {
                $("#<?= $t ?>_searching_title").text("").hide();
            }
            if (<?= $t ?>_preselect > 0) {
                var r = $("#<?= $t ?>_table tbody tr").get(<?= $t ?>_preselect);
                if (r) {
                    var op = $(r).find("td").last();
                    if (op.attr('idr')) {
                        ;
                        <?= $t ?>_idactivo = op.attr('idr');
                    } else {
                        ;
                        <?= $t ?>_idactivo = '';
                    }
                    $(r).addClass('yupii_selected_row');
                }
            } else {
                $("#<?= $t ?>_table tbody tr").first().addClass('yupii_selected_row');
            }
            $("#<?= $t ?>_Tablediv").find('.paginate_button, .paginate_active').addClass('btn btn-xs btn-primary').removeClass('disabled').filter('.paginate_button_disabled, .paginate_active').addClass('disabled');
        }
    });
}
</script>