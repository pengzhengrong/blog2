<?php
return array(
	//'配置项'=>'配置值'
	'URL_MODE' => 2,
	'TMPL_FILE_DEPR' => '_',
	'DB_TYPE' => 'mysqli',
	'DB_HOST' => '127.0.0.1',
	'DB_NAME' => 'test',
	'DB_USER' => 'root',
	'DB_PWD' => '',
	'DB_PREFIX' => 'think_',
	'COMMENT_ON' => true,
	'APP_SUB_DOMAIN_DEPLOY' => 1,
	'APP_SUB_DOMAIN_RULES' => array(
		'APP_DOMAIN_SUFFIX' => 'ticp.io',
		),
	'URL_ROUTER_ON' => true,
	'URL_ROUTE_RULES' => array(
		'/^blog_(\d+)$/' => 'Admin/Index/index?id=:1',
		'/^content_(\d+)$/' => 'Admin/Index/content?id=:1',
		'/^admin$/' => 'Home/Index/index',
		'/^blog$/' => 'Admin/Index/index',
		'/^login$/' => 'Home/Login/index',
		'/^logout$/' => 'Home/Login/logout',
		'/^blogin$/' => 'Admin/Login/index',
		'/^blogout$/' => 'Admin/Login/logout',
		),
	'DEFAULT_MODULE' => 'Admin',
	// 'SHOW_PAGE_TRACE' => true,
);