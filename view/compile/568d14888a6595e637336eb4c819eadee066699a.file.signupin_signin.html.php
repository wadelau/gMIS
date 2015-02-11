<?php /* Smarty version Smarty-3.1.7, created on 2014-12-19 15:29:33
         compiled from "/www/webroot/pages/dev/dbmgmt/view/signupin_signin.html" */ ?>
<?php /*%%SmartyHeaderCode:1773463278535a1a0d9111e7-18143370%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '568d14888a6595e637336eb4c819eadee066699a' => 
    array (
      0 => '/www/webroot/pages/dev/dbmgmt/view/signupin_signin.html',
      1 => 1418974170,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1773463278535a1a0d9111e7-18143370',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_535a1a0d98668',
  'variables' => 
  array (
    'rtvdir' => 0,
    'action' => 0,
    'agentname' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_535a1a0d98668')) {function content_535a1a0d98668($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ('header.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 0px;
	margin-right: 3px;
	margin-bottom: 0px;
	background-color: #1D3647;
}
.nobgcolortbl{
    text-align:left;
    background-image: url(../img/login-content-bg.gif);
    background-repeat: repeat;
    background-size: 100% 100%;
}
-->
</style>
<script language="JavaScript">
function correctPNG()
{
    var arVersion = navigator.appVersion.split("MSIE")
    var version = parseFloat(arVersion[1])
    if ((version >= 5.5) && (document.body.filters)) {
       for(var j=0; j<document.images.length; j++){
          var img = document.images[j]
          var imgName = img.src.toUpperCase()
          if (imgName.substring(imgName.length-3, imgName.length) == "PNG")
          {
             var imgID = (img.id) ? "id='" + img.id + "' " : "";
             var imgClass = (img.className) ? "class='" + img.className + "' " : "";
             var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' ";
             var imgStyle = "display:inline-block;" + img.style.cssText; 
             if (img.align == "left"){ imgStyle = "float:left;" + imgStyle; }
             if (img.align == "right"){ imgStyle = "float:right;" + imgStyle; }
             if (img.parentElement.href){ imgStyle = "cursor:hand;" + imgStyle; }
             var strNewHTML = "<span " + imgID + imgClass + imgTitle
             + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
             + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
             + "(src=\'" + img.src + "\', sizingMethod='scale');\"></span>"; 
             img.outerHTML = strNewHTML;
             j = j-1;
          }
       }
    }    
}
//window.attachEvent("onload", correctPNG);
// window.addEventListener("onload", correctPNG);
</script>
<table width="100%" border="0px" height="566px" border="0px" cellpadding="0" cellspacing="0" class="login_top_bg" >
  <tr >
        <td height="38px">&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
  </tr>
  <tr class="nobgcolortbl">
    <td valign="bottom" height="560px"  style="vertical-align:middle"  >

            <table width="100%" border="0px" cellpadding="0" cellspacing="0" style="background:transparent;">
                <tr>
                  <td  style="text-align:center;" colspan="3" height="80" valign="top">
				  
				人民网工具条( -people-toolbar-admin )
				<br/>互联网前沿追踪( -people-ice )
				<br/>书刊编辑系统( -people-shukan )

				  <br/>

				  <a href="<?php echo $_smarty_tpl->tpl_vars['rtvdir']->value;?>
/General.Mgmt.Info.Sys.201410.v2.pdf" target="_blank" style="font-size:15px;font-weight:bold"><i>g</i>MIS文档参考 / ManualBook and Reference of <i>g</i>MIS <br/> Mar. 2014, v2</a> </td>
                </tr>

                    <tr>
                      <td width="35%">&nbsp;</td>
                      <td height="25" colspan="2" class="left_txt"><p>1- 综合业务管理系统的首选方案...</p></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td height="25" colspan="2" class="left_txt"><p>2- 一站通式的整合方式，方便用户使用...</p></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td height="25" colspan="2" class="left_txt"><p>3- 强大的后台系统，管理内容易如反掌...</p></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td width="30%" height="40"><img src="../img/icon-demo.gif" width="16" height="16"><a href="./ido.php?tbl=info_helptbl&tit=帮助说" target="_blank" class="left_txt3"> 使用说明</a> </td>
                      <td width="35%"><img src="../img/icon-login-seaver.gif" width="16" height="16"><a href="#" class="left_txt3"> 在线客服</a></td>
                    </tr>
             </table>

        </td>
        <td width="2%" >&nbsp;</td>
        <td width="50%" valign="bottom" style="vertical-align:middle" >
        
<!-- class="login_bg2" -->
                    <form name="myform" action="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" method="post">
                        <table cellSpacing="0" cellPadding="0" width="100%" border="0px" height="143" id="table212" style="background:transparent">
                            <tr style="background-image:url(../img/login-wel.gif);">
                                <td colspan="2" height="48" style="vertical-align:middle">&nbsp;</td>
                            </tr>

                            <tr style="background:transparent">
                                <td width="2%">&nbsp;</td>
                                <td width="96%" height="48" style="vertical-align:middle"><span class="login_txt_bt"><?php echo $_smarty_tpl->tpl_vars['agentname']->value;?>
</span></td>
                            </tr>


                          <tr>
                            <td width="13%" height="38" class="top_hui_text" nowrap><span class="login_txt" norwap>用户电子邮箱：&nbsp;&nbsp; </span></td>
                            <td height="38" colspan="2" class="top_hui_text"><input name="email" id="email" class="editbox4" value="" size="20"> <script>var emailtag = document.getElementById('email'); emailtag.focus();</script>                            </td>
                          </tr>
                          <tr>
                            <td width="13%" height="35" class="top_hui_text"><span class="login_txt"> 密 码： &nbsp;&nbsp; </span></td>
                            <td height="35" colspan="2" class="top_hui_text"><input class="editbox4" type="password" size="20" name="password" id="password">
                              <img src="../img/luck.gif" width="19" height="18"> </td>
                          </tr>
                          <tr>
                            <td width="13%" height="35" ><span class="login_txt">验证码：</span></td>
                            <td height="35" colspan="2" class="top_hui_text"><input class=wenbenkuang name="verifycode" id="verifycode" type=text maxLength=4 size=10><img src="<?php echo $_smarty_tpl->tpl_vars['rtvdir']->value;?>
/comm/verifycode.php" alt="-x-" ondblclick="javascript:this.src='<?php echo $_smarty_tpl->tpl_vars['rtvdir']->value;?>
/comm/verifycode.php?i='+(Math.random()*9999999+99999);" id="verifycodeimg2" title="双击刷新" / width="200px"> &nbsp;<a href="javascript:void(0);" onclick="javascript:document.getElementById('verifycodeimg2').src='<?php echo $_smarty_tpl->tpl_vars['rtvdir']->value;?>
/comm/verifycode.php?i='+(Math.random()*9999999+99999);">看不清?</a>
                              </td>
                          </tr>
                          <tr>
                            <td width="20%" height="35" ><input name="Submit" type="submit" class="button" id="Submit" value="登 陆"> </td>
                            <td width="67%" class="top_hui_text"><input name="cs" type="button" class="button" id="cs" value="取 消" onClick="showConfirmMsg1()"></td>
                          </tr>
                           <!--
                            <tr>
                                <td align="right" valign="bottom">&nbsp;</td>
                                <td  height="164" align="right" valign="bottom"><img src="../img/login-wel.gif" ></td>
                            </tr>
                            -->
                        </table>
                    </form>

       </td> 
  </tr>

</table>
<?php echo $_smarty_tpl->getSubTemplate ('footer.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>