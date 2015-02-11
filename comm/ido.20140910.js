//- 
//- Mon Jul 28 15:38:37 CST 2014
//- Fri Aug  1 13:58:12 CST 2014
//-
var currenttbl = '';
var currentdb = '';
var currentlistid = {}; //-- associative array
var userinfo = {};

if(!window.console){
	console = { log:function(){}};
}

//-- script used in /manage/items/index.jsp, 20090303, wadelau
function pnAction(url)
{
    if(url.indexOf("act=") == -1 && url.indexOf("?") > -1){
        url += "&act=list";
    }
	doAction(url);
}
function doAction(strUrl)
{
	var sActive = "actarea";
	var myAjax = new GTAjax();
	myAjax.set('targetarea',sActive);
	myAjax.set('forceframe',true);
	myAjax.set('nobacktag','nobacktag');
	var tmp = myAjax.get( appendTab(strUrl) );

}
function doActionEx(strUrl,sActive)
{  

	if(sActive=='addareaextra')
	{
		//document.getElementById('addareaextradiv').style.display='block';
        switchArea('addareaextradiv', 'on');
	}
    if(sActive == 'contentarea'){
        /*
        document.getElementById('contentarea_outer').style.display='block';
        document.getElementById('contentarea').style.display='block';
        */
        switchArea('contentarea_outer', 'on');
        switchArea('contentarea', 'on');
    }
	var myAjax = new GTAjax();
	myAjax.set('targetarea',sActive);
	myAjax.set('nobacktag','nobacktag');
	myAjax.set('forceframe',true);

	var tmp = myAjax.get( appendTab(strUrl) );

}

function _g( str )
{
	return document.getElementById( str );
}


function appendTab(strUrl)
{
	if(strUrl.indexOf(".php")>-1)
	{
		if(strUrl.indexOf("tbl")==-1)
		{
			//window.alert('need to append acctab.');
			if(strUrl.indexOf("?")==-1)
			{
				strUrl+="?tbl="+currenttbl;
			}
			else
			{
				strUrl+="&tbl="+currenttbl;
			}
			//window.alert('need to append acctab.done:['+strUrl+']');
		}
		if(strUrl.indexOf("db")==-1)
		{
			//window.alert('need to append acctab.');
			strUrl+="&db="+currentdb;
			//window.alert('need to append acctab.done:['+strUrl+']');
		}
	}
	return strUrl;
}

//- display an area or not
function switchArea(sArea, onf){
    if(sArea == null || sArea == ''){
        sArea = 'contentarea';
    }
    oldv = document.getElementById(sArea).style.display;
    newv = '';

    if(onf == null || onf == ''){
        if(oldv == 'block'){
            newv = 'none';
        }else if(oldv == 'none'){
            newv = 'block';
        }
    }else if(onf == 'on'){
        newv = 'block';
    }else if(onf == 'off'){
        newv = 'none';
    }

    document.getElementById(sArea).style.display=newv;

}

