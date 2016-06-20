<?php /* Smarty version Smarty-3.1.6, created on 2016-06-20 18:53:08
         compiled from "./APP/Home/View/Index_blog.html" */ ?>
<?php /*%%SmartyHeaderCode:20344469725767518fefb7c0-78016136%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6c2ef20cf40fedd494e120072fd733f759d3f689' => 
    array (
      0 => './APP/Home/View/Index_blog.html',
      1 => 1466419983,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20344469725767518fefb7c0-78016136',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5767519007d51',
  'variables' => 
  array (
    'rest' => 0,
    'prev' => 0,
    'next' => 0,
    'cate' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5767519007d51')) {function content_5767519007d51($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/home/pzr/workspace/blog/ThinkPHP/Library/Vendor/Smarty/plugins/modifier.date_format.php';
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
                <div class="blog-post">
                    <!-- <a class="blog-post-image" href="#"><img src="<?php echo @__PUBLIC__;?>
/images/pictures/3ww.jpg" alt="img"></a> -->
                    <h3 class="blog-post-title"><?php echo $_smarty_tpl->tpl_vars['rest']->value['title'];?>
</h3>
                    <p class="blog-post-text">
                       <?php echo $_smarty_tpl->tpl_vars['rest']->value['content'];?>

                    </p>
                    <p class="blog-post-date"><i class="fa fa-calendar"></i><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['rest']->value['created'],"
%m/%d/%G %T");?>
</p>
                    <p class="blog-post-more">
                        <a href="<?php if ($_smarty_tpl->tpl_vars['prev']->value['id']>0){?>/blog_<?php echo $_smarty_tpl->tpl_vars['prev']->value['id'];?>
<?php }?>" style="padding-right: 20px;">Prev:<?php echo $_smarty_tpl->tpl_vars['prev']->value['title'];?>
<i class="fa fa-angle-right"></i></a>
                        <a href="<?php if ($_smarty_tpl->tpl_vars['next']->value['id']>0){?>/blog_<?php echo $_smarty_tpl->tpl_vars['next']->value['id'];?>
<?php }?>">Next:<?php echo $_smarty_tpl->tpl_vars['next']->value['title'];?>
<i class="fa fa-angle-right"></i></a>
                    </p>
                </div>
                <div class="decoration"></div>
            </div>

         <!-- search -->
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

        </div>
        <!-- Page Footer-->
       <?php echo $_smarty_tpl->getSubTemplate ("Common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


</body>

<?php }} ?>