<div>
    <form class="form-inline row" role="form" method='post' onsubmit='return false;'>
        <div>
            <?php foreach ($fields as $k => $f) : ?>
                <?= $f->constructControl() ?>
            <?php endforeach; ?>
        </div>
        <div id='group_general_error' class='general_error'></div>
    </form>
</div>            

