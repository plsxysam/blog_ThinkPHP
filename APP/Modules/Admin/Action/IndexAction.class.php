<?php 
/**
 * 后台首页控制器
 */
Class IndexAction extends CommonAction{

	//首页视图
	public function index(){
		$this->display();
	}

	//退出登录
	public function logout(){
		session_unset();
		session_destroy();
		$this->redirect(GROUP_NAME . '/Login/index1');
	}
}
 ?>