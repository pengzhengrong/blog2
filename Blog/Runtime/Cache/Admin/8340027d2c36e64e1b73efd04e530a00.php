<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script type="text/javascript" src="/Public/<?php echo ($module_name); ?>/Js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/Public/<?php echo ($module_name); ?>/Js/index.js"></script>
<link rel="stylesheet" href="/Public/<?php echo ($module_name); ?>/Css/public.css" />
<link rel="stylesheet" href="/Public/<?php echo ($module_name); ?>/Css/index.css" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<base target="iframe"/>
<head>
<?php echo baiduAccount();?>
</head>
<body>
	<div id="top">
		<div class="menu">
			<?php if(is_array($rest)): foreach($rest as $key=>$v): ?><a target="_self"  href="<?php echo C('URL_ROUTER_ON')?'blog_'.$v['id']:U(MODULE_NAME.'/Index/index',array('id'=>$v['id']));?>" ><?php echo ($v["title"]); ?></a><?php endforeach; endif; ?>
		</div>
		<div class="exit">
			<?php echo session('username')==null ?'<a href="/blogin"  target="_self">登入</a>' :'<a href="/blogout"  target="_self" >退出</a>';?>
			
			<a href="#" target="_blank">获得帮助</a>
			<a href="#" target="_blank">my blog</a>
		</div>
	</div>
	<div id="left">
		<?php echo W('Cat/unlimitLayer',array($cate));?>
	</div>
	<div id="right">
		<iframe name="iframe" src="<?php echo U(MODULE_NAME.'/Index/content',array('id'=>$id));?>"></iframe>
	</div>
</body>
<script type="text/javascript">
	$(function(){
		
		$('#left').on( 'click' , '.showDl' , showDl );
		function showDl(event){
			$(event.currentTarget).parent().find('dd').toggle();
		}
		$('#logout').click(function(){
			$.ajax({
				url: '<?php echo U(MODULE_NAME.'/Login/logout','','');?>',
				dataType: 'text',
				success: function(data){
					if(data){
						alert('LOGOUT SUCCESS');
						window.location.reload();
					}  
				}
			});
		})
	})
</script>
</html>