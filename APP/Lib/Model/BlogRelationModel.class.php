<?php 

/**
 * 多对多关联模型
 */
Class BlogRelationModel extends RelationModel{

	Protected $tableName = 'blog';

	Protected $_link = array(
		'attr' => array(
			'mapping_type' => MANY_TO_MANY,
			'mapping_name' => 'attr',
			'foreign_key' => 'bid',
			'relation_foreign_key' => 'aid',
			'relation_table' => 'hd_blog_attr',
			),
		//HAS_MANY一对多HAS_ONE一对一
		'cate' => array(
			'mapping_type' => BELONGS_TO,
			'foreign_key' => 'cid',
			//只读取的部分，比如name
			'mapping_fields' => 'name',
			//改名字
			'as_fields' => 'name:cate',
			)
		);

	Public function getBlogs ($type = 0){
		//用于控制读取主表中的字段,在调用时field($field)是读取其中的字段,field($field,true)是读取除$field以外的字段
		$field = array('del');
		$where = array('del' => $type);
		//如果只想关联其中的某一个，将relation中true修改为对应的名字，->where($where)->field($field)
		return $this->field($field,true)->where($where)->relation(true)->select();
	}
}
 ?>