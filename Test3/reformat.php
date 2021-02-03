<?php
$output = "output/";
// $dir = new RecursiveDirectoryIterator('data/');
// foreach (new RecursiveIteratorIterator($dir) as $filename => $file) {
$file = "data/20131004/device-tokens-for-sfx-collection-1.log";
if (!is_dir($file)) {
    $fp = fopen($file, "r");
    if ($fp !== FALSE) {
        $fpw = fopen("output/" . pathinfo($file)['filename'] . "-mod.csv", (file_exists($file)) ? 'a' : 'w');
        if ($fpw !== FALSE) {
            $header = array(
                "id",
                "appCode",
                "deviceId",
                "contactable",
                "subscription_status",
                "has_downloaded_free_product_status",
                "has_downloaded_iap_product_status"
            );
            fputcsv($fpw, $header);
            $flag = 0;
            $i = 0;
            while (($data = fgetcsv($fp, 1000, ",")) !== FALSE) {
                if ($flag == 1) {
                    $row = array();
                    array_push($row, $i); //id
                    array_push($row, $data[0]); //Appcode
                    array_push($row, $data[1]); //deviceId = deviceToken
                    array_push($row, $data[2]); //Contactable = deviceTokenStatus

                    $taglist = explode("|", $data[3]);
                    $substat = "";
                    $downfreestat = "";
                    $downiapstat = "";
                    $currentTag = "";
                    
                    for ($j = 0; $j <= count($taglist); $j++) {
                        $currentTag = $taglist[$j];
                        if (strcmp($currentTag, "active_subscriber") || strcmp($currentTag, "expired_subscriber") || strcmp($currentTag, "never_subscribed") || strcmp($currentTag, "subscription_unknown")) {
                            $substat = $currentTag;
                            break;
                        }
                    }
                    $currentTag = "";
                    for ($j = 0; $j <= count($taglist); $j++) {
                        $currentTag = $taglist[$j];
                        if (strcmp($currentTag, "has_downloaded_free_product") || strcmp($currentTag, "not_downloaded_free_product") || strcmp($currentTag, "downloaded_free_product_unknown")) {
                            $downfreestat = $currentTag;
                            break;
                        }
                    }
                    $currentTag = "";
                    for ($j = 0; $j <= count($taglist); $j++) {
                        $currentTag = $currentTag;
                        if (strcmp($currentTag, "has_downloaded_iap_product") || strcmp($currentTag, "not_downloaded_free_product") || strcmp($currentTag, "downloaded_iap_product_unknown")) {
                            $downiapstat = $currentTag;
                            break;
                        }
                    }

                    array_push($row, $substat); //subscriptionStatus
                    array_push($row, $downfreestat); //has_downloaded_free_product_status",                
                    array_push($row, $downiapstat); //"has_downloaded_iap_product_status"

                    fputcsv($fpw, $row);
                    $i++;
                } else {
                    $flag++;
                }
            }
            fclose($fpw);
        }
    }
    fclose($fp);
}
// }
