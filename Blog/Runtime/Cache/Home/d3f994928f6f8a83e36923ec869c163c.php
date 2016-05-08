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
  <form action="<?php echo U(MODULE_NAME.'/User/edit');?>"  method="post">
    <table class="table">
      <tr>
        <td>ID</td>
        <td> <input readonly="readonly"  value="<?php echo ($rest["id"]); ?>"  name="uid" /></td>
      </tr>
      <tr>
        <td>UNAME</td>
        <td><?php echo ($rest["username"]); ?></td>
      </tr>
      <tr>
        <td>PASSWD</td>
        <td><input type="password" value="<?php echo ($rest["passwd"]); ?>" name="passwd" /><span></span></td>
      </tr>
      <tr>
        <td>LOGIN_IP</td>
        <td><?php echo ($rest["login_ip"]); ?></td>
      </tr>
      <tr>
        <td>LOGIN_TIME</td>
        <td><?php echo (date('Y-m-d H:i',$rest["login_ip"])); ?></td>
      </tr>
      <tr>
        <td>LOCK</td>
        <td>
         <select name="lock">
          <option>SELECT</option>
          <option <?php if($rest['lock']==0): ?>selected='selected'<?php endif; ?>  value="0">UNLOCK</option>
          <option <?php if($rest['lock']==1): ?>selected='selected'<?php endif; ?>  value="1">LOCK</option>
        </select>
      </td>
    </tr>
  </table>
  <input type="submit" name="do_submit" value="submit" />
</form>
</body>

</html>