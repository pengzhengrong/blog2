<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//Ddiv XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/Ddiv/xhtml1-transitional.ddiv">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>[title]</title>
		<link rel="stylesheet" href="/Public/<?php echo ($module_name); ?>/Css/public.css" />
		<link rel="stylesheet" href="/Public/<?php echo ($module_name); ?>/Css/index.css" />
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
		<script type="text/javascript" src="/Public/<?php echo ($module_name); ?>/Js/jquery-1.7.2.min.js"></script>
		<?php echo baiduAccount();?>
	</head>
	<body>
		<div class="top"><a href="<?php echo U(MODULE_NAME.'/Rbac/role_add','','');?>" >PUBLISH</a></div>		<div>
			<?php if(is_array($rest)): foreach($rest as $key=>$v): ?><div class="modules">
					<p>
						<strong style="font-size: 20px; color: #333"><?php echo ($v["name"]); ?>(<?php echo ($v["remark"]); ?>) </strong>
						<a href="<?php echo U(MODULE_NAME.'/Rbac/role_add',array('pid'=>$v['id']) ,'');?>">[ADD]</a>
						<a href="<?php echo U(MODULE_NAME.'/Rbac/role_edit',array('id'=>$v['id']) ,'');?>">[EDIT]</a>
					</p>
				<?php if(is_array($v["child"])): foreach($v["child"] as $key=>$action): ?><div class="action">
						<p><?php echo ($action["name"]); ?>(<?php echo ($action["remark"]); ?>)
						<a href="<?php echo U(MODULE_NAME.'/Rbac/role_add',array('pid'=>$action['id']) ,'');?>">[ADD]</a>|
						<a href="<?php echo U(MODULE_NAME.'/Rbac/role_delete','id='.$action['id'] ,'' );?>">[DELETE]</a></p>
					<?php if(is_array($action["child"])): foreach($action["child"] as $key=>$method): ?><div class="method">
							<?php echo ($method["name"]); ?>(<?php echo ($method["remark"]); ?>)
							<a href="<?php echo U(MODULE_NAME.'/Rbac/role_delete','id='.$method['id'] ,'' );?>">[DELETE]</a>
						</div><?php endforeach; endif; ?>
					</div><?php endforeach; endif; ?>
				</div><?php endforeach; endif; ?>

		</div>
	</body>
</html>