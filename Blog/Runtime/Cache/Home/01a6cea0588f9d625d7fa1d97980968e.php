<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//Ddiv XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/Ddiv/xhtml1-transitional.ddiv">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>[title]</title>
		<link rel="stylesheet" href="/Public/<?php echo ($module_name); ?>/Css/public.css" />
		<link rel="stylesheet" href="/Public/<?php echo ($module_name); ?>/Css/index.css" />
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
		<script type="text/javascript" src="/Public/<?php echo ($module_name); ?>/Js/jquery-1.7.2.min.js"></script>
		<?php echo baiduAccount();?>
		<script type="text/javascript">
			 $( function(){
			 	$("input[level=1]").click( function(){
			 		var inputs = $(this).parents(".modules").find("input");
			 		$(this).attr("checked") ? inputs.attr('checked','checked') : inputs.removeAttr('checked');
			 	} );

			 	$("input[level=2]").click( function(){
			 		var inputs = $(this).parents(".action").find("input");
			 		$(this).attr("checked") ? inputs.attr('checked','checked') : inputs.removeAttr('checked');
			 	} );

			 	$("input[level=1]").click( function(){
			 		var inputs = $(this).parents(".method").find("input");
			 		$(this).attr("checked") ? inputs.attr('checked','checked') : inputs.removeAttr('checked');
			 	} );
			 });
		</script>
	</head>
	<body>
	<form action="<?php echo U(MODULE_NAME.'/Rbac/access_add','','');?>">
		<div  class="wrap">
			<?php if(is_array($rest)): foreach($rest as $key=>$v): ?><div class="modules">
					<p>
						<input type="checkbox"   name="node_id[]" value="<?php echo ($v["id"]); ?>_1"  level="1"
						 <?php if($v["access"]): ?>checked="checked"<?php endif; ?>  />
						<strong style="font-size: 20px; color: #333"><?php echo ($v["name"]); ?>(<?php echo ($v["remark"]); ?>) </strong>
					</p>
				<?php if(is_array($v["child"])): foreach($v["child"] as $key=>$action): ?><div class="action">
						<dl>
						<dt>
							<input type="checkbox"  name="node_id[]" value="<?php echo ($action["id"]); ?>_2" level="2"
							<?php if($action["access"]): ?>checked="checked"<?php endif; ?> />
							<strong style="font-size: 16px; color: #888"><?php echo ($action["name"]); ?>(<?php echo ($action["remark"]); ?>) </strong>
						</dt>
					<?php if(is_array($action["child"])): foreach($action["child"] as $key=>$method): ?><div class="method">
						<dd>
							<input type="checkbox"  name="node_id[]" value="<?php echo ($method["id"]); ?>_3" level="3" 
							<?php if($method["access"]): ?>checked="checked"<?php endif; ?> />
							<?php echo ($method["name"]); ?>(<?php echo ($method["remark"]); ?>)
						</dd>
						</div><?php endforeach; endif; ?>
					</dl>
					</div><?php endforeach; endif; ?>
				</div><?php endforeach; endif; ?>

		</div>
		<input type="hidden" value="<?php echo ($role_id); ?>" name="role_id" />
		<input  type="submit" value="SUBMIT"   />
	</form>
	</body>
</html>