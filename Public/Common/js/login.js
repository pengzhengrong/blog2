function change_code(){
	$("#code").attr('src',code_url);
	// return false;
}
//登录验证  1为空   2为错误
/*var validate={username:1,password:1,code:1}
$(function(){
	
	console.log( validate );
	$("#login").click(function(){
		//验证用户名
		console.log( $("input[name=username]").val() );
		$("input[name='username']").trigger("blur");
		//验证密码
		$("input[name='passwd']").trigger("blur");
		console.log( validate );
		if(validate.username==0 && validate.password==0 && validate.code==0){
			$('form').submit();
			return true;
		}
		
		//验证验证码
		$("input[name='code']").trigger("blur");

		return false;
		});
	})*/
$(function(){
	//验证用户名
	/*$("input[name='username']").blur(function(){
		console.log( 'username function' );
		var username = $("input[name='username']");
		if(username.val().trim()==''){
			username.parent().find("span").remove().end().append("<span class='error'>用户名不能为空</span>");
			return ;
		}
		$.post(CONTROL+"/checkusername",{username:username.val().trim()},function(stat){
			if(stat==1){
				validate.username=0;
				username.parent().find("span").remove();
			}else{
				username.parent().find("span").remove().end().append("<span class='error'>用户不存在</span>");
			}
		})
	})
	//验证密码
	$("input[name='passwd']").blur(function(){
		console.log( 'passwd function' );
		var password = $("input[name='passwd']");
		var username=$("input[name='username']");
		if(username.val().trim()==''){
			return;
		}
		if(password.val().trim()==''){
			password.parent().find("span").remove().end().append("<span class='error'>密码不能为空</span>");
			return ;
		}
		$.post(CONTROL+"/checkpassword",{password:password.val().trim(),username:username.val().trim()},function(stat){
			if(stat==1){
				validate.password=0;
				password.parent().find("span").remove();
			}else{
				password.parent().find("span").remove().end().append("<span class='error'>密码错误</span>");
			}
		})
	})*/
	//验证验证码
	$("input[name='code']").blur(function(){
		var code = $("input[name='code']");
		if(code.val().trim()==''){
			code.parent().find("span").remove().end().append("<span class='error'>验证码不能为空</span>");
			return ;
		}
		$.post(CONTROL+"/checkcode",{code:code.val().trim()},function(stat){
			if(stat==1){
				// validate.code=0;
				code.parent().find("span").remove();
			}else{
				console.log('error');
				code.parent().find("span").remove().end().append("<span class='error'>验证码错误</span>");
			}
		})
	})
})

