//- 
//- proj specified funcs
//- added by wadelau@ufqi.com, 10:34 Sunday, January 10, 2016
//-

//- fill default value
//- Xenxin@ufqi.com, 19:03 27 November 2017
//- randType = string, number, date, [sys values]
//- e.g.
//- <delayjsaction>onload::3::fillDefault('apikey','string',16);</delayjsaction>
//- 
if(typeof userinfo == 'undefined'){ userinfo = {}; } 
//-
function fillDefault(fieldId, randType, randLen){
    var f = document.getElementById(fieldId);
    if(f){
           var oldv = f.value;
           if(oldv == ''){
                if(randType == null || randType == ''){
                    randType = 'string';    
                } 
                if(randLen == null || randLen == 0 || randLen == ''){
                    radnLen = 16
                }
                if(randType == 'string'){
                    var randVal = '';
                    var sDict = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
                    for (var i = 0; i < randLen; i++){
                        randVal += sDict.charAt(Math.floor(Math.random() * sDict.length));
                    }
                }
                f.value = randVal;
                console.log(' randVal:['+randVal+'] fillDefault succ.');
           }
           else{
               console.log('oldv not empty. fillDefault stopped.');
           } 
    }
    else{
        console.log('fieldId:['+fieldId+'] invalid. fillDefault failed.');
    }
}

//-
//- fillSubInput, xenxin@ufqi, Sun Jun 13 11:13:44 CST 2021
//- switch child input type by parent select option, as supper for fillSubSelect
/*
    <field name="fieldid">
        <chnname>属性名称</chnname>
        <selectoption>fromtable::item_fieldtbl::fieldname::itype=THIS_itype::id</selectoption>
        <jsaction>onchange::fillSubInput('fieldid', 'fieldvalue', 'itemField', './extra/readtblfield.php');</jsaction>
        <memo>如果列表中没有，可以去 扩展属性定义 中新增</memo>
    </field>
    <field name="fieldvalue">
        <chnname>属性值</chnname>
        <inputtype>textarea</inputtype>
        <jsaction>ondblclick::fillSubInput('fieldid', 'fieldvalue', 'itemField', './extra/readtblfield.php');</jsaction>
        <memo>数值型直接录入数字, 不用单位; 选择性的 是/有 选数字1, 否/无 选数字0; 文本内容的直接录入文字内容. &amp;nbsp;双击可转换>
输入方式</memo>
    </field>
 
 */

function fillSubInput(parentId, childId, logicId, myUrl){
    var fieldv = _g(parentId).options[_g(parentId).selectedIndex].value;
    var fieldorig = _g(childId+'_select_orig').value;
    fieldorig = fieldorig == null ? '' : fieldorig;
    console.log("currentVal:["+fieldv+"]");
    console.log("fillSubInput: fieldv:["+fieldv+"] logicId:["+logicId+"] orig_value:["+fieldorig+"]");
    if(fieldv != ''){
        //- 
    if(logicId == 'itemField'){
        var gta = new GTAjax();
        gta.set('targetarea', 'addareaextradiv');
        gta.set("callback", function(){
            //window.alert("getresult:["+this+"]");
            var resp = this;
            if(resp.indexOf('<pre') > -1){
                var resp_1 = /<pre[^>]*>([^<]*)<\/pre>/g;
                var resp_2 = resp_1.exec(resp);
                resp = resp_2[1];
            }
            //console.log("getresult:["+resp+"]");
            var jsonResp = JSON.parse(JSON.parse(resp)); //- <pre>"REAL_JSON_STRING"</pre>
            //console.log("getresult:["+resp+"] jsonResp:"+jsonResp+" ");
            var fieldInfo = jsonResp.result_list[0] ;
            console.log("fieldInfo:["+fieldInfo+"] str:"+JSON.stringify(fieldInfo));
            var childObj = _g(childId); var childOrigVal = childObj.value;
            if(fieldInfo.fieldtype == 4 || fieldInfo.fieldtype == 3){
                //- multiple or single select
                var myInput = "<select id='"+childId+"' name='"+childId+"'>";
                var myOptions = "";
                if(fieldInfo.fieldoption.indexOf('|') > -1){
                    var tmpOptions = fieldInfo.fieldoption.split('|'); var tmmj = 0;
                    for(var tmpi in tmpOptions){
                        if(tmpOptions[tmpi]=='\u662f' || tmpOptions[tmpi] == '有'){ tmpj = 1; }
                        else if(tmpOptions[tmpi]=='\u5426' || tmpOptions[tmpi] == '无'){ tmpj = 0; }
                        else{ tmpj = tmpi; }
                        myOptions += "<option value='"+(tmpj)+"'"+(tmpj==childOrigVal?" selected":"")+">"
                            +tmpOptions[tmpi]+"("+tmpj+")</option>"
                    }
                }
                else{
                    myOptions += "<option value='0'"+(0==childOrigVal?" selected":"")+">否, 无(0)</option>"
                        +"<option value='1'"+(1==childOrigVal?" selected":"")+">是, 有(1)</option>";
                }
                myInput += myOptions + "</select>";
                var newSpan = document.createElement('span');
                newSpan.innerHTML = myInput;
                var childUpObj = childObj.parentNode;
                childUpObj.insertBefore(newSpan, childObj);
                childUpObj.removeChild(childObj);
            }
			else if(fieldInfo.fieldtype == 2 || fieldInfo.fieldtype == 1){
                //- single line input
                var myInput = "<input id='"+childId+"' name='"+childId+"' value='"+childOrigVal+"'/>";
                var newSpan = document.createElement('span');
                newSpan.innerHTML = myInput;
                var childUpObj = childObj.parentNode;
                childUpObj.insertBefore(newSpan, childObj);
                childUpObj.removeChild(childObj);
            }   
            else{
                //- textarea as default...  
            }   
            //console.log("?-fieldtype:"+fieldInfo.fieldtype);
            
        });
        gta.get(appendSid(myUrl+'?objectid='+fieldv+'&isoput=0&logicid='+logicId+'&tbl=item_fieldtbl'));
        
    }
        //-
    }
    else{
        console.log("ido.js::fillSubInput::fieldv:["+fieldv+"] is empty.");
    }
}



