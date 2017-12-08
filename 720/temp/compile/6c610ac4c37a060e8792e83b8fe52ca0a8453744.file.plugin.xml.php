<?php /* Smarty version Smarty-3.1.7, created on 2017-11-11 00:21:26
         compiled from "plugin.xml" */ ?>
<?php /*%%SmartyHeaderCode:92095a05d2065e8ca4-63421107%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6c610ac4c37a060e8792e83b8fe52ca0a8453744' => 
    array (
      0 => 'plugin.xml',
      1 => 1478570734,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '92095a05d2065e8ca4-63421107',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'arr' => 0,
    'v' => 0,
    'k' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a05d206640ef',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a05d206640ef')) {function content_5a05d206640ef($_smarty_tpl) {?> <contextmenu fullscreen="false" versioninfo="false">
 		<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['arr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
        	<item name="name_<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" caption="<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
" onclick="openurl('<?php echo $_smarty_tpl->tpl_vars['v']->value['content'];?>
')" <?php if ($_smarty_tpl->tpl_vars['k']->value==0){?>separator="true"<?php }?>  devices="flash|webgl"/>
        <?php } ?>
</contextmenu><?php }} ?>