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
abstract class YDatasetModel extends YTableModel {

    var $ofieldlist = array();
    var $tablefields = array();
    var $controller = NULL;
    var $errors = array();
    var $insertedId = NULL;

    /**
     * Constructor de la clase
     */
    function __construct() {
        parent:: __construct();
    }

    /**
     * Devuelve el verdadero nombre de campo para un objeto de campo interno del modelo
     *
     * @param string $f
     * @return string
     */
    function realField($f) {
        return $this->ofieldlist[ $f ]->getFieldToShow();
    }

    function addFieldFromArray($f, $array) {
        $this->ofieldlist[ $f ] = new YSimpleTextField($f);
        $this->ofieldlist[ $f ]->loadFromArray($array);
        $this->ofieldlist[ $f ]->setDefaults();
        return $this->ofieldlist[ $f ];
    }

    /**
     * Asigna las condiciones de búsqueda para todos los campos de la relación
     */
    private function setWhereForSearchInMultipleFields($textForSearch) {
        $s = '';
        foreach ($this->tablefields as $k) {
            if ($s != '') {
                $s .= " or ( {$this->realField($k)} like '%$textForSearch%') ";
            } else {
                $s .= " ({$this->realField($k)} like '%$textForSearch%') ";
            }
        }
        $this->db->where('(' . $s . ')', NULL, FALSE);
    }

    /**
     * Devuelve un objeto JSON con los resultados de la búsqueda
     *
     * @return string
     */
    function getTableAjax() {
        if ($this->table_name) {
            $count = $this->getCountForSearch();
            $this->setLimitForJsonResult();
            $this->setOrderByForJsonResult();
            $query = $this->db->get($this->table_name);
            $this->db->flush_cache();
            return $this->generateJsonResult($query, $count);
        } else return NULL;
    }

    /**
     * Asigna el orden en que se han de presentar los datos
     */
    private function setOrderByForJsonResult() {
        if (($this->input->post('iSortingCols', TRUE) == 1)) {
            $col = $this->input->post('iSortCol_0', TRUE);
            if ($col <= (count($this->tablefields) - 1)) {
                $this->db->order_by(
                    $this->realField($this->tablefields[ $col ]), $this->input->post('sSortDir_0', TRUE));
            } else {
                $this->db->order_by($this->id_field, $this->input->post('sSortDir_0', TRUE));
            }
        }
    }

    /**
     * Asigna el número de registros a devolver, así como desde cual registro
     * se ha de iniciar
     */
    private function setLimitForJsonResult() {
        $limit  = $this->input->post('iDisplayLength', TRUE);
        $offset = $this->input->post('iDisplayStart', TRUE);
        $this->db->limit($limit, $offset);
    }

    /**
     * Genera la cadena JSON a ser devuelta, a partir de la query proporcionada
     *
     * @param object $query
     * @param int $count
     * @return string
     */
    private function generateJsonResult($query, $count) {
        $data['query']  = $query;
        $data['count']  = $count;
        $data['modelo'] = $this;
        $this->load->helper('text');
        return $this->load->view('ydatasetmodel/table_json_result', $data, TRUE);
    }

    /**
     * Revisa las relaciones declaradas del modelo, para importar controladores relacionados
     */
    public function checkRelations() {
        foreach ($this->ofieldlist as $k => $f) {
            if (method_exists($f, 'checkRelation')) {
                $f->checkRelation($this);
            }
        }
    }

