<?php

function arrayToCSVFile(array $results, $fileName = 'temp.csv', $download = TRUE) {

    if ($download) {
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Transfer');
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename={$fileName}");
        header("Expires: 0");
        header("Pragma: public");

        $fh = @fopen('php://output', 'w');
    }
    else {
       $fh = @fopen('./temp.csv', 'w'); 
   }

   $headerDisplayed = false;

   foreach ($results as $data) {
    if (!$headerDisplayed) {
        fputcsv($fh, array_keys($data));
        $headerDisplayed = true;
    }
    fputcsv($fh, $data);
}
fclose($fh);

if (!$download) {
    rename('./temp.csv', $fileName);
}

}