//-- search by a field in navigator menu
function searchBy(url){
    var fieldlist = document.getElementById('fieldlist').value;
    var fieldlisttype = document.getElementById('fieldlisttype').value;
    var fieldarr = fieldlist.split(",");
    var fieldtypearr = fieldlisttype.split(",");
    var typearr = new Array();
    for(var i=0; i<fieldtypearr.length; i++){
       var tmparr = fieldtypearr[i].split(":");
       typearr[tmparr[0]] = tmparr[1];
    }
    var appendquery = '';
    for(var i=0;i<fieldarr.length;i++){
        var fieldv = null;
        eval("var obj = document.getElementById('pnsk_"+fieldarr[i]+"');");
        if(obj != null){
            if(typearr[fieldarr[i]] == 'select'){
                eval("fieldv = document.getElementById('pnsk_"+fieldarr[i]+"').options[document.getElementById('pnsk_"+fieldarr[i]+"').selectedIndex].value;");
                //window.alert('field:'+fieldarr[i]+' select:fieldv:['+fieldv+']');
                console.log('field:'+fieldarr[i]+' select:fieldv:['+fieldv+']');
                if(fieldv == ""){
                    continue;
                }
            }else{
                eval("fieldv = document.getElementById('pnsk_"+fieldarr[i]+"').value;");
            }
            //if(fieldv != fieldarr[i]){
            if(fieldv != '~~~'){
				var fieldopv = '';
                if(document.getElementById('oppnsk_'+fieldarr[i]) != null){
                    eval("fieldopv = document.getElementById('oppnsk_"+fieldarr[i]+"').options[document.getElementById('oppnsk_"+fieldarr[i]+"').selectedIndex].value;");

                	console.log('fieldop:'+fieldarr[i]+' select:fieldopv:['+fieldv+']');
					if(fieldopv != '----'){
                		var reg1055 = new RegExp("，");
						fieldv = fieldv.replace(reg1055, ","); 
                		appendquery += "&pnsk"+fieldarr[i]+"="+fieldv;
                    	appendquery += "&oppnsk"+fieldarr[i]+"="+fieldopv;
					}
                }
				else{
					var reg1055 = new RegExp("，");
					fieldv = fieldv.replace(reg1055, ","); 
					appendquery += "&pnsk"+fieldarr[i]+"="+fieldv;
				}

                var reg = new RegExp("&pnsk"+fieldarr[i]+"=([^&]*)");
                url = url.replace(reg, "");
            }
        }
    }
    //window.alert("fieldlist:"+fieldlist+", url:["+url+"]");
    console.log("fieldlist:"+fieldlist+", url:["+url+"]");
    var reg = new RegExp("&pntc=([0-9]*)");
    url = url.replace(reg, "");
    reg = new RegExp("&pnpn=([0-9]*)");
        url = url.replace(reg, "");
    reg = new RegExp("&pnsk[0-9a-zA-Z]+=([^&]*)");
        url = url.replace(reg, "");
    //window.alert("fieldlist:"+fieldlist+", url:["+url+"]");
    doAction(url+appendquery);

}
//-- 挂表操作传递参数
function sendLinkInfo(vars, rw, fieldtag){
    if(rw == 'w'){
        if(parent.currentlistid){
            parent.currentlistid[fieldtag] = vars;
        }else{
            //window.alert('parent.currentlistid is ['+parent.currentlistid+'].');
        }
    }
    //window.alert('sendLinkInfo:'+currentlistid[fieldtag]+', 22-:'+parent.currentlistid[fieldtag]+', 33-:'+currentlistid.fieldtag+', 44-:'+parent.currentlistid.fieldtag+', win.href:['+window.location.href+'],  rw:['+rw+'] fieldtag:['+fieldtag+']');
    if(rw == 'r'){
        tmpid = parent.currentlistid[fieldtag]==undefined?'':parent.currentlistid[fieldtag];
        parent.currentlistid[fieldtag] = '';
        return tmpid;
    }
    return true;
}

//-- auto calculate numbers, designed by Wadelau@ufqi.com, BGN
//-- 16/02/2012 23:11:28
/* example:
 * 	onclick="hss_calcu_onf(this);"
 * 	onchange="hss_calcu(this, 'zongzhichu', {'*':'peitongfangshu','+':'otherid'});"
 * means: zongzhichu = this.value * peitongfangshu + otherid
 */
