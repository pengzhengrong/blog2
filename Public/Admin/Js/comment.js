//comment.html
function showComment(id){
	// alert(id);
	$('.comment_'+id).toggle();
}

function vote_comment(id,type){
	$.ajax({
		url: url_obj['vote_url'],
		type: 'POST',
		data:{
			'id': id,
			'type': type
		},
		dataType: 'text',
		success: function(data){
			if( data == '-1'){
				alert('3q4u had voted!');
			}else if( data == '0'){
				alert('sorry,vote failed!');
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
			url: url_obj['add_url'],
			type: 'POST',
			data: {
				'blog_id': blog_id,
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