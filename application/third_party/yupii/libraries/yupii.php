<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

abstract class Yupii {

    function __construct() {
        parent::__construct();
    }

    static public function loadDefaults() {
        get_instance()->load->helper(array('url', 'array', 'yupii_helper'));
        get_instance()->load->config('yupii');
        if (file_exists(APPPATH . 'config/my_yupii_config.php')) {
            get_instance()->load->config('my_yupii_config');
        }
        get_instance()->load->language('yupii');
    }

    static public function getHeaderScript() {
        Yupii::loadDefaults();
        return get_instance()->load->view('ydatasetcontroller/headerscript', NULL);
    }

    static public function loadScriptFiles() {
        Yupii::getHeaderScript();
        return get_instance()->load->view('ydatasetcontroller/scriptfiles', NULL);
    }

    static public function getHeaderAll() {
        Yupii::getHeaderScript();
        Yupii::loadScriptFiles();
    }

}