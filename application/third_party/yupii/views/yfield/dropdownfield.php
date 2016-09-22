<div class="divfield col-sm-4">
    <div class='input-group' id='group_<?php echo $name ?>'>
        <label class="control-label"><?php echo $label; ?> :</label>
        <?php
        $this->load->helper('form');
        echo form_dropdown($name, $options, $value,
            'data-valueant ="' . $value . '" class="form-control" ' . $extra_attributes); ?>
    </div>
    <script>
        $(document).ready(function () {
            p = $('select[name="<?php echo $name ?>"]');
            if (p.is('[readonly]')) {
                p.prop("disabled", true);
                p.removeAttr("data-valueant");
            }
        });
    </script>
</div>