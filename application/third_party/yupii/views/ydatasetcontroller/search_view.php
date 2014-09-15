<?php
$t = uniqid($controller_name);
$tc = $controller_name;
?>

<div id="<?= $t ?>" class="panel panel-info boxshadowround yupii-widget yupii-search-widget">

    <?php if ($title) : ?>
        <div class="panel-heading text-center">
            <h4 style="margin-top:0;margin-bottom: 0;">
                <?= $this->lang->line('yupii_searching') ?> <?= $title; ?>
            </h4>
        </div>
    <?php endif; ?>
    <h4><span class="label label-danger yupii-searchingtitle" id="<?= $t ?>_searching_title"></span></h4>


    <div id="<?= $t ?>_Tablediv" class="tablediv panel-body">
        <div id="<?= $t ?>_combo" style="display:inline;">
            <span><?= $this->lang->line('yupii_in') ?>: </span>
            <select name="<?= $t ?>_sel" id="<?= $t ?>_sel" class="">
                <option value=""><?= $this->lang->line('yupii_all') ?></option>
                <?php foreach ($tablefields as $f): ?>
                    <option value="<?= $f ?>"><?php echo $fieldlist[$f]->getLabel(); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <table class="yupii_table table table-bordered table-condensed" id="<?= $t ?>_table">
            <thead>
            <tr>
                <?php foreach ($tablefields as $f): ?>
                    <th><?php echo $fieldlist[$f]->getLabel(); ?></th>
                <?php endforeach; ?>
                <th width="30px"></th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            </tfoot>
        </table>
    </div>
    <div class="panel-footer">

        <button id="<?= $t ?>btn_ok_search" class="btn btn-success">
            <i class="fa fa-check fa-lg"></i>&nbsp;<?= $this->lang->line('yupii_accept') ?>
        </button>
        <button id="<?= $t ?>btn_cancel_search" class="btn btn-default">
            <i class="fa fa-undo fa-lg"></i>&nbsp;<?= $this->lang->line('yupii_cancel') ?>
        </button>

        <button id="<?= $t ?>btn_search_admin" class="btn btn-primary col-md-offset-8 col-sm-offset-5">
            <i class="fa fa-pencil fa-lg"></i>&nbsp;
            <?= $this->lang->line('yupii_edit') ?>
        </button>
    </div>
</div>

<div id="<?= $t ?>admin_div" class="panel panel-danger">
    <div class="panel-footer" style="padding:0;">
        <button id="<?= $t ?>btn_search_admin_back" class="btn btn-success">
            <i class="fa fa-chevron-circle-left fa-lg"></i>&nbsp;
            <?= $this->lang->line('yupii_back') ?>
        </button>
    </div>
    <div id="<?= $t ?>admin_container" class="panel-body" style="padding-top:0;"></div>
</div>

<?php echo $this->load->view('ydatasetcontroller/search_view_js', array('t' => $t, 'tc' => $tc), TRUE); ?>
