<select name="nivel<?php echo $i ?>" class="nivelselect form-control">
    <option value=""></option>
    <?php foreach ($fieldlist as $k => $f): ?>
        <?php if (method_exists($f, 'getController')) : ?>
            <option value='<?php echo $f->getFieldName() ?>'
                    data-controller='<?php echo $f->getController() ?>'
                    data-filter='<?php echo base64_encode($f->getFilter()) ?>'>
                <?php echo $f->getLabel() ?>
            </option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>