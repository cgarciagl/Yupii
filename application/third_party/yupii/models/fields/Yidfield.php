<?php

class YIdField extends YFieldDecorator {

    public function constructControl() {
        $this->loadVars();
        return $this->load->view('yfield/idfield', NULL, TRUE);
    }

}

