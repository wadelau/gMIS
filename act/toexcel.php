<?php

# do convert hm records to csv used in excel file, Sat Jun 23 13:21:46 CST 2012

# print_r($hm);

$dnld_dir = $appdir."/dnld";
$dnld_file = "data_".str_replace("hss_","",$tbl)."_".date("Y-m-d").".csv";

$myfp = fopen($dnld_dir.'/'.$dnld_file, 'wb');
fwrite($myfp, chr(0xEF).chr(0xBB).chr(0xBF));
if($myfp){
    $fieldsname = array();
    $firstrow = $hm[0];
    foreach($firstrow as $k=>$v){
        $fieldsname[] = $gtbl->getCHN($k);
    }
    fputcsv($myfp, $fieldsname);
	/*
    foreach($hm as $fields){
        fputcsv($myfp, $fields);
    }
	*/
	foreach($hm as $k=>$v){
		$str = "";
		foreach($v as $k2=>$v2){
			#print "k2:$k2, v2:$v2\n";	
			if($gtbl->getInputType($k2) == "select"){
				$v2 = $gtbl->getSelectOption($k2, $v2,'',1, $gtbl->getSelectMultiple($k2));		
			}
			else if(strpos($v2,",") !== false){
				$v2 = str_replace(",", "_", $v2);
			}
			$str .= $v2.",";
		}
		$str = substr($str, 0, strlen($str)-1);
		fwrite($myfp, $str."\n");
	}
}
fclose($myfp);

$out .= "<script type=\"text/javascript\">";
$out .= "window.open('".$rtvdir."/dnld/".$dnld_file."','Excel File Download','scrollbars,toolbar,location=0,status=yes,resizable,width=600,height=400'');";
$out .= "</script>";

?>
