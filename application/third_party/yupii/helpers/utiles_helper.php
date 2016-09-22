<?php

function dbgConsole($x) {
    ?>
    <script type="text/javascript">
        console.warn('<?php echo json_encode($x)?>');
    </script>
<?php
}

function dbgDie($x) {
    echo '<pre>' . json_encode($x) . '</pre>';
    die();
}

function currency($number, $symbol = TRUE) {
    if ($symbol) {
        return money_format('%.2n', $number);
    } else {
        return money_format('%!.2n', $number);
    }
}

function selfUrl() {
    return get_instance()->uri->ruri_string();
}

function refresh() {
    redirect(selfUrl());
}

function ifSet(&$val, $default = NULL) {
    return isset($val) && !empty($val) ? $val : $default;
}

//var_dump(startsWith("hello world", "hello")); // true
function startsWith($cadena, $parcial) {
    return $parcial === "" || strrpos($cadena, $parcial, -strlen($cadena)) !== FALSE;
}

function endsWith($cadena, $parcial) {
    return $parcial === "" || strpos($cadena, $parcial, strlen($cadena) - strlen($parcial)) !== FALSE;
}

function removeNewLines($text) {
    return str_replace(array("\n", "\r"), ' ', $text);
}