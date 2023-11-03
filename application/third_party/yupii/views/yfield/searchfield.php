<div class="divfield col-sm-4 mr-1 mt-1">
    <div class='form-control' id='group_<?php echo $name ?>'>
        <label class="control-label"><?php echo $label; ?> </label>

        <div class='input-group'>
            <?php echo $this->load->view('yfield/inputfield', NULL, TRUE); ?>
            <script type='text/javascript'>
                $('#<?php echo  $name ?>').YupiiSearch({
                    controller: '<?php echo  $controller ?>',
                    filter: '<?php echo  base64_encode($filter) ?>'
                });
                $('#yupii_id_<?php echo  $name ?>').val('<?php echo  $idvalue ?>').attr('data-valueant', '<?php echo  $idvalue ?>');
            </script>
        </div>
    </div>
</div>