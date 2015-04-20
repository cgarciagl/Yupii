{
"sEcho": <?php echo intval($this->input->post('sEcho', TRUE)) ?>,
"iTotalRecords": <?php echo $count ?>,
"more_data": " ",
"iTotalDisplayRecords":  <?php echo $count ?>,
"sSearch": "<?php echo $this->input->post('sSearch', TRUE) ?>",
"aaData": [
<?php
$datos    = $query->result_array();
$ultimate = end($datos); ?>
<?php foreach ($datos as $aRow) : ?>
    [
    <?php foreach ($modelo->tablefields as $f) : ?>
        "<?php echo $modelo->textForTable($aRow, $f); ?>",
    <?php endforeach; ?>
    "<?php echo addslashes($aRow[$modelo->id_field]) ?>"
    ]
    <?php if ($aRow !== $ultimate): ?> , <?php endif; ?>
<?php endforeach; ?>
] }