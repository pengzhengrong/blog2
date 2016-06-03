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
			url: add_url,
			type: 'POST',
			data: {
				'blog_id': blog_id,
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
	$('.logo-left').click(function(){
		$('.left-container').toggle();
		var display = $('.left-container').css('display');
		// console.log( display );
		if( display == 'none' ){
			$('.logo-left').css('margin-left','95%');
		}else{
			$('.logo-left').css('margin-left','65%');
		}

	})

	$('.attr_title').click(function(event){
		// console.log(event);
		var _this = event.currentTarget;
		var id = $(_this).attr('id');
		var blog_id = id.split('_')[0];
		var attr_id = id.split('_')[1];
		// alert(blog_id);
		$.ajax({
			url: attr_url,
			type: 'POST',
			data: {
				'blog_id': blog_id,
				'attr_id': attr_id
			},
			dataType: 'text',
			success: function(data){
				// console.log(data);
				var obj = eval("("+data+")");
				if( obj.status == 200 ){
					if( obj.data == 1 ){
						alert(obj.msg);
						window.location.reload();
					}else
					alert(obj.msg);
				}else{
					alert(obj.msg);
				}
			}
		});
	})
});
