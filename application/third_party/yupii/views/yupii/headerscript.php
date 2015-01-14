<script type="text/javascript">
    var base_url = '<?= config_item('base_url') ?>';
    var wait_label = '<?= $this->lang->line('yupii_wait') ?>';

    var yupii_csrf = {};

    <?php if (config_item('csrf_protection')) : ?>
    yupii_csrf = {
        "<?= config_item('csrf_token_name') ?>": "<?= $this->security->get_csrf_hash(); ?>"
    };
    <?php endif; ?>
</script>