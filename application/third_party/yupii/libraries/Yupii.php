<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Yupii {

    public static $CI = NULL;

    function __construct() {
        Yupii::get_CI();
    }

    static public function loadDefaults() {
        Yupii::get_CI();
        Yupii::$CI->load->helper(array('url', 'array', 'yupii', 'utiles'));
        Yupii::$CI->load->config('yupii');
        if (file_exists(APPPATH . 'config/my_yupii_config.php')) {
            Yupii::$CI->load->config('my_yupii_config');
        }
        Yupii::$CI->load->language('yupii');
    }

    static public function getHeaderScript() {
        Yupii::loadDefaults();
        return Yupii::$CI->load->view('yupii/headerscript', NULL);
    }

    static public function loadScriptFiles() {
        Yupii::getHeaderScript();
        Yupii::get_CI();
        return Yupii::$CI->load->view('yupii/scriptfiles', NULL);
    }

    static public function getHeaderAll() {
        Yupii::getHeaderScript();
        Yupii::loadScriptFiles();
    }

    static public function get_CI() {
        if (Yupii::$CI == NULL) {
            $f = CI_Controller::get_instance();
            if ($f == NULL) {
                $f = new CI_Controller();
            }
            Yupii::$CI = $f->get_instance();
        }
        return Yupii::$CI;
    }

}
