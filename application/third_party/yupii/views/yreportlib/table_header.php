<table>
    <thead>
    <tr>
        <?php
        $c = (int)(100 / $cuantoscampos);
        foreach ($reportfields as $f) :
            ?>
            <td width='<?= $c ?>%'> <?php echo "{$modelo->ofieldlist[$f]->getLabel()}"; ?> </td>
        <?php endforeach; ?>
    </tr>
    </thead>
    <tbody>
