<input type="<?= $type ?>" name="<?= $name ?>" id="<?= $name ?>" value="<?= $value ?>"
       class="form-control"
    <?php if (config_item('yupii_all_to_uppercase')) : ?>
        onChange="this.value = this.value.toUpperCase();"
    <?php endif; ?>
       data-valueant='<?= $value ?>' <?= $extra_attributes ?> autocomplete="off">