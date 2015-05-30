<?php

class YSearchField extends YFieldDecorator {

    protected $fieldtoshow;
    protected $controller;
    protected $filter;
    protected $idvalue;
    protected $default;

    public function getIdValue() {
        return $this->idvalue;
    }

    public function setIdValue($idvalue) {
        $this->idvalue = $idvalue;
    }

    public function getController() {
        return $this->controller;
    }

    public function setController($controller) {
        $this->controller = $controller;
    }

    public function getFilter() {
        return $this->filter;
    }

    public function setFilter($filter) {
        $this->filter = $filter;
    }

    public function getFieldToShow() {
        return $this->fieldtoshow;
    }

    public function setFieldToShow($fieldtoshow) {
        $this->fieldtoshow = $fieldtoshow;
    }

    public function constructControl() {
        $this->loadVars();
        $a['fieldtoshow'] = $this->getFieldToShow();
        $a['controller']  = $this->getController();
        $a['idvalue']     = $this->getIdValue();
        $a['filter']      = $this->getFilter();
        $this->checkDefault($a);
        return $this->load->view('yfield/searchfield', $a, TRUE);
    }

    function checkDefault(&$a) {
        if (isset($this->default)) {
            if (!isset($a['idvalue'])) {
                if (is_array($this->default)) {
                    $a['value']   = $this->default['text'];
                    $a['idvalue'] = $this->default['id'];
                } else {
                    $a['value'] = $this->default;
                }
            }
        }
    }

    public function checkRelation(&$model) {
        $db            = $this->db;// $model->db;
        $mock          = import_model_from_controller($this->getController());
        $tablename     = $mock->table_name;
        $joincondition = "{$mock->id_field} = {$this->getFieldName()}";
        $db->join($tablename, $joincondition, 'left');
        $mock->completeFieldList();
        $this->setFieldToShow($mock->tablefields[0]);
        $db->select($this->getFieldToShow());
        unset($mock);
       // $model->db = $db;
    }

    public function getDataFromInput() {
        return $this->input->post('yupii_id_' . $this->getFieldName(), TRUE);
    }

}
