<style type="text/css">
    .yupiireportresult h1 {
        padding: 5px;
        text-align: center;
        margin-bottom: 5px;
    }

    .yupiireportresult h2 {
        padding: 5px;
        text-align: center;
        margin-bottom: 5px;
    }

    .yupiireportresult {
        padding: 25px;
    }
</style>

<div class="panel panel-primary boxshadowround yupii-widget">
    <div class="panel-footer">
        <button style="margin-top:15px;" class="btn btn-primary btnbackreport">
            <i class="fa fa-chevron-circle-left fa-lg"></i>
            <?= $this->lang->line('yupii_back') ?>
        </button>
    </div>
    <div class="yupiireportresult">
        <?php echo $tabla; ?>
    </div>
    <div class="panel-footer">
        <button style="margin-top:15px;" class="btn btn-primary btnbackreport">
            <i class="fa fa-chevron-circle-left fa-lg"></i>
            <?= $this->lang->line('yupii_back') ?>
        </button>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        var b = $('.btnbackreport');
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

        $('.yupiireportresult table').addClass('table table-condensed');
    });
</script>        
