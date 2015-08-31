<?php 

Class LoginAction extends Action{

	//登录页面
	public function index(){
		$this->display();
	}

	public function verify(){
		import('Class.Image', APP_PATH);
		Image::Verify();
	}
}
 ?>