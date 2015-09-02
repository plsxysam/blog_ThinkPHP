<?php 

Class AttributeAction extends CommonAction{

	//属性列表
	public function index(){
		$this->attr = M('attr')->select();
		$this->display();
	}

	//添加属性视图
	public function addAttr (){
		$this->display();
	} 

	public function runAddAttr(){
		if (M('attr')->add($_POST)) {
			$this->success('添加成功', U(GROUP_NAME . '/Attribute/index'));
		}else{
			$this->error('添加失败');
		}
	}
}

 ?>