<?php

abstract class YField {

    protected $fieldname;
    protected $label;
    protected $rules;
    protected $value;
    protected $type;
    protected $options;
    protected $default;

    function __construct($fieldname) {
        $this->fieldname = $fieldname;
    }

    public function __get($attr) {
        if (isset(get_instance()->$attr)) {
            return get_instance()->$attr;
        } else return NULL;
    }

    public function getFieldName() {
        return $this->fieldname;
    }

    public function setFieldName($fieldname) {
        $this->fieldname = $fieldname;
    }

    public function getLabel() {
        return $this->label;
    }

    public function getRules() {
        return $this->rules;
    }

    public function getValue() {
        return $this->value;
    }

    public function getDefault() {
        return $this->default;
    }

    public function setDefault($value) {
        $this->default = $value;
    }

    public function setLabel($label) {
        $this->label = $label;
    }

    public function setRules($rules) {
        $this->rules = $rules;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getOptions() {
        return $this->options;
    }

    public function setOptions($options) {
        $this->options = $options;
    }

    public function getFieldToShow() {
        return $this->fieldname;
    }

    public function loadFromArray($array) {
        foreach (array('label', 'value', 'rules', 'type', 'options', 'default') as $prop) {
            if (isset($array[ $prop ])) {
                $method = "set$prop";
                $this->{$method}($array[ $prop ]);
            }
        }
    }

    public function setDefaults() {
        $this->setLabel((!isset($this->label)) ? $this->getFieldName() : $this->getLabel());
        $this->setRules((!isset($this->rules)) ? '' : $this->getRules());
        $this->setValue((!isset($this->value)) ? '' : $this->getValue());
        $this->setType((!isset($this->type)) ? 'text' : $this->getType());
        $this->setOptions((!isset($this->options)) ? array() : $this->getOptions());
        $this->setDefault((!isset($this->default)) ? NULL : $this->getDefault());
    }

    protected function extraAttributesForControl() {
        $more = '';
        if (substr_count($this->rules, 'required')) {
            $more .= ' required ';
        }
        if (substr_count($this->rules, 'readonly')) {
            $more .= ' readonly ';
        }
        return $more;
    }

    public function loadVars() {
        $a['name']             = $this->getFieldName();
        $a['value']            = $this->getValue();
        $a['label']            = $this->getLabel();
        $a['type']             = $this->getType();
        $a['default']          = $this->getDefault();
        $a['options']          = $this->getOptions();
        $a['extra_attributes'] = $this->extraAttributesForControl();
        $this->checkDefault($a);
        $this->load->vars($a);
    }

    function checkDefault(&$a) {
        if (isset($this->default)) {
            if (!isset($a['value'])) {
                if (is_array($this->default)) {
                    $a['value'] = $this->default['text'];
                } else {
                    $a['value'] = $this->default;
                }
            }
        }
    }

    public function constructControl() {
        $this->loadVars();
        if (file_exists(APPPATH . '/third_party/yupii/views/yfield/' . $this->type . 'field.php')) {
            return $this->load->view('yfield/' . $this->type . 'field', NULL, TRUE);
        } else {
            return $this->load->view('yfield/simpletextfield', NULL, TRUE);
        }
    }

    public function getDataFromInput() {
        return $this->input->post($this->getFieldName(), TRUE);
    }

    public function hasChanged() {
        return (new_value($this->getFieldName()) !==
            old_value($this->getFieldName()));
    }

}
