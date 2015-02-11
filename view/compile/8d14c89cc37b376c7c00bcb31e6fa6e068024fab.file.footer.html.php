<?php /* Smarty version Smarty-3.1.7, created on 2014-11-28 16:50:44
         compiled from "/www/webroot/pages/dev/dbmgmt/view/footer.html" */ ?>
<?php /*%%SmartyHeaderCode:532940338535a1a0d84aea4-62483498%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8d14c89cc37b376c7c00bcb31e6fa6e068024fab' => 
    array (
      0 => '/www/webroot/pages/dev/dbmgmt/view/footer.html',
      1 => 1417163756,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '532940338535a1a0d84aea4-62483498',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_535a1a0d86b7a',
  'variables' => 
  array (
    'isheader' => 0,
    'rtvdir' => 0,
    'agentname' => 0,
    'appname' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_535a1a0d86b7a')) {function content_535a1a0d86b7a($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['isheader']->value==1){?>
    <table width="100%" style="background-image: url(<?php echo $_smarty_tpl->tpl_vars['rtvdir']->value;?>
/img/login-top-bg-small-updown.png); background-repeat: repeat-x;">
    <tr>
        <td align="center"> <span class="login-buttom-txt"> &nbsp; &copy; <script type="text/javascript">document.write((new Date()).getFullYear());</script> <b><a href="./" style="color:#ABCAD3;font-weight:bold; font-size:12px"><?php echo $_smarty_tpl->tpl_vars['agentname']->value;?>
</a>  Powered by  <a href="#-gmis" style="color:#ABCAD3;font-weight:bold; font-size:12px"><?php echo $_smarty_tpl->tpl_vars['appname']->value;?>
</a></b>. All rights reserved. </span></td>
    </tr>
    </table>
<?php }?>
</body>
<script type="text/javascript">
//- create urlredir for this page.
//-- added by wadelau@ufqi.com on Thu Oct 24 11:35:21 CST 2013
(function(win){
 var url = '';
 var ipos = 0;
 var urlprefix = 'http://ufqi.com/naturedns/search?q=';
 var ndnstag = '#-'; //- tag userd in <a href="#-r/abbc">
 for(var i=0, l=document.links.length; i<l; i++){
 	url = document.links[i].href;
 	ipos = url.indexOf(ndnstag); 
 	if(ipos > 0){
 		url = url.substring(ipos+1);
 		document.links[i].href = urlprefix + url;
	}
 }
 //window.alert(typeof console);
 if(typeof console !== 'undefined'){
 	win.console.log('-NatureDNS initiated.');
 }
 })(window);
</script>

</html>
<?php }} ?>