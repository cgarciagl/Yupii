<?php
spl_autoload_register(function ($class_name) {

    $directorys = array(
        APPPATH . 'third_party/yupii/libraries/',
        APPPATH . 'third_party/yupii/models/',
        APPPATH . 'third_party/yupii/models/fields/'
    );

    foreach ($directorys as $directory) {
        if (file_exists($directory . $class_name . '.php')) {
            require_once($directory . $class_name . '.php');
            return;
        }
    }
});