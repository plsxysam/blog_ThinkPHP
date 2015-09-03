<?php 

/**
 * 多对多关联模型
 */
Class BlogRelationModel extends RelationModel{

	Protected $tableName = 'blog';

	Protected $_link = array(
		'attr' => array(
			'mapping_type' => MANYTOMANY,
			'mapping_name' => 'attr',
			'foreign_key' => 'bid',
			'relation_foreign_key' => 'aid',
			'relation_table' => 'hd_blog_attr',
			)
		);
}
 ?>