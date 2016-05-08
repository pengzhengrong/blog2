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
		<div class="top"><a href="<?php echo U(MODULE_NAME.'/Nav/add');?>" >ADD</a></div>
		<div  class="wrap">
			<?php if(is_array($rest)): foreach($rest as $key=>$v): ?><div class="modules">
					<p>
						<strong style="font-size: 20px; color: #333"><?php echo ($v["$name"]); ?> </strong>
						<a href="<?php echo U(MODULE_NAME.'/Nav/add',array('pid'=>$v['id'],'level'=>2) ,'');?>">ADD</a>|
						<a href="<?php echo U(MODULE_NAME.'/Nav/edit',array('id'=>$v['id']) ,'');?>">EDIT</a>|
						<a href="<?php echo U(MODULE_NAME.'/Nav/delete','id='.$v['id'] ,'' );?>">DELETE</a>
					</p>
				<?php if(is_array($v["child"])): foreach($v["child"] as $key=>$action): ?><div class="action">
						<?php echo ($action["$name"]); ?>
						<a href="<?php echo U(MODULE_NAME.'/Nav/edit',array('id'=>$action['id']) ,'');?>">EDIT</a>|
						<a href="<?php echo U(MODULE_NAME.'/Nav/delete','id='.$action['id'] ,'' );?>">DELETE</a>
						
					</div><?php endforeach; endif; ?>
				</div><?php endforeach; endif; ?>

		</div>
	</body>
</html>