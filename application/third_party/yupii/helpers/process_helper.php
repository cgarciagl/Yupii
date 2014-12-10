<?php

function timeStart() {
    global $starttime;
    $mtime     = microtime();
    $mtime     = explode(" ", $mtime);
    $mtime     = $mtime[1] + $mtime[0];
    $starttime = $mtime;
}

function timeEnd() {
    global $starttime;
    $mtime = microtime();
    $mtime = explode(" ", $mtime);
    $mtime = $mtime[1] + $mtime[0];
    return ($mtime - $starttime);
}

function processStart() {
    $ci = &get_instance();
    set_time_limit(0);
    ini_set('memory_limit', '-1');
    $ci->db->save_queries = false;
    ob_implicit_flush(true);
    echo $ci->load->view('process/progress', null, TRUE);
    timeStart();
}

function setProgress($porcentaje) {
    $porcentaje = ceil($porcentaje);
    echo "<script type='text/javascript'> $('#pbar').text('$porcentaje %').css('width','$porcentaje%');</script>";
}

function setProgressText($texto) {
    echo "<script type='text/javascript'> $('#textopbar').text('$texto');</script>";
}

function setProgressTitle($texto) {
    echo "<script type='text/javascript'> $('#textotitulo').text('$texto');</script>";
}

function endProcess() {
    setProgressText('');
    echo "<script type='text/javascript'> $('#girando').removeClass('fa-spin');</script>";
    $tiempo = round(timeEnd(), 5);
    echo "<hr> <small>Tiempo del proceso: $tiempo segs.</small>";
    echo '</div></body>';
}

function percentOf($i, $total) {
    return ($i / $total) * 100;
}

function redirectTo($ruta, $segundos = 0) {
    echo "<script type='text/javascript'> setTimeout(function () {
        window.location.href = base_url + 'index.php/$ruta';
    }, $segundos*1000);</script>";
}

function setProgressOf($i, $total) {
    setProgress(percentOf($i, $total));
}

function getLinesNumber($file) {
    $linecount = 0;
    $handle    = fopen($file, "r");
    while (!feof($handle)) {
        if (fgets($handle) !== false) {
            $linecount++;
        }
    }
    fclose($handle);
    return $linecount;
}