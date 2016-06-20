<?php /* Smarty version Smarty-3.1.6, created on 2016-06-18 21:50:46
         compiled from "./APP/Home/View/page_blog.html" */ ?>
<?php /*%%SmartyHeaderCode:357667081576551b6843449-43050366%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '03d235a5823f41d7267e2fd33d476cfdd8441a0e' => 
    array (
      0 => './APP/Home/View/page_blog.html',
      1 => 1466257229,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '357667081576551b6843449-43050366',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'rest' => 0,
    'v' => 0,
    'show' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_576551b69555e',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_576551b69555e')) {function content_576551b69555e($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include '/home/pzr/workspace/blog/ThinkPHP/Library/Vendor/Smarty/plugins/modifier.truncate.php';
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
                       <?php echo smarty_modifier_truncate(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['v']->value['content']),80,'...',true);?>

                    </p>
                    <p class="blog-post-date"><i class="fa fa-calendar"></i><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['created'],"
%m/%d/%G %T");?>
</p>
                    <p class="blog-post-more"><a href="#">Read More<i class="fa fa-angle-right"></i></a></p>
                </div>
                <div class="decoration"></div>
            <?php } ?>
            </div>
<?php echo $_smarty_tpl->tpl_vars['show']->value;?>

            <div class="blog-sidebar">
                <div class="decoration hide-if-responsive"></div>
                <div class="widget container">
                    <h4>Looking for something?</h4>
                    <p>
                        An input field you can connect to your needs and use as a search field.
                    </p>
                    <input class="blog-search" type="text" value="Search here...">
                </div>
                <div class="decoration"></div>
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
                <div class="widget container">
                    <h4>Categories</h4>
                    <p>
                        Your categories styled up to look nice and clean!
                    </p>
                    <div class="one-half">
                        <ul class="blog-category">
                            <li><a href="#"><i class="fa fa-angle-right"></i>Category 1</a></li>
                            <li><a href="#"><i class="fa fa-angle-right"></i>Category 2</a></li>
                            <li><a href="#"><i class="fa fa-angle-right"></i>Category 3</a></li>
                            <li><a href="#"><i class="fa fa-angle-right"></i>Category 4</a></li>
                        </ul>
                    </div>
                    <div class="one-half last-column">
                        <ul class="blog-category">
                            <li><a href="#"><i class="fa fa-angle-right"></i>Category 1</a></li>
                            <li><a href="#"><i class="fa fa-angle-right"></i>Category 2</a></li>
                            <li><a href="#"><i class="fa fa-angle-right"></i>Category 3</a></li>
                            <li><a href="#"><i class="fa fa-angle-right"></i>Category 4</a></li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="decoration"></div>

        </div>
        <!-- Page Footer-->
        <div class="footer">
            <p class="center-text">Copyright 2015. All rights reserved.</p>
            <div class="footer-socials half-bottom">
                <a href="#" class="footer-facebook"><i class="fa fa-facebook"></i></a>
                <a href="#" class="footer-twitter"><i class="fa fa-twitter"></i></a>
                <a href="#" class="footer-transparent"></a>
                <a href="#" class="footer-share show-share-bottom"><i class="fa fa-share-alt"></i></a>
                <a href="#" class="footer-up"><i class="fa fa-angle-up"></i></a>
            </div>
        </div>

    </div>

    <div class="share-bottom">
        <h3>Share Page</h3>
        <div class="share-socials-bottom">
            <a href="">
                <i class="fa fa-facebook facebook-color"></i>
                Facebook
            </a>
            <a href="">
                <i class="fa fa-twitter twitter-color"></i>
                Twitter
            </a>
            <a href="">
                <i class="fa fa-google-plus google-color"></i>
                Google
            </a>

            <a href="">
                <i class="fa fa-pinterest-p pinterest-color"></i>
                Pinterest
            </a>
            <a href="sms:">
                <i class="fa fa-comment-o sms-color"></i>
                Text
            </a>
            <a href="">
                <i class="fa fa-envelope-o mail-color"></i>
                Email
            </a>
        </div>
        <a href="#" class="close-share-bottom">Close</a>
    </div>

</div>

</body>

<?php }} ?>