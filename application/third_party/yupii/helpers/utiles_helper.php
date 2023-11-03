<?php

function dbgConsola($x)
{
?>
    <script type="text/javascript">
        console.group();
        console.warn('<?php echo json_encode($x) ?>');
        console.groupEnd();
    </script>
<?php
}

function dbgDie($x)
{
    echo '<pre>' . json_encode($x) . '</pre>';
    die();
}

function currency($number, $symbol = TRUE)
{
    if ($symbol) {
        return money_format('%.2n', $number);
    } else {
        return money_format('%!.2n', $number);
    }
}

function selfUrl()
{
    return get_instance()->uri->ruri_string();
}

function refresh()
{
    redirect(selfUrl());
}

function ifSet(&$val, $default = NULL)
{
    return isset($val) && !empty($val) ? $val : $default;
}

function startsWith($cadena, $parcial)
{
    return $parcial === "" || strrpos($cadena, $parcial, -strlen($cadena)) !== FALSE;
}

function endsWith($cadena, $parcial)
{
    return $parcial === "" || strpos($cadena, $parcial, strlen($cadena) - strlen($parcial)) !== FALSE;
}

function removeNewLines($text)
{
    return str_replace(array("\n", "\r"), ' ', $text);
}

function valueFromSessionOrDefault($variable, $defaultValue = '')
{
    return get_instance()->session->userdata($variable) ? get_instance()->session->userdata($variable) : $defaultValue;
}

function returnAsJSON($arreglo)
{
    get_instance()->load->view('yupii/json_view', array('data' => $arreglo));
}

function arrayToDropdown($array, $valueField, $textField = null)
{
    if (!($textField)) {
        $textField = $valueField;
    }
    $lista = array();
    foreach ($array as $p) {
        $lista[$p[$valueField]] = $p[$textField];
    }
    return $lista;
}

function arrayToSelect($nombre, $opciones, $campollave, $campovalor, $seleccionado, $extra = array())
{
    $options = arrayToDropdown($opciones, $campollave, $campovalor);
    if (!isset($extra['class'])) {
        $extra['class'] = 'form-control';
    }
    return form_dropdown($nombre, $options, $seleccionado, $extra);
}

function sessionObject()
{
    return json_encode(get_instance()->session->all_userdata());
}
