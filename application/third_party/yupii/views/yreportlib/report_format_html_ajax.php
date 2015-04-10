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
            <?php echo  $this->lang->line('yupii_back') ?>
        </button>
        <button style="margin-top:15px;" class="btn btn-primary btnprint">
            <i class="fa fa-print fa-lg"></i>
            <?php echo  $this->lang->line('yupii_print') ?>
        </button>
    </div>
    <div class="yupiireportresult">
        <?php echo $tabla; ?>
    </div>
    <div class="panel-footer">
        <button style="margin-top:15px;" class="btn btn-primary btnbackreport">
            <i class="fa fa-chevron-circle-left fa-lg"></i>
            <?php echo  $this->lang->line('yupii_back') ?>
        </button>
        <button style="margin-top:15px;" class="btn btn-primary btnprint">
            <i class="fa fa-print fa-lg"></i>
            <?php echo  $this->lang->line('yupii_print') ?>
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

<script src="<?php echo  base_url(); ?>/assets/js/printThis.js" type="text/javascript"></script>

<script>
    $(document).ready(function () {
        $('.btnprint').click(function () {
            $('.yupiireportresult').printThis({
                debug: false,
                importCSS: true,
                importStyle: false,
                printContainer: false,
                removeInline: true,
                loadCSS: "<?php echo  base_url(); ?>/assets/css/forprint.css",
                pageTitle: "<?php echo $title?> <?php echo  uniqid() ?>"
            });
        });
    });
</script>