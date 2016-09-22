<table>
    <thead>
    <tr>
        <?php
        $c = (int)(100 / $cuantoscampos);
        foreach ($reportfields as $f) :
            ?>
            <th width='<?php echo $c ?>%'> <?php echo "{$modelo->ofieldlist[$f]->getLabel()}"; ?> </th>
        <?php endforeach; ?>
    </tr>
    </thead>
    <tbody>
