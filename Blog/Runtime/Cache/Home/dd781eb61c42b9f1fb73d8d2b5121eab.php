<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" href="/Public/<?php echo ($module_name); ?>/Css/public.css" />
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<script type="text/javascript" src="/Public/<?php echo ($module_name); ?>/Js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="/Public/<?php echo ($module_name); ?>/Js/login.js"></script>
	<?php echo baiduAccount();?>
</head>
<body>
	<div class="top"><a href="<?php echo U(MODULE_NAME.'/User/add');?>" >ADD</a></div>
	<table class="table">
		<tr>
			<th>ID</th>
			<th>USERNAME</th>
			<th>LOGIN_IP</th>
			<th>LOGIN_TIME</th>
			<th>ROLE</th>
			<th>STATUS</th>
			<th>OPERATOR</th>
		</tr>
		<?php if(is_array($rest)): foreach($rest as $key=>$v): ?><tr>
				<td><?php echo ($v["id"]); ?></td>
				<td><?php echo ($v["username"]); ?></td>
				<td><?php echo ($v["login_ip"]); ?></td>
				<td><?php echo (date('Y-m-d H:i',$v["login_time"])); ?></td>
				<td>
					<?php if($v['username']==C('RBAC_SUPERADMIN')): ?>SUPERADMIN<?php endif; ?>
					<?php if(is_array($v["role"])): foreach($v["role"] as $key=>$vv): echo ($vv["name"]); ?>(<?php echo ($vv["remark"]); ?>)<br /><?php endforeach; endif; ?>
				</td>
				<td>
					<?php if($v['lock']==1): ?>LOCK<?php endif; ?>
					<?php if($v['lock']==0): ?>UNLOCK<?php endif; ?>
				</td>
				<td>
					<a href="<?php echo U(MODULE_NAME.'/User/user_role',array('uid'=>$v['id']));?>">ROLE</a>
					<a href="<?php echo U(MODULE_NAME.'/User/edit',array('uid'=>$v['id']));?>">EDIT</a>
					<a href="<?php echo U(MODULE_NAME.'/User/delete',array('uid'=>$v['id']));?>">DELETE</a>
				</td>
			</tr><?php endforeach; endif; ?>

	</table>
</body>
</html>