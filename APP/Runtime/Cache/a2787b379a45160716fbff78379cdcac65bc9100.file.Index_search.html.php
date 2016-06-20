<?php /* Smarty version Smarty-3.1.6, created on 2016-06-19 15:10:58
         compiled from "./APP/Home/View/Index_search.html" */ ?>
<?php /*%%SmartyHeaderCode:896224942576638e02cea43-77927382%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a2787b379a45160716fbff78379cdcac65bc9100' => 
    array (
      0 => './APP/Home/View/Index_search.html',
      1 => 1466320251,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '896224942576638e02cea43-77927382',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_576638e037bcc',
  'variables' => 
  array (
    'rest' => 0,
    'v' => 0,
    'k' => 0,
    'content' => 0,
    'show' => 0,
    'cate' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_576638e037bcc')) {function content_576638e037bcc($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include '/home/pzr/workspace/blog/ThinkPHP/Library/Vendor/Smarty/plugins/modifier.truncate.php';
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
                    <?php  $_smarty_tpl->tpl_vars['content'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['content']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['v']->value['highlight']['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['content']->key => $_smarty_tpl->tpl_vars['content']->value){
$_smarty_tpl->tpl_vars['content']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['content']->key;
?>
                        <?php if ($_smarty_tpl->tpl_vars['k']->value==2){?><?php break 1?><?php }?>
                       <?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['content']->value,100,'...',true);?>
<br>
                    <?php } ?>
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



<script type="text/javascript">
    $(function(){
        $('input[name=search_key]').blur(function(){
            $.ajax({
                url:"/search",
                type:"post",
                data:{
                    "search_key":$(this).val()
                },
                dataType:"json",
                success:function(data){
                    // alert(1);
                    console.log(data.data);
                }
            })
        });
    })

</script>
</body>

<?php }} ?>