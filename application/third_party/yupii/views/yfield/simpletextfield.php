<div class="divfield col-sm-4 form-row mr-1 mt-1">
    <div class='form-control' id='group_<?php echo $name ?>'>
        <label class="control-label"><?php echo $label; ?> </label>
        <?php echo $this->load->view('yfield/inputfield', NULL, TRUE); ?>
    </div>
</div>