<?php /* Smarty version Smarty-3.1.7, created on 2014-10-24 09:05:56
         compiled from "/vhost/7/0/9/net70934927/www/phase2/admin/view/index_main.html" */ ?>
<?php /*%%SmartyHeaderCode:19566138875449a5f4c3eae5-21426229%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '041404cbe2267f5a0b00b35f5a0a5b3fa7d93ad7' => 
    array (
      0 => '/vhost/7/0/9/net70934927/www/phase2/admin/view/index_main.html',
      1 => 1414109913,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19566138875449a5f4c3eae5-21426229',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'agentname' => 0,
    'welcomemsg' => 0,
    'content' => 0,
    'module_list_order' => 0,
    'mi' => 0,
    'ido' => 0,
    'k' => 0,
    'module_list_name' => 0,
    'module_list_byuser' => 0,
    'v' => 0,
    'system_lastmodify' => 0,
    'user_count' => 0,
    'module_count' => 0,
    'front_page' => 0,
    'todourl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5449a5f4ecd9a',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5449a5f4ecd9a')) {function content_5449a5f4ecd9a($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ('header.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

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
   <tr>
    <td valign="bottom">
    <table width="100%" border="0px" cellpadding="0" cellspacing="0" class="login_top_bg" style="background-image: url(./img/login-top-bg-small.png);background-repeat: repeat-x;">
      <tr>
        <td width="37%" height="28px">&nbsp;<a href="./"  style="color:#ABCAD3;font-weight:bold; font-size:12px"><?php echo $_smarty_tpl->tpl_vars['agentname']->value;?>
 </a> </td>
        <td width="63%" style="text-align:right;" class="login-buttom-txt"> <?php echo $_smarty_tpl->tpl_vars['welcomemsg']->value;?>
 </td>
      </tr>
    </table>
    </td>
  </tr>

  <tr>
    <td valign="top">

     <table width="100%" align="center" height="532" border="0px" cellpadding="0" cellspacing="0" class="login_bg">
      <tr>
        <td width="98%" align="center" >

            <?php echo $_smarty_tpl->tpl_vars['content']->value;?>

			
            <div id="welcomearea" style="float:left;margin-left:28px">
			<b> &Pi; <a href="./" style="font-size:17px" >首页</a> <span style="font-size:17px">&rarr;</span></b>
			欢迎您回来！ 今天是 <script type="text/javascript" src="./comm/show_today.js"></script>
            <br/> 

           <style type='text/css'>
		   .wrapper{
			      position: relative;
				     float: left;
					    left: 89px;
						   //width: 850px;
						      margin-bottom: 20px;
							     //background-color: #cccccc
		   }
		   .left1{
			      position: relative; word-break:break-all; word-wrap:break-word;
				     float: left; vertical-align:middle;padding:5px 5px 5px 5px;
					    left: 10px;
						   width: 150px;
						      height: 70px;
							     background-color: #cfcfcf
		   }
		   .left2{
			      position: relative; word-break:break-all; word-wrap:break-word;
				     float: left;vertical-align:middle;padding:5px 5px 5px 5px;
					    left: 30px;
						   width: 150px;
						      height: 70px;
							     background-color: #cfcfcf
		   }
		   .left3{
			      position: relative; word-break:break-all; word-wrap:break-word;
				     float: left;vertical-align:middle;padding:5px 5px 5px 5px;
					    left: 50px;
						   width: 150px;
						      height: 70px;
							     background-color: #cfcfcf
		   }
		   .left4{
			      position: relative; word-break:break-all; word-wrap:break-word;
				     float: left;vertical-align:middle;padding:5px 5px 5px 5px;
					    left: 70px;
						   width: 150px;
						      height: 70px;
							     background-color: #cfcfcf
		   }
		</style>
		<table align="center" width="700px"  style="background:transparent"><tr>
		<td>
		<b title="(根据被调用频率自动排列、调整)">MU.常用Most-Used</b><br/>
		<?php $_smarty_tpl->tpl_vars['mi'] = new Smarty_variable(0, null, 0);?>
		<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['module_list_order']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
			<?php if ($_smarty_tpl->tpl_vars['mi']->value==0||($_smarty_tpl->tpl_vars['mi']->value)%4==0){?>
			<div class="wrapper">
			<?php }?>
				 <a href="./<?php echo $_smarty_tpl->tpl_vars['ido']->value;?>
&tbl=<?php echo $_smarty_tpl->tpl_vars['module_list_order']->value[$_smarty_tpl->tpl_vars['k']->value];?>
"><div class="left<?php echo ($_smarty_tpl->tpl_vars['k']->value%4)+1;?>
"><?php echo $_smarty_tpl->tpl_vars['mi']->value+1;?>
.<?php echo $_smarty_tpl->tpl_vars['module_list_name']->value[$_smarty_tpl->tpl_vars['module_list_order']->value[$_smarty_tpl->tpl_vars['k']->value]];?>
(<?php echo $_smarty_tpl->tpl_vars['module_list_order']->value[$_smarty_tpl->tpl_vars['k']->value];?>
)</div></a>
			<?php if (($_smarty_tpl->tpl_vars['mi']->value+1)%4==0){?>
			</div>
			<?php }?>
			<?php $_smarty_tpl->tpl_vars['mi'] = new Smarty_variable($_smarty_tpl->tpl_vars['mi']->value+1, null, 0);?>
		<?php } ?>
		<!--
			<div class="wrapper">
				 <div class="left1"></div>
					<div class="left2"></div>
					<div class="left3"></div>
					<div class="left4"></div>
			</div>
			-->
		</td>
		</tr><tr>
		<td>
		<b title="（用户自定义的快捷列表，在“系统设置--单元模块”中选择某个模块，修改其中“添加到桌面”即可）">DT.桌面Desktop</b><br/>
		<?php $_smarty_tpl->tpl_vars['mi'] = new Smarty_variable(0, null, 0);?>
		<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['module_list_byuser']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
			<?php if ($_smarty_tpl->tpl_vars['mi']->value==0||($_smarty_tpl->tpl_vars['mi']->value)%4==0){?>
			<div class="wrapper">
			<?php }?>
				 <a href="./<?php echo $_smarty_tpl->tpl_vars['ido']->value;?>
&tbl=<?php echo $_smarty_tpl->tpl_vars['v']->value['tblname'];?>
"><div class="left<?php echo ($_smarty_tpl->tpl_vars['k']->value%4)+1;?>
"><?php echo $_smarty_tpl->tpl_vars['mi']->value+1;?>
.<?php echo $_smarty_tpl->tpl_vars['v']->value['objname'];?>
(<?php echo $_smarty_tpl->tpl_vars['v']->value['tblname'];?>
)</div></a>
			<?php if (($_smarty_tpl->tpl_vars['mi']->value+1)%4==0){?>
			</div>
			<?php }?>
			<?php $_smarty_tpl->tpl_vars['mi'] = new Smarty_variable($_smarty_tpl->tpl_vars['mi']->value+1, null, 0);?>
		<?php } ?>
		</td>
		</tr>
		<tr><td colspan="10">
		<script type="text/javascript"> 
		function diffInYearsAndDays(startDate, endDate) {
			// Copy and normalise dates
			var d0 = new Date(startDate);
			d0.setHours(12,0,0,0);
			var d1 = new Date(endDate);
			d1.setHours(12,0,0,0);
			// Make d0 earlier date
			// Can remember a sign here to make -ve if swapped
			if (d0 > d1) {
				var t = d0;
				d0 = d1;
				d1 = t;
			}  
			// Initial estimate of years
			var dY = d1.getFullYear() - d0.getFullYear();
			// Modify start date
			d0.setYear(d0.getFullYear() + dY);
			// Adjust if required
			if (d0 > d1) {
				d0.setYear(d0.getFullYear() - 1);
				--dY;
			}
			// Get remaining difference in days
			var dD = (d1 - d0) / 8.64e7;
			// If sign required, deal with it here
			return [dY, dD];  
		}
		</script>
		<b><i>ii</i></b>.系统已上线 <a href="./"><script type="text/javascript">diff=diffInYearsAndDays('<?php echo $_smarty_tpl->tpl_vars['system_lastmodify']->value;?>
',(new Date()));document.write(''+diff[0]+' 年 '+diff[1]+' 天');</script></a> , 目前共 <b><?php echo $_smarty_tpl->tpl_vars['user_count']->value;?>
</b> 位用户，管理着<b> <?php echo $_smarty_tpl->tpl_vars['module_count']->value;?>
  </b>个功能模块.  
		</td></tr>
		<tr><td><b><i>HM</i></b>.<a href="<?php echo $_smarty_tpl->tpl_vars['front_page']->value;?>
" target="_blank">打开主站</a></td></tr>
		</table>
			<!-- <script type="text/javascript"> window.setTimeout(location.href = '<?php echo $_smarty_tpl->tpl_vars['todourl']->value;?>
', 10*1000); </script> -->

		<br/>
            </div>
		<br/>

        </td>
      </tr>
     </table>

    </td>
  </tr>
 
</table>
<?php echo $_smarty_tpl->getSubTemplate ('footer.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>