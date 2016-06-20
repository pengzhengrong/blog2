<?php
return array(
	//'配置项'=>'配置值'
	    'TMPL_ENGINE_TYPE'      =>  'SMARTY',     // 默认模板引擎 以下设置仅对使用Think模板引擎有效
	    'TMPL_ENGINE_CONFIG' => array(
	    	'caching' => false,
	    	'template_dir' =>'./APP/Home/View/',
	    	'compile_dir' => './APP/Runtime/Cache/',
	    	'cache_dir' =>'./APP/Runtime/Temp/',
	    	'left_delimiter' => '{',
	    	'right_delimiter' => '}',
	    	),
	    'TMPL_FILE_DEPR' => '_',
	    'DEFAULT_MODULE' => 'Home',
	    'PAGE_SIZE' => 10,

	    'DB_HOST' => '127.0.0.1',
	    'DB_USER' => 'root',
	    'DB_PWD' => '',
	    'DB_NAME' => 'test',
	    'DB_TYPE' => 'mysqli',
	    'DB_PREFIX' => 'think_',

	    'LOAD_EXT_CONFIG' => 'elastic',

	 
);