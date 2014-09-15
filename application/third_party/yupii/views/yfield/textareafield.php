<div class="divfield col-sm-12">
    <div class='input-group' id='group_<?= $name ?>'>
        <label class="control-label"><?= $label; ?> :</label>
        <div class='input-group input-group'>
            <textarea name="<?= $name ?>" id="<?= $name ?>" class="form-control" rows="4" data-valueant='<?= $value ?>' <?= $extra_attributes ?> autocomplete="off" ><?= $value ?></textarea>
        </div>
    </div>
</div>