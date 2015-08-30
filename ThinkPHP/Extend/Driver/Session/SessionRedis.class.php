<?php 
/**
 * 自定义REDIS SESSION驱动
 */

Class SessionRedis{

	public function execute(){
		session_set_save_handler(
			array(&$this,"open"), 
            array(&$this,"close"), 
            array(&$this,"read"), 
            array(&$this,"write"), 
            array(&$this,"destroy"), 
            array(&$this,"gc")
            ); 
	}

	public function open($path, $name){
		
	}

	public function close(){

	}

	public function read($id){

	}

	public function write($id, $data){

	}

	public function destroy($id){

	}

	public function gc($maxLifeTime){

	}
}
?>