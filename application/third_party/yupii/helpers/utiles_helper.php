<?php

function dbgconsole($x) {
    ?>
    <script type="text/javascript">
        console.warn('<?php echo json_encode($x)?>');
    </script>
<?php
}

function dbgdie($x) {
    echo '<pre>' . json_encode($x) . '</pre>';
    die();
}

function currency($number, $symbol = TRUE) {
    if ($symbol) {
        return money_format('%.2n', $number);
    } else {
        return money_format('%!.2n', $number);
    }
}

function self_url() {
    return get_instance()->uri->ruri_string();
}

function refresh() {
    redirect(self_url());
}

function ifset(&$val, $default = NULL) {
    return isset($val) && !empty($val) ? $val : $default;
}

function result_to_select($result, $blank = FALSE) {
    if (is_array($result)) {
        $options = $keys = array();
        foreach ($result AS $row) {
            if (count($row) !== 2) {
                show_error('function ' . __function__ . ": Array having more than 2 or less columns");
            }
            foreach ($row AS $key => $value) {
                $keys[] = $key;
            }
            for ($i = 0; $i < count($keys); $i++) {
                $options[$row[$keys[0]]] = $row[$keys[1]];
            }
        }
        if ($__blank) {
            $options = add_blank_option($options, $blank);
        }
        return $options;
    }
    show_error("Passed wrong array options parameter");
}
