<script type="text/javascript">
    var todos = [];
    var demas = [];
    $(function () {
        var b = $('#btnback');
        if (stackwidgets.count() > 0) {
            b.show();
            b.click(function (e) {
                e.preventDefault();
                $(this).parents('.yupii-widget').first().remove();
                stackwidgets.pop().show('slide');
            });
        } else {
            b.hide();
        }

        $('#btn_pdf_<?= $t ?>_View_Report').click(function () {
            var y = $('#<?= $t ?>form_rep');
            y.find('input[name=typeofreport]').val('pdf');
            y.submit();
        });

        $('#btn_xls_<?= $t ?>_View_Report').click(function () {
            var y = $('#<?= $t ?>form_rep');
            y.find('input[name=typeofreport]').val('xls');
            y.submit();
        });

        $('#btn_htm_<?= $t ?>_View_Report').click(function () {
            var forma = $('#<?= $t ?>form_rep');
            forma.find('input[name=typeofreport]').val('htm');
            var widget = $(this).parents('.yupii-widget').first();
            var widget_container = widget.parent();
            widget.hide();
            stackwidgets.push(widget);
            stacksearches.push(t);
            var p = forma.serialize();
            getValue('<?= $tc ?>/showReport', p,
                function (s) {
                    $(s).appendTo(widget_container).show('slide');
                });
        });

        $('.nivelselect').change(function () {
            var v = $(this).find('option:selected').val();
            var i = $(this).parents('.nivel').index();
            var cont = $(this).find('option:selected').attr('data-controller');
            var fg = $(this).parent('.nivel').children('.filtergroup');
            if (v != '') {
                fg.removeClass('hide');
                var b = fg.find('.reportgroupfilter');
                b.YupiiSearch({controller: cont});
                b.val('');
                checklevels($(this));
            } else {
                fg.hide();
                $(this).parents('.yupii-widget').find('.nivel:gt(' + i + ')').each(function (index, Element) {
                    $(Element).find('.searchhiddenfield').val('');
                    $(Element).find('.yupiiffied').val('');
                    $(Element).hide();
                });
            }
        });

        function checklevels(t) {
            todos = t.parents('.yupii-widget').find('.nivel');
            todos.find('.nivelselect').find('option').removeClass('hide').prop('disabled', false);
            todos.each(function (i, e) {
                e = $(e);
                var i = e.index();
                var indexselected = e.find('.nivelselect').find('option:selected').index();
                demas = todos.filter(':gt(' + i + ')');
                demas.each(function (index, elem) {
                    $(elem).find('.nivelselect').find('option').eq(indexselected).addClass('hide').prop('disabled', true);
                    if ($(elem).find('.nivelselect').find('option:selected').index() == indexselected) {
                        $(elem).find('option[value=""]').attr('selected', 'selected');
                        $(elem).children('.filtergroup').hide();
                        $(elem).next('.nivel').hide();
                    }
                });
                if (e.find('.nivelselect').find('option').not('.hide').size() == 1) {
                    e.addClass('hide');
                }
                if (indexselected > 0) {
                    demas.first().removeClass('hide');
                }
            });

        }

        var e1 = $('.nivel').first();
        if (e1.find('.nivelselect').find('option').not('.hide').size() == 1) {
            e1.addClass('hide');
        }
    });
</script> 
