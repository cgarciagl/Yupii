<?php

class YSearchField extends YFieldDecorator {

    protected $fieldtoshow;
    protected $controller;
    protected $idvalue;

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
        return $this->load->view('yfield/searchfield', $a, TRUE);
    }

    public function checkRelation(&$model) {
        $db            = $model->db;
        $mock          = import_controller($this->getController());
        $tablename     = $mock->modelo->table_name;
        $joincondition = "{$mock->modelo->id_field} = {$this->getFieldName()}";
        $db->join($tablename, $joincondition, 'left');
        $mock->modelo->completeFieldList();
        $this->setFieldToShow($mock->modelo->tablefields[0]);
        $db->select($this->getFieldToShow());
        unset($mock);
        $model->db = $db;
    }

    public function getDataFromInput() {
        return $this->input->post('yupii_id_' . $this->getFieldName(), TRUE);
    }

}
