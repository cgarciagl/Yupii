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
 * @mainpage  Yupii
 *
 *  Yupii es un paquete agregado a CodeIgniter que lo transforma en un Business Framework !!
 *            <p/> <br/>
 */
abstract class YDatasetController extends YDataset {

    private $hasDetailsProp = FALSE;
    private $sortingField = -1;
    private $sortingDir = 'asc';

    /**
     * Constructor de la clase
     */
    function __construct() {
        parent::__construct();
        Yupii::get_CI()->readonly = function(){ return $this->readonly; };
    }

    function setSortingField($value, $dir = 'asc') {
        if (is_string($value)) {
            $pos = array_search($value, $this->modelo->tablefields);
            if ($pos !== FALSE) {
                $v = $pos;
            } else {
                $v = -1;
            }
        } elseif (is_integer($value)) {
            $v = $value;
        }
        $this->sortingField = $v;
        $this->sortingDir   = $dir;
    }

    function setHasDetails($band) {
        $this->hasDetailsProp = (bool)$band;
    }

    function hasDetails() {
        return $this->hasDetailsProp;
    }

    /**
     * Devuelve la vista inicial con los datos de la relación definida
     */
    function index() {
        $data['content'] = $this->renderTable();
        $this->load->view('yupii/template', $data);
    }

    /**
     * Devuelve una vista construida para administrar el CRUD del catálogo
     *
     * @return string
     */
    function renderTable() {
        $data['controller_name'] = $this->getClassName();
        $data['title']           = $this->title;
        $this->modelo->completeFieldList();
        $data['tablefields']  = $this->modelo->tablefields;
        $data['fieldlist']    = $this->modelo->ofieldlist;
        $data['hasdetails']   = $this->hasDetails();
        $data['sortingField'] = $this->sortingField;
        $data['sortingDir']   = $this->sortingDir;
        return $this->load->view('ydatasetcontroller/table_view', $data, TRUE);
    }

    /**
     * Devuelve una vista construida con los resultados de una búsqueda
     *
     * @return string
     */
    function renderSearchResults() {
        $data['controller_name'] = $this->getClassName();
        $data['title']           = $this->title;
        $this->modelo->completeFieldList();
        $data['tablefields']  = $this->modelo->tablefields;
        $data['fieldlist']    = $this->modelo->ofieldlist;
        $data['sortingField'] = $this->sortingField;
        $data['sortingDir']   = $this->sortingDir;
        return $this->load->view('ydatasetcontroller/search_view', $data, TRUE);
    }

    /**
     * Devuelve una vista construida para generar reportes automatizados para el catálogo
     *
     * @return string
     */
    function renderReport() {
        $this->load->helper('form');
        $data['controller_name'] = $this->getClassName();
        $data['title']           = $this->title;
        $this->modelo->completeFieldList();
        $data['tablefields'] = $this->modelo->tablefields;
        $data['fieldlist']   = $this->modelo->ofieldlist;
        return $this->load->view('ydatasetcontroller/report_view', $data, TRUE);
    }

    /**
     * devuelve un objeto JSON, ya sea con los errores generados o con el resultado 'ok'
     */
    private function showErrorsOrOk() {
        $result = array();
        if (empty($this->modelo->errors)) {
            $result['result'] = 'ok';
            if ($this->modelo->insertedId) {
                $result['insertedid'] = $this->modelo->insertedId;
            }
        } else {
            $result['result'] = 'error';
            $result['errors'] = $this->modelo->errors;
        }
        $this->load->view('yupii/json_view', array('data' => $result));
    }

    /**
     * Permite borrar un registro via AJAX
     */
    function delete() {
        if ($this->modelo->canDelete) {
            if ($this->input->is_ajax_request()) {
                try {
                    $this->processDelete();
                } catch (Exception $e) {
                    $this->modelo->errors['general_error'] = $e->getMessage();
                }
                $this->showErrorsOrOk();
            } else {
                show_error('error');
            }
        }
    }

    /**
     * Ejecuta el proceso de borrado con sus triggers
     */
    private function processDelete() {
        $this->_beforeDelete();
        $id = $this->input->post('id', TRUE);
        $this->modelo->delete($id);
        $this->_afterDelete();
    }

