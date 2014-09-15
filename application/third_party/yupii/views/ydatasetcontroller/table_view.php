<?php
$t = uniqid($controller_name);
$tc = $controller_name;
?>

    <div id="<?= $t ?>" class="panel panel-primary yupii-widget">

        <?php if ($title) : ?>
            <div class="panel-heading text-center">
                <h4 style="margin-top:0;margin-bottom: 0;"><?= $title; ?></h4>
            </div>
        <?php endif; ?>

        <div id="<?= $t ?>tabs" class="panel-body">
            <ul class="nav nav-tabs">
                <li><a href="#<?= $t ?>_Form" data-toggle="tab">
                        <i class="fa fa-pencil fa-lg"></i>&nbsp;
                        <?= $this->lang->line('yupii_form_label') ?>
                    </a></li>
                <li class="active"><a href="#<?= $t ?>_Tablediv" data-toggle="tab">
                        <i class="fa fa-table fa-lg"></i>&nbsp;
                        <?= $this->lang->line('yupii_table_label') ?>
                    </a></li>
            </ul>
            <div class="tab-content">
                <div id="<?= $t ?>_Tablediv" class="tablediv tab-pane active">
                    <div id="<?= $t ?>_combo" style="display:inline;">
                        <span><?= $this->lang->line('yupii_in') ?>: </span>
                        <select name="<?= $t ?>_sel" id="<?= $t ?>_sel" class="">
                            <option value=""><?= $this->lang->line('yupii_all') ?></option>
                            <?php foreach ($tablefields as $f): ?>
                                <option value="<?= $f ?>">
                                    <?php echo $fieldlist[$f]->getLabel(); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="btn-toolbar" style="margin-top:10px;margin-bottom:10px;">
                        <div>
                            <?php if ($this->modelo->canInsert): ?>
                                <button id="btn_<?= $t ?>_New" class="toolbtn btn btn-primary">
                                    <i class="fa fa-plus-circle fa-lg"></i>
                                </button>
                            <?php endif; ?>
                            <button id="btn_<?= $t ?>_Refresh" class="toolbtn btn btn-primary">
                                <i class="fa fa-refresh fa-lg"></i>
                            </button>
                            <button id="btn_<?= $t ?>_Print" class="toolbtn btn btn-primary">
                                <i class="fa fa-print fa-lg"></i>
                            </button>
                            <button id="btn_<?= $t ?>_Filter" class="toolbtn btn btn-primary">
                                <i class="fa fa-filter fa-lg"></i>
                            </button>
                        </div>
                        <h4> <span class="label label-danger yupii-searchingtitle"
                                   id="<?= $t ?>_searching_title"></span></h4>
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
                <div id="<?= $t ?>_Form" class="tab-pane">
                    <div id="<?= $t ?>_FormContent" class="yupii-formcontent"></div>
                    <div class="panel-footer">
                        <button class='btn btn-success' id="<?= $t ?>btn_ok">
                            <i class="fa fa-check fa-lg"></i>&nbsp;<?= $this->lang->line('yupii_accept') ?>
                        </button>
                        <button class='btn btn-default' id="<?= $t ?>btn_cancel">
                            <i class="fa fa-undo fa-lg"></i>&nbsp;<?= $this->lang->line('yupii_cancel') ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="<?= $t ?>myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p><?= $this->lang->line('yupii_delete_message') ?></p>

                    <p class="diverror ui-state-error label label-danger"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-undo fa-lg"></i>&nbsp;<?= $this->lang->line('yupii_no') ?>
                    </button>
                    <button type="button" class="btn btn-danger" id="<?= $t ?>btndelete">
                        <i class="fa fa-check fa-lg"></i>&nbsp;<?= $this->lang->line('yupii_yes') ?>
                    </button>
                </div>
            </div>
        </div>
    </div>

<?php echo $this->load->view('ydatasetcontroller/table_view_js', array('t' => $t, 'tc' => $tc), TRUE); ?>