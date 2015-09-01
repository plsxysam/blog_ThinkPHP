<?php 

Class SystemAction extends CommonAction{

	Public function verify(){
		$this->display();
	}

	Public function updateVerify(){
		//	文件 写入的数据 文件地址
		if(F('verify', $_POST, CONF_PATH)){
			$this->success('修改成功', U(GROUP_NAME . '/System/verify'));
		} else {
			$this->error('修改失败，请修改' . CONF_PATH . 'verify.php权限');
		}
	}
}
 ?>