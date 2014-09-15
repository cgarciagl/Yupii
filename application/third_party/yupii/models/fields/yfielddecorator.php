<?php

abstract class YFieldDecorator extends YField {

    protected $_field;

    public function __construct(YField $Field) {
        parent::__construct($Field->fieldname);
        $this->_field    = $Field;
        $this->fieldname = &$Field->fieldname;
        $this->rules     = &$Field->rules;
        $this->label     = &$Field->label;
        $this->value     = &$Field->value;
    }

}
