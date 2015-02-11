<?php /* Smarty version Smarty-3.1.7, created on 2014-10-24 09:51:05
         compiled from "/vhost/7/0/9/net70934927/www/phase2/admin/view/signupin_signout.html" */ ?>
<?php /*%%SmartyHeaderCode:10643596685449b089c62212-91804973%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e372dfe670f2143dd5fc659f988d85042324e849' => 
    array (
      0 => '/vhost/7/0/9/net70934927/www/phase2/admin/view/signupin_signout.html',
      1 => 1414109914,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10643596685449b089c62212-91804973',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'action' => 0,
    'agentname' => 0,
    'result' => 0,
    'nexturl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5449b089dc104',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5449b089dc104')) {function content_5449b089dc104($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ('header.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

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
    background-size: 100% 100%;
    background-repeat: repeat;
}
-->
</style>
<script language="JavaScript">
function correctPNG()
{
    var arVersion = navigator.appVersion.split("MSIE")
    var version = parseFloat(arVersion[1])
    if ((version >= 5.5) && (document.body.filters)) 
    {
       for(var j=0; j<document.images.length; j++)
       {
          var img = document.images[j]
          var imgName = img.src.toUpperCase()
          if (imgName.substring(imgName.length-3, imgName.length) == "PNG")
          {
             var imgID = (img.id) ? "id='" + img.id + "' " : ""
             var imgClass = (img.className) ? "class='" + img.className + "' " : ""
             var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' "
             var imgStyle = "display:inline-block;" + img.style.cssText 
             if (img.align == "left") imgStyle = "float:left;" + imgStyle
             if (img.align == "right") imgStyle = "float:right;" + imgStyle
             if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle
             var strNewHTML = "<span " + imgID + imgClass + imgTitle
             + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
             + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
             + "(src=\'" + img.src + "\', sizingMethod='scale');\"></span>" 
             img.outerHTML = strNewHTML
             j = j-1
          }
       }
    }    
}
//window.attachEvent("onload", correctPNG);
//window.addEventListener("onload", correctPNG);
</script>
<table width="100%" height="566" border="0px" cellpadding="0" cellspacing="0" class="login_top_bg" >
  <tr>
        <td height="38">&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
  </tr>
  <tr class="nobgcolortbl">
    <td valign="bottom" height="560px"  style="vertical-align:middle"  >
        <table width="100%" border="0px" cellpadding="0" cellspacing="0" style="background:transparent" class="">
                
                <tr>
                  <td  style="text-align:center;" colspan="3" height="80" valign="top"> </td>
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
                      <td width="30%" height="40"><img src="../img/icon-demo.gif" width="16" height="16"><a href="./ido.php?tbl=info_helptbl&tit=帮组说明" target="_blank" class="left_txt3"> 使用说明</a> </td>
                      <td width="35%"><img src="../img/icon-login-seaver.gif" width="16" height="16"><a href="gmis" class="left_txt3"> 在线客服</a></td>
                    </tr>
             </table>
        </td>
        <td width="2%" >&nbsp;</td>
        <td width="50%" valign="bottom" style="vertical-align:middle" >
                <!--  class="login_bg2" -->
                   
                    <form name="myform" action="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" method="post">
                        <table cellSpacing="0" cellPadding="0" width="100%" style="background:transparent"  border="0" height="143" id="table212" >
                            <tr style="background-image:url(../img/login-wel.gif);">
                                <td colspan="2" height="48" style="vertical-align:middle">&nbsp;</td>
                            </tr>

                            <tr style="background:transparent">
                                <td width="2%">&nbsp;</td>
                                <td width="96%" height="48" style="vertical-align:middle"><span class="login_txt_bt"> <?php echo $_smarty_tpl->tpl_vars['agentname']->value;?>
 </span></td>
                            </tr>

                            <tr>
                            <td colspan="2">
                                 <span class="login_txt"> 
                                    <?php echo $_smarty_tpl->tpl_vars['result']->value;?>

                                 <br/><br/><a href="<?php echo $_smarty_tpl->tpl_vars['nexturl']->value;?>
">继续</a>
                                 </span>
                            </td>
                          
                          </tr>
                          
                        </table>
                    </form>
            </td> 
  </tr>
</table>
<?php echo $_smarty_tpl->getSubTemplate ('footer.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>