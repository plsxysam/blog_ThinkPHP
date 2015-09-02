<?php 

Class BlogAction extends CommonAction{

	//博文列表
	Public function index(){

	}

	//添加博文
	Public function blog(){
		//博文所属分类
		import('Class.Category', APP_PATH);
		$cate = M('cate')->order('sort')->select();
		$this->cate = Category::unlimitedForLevel($cate);

		//博文属性
		$this->attr = M('attr')->select();
		$this->display();
	}

	//添加博文表单处理
	Public function addBlog () {
		p($_POST);
	}
}
 ?>