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
			<a href="#">选择按钮</a>
			<a href="#">选择按钮</a>
			<a href="#">选择按钮</a>
			<a href="#">选择按钮</a>
		</div>
		<div class="exit">
			<a href="<?php echo C('URL_ROUTER_ON')?'/logout':U(MODULE_NAME.'/Login/logout');?>" target="_self">退出</a>
			<a href="http://bbs.houdunwang.com" target="_blank">获得帮助</a>
			<a href="http://www.houdunwang.com" target="_blank">后盾网</a>
		</div>
	</div>
	<div id="left">
		<?php if(is_array($rest)): foreach($rest as $key=>$v): ?><dl>
			<dt><?php echo ($v["$name"]); ?></dt>
			<?php if(is_array($v["child"])): foreach($v["child"] as $key=>$vv): ?><dd><a href="<?php echo U(MODULE_NAME.$vv['url']);?>"><?php echo ($vv["$name"]); ?></a></dd><?php endforeach; endif; ?>
		</dl><?php endforeach; endif; ?>
		<dl>
			<dt>导航管理</dt>
			<dd><a href="<?php echo U(MODULE_NAME.'/Nav/index');?>">导航菜单</a></dd>
		</dl>
	</div>
	<div id="right">
		<iframe  style="border: none;width: 100%;" name="iframe" src=""></iframe>
	</div>
</body>
</html>