var hss_currentCalcu = {};
function hss_calcu_onf(thisfield){
    //window.alert('oldv: ['+thisfield.value+']');
    var fieldid = thisfield.id;
    hss_currentCalcu.fieldid = thisfield.value==''?0:thisfield.value;
}
function hss_calcu(thisfield, targetx, otherlist){
    var fieldid = thisfield.id;
    if(hss_currentCalcu.fieldid == null || hss_currentCalcu.fieldid == undefined || hss_currentCalcu.fieldid == 'null'){
        var tmpobj = document.getElementById(fieldid);
        hss_currentCalcu.fieldid = tmpobj.value == ''?0:tmpobj.value;
    }
    var thisfieldv = thisfield.value==''?0:thisfield.value;
    var bala = thisfieldv - hss_currentCalcu.fieldid;
    var tgt = document.getElementById(targetx);
    var formulax  = '';
    if(tgt != null && isNumber(hss_currentCalcu.fieldid) && isNumber(thisfieldv)){
            var oldv = tgt.value==''?0:tgt.value;
            oldv = parseInt(oldv);
            for(var k in otherlist){
                //window.alert('k:['+k+'] val:['+otherlist[k]+']');
                var tmpobj = document.getElementById(otherlist[k]);
                var tmpval = 1;
                if(tmpobj != null){
                    tmpval = tmpobj.value==''?0:tmpobj.value;
                }else if(k == '+' || k == '-'){
                    tmpval = 0;
                }
                formulax += ' ' + k + ' ' + tmpval;
            }
            //window.alert('formulax:['+formulax+']');
            var balax = eval(bala+formulax);
            var newv = oldv + parseInt(balax);
            tgt.value = parseInt(newv);
            //window.alert('oldv:['+hss_currentCalcu.fieldid+'] new-field: ['+thisfield.value+'] bala:['+bala+'] formula:['+formulax+'] balax:['+balax+'] newv:['+newv+']');
            //hss_currentCalcu.fieldid = null;
    }else{
        window.alert('Javascript:hss_calcu: Error! targetx:['+targetx+'] is null or hss_currentCalcu.'+fieldid+':['+hss_currentCalcu.fieldid+'] is not numeric. \n\tClick an input field firstly.');
        thisfield.focus();
    }
}
function isNumber(n){
	return !isNaN(parseFloat(n)) && isFinite(n);
}
//- added Wed Apr  4 19:57:23 CST 2012
function hss_calcuTbl(theform, targetx,f){
    var id = theform.id;
    if(typeof id != 'string'){
        id = theform.name;
    }
    //window.alert('this.id:['+id+'] name:['+theform.name+'] method:['+theform.method+'] formula:['+f+']');
    var fArr = f.split(" "); //-- use space to separate each element in the formula
    var symHm = {'=':'','+':'','-':'','*':'','/':'','(':'',')':''};
    for(var i=0; i<fArr.length; i++){
        //window.alert('i:['+i+'] f:['+fArr[i]+']');
        if(fArr[i] != null && fArr[i] != ''){
        if(fArr[i] in symHm){
            //-
        }else{
            if(isNumber(fArr[i])){
                //-
            }else{
                var field = document.getElementById(fArr[i]);
                var fVal = null;
                if(field != null){
                    fVal = field.value==''?0:field.value;
                    fVal = parseInt(fVal);
                    fVal = fVal == NaN?0:fVal;
                    f = f.replace(new RegExp(' '+fArr[i],"gm"), ' '+fVal);
                    f = f.replace(new RegExp(fArr[i]+' ',"gm"), fVal+' ');
                }else{
                    window.alert('hss_calcuTbl: Unknown field:['+fArr[i]+']');
                }
                //window.alert('field:['+fArr[i]+'] val:['+fVal+'] new formula:['+f+']');
            }
        }
        }
    }
    //window.alert('new formula:['+f+']');
    var targetx = document.getElementById(targetx);
    if(targetx != null){
        targetx.value = eval(f);
    }
}
//-- auto calculate numbers, designed by Wadelau@ufqi.com, END

