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

/**
 * Permite importar un controlador para usarlo como objeto para analizar
 *
 * @staticvar array $controllers
 * @param string $path
 * @return string
 * @throws Exception
 */
function import_controller($path) {
    static $controllers = array();
    if (!isset($controllers[$path])) {
        $parts = preg_split("~/~", $path, -1, PREG_SPLIT_NO_EMPTY);
        $c     = ucfirst(array_pop($parts));
        $file  = APPPATH . '/controllers/' . implode('/', $parts) . '/' . strtolower($c) . '.php';
        $error = "Could not load controller [{$file}]";
        if (file_exists($file)) {
            require_once $file;
            if (!class_exists($c, FALSE)) {
                throw new Exception($error);
            }
            $controllers[$path] = new $c;
        } else {
            throw new Exception($error);
        }
    }
    return $controllers[$path];
}