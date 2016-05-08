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
	<form action="<?php echo U(MODULE_NAME.'/Cat/add');?>" method="post" >
		<table class="table"> 
			<tr>
				<td>TITLE</td>
				<td><input  name="title"  /></td>
			</tr>
			<tr>
				<td>SORT</td>
				<td><input  name="sort"  /></td>
			</tr>
			<tr>
				<td>MULTI</td>
				<td>
				<select name="multi">
					<option value="0">文件格式</option>
					<option value="1">目录格式</option>
				</select>
				</td>
			</tr>
		</table>
		<input type='hidden'  value="<?php echo ($pid); ?>" name="pid"  />
		<input type='hidden'  value="<?php echo ($level); ?>" name="level"  />
		<input  type="submit" value="SUBMIT" />
	</form>
</body>
</html>