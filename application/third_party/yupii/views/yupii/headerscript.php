<script type="text/javascript">
    var base_url = '<?php echo  config_item('base_url') ?>';
    var wait_label = '<?php echo  $this->lang->line('yupii_wait') ?>';

    var yupii_csrf = {};

    <?php if (config_item('csrf_protection')) : ?>
    yupii_csrf = {
        "<?php echo  config_item('csrf_token_name') ?>": "<?php echo  $this->security->get_csrf_hash(); ?>"
    };
    <?php endif; ?>
</script>