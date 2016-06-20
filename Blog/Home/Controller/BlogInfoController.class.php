<?php

namespace Home\Controller;
use Think\Controller\RestController;

/**
 * Restful Test
 */
Class BlogInfoController extends RestController {
	protected $allowMethod    = array('get','post','put'); // REST允许的请求类型列表
	protected $allowType      = array('html','xml','json'); // REST允许请求的资源类型列表

	Public function read_get_html(){
	    P(I());
	}
	Public function read_get_xml(){
	    // 输出id为1的Info的XML数据
	}
	Public function read_xml(){
	    // 输出id为1的Info的XML数据
	}
	Public function read_json(){
	    // 输出id为1的Info的json数据
	}
}