<select name="nivel<?= $i ?>" class="nivelselect form-control">
    <option value=""></option>
    <?php foreach ($fieldlist as $k => $f): ?>
        <?php if (method_exists($f, 'getController')) : ?>
            <option value='<?= $f->getFieldName() ?>'
                    data-controller='<?= $f->getController() ?>'
                    data-filter='<?= base64_encode($f->getFilter()) ?>'>
                <?= $f->getLabel() ?>
            </option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>