<?php 
/**
 * 首页
 */
Class IndexAction extends Action {

	Public function index(){
		if (!$list = S('index_list')) {
			$list = M('cate')->where(array('pid' => 0))->order('sort')->select();

			import('Class.Category', APP_PATH);
			$cate = M('cate')->order('sort')->select();

			$db = M('blog');
			foreach ($list as $k => $v) {
				$cids = Category::getChildsId($cate, $v['id']);
				$cids[] = $v['id'];
				$where = array('cid' => array('IN', $cids));
				$list[$k]['blog'] = $db->field(array('id','title','time'))->where($where)->select();
			}
			//缓存名称  缓存数据 缓存时间10s
			S('index_list', $list, 3600 * 24);
		}
		
		
		

		$this->cate = $list;
		$this->display();
	}
}
 ?>