    /**
     * Obtiene los valores de un registro de la tabla y llena los campos internos
     *
     * @param int $id
     */
    private function getValuesFor($id) {
        $a = array_keys($this->ofieldlist);
        $this->db->select($a);
        if ($id != '') {
            $this->db->where($this->id_field, $id);
        }
        $this->checkRelations();
        $this->db->limit(1);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            $b = $query->row_array();
            foreach ($this->ofieldlist as $k => $f) {
                $f->setValue($b[ $this->realField($f->getFieldName()) ]);
                if (method_exists($f, 'setIdValue')) {
                    $f->setIdValue($b[ $f->getFieldName() ]);
                }
            }
        }
    }

    private function checkForDefaultValues() {
        $this->checkRelations();
        foreach ($this->ofieldlist as $k => $f) {
            if ($f->getDefault() != NULL) {
                if (!$f->getValue()) {
                    $f->setValue($f->getDefault());
                }
            }
        }
    }

    /**
     * Completa los valores faltantes en el arreglo de campos
     */
    function completeFieldList() {
        $this->fillEmptyTablefields();
        $this->fillFieldlist();
        $this->addIdFieldToFieldlist();
        $this->setDefaults();
    }

    /**
     * Si esta vacío el arreglo de campos de la tabla, usa la lista de campos para llenarlo
     */
    private function fillEmptyTablefields() {
        if (!count($this->tablefields)) {
            foreach ($this->ofieldlist as $k => $f) {
                $this->tablefields[] = $k;
            }
        }
    }

    /**
     * ingresa los campos del arreglo de campos de la tabla a la lista de campos
     */
    private function fillFieldlist() {
        foreach ($this->tablefields as $f) {
            if (!(isset($this->ofieldlist[ $f ]))) {
                $this->ofieldlist[ $f ] = new YSimpleTextField($f);
            }
        }
    }

    /**
     * Asegura que el campo de la llave primaria, esté en la lista de campos
     */
    private function addIdFieldToFieldlist() {
        if (!(isset($this->ofieldlist[ $this->id_field ]))) {
            $this->ofieldlist[ $this->id_field ] = new YIdField(new YSimpleTextField($this->id_field));
        }
    }

    /**
     * Asigna valores por defecto a las diferentes propiedades de los campos
     */
    private function setDefaults() {
        foreach ($this->ofieldlist as $k => $f) {
            $f->setDefaults();
        }
    }

    /**
     * Construye el formulario para el ingreso de datos
     *
     * @param string $id
     * @return string
     */
    function getFormData($id = '') {
        $this->completeFieldList();
        if ($id != 'new') {
            $this->getValuesFor($id);
        } else {
            $this->checkForDefaultValues();
        }
        $data['fields'] = $this->ofieldlist;
        return $this->load->view('ydatasetmodel/form_data', $data, TRUE);
    }

    /**
     * Evalua los datos ingresados por el usuario, y aplica las reglas de validación
     *
     */
    function processFormInput() {
        $this->completeFieldList();
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $i = 0;
        foreach ($this->ofieldlist as $k => $f) {
            if ($f->getRules()) {
                $this->form_validation->set_rules(
                    $f->getFieldName(), $f->getLabel(), $this->completeRules($f));
                $i++;
            }
        }
        $mustApplyValidations = ($i > 0);
        $this->checkValidations($mustApplyValidations);
    }

    private function completeRules($f) {
        $s = str_replace('is_unique', 'callback_is_unique[' . $this->table_name . '.' . $f->getFieldName() . ']', $f->getRules());
        return $s;
    }

    /**
     * Checa las validaciones del modelo
     */
    private function checkValidations($mustApplyValidations) {
        if (($this->form_validation->run() == FALSE) && ($mustApplyValidations)) {
            foreach ($this->ofieldlist as $k => $f) {
                $error = $this->form_validation->error($f->getFieldName());
                if ($error != '') {
                    $this->errors[ $f->getFieldName() ] = $error;
                }
            }
        } else {
            $this->processFormAction();
        }
    }

    /**
     * Devuelve un arreglo con los datos de entrada para la operación
     *
     * @return array
     */
    function createInputDataArray() {
        $a = array();
        if ($this->input->post($this->id_field, TRUE)) {
            foreach ($this->ofieldlist as $k => $f) {
                if ($f->hasChanged()) {
                    $a[ $f->getFieldName() ] = $f->getDataFromInput();
                }
            }
        } else {
            foreach ($this->ofieldlist as $k => $f) {
                $a[ $f->getFieldName() ] = $f->getDataFromInput();
            }
        }
        return $a;
    }

    /**
     * Decide que operación ha de aplicarse en la BD con los datos ingresados
     */
    function processFormAction() {
        if ($this->input->post($this->id_field, TRUE)) {
            $this->performUpdate();
        } else {
            $this->performInsert();
        }
    }

    /**
     * Realiza la actualización en la BD y ejecuta los triggers
     */
    private function performUpdate() {
        if ($this->canUpdate) {
            try {
                $a = $this->createInputDataArray();
                if (sizeof($a) > 0) {
                    $this->controller->_beforeUpdate($a);
                    $this->update($this->input->post($this->id_field, TRUE), $a);
                    $this->controller->_afterUpdate();
                }
            } catch (Exception $e) {
                $this->errors['general_error'] = $e->getMessage();
            }
        }
    }

    /**
     * Realiza la inserción en la BD y ejecuta los triggers
     */
    private function performInsert() {
        if ($this->canInsert) {
            try {
                $a = $this->createInputDataArray();
                if (isset($a[ $this->id_field ])) {
                    unset($a[ $this->id_field ]);
                }
                $this->controller->_beforeInsert($a);
                $pk                       = $this->insert($a);
                $_POST[ $this->id_field ] = $pk;
                $this->insertedId = $pk;
                $this->controller->_afterInsert();
            } catch (Exception $e) {
                $this->errors['general_error'] = $e->getMessage();
            }
        }
    }

    /**
     * Devuelve el número de registros que incluye la búsqueda solicitada
     */
    function getCountForSearch() {
        $this->completeFieldList();
        $this->db->start_cache();
        $this->db->select($this->id_field);
        $this->db->select($this->tablefields);
        $this->checkRelations();
        $this->performSearchForJson();
        $this->db->stop_cache();
        return $this->countAllResults();
    }

    /**
     * Aplica los criterios para filtrar a partir de un texto
     */
    private function performSearchForJson() {
        $se = htmlspecialchars_decode($this->input->post('sSearch', TRUE));
        if ($se) {
            if ($this->input->post('sOnlyField', TRUE)) {
                $f = $this->input->post('sOnlyField', TRUE);
                $this->db->like($this->realField($f), $se);
            } else {
                $this->setWhereForSearchInMultipleFields($se);
            }
        }
        $filter = base64_decode($this->input->post('sFilter', TRUE));
        if ($filter) {
            $this->db->where($filter, FALSE, FALSE);
        }
    }

    /**
     * Devuelve un campo del modelo a partir de su nombre
     *
     * @param string $fieldname nombre del campo
     * @return YField
     */
    public function fieldByName($fieldname) {
        return $this->ofieldlist[ $fieldname ];
    }

    function textForTable($values, $fieldname) {
        $f     = $this->fieldByName($fieldname);
        $value = $values[ $this->realField($fieldname) ];

        if ($f->getType() == 'multiselect') {
            $values = explode(',', $value);
            $opts   = $f->getOptions();
            foreach ($values as $k => $v) {
                $values[ $k ] = @$opts[ $v ];
            }
            $value = implode(',', $values);
        }

        if ($f->getType() == 'dropdown') {
            $opts  = $f->getOptions();
            $value = @$opts[ $value ];
        }

        $value = removeNewLines(convert_accented_characters(character_limiter(strip_tags(addslashes($value)), 30)));

        return $value;
    }

}
