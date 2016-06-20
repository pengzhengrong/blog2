<?php /* Smarty version Smarty-3.1.6, created on 2016-06-20 11:40:36
         compiled from "./APP/Home/View/Index_category.html" */ ?>
<?php /*%%SmartyHeaderCode:14350379675767598232c236-65123404%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5cf7537922e0bd3047f622fdf8e61b64b42adfd5' => 
    array (
      0 => './APP/Home/View/Index_category.html',
      1 => 1466393410,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14350379675767598232c236-65123404',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_576759823c7e3',
  'variables' => 
  array (
    'rest' => 0,
    'v' => 0,
    'show' => 0,
    'cate' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_576759823c7e3')) {function content_576759823c7e3($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include '/home/pzr/workspace/blog/ThinkPHP/Library/Vendor/Smarty/plugins/modifier.truncate.php';
if (!is_callable('smarty_modifier_date_format')) include '/home/pzr/workspace/blog/ThinkPHP/Library/Vendor/Smarty/plugins/modifier.date_format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("Common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('title'=>"blog"), 0);?>

</head>
<body>
<?php echo $_smarty_tpl->getSubTemplate ("Common/loader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="all-elements">
<?php echo $_smarty_tpl->getSubTemplate ("Common/left.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


    <div class="header">
        <a href="#" class="main-logo"></a>
        <a href="#" class="open-menu"><i class="fa fa-navicon"></i></a>
        <a href="#" class="open-call"><i class="fa fa-phone"></i></a>
        <a href="#" class="open-mail"><i class="fa fa-envelope-o"></i></a>
    </div>

    <a href="#" class="footer-ball"><i class="fa fa-navicon"></i></a>

    <!-- Page Content-->
    <div id="content" class="snap-content">
        <div class="header-clear"></div>
        <div class="content">

            <div class="blog-posts">
            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rest']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                <div class="blog-post">
                    <!-- <a class="blog-post-image" href="#"><img src="<?php echo @__PUBLIC__;?>
/images/pictures/3ww.jpg" alt="img"></a> -->
                    <h3 class="blog-post-title"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</h3>
                    <p class="blog-post-text">
                       <?php echo smarty_modifier_truncate(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['v']->value['content']),100,'...',true);?>

                    </p>
                    <p class="blog-post-date"><i class="fa fa-calendar"></i><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['created'],"
%m/%d/%G %T");?>
</p>
                    <p class="blog-post-more"><a href="/blog_<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">Read More<i class="fa fa-angle-right"></i></a></p>
                </div>
                <div class="decoration"></div>
            <?php } ?>
            <?php echo $_smarty_tpl->tpl_vars['show']->value;?>

            </div>

            
            <?php echo $_smarty_tpl->getSubTemplate ("Common/search.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

               <!--  <div class="widget container">
                    <h4>Recent Works</h4>
                    <p>
                        You can link this to be a gallery or link it to act like a normal anchor
                        to redirect your users to the specific post you want.
                    </p>
                    <ul class="gallery square-thumb blog-gallery">
                        <li><a href="#"><img src="<?php echo @__PUBLIC__;?>
/images/pictures/1s.jpg" alt="img"/></a></li>
                        <li><a href="#"><img src="<?php echo @__PUBLIC__;?>
/images/pictures/2s.jpg" alt="img"/></a></li>
                        <li><a href="#"><img src="<?php echo @__PUBLIC__;?>
/images/pictures/3s.jpg" alt="img"/></a></li>
                        <li><a href="#"><img src="<?php echo @__PUBLIC__;?>
/images/pictures/4s.jpg" alt="img"/></a></li>
                    </ul>
                </div> -->

               <!-- category -->
               <?php echo W('Cate/cate',array($_smarty_tpl->tpl_vars['cate']->value));?>

        <!-- Page Footer-->
    <?php echo $_smarty_tpl->getSubTemplate ("Common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</body>

<?php }} ?>