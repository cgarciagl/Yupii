{
"sEcho": <?= intval($this->input->post('sEcho', TRUE)) ?>,
"iTotalRecords": <?= $count ?>,
"more_data": " ",
"iTotalDisplayRecords":  <?= $count ?>,
"sSearch": "<?= $this->input->post('sSearch', TRUE) ?>",
"aaData": [
<?php $ultimate = end($query->result_array()); ?>
<?php foreach ($query->result_array() as $aRow) : ?>
    [
    <?php foreach ($modelo->tablefields as $f) : ?>
        "<?= addslashes($aRow[$modelo->realField($f)]) ?>",
    <? endforeach; ?>
    "<?= addslashes($aRow[$modelo->id_field]) ?>"
    ]
    <?php if ($aRow !== $ultimate): ?> , <?php endif; ?>
<? endforeach; ?>
] }