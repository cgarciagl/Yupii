<div class="divfield col-sm-4">
    <div class='input-group' id='group_<?= $name ?>'>
        <label class="control-label"><?= $label; ?> :</label>
        <?php
        $this->load->helper('form');
        echo form_dropdown($name, $options, $value,
            'data-valueant ="' . $value . '" class="form-control" ' . $extra_attributes); ?>
    </div>
</div>