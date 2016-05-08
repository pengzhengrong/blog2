<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<title>COMMENT</title>
	<script type="text/javascript" src="/Public/<?php echo ($module_name); ?>/Js/jquery-1.7.2.min.js"></script>
	<link href="/Public/Common/css/common.css" rel="stylesheet" type="text/css">	
</head>
<style type="text/css">
	.fa {
	    /*border: 1px solid #ccc;*/
	    /*padding-top: 7px;
	    padding-bottom: 5px;
	    text-align: center;
	    width: 100px;
	    height: 20px;
	    transition: background-color 0.3s;*/
	    cursor: pointer;
	}
	.comment-name{
		/*float: left; */
		margin-left: 10px;
	}

	.comment-date{
		font-size: 10px;
		padding-left: :10px;
	}
	.show_comment{
		/*float: right;*/
		padding-left: 100px;
		padding-bottom: 20px;
		cursor: hand;
	}
/*	.reply{
		padding-left : 250px;
	}*/

	.comment-content{
		/*display: none;*/
	}

	.fa {
	    display: inline-block;
	    font-family: FontAwesome;
	    font-style: normal;
	    font-weight: normal;
	    line-height: 1;
	    -webkit-font-smoothing: antialiased;
	}
</style>
<body>
<div>
<font color="<?php echo fontColor();?>">总共评论<?php echo count($comment);?></font>
<ul id="ul_id">
<?php echo W('Comment/unlimitComments',array($comment));?>
</ul>
</div>
</body>
<script type="text/javascript">

function showComment(id){
	// alert(id);
	$('.comment_'+id).toggle();
}

function vote_comment(id,type){
		// alert(id+' '+type);
		$.ajax({
			url: '<?php echo U(MODULE_NAME.'/Comment/vote','','');?>',
			type: 'POST',
			data:{
				'id': id,
				'type': type
			},
			dataType: 'text',
			success: function(data){
				if( data == '-1'){
					alert('u had voted!');
				}else if( data == '0'){
					alert('vote failed!');
				}else{
					alert('3q4u vote!');
					window.location.reload();
				}
			}
		});
	}

$( function(){

	$('#ul_id').on("click",".reply",handleFun);
	function handleFun(event){
		$('.comment-content').remove();
		var ev = event.target;
		var data_id = ev.id;
		var title = $('#'+data_id).attr('title');
		// alert(title);return;
		var content_text =  '<span  class="comment-content"><textarea id="content"  placeholder="回复'+title+':" name="content"></textarea>'+
		'<br><button class="btn" id="comment">回复</span>';
		$(ev).after( content_text);

		$('#comment').click( function(){
		var content = $('#content').val();
		// alert(data_id+'  '+content);
		$.ajax({
			url: '<?php echo U(MODULE_NAME.'/Comment/add','','');?>',
			type: 'POST',
			data: {
				'blog_id': <?php echo ($blog_id); ?>,
				'content': content,
				'pid': data_id
			},
			dataType: 'text',
			success: function(data){
				// alert(data);
				if( data != '0'){
					alert('发表评论成功!');
					window.location.reload();

				}else{
					// alert('发表评论失败!');
					alert('请先登入!');
				}
			}
		});
	});	
	}




	
	
});
</script>
</html>