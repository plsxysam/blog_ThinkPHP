<?php 

return array(
	'TMPL_PARSE_STRING' => array(
		'__PUBLIC__' => __ROOT__ . '/APP/Modules/' . GROUP_NAME . '/Tpl/Public'
		),

	//verify时去掉伪静态后缀名，是的看不清的js正常刷新
	'URL_HTML_SUFFIX' => '',
	'SHOW_PAGE_TRACE' =>true,

	//开启静态缓存
	'HTML_CACHE_ON' => true,
	'HTML_CACHE_RULES' => array(
		//'index'所有控制器的index都缓存
		'Show:index'=>array('{:module}_{:action}_{id}', 10),
		),

	//动态缓存方式 field Redis
	// 'DATA_CACHE_TYPE' => 'Memcache',
	// 'MEMCACHE_HOST' => '127.0.0.1',
	// 'MEMCACHE_PORT' => 11211,

	// 'REDIS_HOST' => '127.0.0.1',
	// 'REDIS_PORT' => 6379,

	);
 ?>