<?php
return array(
	//'配置项'=>'配置值'
	'URL_ROUTER_ON' => true,
	'URL_ROUTE_RULES' => array(
		'/^blog_(\d+)$/' => 'Home/Index/blog?id=:1',
		'/^(\w+)$/' => 'Home/Index/:1',
		),
	'CACHE_TIME' => 60,
);