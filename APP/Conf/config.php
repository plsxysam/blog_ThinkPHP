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
	'LOAD_EXT_CONFIG' => 'verify,water',
);
?>