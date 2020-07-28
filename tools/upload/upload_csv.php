<?php

require '../../inc/config.php';
require '../../inc/functions.php';

$row = 1;
if (($handle = fopen($argv[1], "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, $argv[2])) !== FALSE) {
        if (!defined('CONSTANT_ARRAY')) {
            define("CONSTANT_ARRAY", $data);
        } else {
            $num = count($data);
            for ($c=0; $c < $num; $c++) {
                $doc["doc"][CONSTANT_ARRAY[$c]] = $data[$c];
            }
        }
        $doc["doc_as_upsert"] = true;
        print_r($doc);
        unset($doc);
    }
    fclose($handle);
}
?>
