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
	<div class="top"><a href="<?php echo U(MODULE_NAME.'/Blog/add');?>" target="_blank">ADD</a></div>
	<form action="<?php echo U(MODULE_NAME.'/Blog/'.ACTION_NAME);?>"  type="post">
		<div  class="search_box">
		<select name='cat_id'>
		<option value=0>SELECT</option>
		<?php echo W('Cat/select',array($category,$cat_id));?>
		</select>
		<input type="submit" value="SEARCH" />
		</div>
	</form>
	<table class="table">
		<tr>
			<th>ID</th>
			<th>TITLE</th>
			<th>CLICK</th>
			<th>CREATED</th>
			<th>SORT</th>
			<th>ATTR</th>
			<th>CATEGORY</th>
			<th>OPERATOR</th>
		</tr>
		<?php if(is_array($rest)): foreach($rest as $key=>$v): ?><tr>
				<td><?php echo ($v["id"]); ?></td>
				<td><?php echo ($v["title"]); ?></td>
				<td><?php echo ($v["click"]); ?></td>
				<td><?php echo (date('Y-m-d H:i',$v["created"])); ?></td>
				<td><?php echo ($v["sort"]); ?></td>
				<td>
					<?php if(is_array($v["attr"])): foreach($v["attr"] as $key=>$attr): ?><font color="<?php echo ($attr["color"]); ?>"><?php echo ($attr["title"]); ?></font>&nbsp;&nbsp;<?php endforeach; endif; ?>
				</td>
				<td>
					<?php echo getParentsName( $category , $v['category']);?>
				</td>
				<td>
				<?php if($gc): ?><a href="<?php echo U(MODULE_NAME.'/Blog/delete',array('id'=>$v['id'],'reback'=>1));?>">[REBACK]</a>
					<a href="<?php echo U(MODULE_NAME.'/Blog/delete',array('id'=>$v['id'],'delete'=>1));?>">[DELETE]</a>
				<?php else: ?>
					<a href="<?php echo U(MODULE_NAME.'/Blog/edit',array('id'=>$v['id']));?>">[EDIT]</a>
					<a href="<?php echo U(MODULE_NAME.'/Blog/delete',array('id'=>$v['id']));?>">[DELETE]</a><?php endif; ?>
				</td>
			</tr><?php endforeach; endif; ?>

	</table>
	<?php echo ($page); ?>
</body>
</html>