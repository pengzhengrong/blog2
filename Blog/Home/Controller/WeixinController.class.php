<?php

namespace Home\Controller;
use Think\Controller;

CLass WeixinController extends Controller {

	Public function test() {
		vendor('Weixin.WechatCallback#class');
		$wechat = new \WechatCallback();
		$wechat->valid();
	}
	
}
