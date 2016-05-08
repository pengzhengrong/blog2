<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<head>
	
	<title>Products - Black White HTML5 Template</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link href="/Public/<?php echo ($module_name); ?>/Css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/Public/<?php echo ($module_name); ?>/Css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="/Public/<?php echo ($module_name); ?>/Css/templatemo_style.css" rel="stylesheet" type="text/css">
	<link href="/Public/Common/css/common.css" rel="stylesheet" type="text/css">	
	<script type="text/javascript" src="/Public/<?php echo ($module_name); ?>/Js/jquery-1.7.2.min.js"></script>
</head>
<body>
	
	<div class="templatemo-container">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 white-bg right-container">
			<h1 class="logo-left hidden-xs margin-bottom-60">Content</h1>
			<div class="tm-right-inner-container">
			<?php if($blog): ?><h1 class="templatemo-header"><?php echo ($blog["title"]); ?></h1>
				<div>
					<span>点击量: <strong><?php echo ($blog["click"]); ?></strong></span>
					<span>上次更新时间<?php echo (date('Y-m-d H:m',$blog["update_time"])); ?></span>
					<span>创建时间<?php echo (date('Y-m-d H:m',$blog["created"])); ?></span>
					<br />
					<div style="float:right;padding-right: 30px;">
						<?php if(is_array($blog["attr"])): foreach($blog["attr"] as $key=>$v): ?><span ><font color="<?php echo ($v["color"]); ?>"><?php echo ($v["title"]); ?></font></span>&nbsp;&nbsp;<?php endforeach; endif; ?>
					</div>
				</div>		
				<article class="templatemo-item" id="article">
					<?php echo ($blog["content"]); ?>	
				</article>	
			<?php else: ?>
				<h1 class="templatemo-header">博主还未添加任何相关的内容</h1>
				<article class="templatemo-item">
					博主还未添加任何相关的内容,有意请邮件  <font color="red"><?php echo C('EMAIL');?></font>
				</article><?php endif; ?>
				
				<hr>
				<footer>
					<p class="col-lg-6 col-md-6 col-sm-12 col-xs-12 templatemo-copyright">Copyright &copy; 2084  Welcome to hello2world.top</p>
					<p class="col-lg-6 col-md-6 col-sm-12 col-xs-12 templatemo-social">
						<a href="#"><i class="fa fa-facebook fa-medium"></i></a>
						<a href="#"><i class="fa fa-twitter fa-medium"></i></a>
						<a href="#"><i class="fa fa-google-plus fa-medium"></i></a>
						<a href="#"><i class="fa fa-youtube fa-medium"></i></a>
						<a href="#"><i class="fa fa-linkedin fa-medium"></i></a>
					</p>
				</footer>
			</div>		
			
		</div> <!-- left section -->
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 black-bg left-container">
			<h1 class="logo-right hidden-xs margin-bottom-60">Comment</h1>	
			<div class="tm-left-inner-container">
				<ul class="nav nav-stacked templatemo-nav">
				 <input class="btn btn-warning" type="button" value="抢沙发" id="comment" />
				 <hr>
				 <font color="<?php echo fontColor();?>"><textarea id="comment_content"></textarea></font>
				</ul>
				<div style="width: 300px;height: 500px" >
					<iframe  width="400px;" height="400px"  name="comment" src="<?php echo U(MODULE_NAME.'/Comment/index',array('blog_id'=>$blog['id']));?>"></iframe>
				</div>
			</div>
		</div> <!-- right section -->
	</div>	
</body>
<script type="text/javascript">
$( function(){
	$('pre').hide();
	$('pre').before('<i class="iconfont showPre">&#xe605;</i>');
	$('#article').on( 'click' , '.showPre' ,callback );
	$('#article').on( 'click' , '.closePre' ,callback );
	function callback(event){
		// console.log( event );
		$(event.currentTarget).next().toggle();
		if( $(event.currentTarget).attr('class') == 'iconfont showPre' ){
			$(event.currentTarget).html( '&#xe604;' );
			$(event.currentTarget).attr('class','iconfont closePre');
		}else{
			$(event.currentTarget).html( '&#xe605;' );
			$(event.currentTarget).attr('class','iconfont showPre');
		}
	}
	$('#comment').click( function(){
		var content = $('#comment_content').val();
		$.ajax({
			url: '<?php echo U(MODULE_NAME.'/Comment/add','','');?>',
			type: 'POST',
			data: {
				'blog_id': <?php echo ($blog["id"]); ?>,
				'content': content
			},
			dataType: 'text',
			success: function(data){
				if( data == '0' ){
					alert('请先登入!');	
				}else if( data == '-1'){
					alert('评论功能关闭!');
				}else{
					alert('发表评论成功!');
					window.location.reload();
				}
			}
		});
	});	
});
</script>
</html>