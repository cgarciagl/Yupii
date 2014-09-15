<div class="panel panel-primary boxshadowround yupii-widget">
    <?php $t = uniqid($controller_name); ?>
    <?php $tc = $controller_name; ?>
    <?php if ($title) : ?>
        <div class="panel-heading text-center">
            <h4 style="margin-top:0;margin-bottom: 0;"> <?= $this->lang->line('yupii_report_of') ?> <?= $title; ?> </h4>
        </div>
    <?php endif; ?>
    <div class="panel-footer">
        <button id="btnback" style="margin-top:15px;" class="btn btn-primary">
            <i class="fa fa-chevron-circle-left fa-lg"></i>
            <?= $this->lang->line('yupii_back') ?>
        </button>
    </div>
    <hr/>
    <div class="btn-toolbar" style="margin-left:15px;">
        <div class="btn-group">
            <button id="btn_xls_<?= $t ?>_View_Report" class="toolbtn btn">
                <i class="fa fa-fire fa-lg"></i>EXCEL
            </button>
            <button id="btn_htm_<?= $t ?>_View_Report" class="toolbtn btn">
                <i class="fa fa-fire fa-lg"></i>HTML
            </button>
            <button id="btn_chart_<?= $t ?>_View_Report" class="toolbtn btn">
                <i class="fa fa-bar-chart fa-lg"></i>
            </button>
        </div>
    </div>
    <div class="boxshadowround row" style="padding:5px;margin:5px;">
        <?=
        form_open("{$tc}/showReport", array('id' => "{$t}form_rep", 'method' => 'post'))
        ?>
        <input type="hidden" name="typeofreport"/>

        <div class="grupos col-md-12">
            <?php for ($i = 1; $i <= 3; $i++) : ?>
                <div class="nivel well rplevel col-md-5 <?php
                if ($i > 1) {
                    echo "hide";
                }
                ?>">
                    <h5>Grupo</h5>
                    <?php
                    echo $this->load->view('ydatasetcontroller/group_level_control_view', array('fieldlist' => $fieldlist, 'i' => $i), TRUE);
                    ?>
                    <div class="filtergroup hide">
                        <h5>Filtro</h5>

                        <div class=''>
                            <div class='rpfilter input-group input-group-lg'>
                                <input type="text" class="reportgroupfilter form-control" name="filter<?= $i ?>"/>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
        </form>
    </div>
    <?php echo $this->load->view('ydatasetcontroller/report_view_js', array('t' => $t, 'tc' => $tc), TRUE); ?>
</div>