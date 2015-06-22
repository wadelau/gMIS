<?php
# save data from act=add|modify

$fieldlist = array();
$fieldvlist = array(); # remedy for overrided by $obj->get during adding, need a tmp container for query string, Thu Jun 11 22:15:32 CST 2015
$filearr = array();
if($id != ''){
    $gtbl->setId($id); # speical field
}

for($hmi=$min_idx; $hmi<=$max_idx; $hmi++){
    $field = $gtbl->getField($hmi);
    $fieldv = ''; # remedy by wadelau@ufqi.com, Wed Oct 17 12:46:16 CST 2012
    if($field == null | $field == '' 
            || $field == 'id'){
        continue;

    }else if(!$user->canWrite($field)){
        $out .= "$field cannot be written.\n";
        continue;

    }else if(in_array($field, $opfield)){
        $fieldv = $userid;
        $fieldlist[] = $field;
        #$gtbl->set($field, $fieldv);
		$fieldvlist[$field] = $fieldv;

    }else if(in_array($field,$timefield)){
        $fieldv = 'NOW()'; 
        $fieldlist[] = $field;
        #$gtbl->set($field, $fieldv);
        $fieldvlist[$field] = $fieldv;
        continue;
    
    }else if($field == 'password'){
        if($_REQUEST[$field] != ''){
           $fieldv = sha1($_REQUEST[$field]); 
		   $fieldlist[] = $field; 
		   #$gtbl->set($field, $fieldv); # 2014-10-26 21:33
		   $fieldvlist[$field] = $fieldv;
        }else{
          continue;    
        }            
        error_log(__FILE__.": field:[$field] fieldv:[$fieldv]");
		#print(__FILE__.": field:[$field] fieldv:[$fieldv]");
		
    }else{
        if($gtbl->getInputType($field) == 'file'){

            $fieldv_orig = $_REQUEST[$field.'_orig'];

            if($_FILES[$field]['name'] == '' && $fieldv_orig != ''){
                $fieldv = $fieldv_orig;
            
            }else if($_FILES[$field]['name'] != ''){
                
                # safety check 
                $disableFileExt = array('html','php','js','jsp','pl','shtml');
                $tmpFileNameArr = explode(".",strtolower($_FILES[$field]['name']));
                $tmpfileext = end($tmpFileNameArr);
                if(in_array($tmpfileext, $disableFileExt)){
                   error_log(__FILE__.": found illegal upload file:[".$_FILES[$field]['name']."]");
                   $out .= __FILE__.": file:[".$_FILES[$field]['name']."] is not allowed. 201210241927";
                   continue;
                }

                $filedir = $_CONFIG['uploaddir'];
                if($gtbl->getId() != ''){ # remove old file if necessary
                    $oldfile = $gtbl->get($field); # this might override what has been set by query string
                    if($oldfile != ""){
                    	$oldfile = str_replace($shortDirName."/","", $oldfile);
                        unlink($appdir."/".$oldfile);
                    }else{
                        error_log(__FILE__.": oldfile:[$oldfile] not FOUND. field:[$field]");				
                    }
                }
				$filedir = $filedir."/".date("Ym"); # Fri Dec  5 14:19:05 CST 2014
				if(!file_exists($appdir."/".$filedir)){
					mkdir($appdir."/".$filedir);	
				}
				$filename = basename($_FILES[$field]['name']);
				$filename = `$appdir/comm/base62x -encode "$filename"`;
				$filename = str_replace("\n", "", $filename);
                $filename = date("dHi")."_".substr($filename,0,64).".".$tmpfileext;
				#print __FILE__.": filename:[$filename]";
                if(move_uploaded_file($_FILES[$field]['tmp_name'], $appdir."/".$filedir."/".$filename)){
                    $out .= __FILE__.": file:[$filedir/$filename] succ.";
                }else{
                    $out .= __FILE__.": file:[$filename] fail. 201202251535";
                }
                #$fieldv = $filedir."/".$filename; 
                $fieldv = $shortDirName."/".$filedir."/".$filename; 
                $filearr['filename'] = basename($_FILES[$field]['name']); # sometimes original name may be different with uploadedfile.
                $filearr['filesize'] = $_FILES[$field]['size'];
                $filearr['filetype'] = $_FILES[$field]['type'];
            }

        }else if($gtbl->getSelectMultiple($field)){

            if(is_array($_REQUEST[$field])){ 
                $fieldv = implode(",", $_REQUEST[$field]);
            }else{
                $fieldv = $_REQUEST[$field]; 
            }

        }else{
            $fieldv = $_REQUEST[$field];
			if($fieldv == ''){
				$fieldv = $hmfield[$field."_default"];
			}
            else{
				if(strpos($fieldv,"<") !== false){ # added by wadelau on Sun Apr 22 22:09:46 CST 2012
                	#$fieldv = str_replace("<","&lt;", $fieldv);
                	# allow all html tags except these below 
                	$fieldv = str_replace("<script","&lt;script", $fieldv);
                	$fieldv = str_replace("<iframe","&lt;iframe", $fieldv);
                	$fieldv = str_replace("<embed","&lt;embed", $fieldv);
            	}
            	if(strpos($fieldv, "\n") !== false){
                	$fieldv = str_replace("\n", "<br/>", $fieldv);
            	}
        	}
    	}
    	$fieldlist[] = $field;
    	#$gtbl->set($field, $fieldv);
    	$fieldvlist[$field] = $fieldv;
	}

	#print(__FILE__.": field:[$field] fieldv:[$fieldv]");
}

#print(__FILE__.": fieldlist:[".$gtbl->toString($fieldlist)."]");
foreach($fieldvlist as $k=>$v){
	$gtbl->set($k, $v);		
}

if(count($filearr)){
    foreach($filearr as $k=>$v){
        $gtbl->set($k, $v);
    }
}

$hm = $gtbl->setBy(implode(',', $fieldlist), null); 
#print_r($hm);
if($hm[0]){
    
    $hm = $hm[1];
    if($gtbl->getId() == ''){
        $gtbl->setId($hm['insertid']);
        $id = $gtbl->getId();
    }

    # some triggers bgn, added on Fri Mar 23 21:51:12 CST 2012
    include("./act/trigger.php");
    # some triggers end, added on Fri Mar 23 21:51:12 CST 2012

    $out .= "<script> parent.sendNotice(true, '操作成功！'); parent.switchArea('contentarea_outer','off'); </script>";

}else{
    $out .= "<script> parent.sendNotice(false, '遗憾！操作失败，请重试');</script>";
}

$gtbl->setId('');

?>
