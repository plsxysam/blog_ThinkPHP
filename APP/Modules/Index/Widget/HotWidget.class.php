<?php 

Class HotWidget extends Widget{

	Public function render ($data) {
		//支持显示模板，在相同目录下同名，如./Hot/Hot.html   $data 传递过去的是 id = '';将数组里内变量传递过去
		//热门博文
		$data['blog'] = M('blog')->field(array('id', 'title', 'click'))->order('click DESC')->limit(5)->select();
		p($blog);
		return $this->renderFile('', $data);
		//输出的字符串需要返回 例如 return 'Widget';
	}
}
 ?>