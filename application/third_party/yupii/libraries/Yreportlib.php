<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Yupii
 *
 * a thirdparty asset that transforms CodeIgniter into a Business Framework !!
 *
 * @package             Yupii
 * @author              Carlos García Trujillo
 * @link                https://github.com/cgarciagl/Yupii
 * @since               Version 1.0
 */
abstract class YReportLib
{

    private $reportfields = array();
    private $descfilter = '';
    private $groups = array();
    private $totalrecords = 0;
    private $grouprecords = 0;
    private $modelo = NULL;

    public function __get($attr)
    {
        $CI = Yupii::get_CI();
        if (isset($CI->$attr)) {
            return $CI->$attr;
        } else return NULL;
    }

    private function initReport($controller)
    {
        $this->title  = $controller->getTitle();
        $this->modelo = $controller->modelo;
        $this->modelo->completeFieldList();
        $this->modelo->checkRelations();
        $this->reportfields = $this->modelo->tablefields;
    }

    public function buildReport($controller)
    {
        $this->initReport($controller);
        $modelo               = $controller->modelo;
        $reportselectfields[] = $modelo->id_field;
        foreach ($this->reportfields as $f) {
            $reportselectfields[] = $modelo->realField($f);
            $reportselectfields[] = $f;
        }
        $reportselectfields = array_unique($reportselectfields);
        return $this->getTable($reportselectfields);
    }

    private function getTable($reportselectfields)
    {
        $this->modelo->select($reportselectfields);
        $limiteReporte = config_item('yupii_report_limit');
        if ((int)$limiteReporte > 0) {
            $this->modelo->limit($limiteReporte);
        }
        $this->applyFiltersAndOrder($this->modelo);
        $query = $this->modelo->get($this->modelo->table_name);
        return $this->generateTable($query, $this->modelo);
    }

    private function applyFiltersAndOrder($modelo)
    {
        $ordertoapply = array();
        for ($i = 1; $i <= 3; $i++) {
            if ($this->input->post("nivel$i", TRUE) != '') {
                if ($this->input->post("filter$i", TRUE) != '') {
                    $this->modelo->setWhere($this->input->post("nivel$i", TRUE), $this->input->post("yupii_id_filter$i", TRUE));
                    $this->descfilter .= " < {$modelo->ofieldlist[$this->input->post('nivel' . $i, TRUE)]->getLabel()} = '{$this->input->post('filter' . $i, TRUE)}' > ";
                }
                $realField      = $modelo->realField($this->input->post("nivel$i", TRUE));
                $ordertoapply[] = $realField;
                $a              = array(
                    'field' => $this->input->post("nivel$i", TRUE),
                    'count' => 0, 'current' => '', 'realField' => $realField,
                    'label' => $modelo->ofieldlist[$this->input->post('nivel' . $i, TRUE)]->getLabel()
                );
                $this->groups[] = $a;
            }
        }
        $ordertoapply[] = $modelo->tablefields[0];
        if (sizeof($ordertoapply) > 0) {
            $this->modelo->setOrderBy(implode(',', $ordertoapply));
        }
    }

    private function generateTableHeader($modelo)
    {
        $this->grouprecords = 0;
        $a['cuantoscampos'] = sizeof($this->reportfields);
        $a['title']         = $this->title;
        $a['reportfields']  = $this->reportfields;
        $a['modelo']        = $modelo;
        return $this->load->view('yreportlib/table_header', $a, TRUE);
    }

    private function generateTableFooter()
    {
        $a['cuantoscampos'] = sizeof($this->reportfields);
        $a['grouprecords']  = $this->grouprecords;
        $a['title']         = $this->title;
        return $this->load->view('yreportlib/table_footer', $a, TRUE);
    }

    private function generateTableRow($row, $modelo)
    {
        $temp_string = "<tr>";
        foreach ($this->reportfields as $f) {
            $temp_string .= "<td> {$this->fieldToReport($row, $modelo, $f)} </td>";
        }
        $temp_string .= "</tr>";
        $this->totalrecords++;
        $this->grouprecords++;
        return $temp_string;
    }

    private function generateRowOrLevel($row)
    {
        $showldwritelevelheader = FALSE;
        $showldwritelevelfooter = TRUE;
        $encab                  = '';
        $this->calculateEncab($row, $showldwritelevelheader, $showldwritelevelfooter, $encab);
        return $this->generateEncabAndDetail($row, $showldwritelevelheader, $showldwritelevelfooter, $encab);
    }

    private function calculateEncab($row, &$showldwritelevelheader, &$showldwritelevelfooter, &$encab)
    {
        $i = 2;
        foreach ($this->groups as &$g) {
            $i++;
            if (($g['current'] != @$row[$g['field']]) || ($showldwritelevelheader)) {
                if ($g['current'] == '') {
                    $showldwritelevelfooter = FALSE;
                }
                $g['current']           = $row[$g['field']];
                $showldwritelevelheader = TRUE;
                $encab .= "<h{$i}>{$g['label']}: {$row[$g['realField']]}  </h{$i}>";
            }
        }
    }

    private function generateEncabAndDetail($row, $showldwritelevelheader, $showldwritelevelfooter, $encab)
    {
        $temp_string = '';
        if ($showldwritelevelheader) {
            if ($showldwritelevelfooter) {
                $temp_string .= $this->generateTableFooter();
            }
            $temp_string .= $encab;
            $temp_string .= $this->generateTableHeader($this->modelo);
        }
        $temp_string .= $this->generateTableRow($row, $this->modelo);
        return $temp_string;
    }

    private function generateTable($query, $modelo)
    {
        $temp_string = "<h1> {$this->lang->line('yupii_report_of')} {$this->title} </h1>";
        $temp_string .= "<h2> {$this->descfilter} </h2>";
        if (sizeof($this->groups) == 0) {
            $temp_string .= $this->generateTableHeader($modelo);
        }
        foreach ($query->result_array() as $row) {
            $temp_string .= $this->generateRowOrLevel($row, $modelo);
        }
        $temp_string .= $this->generateTableFooter();
        $temp_string .= "<hr> <h3 style='text-align:right'> {$this->lang->line('yupii_total')}: {$this->totalrecords} {$this->title} </h3>";
        return $temp_string;
    }

    /**
     * Genera la salida del reporte
     *
     * @param array $data datos de entrada
     */
    function renderReportOutput($data)
    {
        $this->buildHtmlReport($data);
        $this->buildXlsReport($data);
    }

    /**
     * Construye un reporte con los datos en formato html
     *
     * @param array $data array
     */
    private function buildHtmlReport($data)
    {
        if ($this->input->post('typeofreport', TRUE) == 'htm') {
            $this->load->view('yreportlib/report_format_html_ajax', $data);
        }
    }

    /**
     * Construye un reporte con los datos en formato xls
     *
     * @param array $data array
     */
    private function buildXlsReport($data)
    {
        if ($this->input->post('typeofreport', TRUE) == 'xls') {
            $vista = $this->load->view('yreportlib/report_format_html', $data, TRUE);
            header("Content-type: application/vnd.ms-excel; name='excel'");
            header("Content-Disposition: filename=reporte.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $vista;
        }
    }

    private function fieldToReport($row, $modelo, $f)
    {
        return $modelo->textForTable($row, $f);
    }
}
