<div class="divfield col-sm-12">
    <div class='input-group' id='group_<?= $name ?>'>
        <label class="control-label"><?= $label; ?> :</label>

        <div class='input-group input-group'>
            <input type='hidden' name='<?= $name ?>' id='<?= $name ?>'
                   value='<?= $value ?>' data-valueant='<?= $value ?>'>

            <div class="htmltextarea" id="divsummernote<?= $name ?>">
                <?= $value ?>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url(); ?>/assets/js/summernote.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?= base_url(); ?>/assets/css/summernote.css" type="text/css" media="all"/>
<script>
    $(document).ready(function () {
        $('.htmltextarea').summernote({
            onkeyup: function (e) {
                $("input[name='<?= $name ?>']").val($("#divsummernote<?= $name ?>").code().trim());
            },
            height: 100
        });
    });
</script>