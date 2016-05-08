<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//Ddiv XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/Ddiv/xhtml1-transitional.ddiv">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>[title]</title>
		<link rel="stylesheet" href="/Public/Common/css/index.css" />
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
		<script type="text/javascript" src="/Public/<?php echo ($module_name); ?>/Js/jquery-1.7.2.min.js"></script>
		<?php echo baiduAccount();?>
<script type="text/javascript" charset="utf-8" src="/Public/<?php echo ($module_name); ?>/Js/Editor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/<?php echo ($module_name); ?>/Js/Editor/ueditor.all.min.js"> </script>
</head>
<body>
	<form action="<?php echo U(MODULE_NAME.'/Blog/edit');?>" method="post" >

		<select name="cat_id">
		<?php echo W('Cat/select',array($category,$rest['cat_id']));?>
		</select>

		<table class="table"> 
			<tr>
				<td>TITLE</td>
				<td><input  name="title" value="<?php echo ($rest["title"]); ?>"  /></td>
			</tr>
			<tr>
				<td>CLICK</td>
				<td><input  name="click"  value="<?php echo ($rest["click"]); ?>" /></td>
			</tr>
			<tr>
				<td>SORT</td>
				<td><input  name="sort"  value="<?php echo ($rest["sort"]); ?>" /></td>
			</tr>
			<tr>
				<td>ATTR</td>
				<td>
					<?php echo W('Attr/blog_check',array($attr,$rest['attr']));?>
				</td>
			</tr>
			<tr>
				<td colspan="2">CONTENT</td>
			</tr>
			<tr>
				<td colspan="2">
					<div>
						<!-- 加载编辑器的容器 -->
						<script id="container" name="content" type="text/plain"><?php echo ($rest["content"]); ?></script>
					</div>
				</td>
			</tr>
		</table>
		<input type="hidden" name="id" value="<?php echo ($rest["id"]); ?>" />
		<input  type="submit" value="SUBMIT" />
	</form>
</body>
<!-- 实例化编辑器 -->
<script type="text/javascript">
	var ue = UE.getEditor('container',{
		enableAutoSave: false	,
		imageUrlPrefix: 'http://blog.test.com:8894/',
		imagePathFormat: 'Blog/upload/{filename}'
	});
	// ue.enableAutoSave = false;
</script>
</html>