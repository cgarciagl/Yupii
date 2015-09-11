<?php
$t  = uniqid($controller_name);
$tc = $controller_name;
?>

    <div id="<?php echo $t ?>" class="panel panel-primary yupii-widget">

        <?php if ($title) : ?>
            <div class="panel-heading text-center">
                <h4 style="margin-top:0;margin-bottom: 0;"><?php echo $title; ?></h4>
            </div>
        <?php endif; ?>

        <div id="<?php echo $t ?>tabs" class="panel-body">
            <ul class="nav nav-tabs">
                <li><a href="#<?php echo $t ?>_Form" data-toggle="tab">
                        <i class="fa fa-pencil fa-lg"></i>&nbsp;
                        <?php echo $this->lang->line('yupii_form_label') ?>
                    </a></li>
                <li class="active"><a href="#<?php echo $t ?>_Tablediv" data-toggle="tab">
                        <i class="fa fa-table fa-lg"></i>&nbsp;
                        <?php echo $this->lang->line('yupii_table_label') ?>
                    </a></li>
            </ul>
            <div class="tab-content">
                <div id="<?php echo $t ?>_Tablediv" class="tablediv tab-pane active">
                    <div id="<?php echo $t ?>_combo" style="display:inline;">
                        <span><?php echo $this->lang->line('yupii_in') ?>: </span>
                        <select name="<?php echo $t ?>_sel" id="<?php echo $t ?>_sel" class="">
                            <option value=""><?php echo $this->lang->line('yupii_all') ?></option>
                            <?php foreach ($tablefields as $f): ?>
                                <option value="<?php echo $f ?>">
                                    <?php echo $fieldlist[ $f ]->getLabel(); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="btn-toolbar" style="margin-top:10px;margin-bottom:10px;">

                        <?php if (Yupii::get_CI()->activeYupiiObject->modelo->canInsert): ?>
                            <button id="btn_<?php echo $t ?>_New" class="toolbtn btn btn-primary">
                                <i class="fa fa-plus-circle fa-lg"></i>
                            </button>
                        <?php endif; ?>
                        <button id="btn_<?php echo $t ?>_Refresh" class="toolbtn btn btn-primary">
                            <i class="fa fa-refresh fa-lg"></i>
                        </button>
                        <button id="btn_<?php echo $t ?>_Print" class="toolbtn btn btn-primary">
                            <i class="fa fa-print fa-lg"></i>
                        </button>
                        <!-- <button id="btn_<?php echo $t ?>_Filter" class="toolbtn btn btn-primary">
                                <i class="fa fa-filter fa-lg"></i>
                            </button> -->
                        
                        <h4> <span class="label label-danger yupii-searchingtitle"
                                   id="<?php echo $t ?>_searching_title"></span></h4>
                    </div>
                    <table class="yupii_table table table-bordered table-condensed" id="<?php echo $t ?>_table">
                        <thead>
                        <tr>
                            <?php foreach ($tablefields as $f): ?>
                                <th><?php echo $fieldlist[ $f ]->getLabel(); ?></th>
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
                <div id="<?php echo $t ?>_Form" class="tab-pane">
                    <div id="<?php echo $t ?>_FormContent" class="yupii-formcontent"></div>
                    <div class="panel-footer">
                        <button class='btn btn-success' id="<?php echo $t ?>btn_ok">
                            <i class="fa fa-check fa-lg"></i>&nbsp;<?php echo $this->lang->line('yupii_accept') ?>
                        </button>
                        <button class='btn btn-default' id="<?php echo $t ?>btn_cancel">
                            <i class="fa fa-undo fa-lg"></i>&nbsp;<?php echo $this->lang->line('yupii_cancel') ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="<?php echo $t ?>myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p><?php echo $this->lang->line('yupii_delete_message') ?></p>

                    <p class="diverror ui-state-error label label-danger"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-undo fa-lg"></i>&nbsp;<?php echo $this->lang->line('yupii_no') ?>
                    </button>
                    <button type="button" class="btn btn-danger" id="<?php echo $t ?>btndelete">
                        <i class="fa fa-check fa-lg"></i>&nbsp;<?php echo $this->lang->line('yupii_yes') ?>
                    </button>
                </div>
            </div>
        </div>
    </div>

<?php echo $this->load->view('ydatasetcontroller/table_view_js',
    array('t' => $t, 'tc' => $tc, 'hasdetails' => $hasdetails),
    TRUE); ?>