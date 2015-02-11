<?php /* Smarty version Smarty-3.1.7, created on 2014-12-19 09:38:40
         compiled from "/www/webroot/pages/dev/dbmgmt/view/ido_main.html" */ ?>
<?php /*%%SmartyHeaderCode:1219435354535a1a28683f83-06235699%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '03b458b4f7cfe87e351b451213359dfd7700b32d' => 
    array (
      0 => '/www/webroot/pages/dev/dbmgmt/view/ido_main.html',
      1 => 1418953044,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1219435354535a1a28683f83-06235699',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_535a1a286f8ec',
  'variables' => 
  array (
    'isheader' => 0,
    'agentname' => 0,
    'welcomemsg' => 0,
    'out_header' => 0,
    'content' => 0,
    'out_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_535a1a286f8ec')) {function content_535a1a286f8ec($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ('header.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<style type="text/css">
<!--
body {
	margin-left: 5px;
	margin-top: 5px;
	margin-right: 5px;
	margin-bottom: 0px;
	background-color: #1D3647;
}
-->
</style>
<table width="100%"  border="0px" cellpadding="0" cellspacing="0">
    <?php if ($_smarty_tpl->tpl_vars['isheader']->value==1){?>
       <tr>
        <td valign="top">
        <table width="100%" border="0px" cellpadding="0" cellspacing="0" class="login_top_bg" style="background-image: url(./img/login-top-bg-small.png);background-repeat: repeat-x;">
          <tr>
            <td width="33%" height="28px" style=""><a href="./" style="color:#ABCAD3;font-weight:bold; font-size:12px">&nbsp;<?php echo $_smarty_tpl->tpl_vars['agentname']->value;?>
 </a></td>
            <td width="5%"> <div id="top_notice_div" style="postion:absolute; width:400px; top:20px; left:20px; text-align:center;z-index:99"></div> </td>
            <td width="62%" style="text-align:right;" class="login-buttom-txt"> <?php echo $_smarty_tpl->tpl_vars['welcomemsg']->value;?>
 </td>
          </tr>
        </table>
        </td>
      </tr>
    <?php }?>
  <tr>
    <td valign="top">

     <table width="100%" height="98%" border="0px" cellpadding="0" cellspacing="0" class="login_bg">
      <tr>
        <td width="98%" height="<?php if ($_smarty_tpl->tpl_vars['isheader']->value==0){?>390px%<?php }else{ ?>699px<?php }?>" align="left">
		<?php echo $_smarty_tpl->tpl_vars['out_header']->value;?>

			
        <?php echo $_smarty_tpl->tpl_vars['content']->value;?>


		<?php echo $_smarty_tpl->tpl_vars['out_footer']->value;?>

        </td>
      </tr>
     </table>

    </td>
  </tr>
 
</table>
<?php echo $_smarty_tpl->getSubTemplate ('footer.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>