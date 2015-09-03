<?php 

Class BlogAction extends CommonAction{

	//博文列表
	Public function index(){
		//用于控制读取主表中的字段,在调用时field($field)是读取其中的字段,field($field,true)是读取除$field以外的字段
		$field = array('id', 'title', 'content', 'time', 'click');
		$where = array('del' => 0);
		//如果只想关联其中的某一个，将relation中true修改为对应的名字，->where($where)->field($field)
		$this->blog = D('BlogRelation')->relation(true)->select();
		 // p($blog);die();
		$this->display();
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
		//不安全了可以用I方法
		$data = array(
			'title' => I('title'),
			'content' => $_POST['content'],
			'time' => time(),
			'click' => (int) $_POST['click'],
			'cid' => (int) $_POST['cid']
			);
		if ($bid = M('blog')->add($data)) {
			
			if (isset($_POST['aid'])) {
				$sql = 'INSERT INTO `' . C('DB_PREFIX') . 'blog_attr` (bid, aid) VALUES';
				foreach ($_POST['aid'] as $v) {
					$sql .= '(' . $bid . ',' . $v . '),';
				}
				$sql = rtrim($sql, ',');
				M('blog_attr')->query($sql);
			}
			$this->success('添加成功', U(GROUP_NAME . '/Blog/index'));
		} else {
			$this->error('添加失败');
		}
	} 

	//编辑器图片上传处理
	Public function upload(){
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();
		$upload->autoSub = true;
		$upload->subType = 'date';
		$upload->dateFormat = 'Ym';

		if($upload->upload('./Uploads/')){
			$info = $upload->getUploadFileInfo();
			// import('ORG.Util.Image');
			// Image::water('./Uploads/' . $info[0]['savename'], './Data/fff.png');
			import('Class.Image', APP_PATH);
			Image::water('./Uploads/' . $info[0]['savename'], './Data/fff.png');

			echo json_encode(array(
				'url' => $info[0]['savename'],
				'title' => htmlspecialchars($POST['pictitle'], ENT_QUOTES),
				'original' => $info[0]['name'],
				'state' => 'SUCCESS'
				));
		} else {
			echo json_encode(array(
				'state' =>$upload->getErrorMsg()
				));
			
		}


	}
}
 ?>