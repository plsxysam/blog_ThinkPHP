<?php 

Class CategoryAction extends CommonAction {

	//分类列表视图
	public function index(){
		$cate = M('cate')->order('sort ASC')->select();
		//$this->assign('cate', $cate)->display();

		import('Class.Category', APP_PATH);
		// $cate = Category::unlimitedForLayer($cate);
		$this->cate = Category::unlimitedForLevel($cate, '&nbsp;&nbsp;&nbsp;&nbsp;--');
		$this->display();
	}

	//添加分类视图
	public function addCate(){
		//$pid = isset($_GET['pid']) ? $_GET['pid'] : 0 ;
		$this->pid = I('pid', 0, 'intval');
		$this->display();
	}

	//添加分类表单处理
	public function runAddCate(){
		if(M('cate')->add($_POST)){
			$this->success('添加成功', U(GROUP_NAME . '/Category/index'));
		} else {
			$this->error('添加失败');
		}
	}

	public function sortCate(){
		$db = M('cate');
		foreach ($_POST as $id => $sort) {
			$db->where(array('id' => $id))->setField('sort', $sort);
		}

		$this->redirect(GROUP_NAME . '/Category/index');
	}
}
 ?>