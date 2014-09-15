<div class="divfield col-sm-4">
    <div class='input-group' id='group_<?= $name ?>'>
        <label class="control-label"><?= $label; ?> :</label>

        <div class='input-group'>
            <?= $this->load->view('yfield/inputfield'); ?>
            <script type='text/javascript'>
                $('#<?= $name ?>').YupiiSearch({controller: '<?= $controller ?>'});
                $('#yupii_id_<?= $name ?>').val('<?= $idvalue ?>').attr('data-valueant', '<?= $idvalue ?>');
            </script>
        </div>
    </div>
</div>    