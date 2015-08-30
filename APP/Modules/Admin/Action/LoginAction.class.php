<?php 

Class LoginAction extends Action{

	//登录页面
	public function index(){
		$this->display();
	}

	public function verify(){
		import('ORG.Util.Image');
		Image::buildImageVerify();
	}
}
 ?>