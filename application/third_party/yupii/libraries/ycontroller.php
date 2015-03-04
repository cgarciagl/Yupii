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
abstract class YController extends CI_Controller {

    private $partial = 'views/default';
    private $classname = '';

    /**
     * Constructor de la clase
     */
    function __construct() {
        parent::__construct();
        $this->classname = strtolower(get_class($this));
        Yupii::loadDefaults();
        $this->getPartial();
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

}
