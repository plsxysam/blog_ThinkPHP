<?php 

Class ShowAction extends Action {

	Public function index(){
		$id = (int) $_GET['id'];
		//setInc指定字段加1  setDec指定字段减1     setInc('click',2)增2
		M('blog')->where(array('id'=>$id))->setInc('click');

		$where = array('id' => $id);
		$field = array('id','title', 'time', 'click', 'content','cid');
		$this->blog = M('blog')->field($field)->find($where);

		$cid = $this->blog['cid'];
		import('Class.Category', APP_PATH);
		$cate = M('cate')->order('sort')->select();
		$this->parent = Category::getParents($cate, $cid);



		$this->display();
	}

	Public function clickNum(){
		$id = (int) $_GET['id'];
		$click = M('blog')->where(array('id'=>$id))->getField('click');
		//setInc指定字段加1  setDec指定字段减1     setInc('click',2)增2
		M('blog')->where(array('id'=>$id))->setInc('click');
		
		echo 'document.write(' . $click .')';
	}
}
 ?>