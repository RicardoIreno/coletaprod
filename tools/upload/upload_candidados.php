<?php

require '../../inc/config.php';
require '../../inc/functions.php';

var_dump($argv);

$row = 1;
if (($handle = fopen($argv[1], "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        echo "<p> $num campos na linha $row: <br /></p>\n";
        $row++;
        for ($c=0; $c < $num; $c++) {
            echo $data[$c] . "\n";
        }
    }
    fclose($handle);
}

?>