//- dynammic select, bgn, Sun Mar 11 11:36:44 CST 2012
function fillSubSelect(parentId, childId, logicId, myUrl){
    
    var fieldv = document.getElementById(parentId).options[document.getElementById(parentId).selectedIndex].value;
    var fieldorig = _g(childId+'_select_orig').value;
    fieldorig = fieldorig == null?'':fieldorig;
    console.log("currentVal:["+fieldv+"]");
    console.log("fieldv:["+fieldv+"] logicId:["+logicId+"] orig_value:["+fieldorig+"]"); 
    if(fieldv != ''){

    if(logicId == 'xiane'){
        var gta = new GTAjax();
        gta.set('targetarea', 'addareaextradiv');
        gta.set("callback", function(){
                    //window.alert("getresult:["+this+"]");
                    var s = this;
                    //console.log("getresult:["+s+"]");
                    var sArr = s.split("\n");
                    for(var i=0;i<sArr.length;i++){
                        //console.log('i:['+i+'] line:['+sArr[i]+']');
                        var tmpArr = sArr[i].split(':::');
                        console.log('key:['+tmpArr[0]+'] val:['+tmpArr[1]+']');
                        if(tmpArr[0] != '' && tmpArr[0] != 'id' && tmpArr[1] != undefined){
                            var issel = false;
                            if(fieldorig.indexOf(tmpArr[0]) > -1){
                                issel = true;
                            }
                            document.getElementById(childId).options[i] = new Option(tmpArr[1]+'('+tmpArr[0]+')',tmpArr[0], true,issel);
                        }
                    }
                });
        gta.get(myUrl+'?objectid='+fieldv+'&isoput=0&logicid='+logicId);

    }else if(logicId == 'mingcheng'){
        var gta = new GTAjax();
        gta.set('targetarea', 'addareaextradiv');
        gta.set("callback", function(){
                    //window.alert("getresult:["+this+"]");
                    var s = this;
                    console.log("getresult:["+s+"]");
                    var sArr = s.split("\n");
                    for(var i=0;i<sArr.length;i++){
                        //console.log('i:['+i+'] line:['+sArr[i]+']');
                        var tmpArr = sArr[i].split(':::');
                        console.log('key:['+tmpArr[0]+'] val:['+tmpArr[1]+']');
                        if(tmpArr[0] != '' && tmpArr[0] != 'id' && tmpArr[1] != undefined){
                            document.getElementById(childId).options[i] = new Option(tmpArr[1]+'('+tmpArr[0]+')',tmpArr[0], true,false);
                        }
                    }
                });
        gta.get(myUrl+'?objectid='+fieldv+'&isoput=0&logicid='+logicId); 

    }else if(logicId == 'leibie'){
                    console.log("getinto leibie");
        var gta = new GTAjax();
        gta.set('targetarea', 'addareaextradiv');
        gta.set("callback", function(){
                    //window.alert("getresult:["+this+"]");
                    var s = this;
                    console.log("getresult:["+s+"]");
                    var sArr = s.split("\n");
                    for(var i=0;i<sArr.length;i++){
                        //console.log('i:['+i+'] line:['+sArr[i]+']');
                        var tmpArr = sArr[i].split(':::');
                        console.log('key:['+tmpArr[0]+'] val:['+tmpArr[1]+']');
                        if(tmpArr[0] != '' && tmpArr[0] != 'id' && tmpArr[1] != undefined){
                            var issel = false;
                            if(fieldorig.indexOf(tmpArr[0]) > -1){
                                issel = true;
                            }
                            document.getElementById(childId).options[i] = new Option(tmpArr[1]+'('+tmpArr[0]+')',tmpArr[0], true,issel);
                        }
                    }
                });
        gta.get(myUrl+'?tbl=categorytbl&objectid='+fieldv+'&isoput=0&logicid='+logicId);
    
    }else if(logicId == 'area'){
                    console.log("getinto area");
        var gta = new GTAjax();
        gta.set('targetarea', 'addareaextradiv');
        gta.set("callback", function(){
                    //window.alert("getresult:["+this+"]");
                    var s = this;
                    console.log("getresult:["+s+"]");
                    var sArr = s.split("\n");
                    for(var i=0;i<sArr.length;i++){
                        //console.log('i:['+i+'] line:['+sArr[i]+']');
                        var tmpArr = sArr[i].split(':::');
                        console.log('key:['+tmpArr[0]+'] val:['+tmpArr[1]+']');
                        if(tmpArr[0] != '' && tmpArr[0] != 'id' && tmpArr[1] != undefined){
                            var issel = false;
                            if(fieldorig.indexOf(tmpArr[0]) > -1){
                                issel = true;
                            }
                            document.getElementById(childId).options[i] = new Option(tmpArr[1]+'('+tmpArr[0]+')',tmpArr[0], true,issel);
                        }
                    }
                });
        gta.get(myUrl+'?tbl=areatbl&objectid='+fieldv+'&isoput=0&logicid='+logicId);
    }



    }else{
        console.log("ido.js::fillSubSelect::fieldv:["+fieldv+"] is empty.");
    }
}
//- dynammic select, end, Sun Mar 11 11:36:44 CST 2012

//-- setSelectIndex, bgn, Tue May  8 20:59:42 CST 2012
//-- 其中一个 select 变化时，其余 select 的 selectedIndex 也跟着动
function setSelectIndex(mySelect, myValue){
    var objsel = document.getElementById(mySelect);
    if(objsel != null){
        for(var i = 0; i < objsel.options.length; i++){
            if(objsel.options[i].value == myValue){
                if(objsel.selectedIndex != i){
                    objsel.selectedIndex = i;
                }
                break;
            }
        }
    }
}
//-- setSelectIndex, bgn, Tue May  8 20:59:42 CST 2012


//-- generate tuanhao, bgn, Wed Mar 14 19:13:51 CST 2012
function generateTuanHao(userinfo,targetId,promptMsg){

    var targetObj = document.getElementById(targetId);
    var oldvar = '';
    if(targetObj != undefined){
        oldvar = targetObj.value;
    }
    if(oldvar == ''){

        var tuantype = window.prompt(promptMsg,'T');
        if(tuantype == null){
            tuantype = 'S';
        }
        var useremail = userinfo.email;
       
       // var tuanhao = userinfo.branch + '-' + useremail.substring(0,useremail.indexOf('@'));
        
        var tuanhao = userinfo.branch + '-' + useremail.substring(0,useremail.indexOf('@')) + '-' + tuantype;
        var tdate = new Date();
       
        tuanhao += '-' + (tdate.getFullYear()+''+(tdate.getMonth()+1)+''+tdate.getDate()+''+tdate.getHours()+''+tdate.getMinutes());
        
        //tuanhao += '-' + (tdate.getFullYear()+''+(tdate.getMonth()+1)+''+tdate.getDate()+''+tdate.getHours()+''+tdate.getMinutes());
        //-window.alert('user-email:['+userinfo.email+'] tuanhao:['+tuanhao+']');

        document.getElementById(targetId).value = tuanhao;
    }
}
//-- generate tuanhao, end, Wed Mar 14 19:13:51 CST 2012

