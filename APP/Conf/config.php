<?php
return array(
	//'配置项'=>'配置值'

	'DB_HOST' => '127.0.0.1',
	'DB_USER' => 'root',
	'DB_PWD' => '123456',
	'DB_NAME' => 'blog',
	'DB_PREFIX' => 'hd_',

	'APP_GROUP_LIST' => 'Index,Admin',
	'DEFAULT_GROUP' => 'Index',
	'APP_GROUP_MODE' => 1,
	'APP_GROUP_PATH' => 'Modules',

	//加载独立配置项文件
	'LOAD_EXT_CONFIG' => 'verify',

	//URL路由 'URL_MODEL' => 2, 0普通 1正常 2URL路由 
	//apache 配置mod_rewrite.so和AllowOverride
	'URL_MODEL' => 2, 
	'URL_ROUTER_ON' => true,
	'URL_ROUTE_RULES' => array(
		//正则中\d代表数字	正则路由/^c_(\d+)$/   Index/List/index?id=:1
		'/^c_(\d+)$/' => 'Index/List/index?id=:1',
		':id\d' => 'Index/Show/index'
		)
);
?>