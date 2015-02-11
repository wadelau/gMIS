<?php /* Smarty version Smarty-3.1.7, created on 2014-10-26 21:17:57
         compiled from "/vhost/7/0/9/net70934927/www/phase2/admin/view/footer.html" */ ?>
<?php /*%%SmartyHeaderCode:17414417345449a1a76c45b0-05181700%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ceab135cc661981e482c9e579e5291a2bc82be24' => 
    array (
      0 => '/vhost/7/0/9/net70934927/www/phase2/admin/view/footer.html',
      1 => 1414329648,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17414417345449a1a76c45b0-05181700',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5449a1a7717f2',
  'variables' => 
  array (
    'isheader' => 0,
    'rtvdir' => 0,
    'agentname' => 0,
    'appname' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5449a1a7717f2')) {function content_5449a1a7717f2($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['isheader']->value==1){?>
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