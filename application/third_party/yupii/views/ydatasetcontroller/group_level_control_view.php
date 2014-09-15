<select name="nivel<?= $i ?>" class="nivelselect form-control">
    <option value=""></option>
    <?php foreach ($fieldlist as $k => $f): ?>
        <?php if (method_exists($f, 'getController')) : ?>
            <option value='<?= $f->getFieldName() ?>'
                    data-controller='<?= $f->getController() ?>'>
                <?= $f->getLabel() ?>
            </option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>