//- switchEditable, bgn, Thu Mar 15 20:14:02 CST 2012
//-- 增加对 select 点击即编辑的支持
function switchEditable(targetObj,fieldName,fieldType,fieldValue,myUrl,readOnly){
    if(readOnly != ''){
        return true;
    }
    targetObj = document.getElementById(targetObj);
    targetObj.contentEditable = true;
    targetObj.style.background = "#ffffff";
    var newSelId = fieldName+'_new1425';
    var newsel = null;
    if(fieldType == 'select'){
       //window.alert('is Select:['+fieldValue+']!'); 
       newsel = document.createElement('select');
       newsel.setAttribute('id', newSelId);
       var searsel = document.getElementById('pnsk_'+fieldName);
       if(searsel != null){
            for(var i=0; i < searsel.length; i++){ //- 复制搜索栏里的select选项到当前
                var isselected = false;
                if(searsel.options[i].value == fieldValue){
                    isselected = true;
                }
                //window.alert('is Select:['+fieldValue+'] currentVal:['+searsel.options[i].value+'] isselected:['+isselected+']!'); 
                newsel.add(new Option(searsel.options[i].text, searsel.options[i].value, isselected, isselected));       
            }
       }
       targetObj.innerHTML = '';
       targetObj.appendChild(newsel);
    }
    var oldv = targetObj.innerHTML;
    var blurObj = targetObj;
    if(fieldType == 'select'){ 
        oldv = fieldValue;
        blurObj = newsel;
    }

    blurObj.onblur = function(){
        var newv = targetObj.innerHTML;
        var newvStr = '';
        if(fieldType == 'select'){
            newv = newsel.options[newsel.selectedIndex].value;
            newvStr = newsel.options[newsel.selectedIndex].text;
        } 
        //window.alert('oldv:['+oldv+'] newv:['+newv+'] newvStr:['+newvStr+']');
        if(newv != oldv){
            //window.alert('newcont:['+newv+'] \noldv:['+oldv+']');
            var gta = new GTAjax();
            gta.set('targetarea', 'addareaextradiv');
            gta.set("callback", function(){
                        var s = this;
                        if(s.indexOf('--SUCC--') > -1){
                            sendNotice(true,'Data updated Successfully. 成功');
                        }else{
                            
                           sendNotice(false,'Data updated Failed. Please Try again.');
                        }
                    });
            gta.get(myUrl+'&'+fieldName+'='+newv);

        }else{
            //window.alert('same content. unchanged.');
        }
        targetObj.style.background = "#E8EEF7";
        if(fieldType == 'select'){
            targetObj.innerHTML = newvStr; 
        }else{
            targetObj.innerHTML = newv;
        }
       
    }

}
//- switchEditable, end, Thu Mar 15 20:14:02 CST 2012

//-- notice bgn, Mon Mar 19 21:41:02 CST 2012
function sendNotice(isSucc, sMsg){
    var obj = document.getElementById('top_notice_div');
    if(obj != undefined && obj != null){
        
        if(isSucc){
            obj.innerHTML = '<span style="background-color:yellow; color:green">&nbsp; <b> '+sMsg+' </b> &nbsp;</span>';
        }else{
            obj.innerHTML = '<span style="background-color:yellow; color:red">&nbsp; <b> '+sMsg+' </b> &nbsp; </span>';
        }
        window.setTimeout(function(){ obj.innerHTML = ''; }, 8*1000);

    }else{
        window.alert(sMsg);
    }
}
//-- notice end, Mon Mar 19 21:41:02 CST 2012

//-- register an action to be run in a few seconds later, bgn
//-- see xml/hss_useraccesstbl.xml
function registerAct(tObj){
    if(tObj.status == 'onload'){
        //window.alert('delaytime:['+tObj.delaytime+']');
        window.setTimeout(unescape(tObj.action), tObj.delaytime*1000);
    }
}
//-- register an action to be run in a few seconds, end

//-- act list, 执行动作, bgn, Sat Jun  2 19:19:12 CST 2012
function doActSelect(sSel, sUrl, iId){
    
    var fieldv = document.getElementById(sSel).options[document.getElementById(sSel).selectedIndex].value;
    console.log("doActSelect: fieldv:["+fieldv+"]");
    var targetUrl = sUrl+"&act="+fieldv;
    if(fieldv != ''){
        if(fieldv == 'list-dodelete'){
            var isconfirm = window.confirm('Are you sure to delete Id:['+iId+']?');
            if(isconfirm){
                doAction(targetUrl);
            }
        }else{
            doActionEx(targetUrl, 'contentarea');
        }
    }else{
    
    }
}
//-- act list, end, Sat Jun  2 19:19:12 CST 2012

