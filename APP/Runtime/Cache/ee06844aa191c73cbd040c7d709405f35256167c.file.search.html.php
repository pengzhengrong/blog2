<?php /* Smarty version Smarty-3.1.6, created on 2016-06-20 10:05:54
         compiled from "./APP/Home/View/Common/search.html" */ ?>
<?php /*%%SmartyHeaderCode:74651451557674f821b7568-22262993%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ee06844aa191c73cbd040c7d709405f35256167c' => 
    array (
      0 => './APP/Home/View/Common/search.html',
      1 => 1466387132,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '74651451557674f821b7568-22262993',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'search_key' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_57674f821c24d',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57674f821c24d')) {function content_57674f821c24d($_smarty_tpl) {?>            <div class="blog-sidebar">
                <div class="decoration hide-if-responsive"></div>
                <div class="widget container">
                    <h4>Looking for something?</h4>
                   <!--  <p>
                        An input field you can connect to your needs and use as a search field.
                    </p> -->
                    <form method="post" action="/search">
                        <input class="blog-search" type="text" name="search_key" value="<?php echo $_smarty_tpl->tpl_vars['search_key']->value;?>
" placeholder="Search here...">
                    </form>
                </div>
                <div class="decoration"></div><?php }} ?>