<div class="divfield col-sm-12">
    <div class='input-group' id='group_<?php echo  $name ?>'>
        <label class="control-label"><?php echo  $label; ?> :</label>
        <div class='input-group input-group'>
            <textarea name="<?php echo  $name ?>" id="<?php echo  $name ?>" class="form-control" rows="4" data-valueant='<?php echo  $value ?>' <?php echo  $extra_attributes ?> autocomplete="off" ><?php echo  $value ?></textarea>
        </div>
    </div>
</div>