<?php /* Smarty version Smarty-3.1.6, created on 2016-06-19 14:32:34
         compiled from "./APP/Home/View/Common/search.html" */ ?>
<?php /*%%SmartyHeaderCode:200556127057662f2616e3b6-19924299%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ee06844aa191c73cbd040c7d709405f35256167c' => 
    array (
      0 => './APP/Home/View/Common/search.html',
      1 => 1466317950,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '200556127057662f2616e3b6-19924299',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_57662f26183d3',
  'variables' => 
  array (
    'search_key' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57662f26183d3')) {function content_57662f26183d3($_smarty_tpl) {?>            <div class="blog-sidebar">
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