//-- getUrlByTime, Sat Jun 23 11:15:09 CST 2012
function getUrlByTime(baseUrl, timepara, timeop, timeTag){
    var url = baseUrl;
    var myDate = new Date();
    var today = myDate.getDay();
    var now = myDate.getTime();
    var fromd = 0;
    var tod = 0;
    var fromD = new Date(fromd);
    var toD = new Date(tod);
    var fromDStr = '';
    var toDStr = '';

    if(timeTag == 'THIS_WEEK'){
       fromd = now + (-today+1)*86400*1000;
       tod = now + (7-today)*86400*1000;
    }else if(timeTag == 'LAST_WEEK'){
       now = now - 86400*1000*7;
       fromd = now + (-today+1)*86400*1000;
       tod = now + (7-today)*86400*1000;
    }else if(timeTag == 'THIS_MONTH'){
       today = myDate.getDate(); 
       fromd = now + (-today)*86400*1000;
       tod = now + (30-today)*86400*1000;
    }else if(timeTag == 'LAST_MONTH'){
       today = myDate.getDate(); 
       now = now - 86400*1000*30;
       fromd = now + (-today)*86400*1000;
       tod = now + (30-today)*86400*1000;
    }

    fromD = new Date(fromd);
    toD = new Date(tod);
    fromDStr = fromD.getFullYear()+'-'+(fromD.getMonth()+1)+'-'+fromD.getDate();
    toDStr = toD.getFullYear()+'-'+(toD.getMonth()+1)+'-'+toD.getDate();

    if(timeop == 'inrange'){
        url += '&pnsk'+timepara+'='+fromDStr+','+toDStr+'&oppnsk'+timepara+'='+timeop;
    }
    //window.alert('now:['+now+'] fromd:['+fromd+'] tod:['+tod+'] url:['+url+']');

    doAction(url);

}
//-- getUrlByTime, Sat Jun 23 11:15:09 CST 2012


//-- old functions

function updateTag(tagtype,tagid,str)
{
	try
	{
		if(tagtype=='div' || tagtype=='span')
		{
			document.getElementById(tagid).innerHTML=str;
		}
		else
		{
			document.getElementById(tagid).value=str;
		}
	}
	catch(err)
	{
		//--
		window.alert('update err.');
	}

}


function checkAll()
{
	var boxValue="";
	for(var i=0;i<document.all.checkboxid.length;i++)
	{
	    document.all.checkboxid[i].checked   =   true;
		  boxValue= boxValue +document.all.checkboxid[i].value+",";
	}
	window.clipboardData.setData('text',boxValue);
	window.alert("something wrong. 03061743.");
}

function uncheckAll()
{
	var box1="";
	for(var i=0;i<document.all.checkboxid.length;i++)
	{
		if(document.all.checkboxid[i].checked == false)
		{
			 document.all.checkboxid[i].checked   =   true;
		   box1 = box1+document.all.checkboxid[i].value+",";
		}
		else
		{
			 document.all.checkboxid[i].checked = false;
		}
	}
  window.clipboardData.setData('text',box1);
  window.alert("something wrong. 03061744.");
}


function batchDelete(url,checkboxid)
{
	var box="";
	for(var i=0;i<document.all.checkboxid.length;i++)
	{
		if(document.all.checkboxid[i].checked == true)
		{
	    	box = box+document.all.checkboxid[i].value+",";
		}
	}
	var url1 = url+"&checkboxid="+box;
	if(box=="")
	{
		if(document.all.copyid.value=="??")
		{
		    alert("something wrong. 03061745.");
		}
		else
		{
		    alert("something wrong. 03061746.");
		}
	}
	else
	{
		if(document.all.copyid.value=="??")
		{
			if(confirm("are you sure:"+box))
			{
			    doAction(url1);
			}
		}
		else if(document.all.copyid.value=="??")
		{
			if(confirm("are you sure:"+box))
			{
				doAction(url1);
			}
		}
	}
}

function WdatePicker(){
    
    var obj = getElementByEvent(event);
    obj = document.getElementById(obj); 
    //window.alert('obj.id:['+obj.id+'] this.name:['+obj.name+']');
    if(obj.id != null){
        var newId = (obj.id).replace(new RegExp('-','gm'), '_');
        var myDatePicker = new DatePicker('_tmp'+newId,{
            inputId: obj.id,
            separator: '-',
            className: 'date-picker-wp'
        });
    }else{
        sendNotice('DateP has an invalid obj:['+obj+']');
    }
}

