{
"sEcho": <?php echo intval($this->input->post('sEcho', TRUE)) ?>,
"iTotalRecords": <?php echo $count ?>,
"more_data": " ",
"iTotalDisplayRecords":  <?php echo $count ?>,
"sSearch": "<?php echo $this->input->post('sSearch', TRUE) ?>",
"aaData": [
<?php $ultimate = end($query->result_array()); ?>
<?php foreach ($query->result_array() as $aRow) : ?>
    [
    <?php foreach ($modelo->tablefields as $f) : ?>
        "<?php echo addslashes($aRow[$modelo->realField($f)]) ?>",
    <?php endforeach; ?>
    "<?php echo addslashes($aRow[$modelo->id_field]) ?>"
    ]
    <?php if ($aRow !== $ultimate): ?> , <?php endif; ?>
<?php endforeach; ?>
] }