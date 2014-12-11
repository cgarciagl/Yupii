<?php

class YSimpleLevelReport {
    private $title = '';
    private $descfilter = '';
    private $encab = '';
    private $groups = array();
    private $totalrecords = 0;
    private $grouprecords = 0;
    private $listfields = array();
    private $data = array();

    public function __get($attr) {
        if (isset(get_instance()->$attr)) {
            return get_instance()->$attr;
        } else return null;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }

    private $showldwritelevelheader = false;
    private $showldwritelevelfooter = true;

    public function getDescfilter() {
        return $this->descfilter;
    }

    public function setDescfilter($descfilter) {
        $this->descfilter = $descfilter;
    }

    public function getGroups() {
        return $this->groups;
    }

    public function setGroups($groups) {
        $this->groups = $groups;
    }

    public function getListFields() {
        return $this->listfields;
    }

    public function setListFields($listfields) {
        $this->listfields = $listfields;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function quickSetup($title, $data, $listfields, $groups, $desc_filter = '') {
        $this->title        = $title;
        $this->data         = $data;
        $this->listfields   = $listfields;
        $this->groups       = $groups;
        $this->descfilter   = $desc_filter;
        $this->totalrecords = 0;
    }

    function generateTableHeader() {
        ?>
        <table>
        <thead>
        <tr>
            <?php
            $c            = (int)(100 / sizeof($this->listfields));
            $grouprecords = 0;
            foreach ($this->listfields as $f => $l) :
                ?>
                <th width='<?php echo $c ?>%'> <?php echo $l; ?> </th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
    <?php
    }

    function generateTableFooter() {
        ?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="<?php echo sizeof($this->listfields) ?>">
                <h5 style='float:right'> Total = <?php echo "{$this->grouprecords} {$this->title}"; ?> </h5>
            </td>
        </tr>
        </tfoot>
        </table>
    <?php
    }

    function generateTableRow($row) {
        $temp_string = "<tr>";
        foreach ($this->listfields as $f => $l) {
            $temp_string .= "<td> {$row[$f]} </td>";
        }
        $temp_string .= "</tr>";
        $this->totalrecords++;
        $this->grouprecords++;
        echo $temp_string;
    }

    function generateRowOrLevel($row) {
        $this->showldwritelevelheader = false;
        $this->showldwritelevelfooter = true;
        $this->encab                  = '';
        $this->calculateEncab($row);
        $this->generateEncabAndDetail($row);
    }

    function calculateEncab($row) {
        $i = 2;
        if ($this->groups) {
            foreach ($this->groups as $f => &$g) {
                $i++;
                if ((@$g['current'] != $row[$f]) || ($this->showldwritelevelheader)) {
                    if (@$g['current'] == '') {
                        $this->showldwritelevelfooter = false;
                    }
                    $g['current']                 = $row[$f];
                    $this->showldwritelevelheader = true;
                    $this->load->helper('utiles');
                    $this->encab .= "<h{$i}> " . ifset($g['label'], $f) . ": {$row[$f]} </h{$i}>";
                }
            }
        }
    }

    function generateEncabAndDetail($row) {
        if ($this->showldwritelevelheader) {
            if ($this->showldwritelevelfooter) {
                $this->generateTableFooter();
            }
            echo $this->encab;
            $this->generateTableHeader();
        }
        $this->generateTableRow($row);
    }

    function generate() {
        ?>
        <div id="imprimible" class="row">
            <h1><?php echo $this->title; ?></h1>
            <?php if (@$this->descfilter): ?>
                <h2><?php echo $this->descfilter; ?></h2>
            <?php endif; ?>
            <?php
            if (sizeof(@$this->groups) == 0) {
                $this->generateTableHeader();
            }
            ?>
            <?php foreach ($this->data as $row) {
                $this->generateRowOrLevel($row);
            } ?>
            <?php $this->generateTableFooter(); ?>

            <hr/>
            <h3 style='text-align:right'> Total : <?php echo $this->totalrecords; ?>  <?php echo $this->title; ?></h3>
        </div>
    <?php
    }

    function showSimpleView() {
        $this->load->view('yreportlib/ysimplelevelreport');
    }

}