var DatePicker = function () {
    var $ = function (i) {return document.getElementById(i)},
        addEvent = function (o, e, f) {o.addEventListener ? o.addEventListener(e, f, false) : o.attachEvent('on'+e, function(){f.call(o)})},
        getPos = function (el) {
            for (var pos = {x:0, y:0}; el; el = el.offsetParent) {
                pos.x += el.offsetLeft;
                pos.y += el.offsetTop;
            }
            return pos;
        }

    var init = function (n, config) {
        window[n] = this;
        Date.prototype._fd = function () {var d = new Date(this); d.setDate(1); return d.getDay()};
        Date.prototype._fc = function () {var d1 = new Date(this), d2 = new Date(this); d1.setDate(1); d2.setDate(1); d2.setMonth(d2.getMonth()+1); return (d2-d1)/86400000;};
        this.n = n;
        this.config = config;
        this.D = new Date;
        this.el = $(config.inputId);
        this.el.title = this.n+'DatePicker';
        this.update();
        this.bind();
    }

    init.prototype = {
        update : function (y, m) {
             var con = [], week = ['Su','Mo','Tu','We','Th','Fr','Sa'], D = this.D, _this = this;
             fn = function (a, b) {return '<td title="'+_this.n+'DatePicker" class="noborder hand" onclick="'+_this.n+'.update('+a+')">'+b+'</td>'},
                _html = '<table cellpadding=0 cellspacing=2>';
             y && D.setYear(D.getFullYear() + y);
             m && D.setMonth(D.getMonth() + m);
             var year = D.getFullYear(), month = D.getMonth() + 1, date = D.getDate();
             for (var i=0; i<week.length; i++) con.push('<td title="'+this.n+'DatePicker" class="noborder">'+week[i]+'</td>');
             for (var i=0; i<D._fd(); i++ ) con.push('<td title="'+this.n+'DatePicker" class="noborder">?</td>');
             for (var i=0; i<D._fc(); i++ ) con.push('<td class="hand" onclick="'+this.n+'.fillInput('+year+', '+month+', '+(i+1)+')">'+(i+1)+'</td>');
             var toend = con.length%7;
             if (toend != 0) for (var i=0; i<7-toend; i++) con.push('<td class="noborder">?</td>');
             _html += '<tr>'+fn("-1, null", "<<")+fn("null, -1", "<")+'<td title="'+this.n+'DatePicker" colspan=3 class="strong">'+year+'/'+month+'/'+date+'</td>'+fn("null, 1", ">")+fn("1, null", ">>")+'</tr>';
             for (var i=0; i<con.length; i++) _html += (i==0 ? '<tr>' : i%7==0 ? '</tr><tr>' : '') + con[i] + (i == con.length-1 ? '</tr>' : '');
             !!this.box ? this.box.innerHTML = _html : this.createBox(_html);
         },
        
        fillInput : function (y, m, d) {
                var s = this.config.separator || '/';
                this.el.value = y + s + m + s + d;
                this.box.style.display = 'none';
            },
        
        show : function () {
           var s = this.box.style, is = this.mask.style;
           s['left'] = is['left'] = getPos(this.el).x + 'px';
           s['top'] = is['top'] = getPos(this.el).y + this.el.offsetHeight + 'px';
           s['display'] = is['display'] = 'block';
           is['width'] = this.box.offsetWidth - 2 + 'px';
           is['height'] = this.box.offsetHeight - 2 + 'px';
        },

        hide : function () {
           this.box.style.display = 'none';
           this.mask.style.display = 'none';
        },

        bind : function () {
           var _this = this;
           addEvent(document, 'click', function (e) {
                   e = e || window.event;
                   var t = e.target || e.srcElement;
                   if (t.title != _this.n+'DatePicker') {_this.hide()} else {_this.show()}
                   })
        },

        createBox : function (html) {
                var box = this.box = document.createElement('div'), mask = this.mask = document.createElement('iframe');
                box.className = this.config.className || 'datepicker';
                mask.src = 'javascript:false';
                mask.frameBorder = 0;
                box.style.cssText = 'position:absolute;display:none;z-index:9999';
                mask.style.cssText = 'position:absolute;display:none;z-index:9998';
                box.title = this.n+'DatePicker';
                box.innerHTML = html;
                document.body.appendChild(box);
                document.body.appendChild(mask);
                return box;
            }
        }

    return init;
}();

