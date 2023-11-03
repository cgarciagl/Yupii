<div><br>
    <form class="" role="form" method='post' onsubmit='return false;'>
        <div class="form-row row">
            <?php foreach ($fields as $k => $f) : ?>
                <?php echo $f->constructControl() ?>
            <?php endforeach; ?>
        </div>
        <div id='group_general_error' class='general_error'></div>
    </form>
</div>