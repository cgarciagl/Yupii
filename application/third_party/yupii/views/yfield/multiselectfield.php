<script src="<?php echo base_url(); ?>/assets/js/bootstrap-multiselect.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>/assets/css/bootstrap-multiselect.css" rel="stylesheet">

<div class="divfield col-sm-4">
    <div class='input-group' id='group_<?php echo $name ?>'>
        <label class="control-label"><?php echo $label; ?> :</label>
        <?php
        $this->load->helper('form');
        echo form_dropdown($name . '_yupiitemp', $options, $value,
            'data-valueant ="' . $value . '" class="form-control" multiple="multiple" ' . $extra_attributes); ?>
        <input type="hidden" name="<?php echo $name; ?>" value="<?php echo $value; ?>"/>
    </div>
    <script>
        $(document).ready(function () {
            $m = $('select[name="<?php echo $name ?>_yupiitemp"]').multiselect({
                buttonClass: 'btn btn-danger',
                nonSelectedText: 'Seleccione:',
                allSelectedText: 'Se ha seleccionado todo ...',
                nSelectedText: ' - ha seleccionado varios ...',
                onChange: function (option, checked, select) {
                    var s = '';
                    $opciones = $('select[name="<?php echo $name ?>_yupiitemp"] option:selected');
                    $opciones.each(function (index, value) {
                        if (s != '') {
                            s = s + ',';
                        }
                        s = s + $(this).attr('value');
                    });
                    $('input[name="<?php echo $name ?>"]').attr('value', s);
                }
            });

            var s = $('input[name="<?php echo $name ?>"]').attr('value');
            $b = s.split(',');
            $('select[name="<?php echo $name ?>_yupiitemp"]').multiselect('select', $b, true);
        });
    </script>
</div>