function getElementByEvent(e)
{
    var targ;
    if (!e){ var e = window.event; }
    if (e.target){ targ = e.target;}
    else if (e.srcElement){ targ = e.srcElement };
    
    if (targ.nodeType == 3){ // defeat Safari bug
        targ = targ.parentNode
    }
    //window.alert('targ:['+targ+']');
    var tId;
    tId=targ.id;
    if(tId == null || tId == '' || tId == undefined){
        tId = targ.name;
    }
    //window.alert('targ:['+targ+'] id:['+tId+']');
    return tId;
}

//- added on Thu Jul 25 09:13:23 CST 2013
//- by wadelau@ufqi.com
//- for html editor
function getCont(sId){
    var obj = document.getElementById(sId);
    var objtype = '';
    var cont = '';
    if(obj){
        objtype = obj.tagName.toLowerCase();
        if(objtype == 'div'){
            cont = obj.innerHTML; 
        }else{
            cont = obj.value;
        }
    }
    console.log('./comm/ido.js: getCont: sId:['+sId+'] cont:['+cont+']');
    return cont;
}

function setCont(sId, sCont){
    var obj = document.getElementById(sId);
    var objtype = '';
    if(obj){
        objtype = obj.tagName.toLowerCase();
        if(objtype == 'div'){
            obj.innerHTML = sCont;
        }else{
            obj.value = sCont;
        }
    }
	console.log("setCont: ["+sCont+"]");
	//window.alert("setCont once");
    return 0;
}

function openEditor(sUrl, sField){
    document.getElementById(sField+"_myeditordiv").innerHTML = "<iframe name=\'myeditoriframe\' id=\'myeditoriframe\' src=\'"+sUrl+"\' width=\'680px\' height=\'330px\' border=\'0px\' frameborder=\'0px\'></iframe>"; 
} 

//-- select to input & search, Sun Jul 27 21:25:39 CST 2014
function changeBGC(obj, onoff){
	if(onoff==1){
		obj.style.background='silver';
	}
	else{ 
		obj.style.background='#fff';
	}
}
function makeSelect(sId, sCont, sDiv, sSele){
	setCont(sId, sCont);
	var hidesele = document.getElementById(sSele);
	if(hidesele != null){
		for(var i=0; i < hidesele.length; i++){ //- 复制搜索栏里的select选项到当前
			var seleText = hidesele.options[i].text;
			if(seleText == sCont){
				hidesele.selectedIndex = i;	
				break;
			}
		}
		console.log('makeSelect: i:'+i);
	}

	var objDiv = document.getElementById(sDiv)
	objDiv.style.display='none';
	objDiv.innerHTML = '';
}
function input2Search(inputx,obj){
	var lastSearchTime = userinfo.lastInput2SearchTime;
	var lastSearchItem = userinfo.lastInput2SearchItem;
	var nowTime = (new Date()).getTime();
	var balaTime = nowTime - lastSearchTime;
	var inputVal = inputx.value;
	var obj1737 = document.getElementById('pnsk_'+obj+'_sele_div');
	if(inputVal.length < 2 || balaTime < 50 || inputVal == lastSearchItem){
		// || balaTime < 100 
		console.log('input-length:'+inputVal.length+', balaTime:'+balaTime+', lastItem:'+lastSearchItem);
		//obj1737.innerHTML = '';
		return 0;
	}
	else{
		var iInputX = inputx.value.toLowerCase();
		var hidesele = document.getElementById('pnsk_'+obj+'');
		var odata = ""; 
		var dataarr = []; var j = 0;
		if(hidesele != null){
			for(var i=0; i < hidesele.length; i++){ //- 复制搜索栏里的select选项到当前
				var seleText = hidesele.options[i].text;
				if(seleText.toLowerCase().indexOf(iInputX) > -1){
					//--
					dataarr[j++] = '<span onmouseover=parent.changeBGC(this,1); onmouseout=parent.changeBGC(this,0); onclick=parent.makeSelect(\'input2sele_'+obj+'\',this.innerText,\'pnsk_'+obj+'_sele_div\',\'pnsk_'+obj+'\');>'+seleText+'</span>';
					if(j>30){
						dataarr[j++] = '更多.....';
						break;	
					}
				}
			}
		}
		if(dataarr.length == 0){
			dataarr[0] = "......Searching....";	
		}
		odata = dataarr.join('<br/>');
		//console.log(odata);	
		obj1737.innerHTML = odata;
		userinfo.lastInput2SearchTime = (new Date()).getTime();
		userinfo.lastInput2SearchItem = inputVal;
	}
}
