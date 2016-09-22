<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * Yupii
 *
 * a thirdparty asset that transforms CodeIgniter into a Business Framework !!
 *
 * @package        Yupii
 * @author        Carlos García Trujillo
 * @link        https://github.com/cgarciagl/Yupii
 * @since        Version 1.0
 */

/**
 * Clase Base para los controladores de Yupii
 *
 * Carga las bibliotecas necesarias estandar así como la configuración y lenguaje
 */
class YController {

    private $partial = 'views/default';
    private $classname = '';


    /**
     * Constructor de la clase
     */
    function __construct() {
        $this->classname = strtolower(get_class($this));
        $CI              = Yupii::get_CI();
        if (!isset($CI->activeYupiiController)) {
            $CI->activeYupiiController = $this->classname;
            $CI->activeYupiiObject = $this;
        }
        Yupii::loadDefaults();
        $this->getPartial();
    }

    public function __get($attr) {
        $CI = Yupii::get_CI();
        if (isset($this->$attr)) {
            return $this->$attr;
        } else
            if (isset($CI->$attr)) {
                return $CI->$attr;
            } else return NULL;
    }

    /**
     * Método que revisa si existe una vista parcial para la clase del controlador
     */
    private function getPartial() {
        $uri = $this->classname . '/' . $this->router->method;
        if (is_file(APPPATH . 'views/' . $uri . '.php')) {
            $this->partial = $this->classname . '/' . $this->router->method;
        }
    }

    /**
     * Devuelve el nombre de la clase del controlador
     *
     * @return string
     */
    function getClassName() {
        return $this->classname;
    }


    function isThisActiveController() {
        $CI = Yupii::get_CI();
        if ($CI->activeYupiiController == $this->getClassName()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
