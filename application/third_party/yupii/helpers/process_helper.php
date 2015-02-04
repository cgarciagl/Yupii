<?php

function timeStart() {
    global $starttime;
    $mtime     = microtime();
    $mtime     = explode(" ", $mtime);
    $mtime     = $mtime[1] + $mtime[0];
    $starttime = $mtime;
}

function fecho($string) {
    echo $string;
    @ob_flush();
    flush();
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
    @ini_set('zlib.output_compression', 0);
    @ini_set('implicit_flush', 1);
    @ob_end_clean();

    $ci->db->save_queries = false;
    ob_implicit_flush(true);
    timeStart();
    fecho($ci->load->view('process/progress', null, TRUE));
}

function setProgress($porcentaje) {
    $porcentaje = ceil($porcentaje);
    fecho("<script type='text/javascript'> $('#pbar').text('$porcentaje %').css('width','$porcentaje%');</script>");
}

function setProgressText($texto) {
    fecho("<script type='text/javascript'> $('#textopbar').html('$texto');</script>");

}

function setProgressTitle($texto) {
    fecho("<script type='text/javascript'> $('#textotitulo').text('$texto');</script>");
}

function endProcess() {
    setProgressText('');
    fecho("<script type='text/javascript'> $('#girando').removeClass('fa-spin');</script>");
    $tiempo = round(timeEnd(), 5);
    fecho("<hr> <small>Tiempo del proceso: $tiempo segs.</small>");
    fecho('</div></body>');

}

function percentOf($i, $total) {
    return ($i / $total) * 100;
}

function redirectTo($ruta, $segundos = 0) {
    fecho("<script type='text/javascript'> setTimeout(function () {
        window.location.href = base_url + 'index.php/$ruta';
    }, $segundos*1000);</script>");
}

function setProgressOf($i, $total) {
    setProgress(percentOf($i, $total));
}