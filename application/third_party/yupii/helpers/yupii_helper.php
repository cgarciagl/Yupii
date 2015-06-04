<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Lanza una excepción
 *
 * @param string $exception_message Mensaje de la excepción a lanzar
 * @throws Exception
 */
function raise($exception_message) {
    throw new Exception($exception_message);
}

/**
 * Devuelve el valor nuevo a guardar en el campo $fieldname
 *
 * @param string $fieldname
 * @return string
 */
function new_value($fieldname) {
    $CI = &get_instance();
    return $CI->input->post($fieldname, TRUE);
}

/**
 * Devuelve el valor anterior en el campo $fieldname
 *
 * @param string $fieldname
 * @return string
 */
function old_value($fieldname) {
    $CI = &get_instance();
    return $CI->input->post('yupii_value_ant_' . $fieldname, TRUE);
}

/**
 * Devuelve un booleano indicando si el campo $fieldname ha cambiado en una actualización
 *
 * @param string $fieldname
 * @return string
 */
function has_changed($fieldname) {
    return (new_value($fieldname) != old_value($fieldname));
}

function  import_model_from_controller($path) {
    $c    = $path;
    $file = APPPATH . '/controllers/' . ucfirst($c) . '.php';
    if (!file_exists($file)) {
        $file = APPPATH . '/controllers/' . strtolower($c) . '.php';
    }

    require_once $file;
    $f = new $c;
    $m = $f->modelo;
    unset($f);

    return $m;
}
