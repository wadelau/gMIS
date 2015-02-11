<?php

# do convert hm records to csv used in excel file, Sat Jun 23 13:21:46 CST 2012

# print_r($hm);

$dnld_dir = $appdir."/dnld";
$dnld_file = "data_".str_replace("hss_","",$tbl)."_".date("Y-m-d").".csv";

$myfp = fopen($dnld_dir.'/'.$dnld_file, 'w');
fwrite($myfp, chr(0xEF).chr(0xBB).chr(0xBF));
if($myfp){
    $fieldsname = array();
    $firstrow = $hm[0];
    foreach($firstrow as $k=>$v){
        $fieldsname[] = $gtbl->getCHN($k);
    }
    fputcsv($myfp, $fieldsname);
    foreach($hm as $fields){
        fputcsv($myfp, $fields);
    }
}
fclose($myfp);

$out .= "<script type=\"text/javascript\">";
$out .= "window.open('".$rtvdir."/dnld/".$dnld_file."','Excel File Download','scrollbars,toolbar,location=0');";
$out .= "</script>";

?>
