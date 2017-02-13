<?php

function arrayToCSVFile(array $results, $fileName = 'temp.csv') {

    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header('Content-Description: File Transfer');
    header("Content-type: text/csv");
    header("Content-Disposition: attachment; filename={$fileName}");
    header("Expires: 0");
    header("Pragma: public");

    $fh = @fopen('php://output', 'w');

    $headerDisplayed = false;

    foreach ($results as $data) {
        // Add a header row if it hasn't been added yet
        if (!$headerDisplayed) {
            // Use the keys from $data as the titles
            fputcsv($fh, array_keys($data));
            $headerDisplayed = true;
        }

        // Put the data into the stream
        fputcsv($fh, $data);
    }
    fclose($fh);
    exit;
}
