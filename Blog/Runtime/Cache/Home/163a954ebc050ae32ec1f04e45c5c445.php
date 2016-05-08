<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//Ddiv XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/Ddiv/xhtml1-transitional.ddiv">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>[title]</title>
		<link rel="stylesheet" href="/Public/Common/css/index.css" />
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
		<script type="text/javascript" src="/Public/<?php echo ($module_name); ?>/Js/jquery-1.7.2.min.js"></script>
		<?php echo baiduAccount();?>
</head>
<body>
	<div class="top"><a href="<?php echo U(MODULE_NAME.'/Attr/add');?>" >ADD</a></div>
	<table class="table">
		<tr>
			<th>ID</th>
			<th>TITLE</th>
			<th>SORT</th>
			<th>OPERATOR</th>
		</tr>
		<?php if(is_array($rest)): foreach($rest as $key=>$v): ?><tr>
				<td><?php echo ($v["id"]); ?></td>
				<td><font color="<?php echo ($v["color"]); ?>"><?php echo ($v["title"]); ?></font></td>
				<td><?php echo ($v["sort"]); ?></td>
				<td>
					<a href="<?php echo U(MODULE_NAME.'/Attr/edit',array('id'=>$v['id']));?>">EDIT</a>|
					<a href="<?php echo U(MODULE_NAME.'/Attr/delete',array('id'=>$v['id']));?>">DELETE</a>
				</td>
			</tr><?php endforeach; endif; ?>

	</table>
</body>
</html>