    function _customFormDataFooter() {

    }

    /**
     * Obtiene via AJAX el formulario para ingresar datos al catálogo
     *
     * Para mostrar el formulario vacío para un nuevo registro, solo no pasar ningún parámetro
     *
     * @param string $id
     */
    function getFormData($id = '') {
        if ($this->input->is_ajax_request()) {
            $s = $this->modelo->getFormData($id);
            $this->load->view('yupii/justecho', array('content' => $s));
            $s = $this->_customFormDataFooter();
            $this->load->view('yupii/justecho', array('content' => $s));
        } else {
            show_error('error');
        }
    }

    /**
     * Devuelve los datos del catálogo en formato JSON, via AJAX
     */
    function getAjaxGridData() {
        $this->output->enable_profiler(FALSE);
        if ($this->input->is_ajax_request()) {
            $this->applyFilters();
            $res = $this->modelo->getTableAjax();
            $this->load->view('yupii/json_view', array('data' => $res));
        } else {
            show_error('error');
        }
    }

    /**
     * Recibe los datos del formulario via AJAX, para procesarles
     */
    function formProcess() {
        $this->output->enable_profiler(FALSE);
        if ($this->input->is_ajax_request()) {
            $this->modelo->processFormInput();
            $this->showErrorsOrOk();
        } else {
            show_error('error');
        }
    }

    /**
     * Devuelve los resultados de una búsqueda, via AJAX
     */
    function searchByAjax() {
        $this->output->enable_profiler(FALSE);
        if ($this->input->is_ajax_request()) {
            echo $this->renderSearchResults();
        } else {
            show_error('error');
        }
    }

    /**
     * Devuelve una vista construida para mostrar la tabla de resultados de búsquedas
     */
    function search() {
        $data['content'] = $this->renderSearchResults();
        $this->load->view('yupii/template', $data);
    }

    /**
     * Devuelve el formulario del reporte del catálogo, via AJAX
     */
    function reportByAjax() {
        $this->output->enable_profiler(FALSE);
        if ($this->input->is_ajax_request()) {
            echo $this->renderReport();
        } else {
            show_error('error');
        }
    }

    /**
     * Devuelve la vista de tabla para administrar el catálogo, solo via AJAX
     */
    function tableByAjax() {
        $this->output->enable_profiler(FALSE);
        if ($this->input->is_ajax_request()) {
            echo $this->renderTable();
        } else {
            show_error('error');
        }
    }

    /**
     * Devuelve una vista construida para generar el reporte del catálogo
     */
    function report() {
        $data['content'] = $this->renderReport();
        $this->load->view('yupii/template', $data);
    }

    /**
     * Muestra los resultados del reporte en diferentes formatos
     */
    function showReport() {
        // $this->load->library('ydatasetreportlib');
        $this->ydatasetreportlib = new ydatasetreportlib;
        $this->load->helper('url');
        $this->applyFilters();
        $data['tabla'] = $this->ydatasetreportlib->buildReport($this);
        $this->ydatasetreportlib->renderReportOutput($data);
    }

    /**
     * Devuelve un JSON con los datos de un registro , solo via AJAX
     */
    function getRecordByAjax() {
        $this->output->enable_profiler(FALSE);
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id', TRUE);
            if ($id) {
                $this->modelo->completeFieldList();
                $res = $this->modelo->getById($id)->row_array();
                $this->load->view('yupii/json_view', array('data' => $res));
            }
        } else {
            show_error('error');
        }
    }

    public function is_unique($string, $field) {
        $primarykeyvalue = new_value($this->modelo->id_field);
        $this->modelo->setWhere($this->modelo->id_field . ' <> ', $primarykeyvalue);
        $this->modelo->setWhere($field, $string);
        $c = $this->modelo->countAllResults();
        if ($c > 0) {
            $this->form_validation->set_message('rule', 'Error Message');
            return FALSE;
        }
        return TRUE;
    }

    public function readonly($string, $field) {
        $b = has_changed($field);
        if ($b) {
            $this->form_validation->set_message('rule', 'Error Message');
            return FALSE;
        }
        return TRUE;
    }

}
