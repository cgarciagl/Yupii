<script src="<?php echo base_url(); ?>/assets/js/moment-with-locales.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>/assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

<div class="divfield col-sm-4">
    <div class='input-group' id='group_<?php echo $name ?>'>
        <label class="control-label"><?php echo $label; ?> :</label>

        <div class='input-group date' id='<?php echo $name ?>datetimepicker'>
            <input name="<?php echo $name; ?>" type='text' class="form-control"
                   value="<?php echo $value ?>"
                   data-valueant="<?php echo $value ?>" <?php echo $extra_attributes; ?> />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#<?php echo $name ?>datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:SS',
                locale: 'es'
            }).data("DateTimePicker");
        });
    </script>
</div>