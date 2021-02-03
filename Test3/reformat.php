<?php
$output = "output/";
$dir = new RecursiveDirectoryIterator('data/');
foreach (new RecursiveIteratorIterator($dir) as $filename => $file) {
    // $file = "data/20131004/device-tokens-for-sfx-collection-1.log";
    $fp = fopen($file, "r");
    if ($fp !== FALSE) {
        // $fpw = fopen("/output/new-" . $file, "w");
        $fpw = fopen("/new-" . $file, (file_exists($file)) ? 'a' : 'w');
        if ($fpw !== FALSE) {
            $list = array();
            $row = array();
            while (($data = fgetcsv($fp, 1000, ",")) !== FALSE) {
                $num = count($data);
                for ($i = 0; $i < $num; $i++) {
                    // echo $data[$i] . "\n";
                    array_push($row, $data[$i]);
                }
                array_push($list, $row);
            }
            foreach ($list as $value) {
                fputcsv($fpw, $value);
            }
            fclose($fpw);
        }
    }
    fclose($fp);
}
