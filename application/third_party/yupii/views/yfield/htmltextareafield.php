<div class="divfield col-sm-12">
    <div class='input-group' id='group_<?php echo $name ?>'>
        <label class="control-label"><?php echo $label; ?> </label>

        <div class='input-group input-group'>
            <input type='hidden' name='<?php echo $name ?>' id='<?php echo $name ?>' value='<?php echo $value ?>' data-valueant='<?php echo $value ?>'>

            <div class="htmltextarea" id="divsummernote<?php echo $name ?>">
                <?php echo $value ?>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>/assets/js/summernote.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/summernote.css" type="text/css" media="all" />
<script>
    $(document).ready(function() {
        $('.htmltextarea').summernote({
            onkeyup: function(e) {
                $("input[name='<?php echo  $name ?>']").val($("#divsummernote<?php echo  $name ?>").code().trim());
            },
            height: 100
        });
    });
</script>