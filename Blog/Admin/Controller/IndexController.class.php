<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
	public function index(){
		$rest = M('category')->order('sort')->select();
		$this->rest = node_merge( $rest );
		if( I('id') != null ){
			foreach ($this->rest as $key => $value) {
				if( $value['id'] == I('id') ){
					$this->cate = $value['child'];
					// p($this->cate);die;
				}
			}
		}
		$this->id = I('id');
		$this->display();
	}

	public function _after_index() {
		// my_log('id_test',I('id'));
		
	}

	public function content() {
		 $where = array(
		 	'status' => 0,
		 	'cat_id' => I('id')
		 	);
		 // $this->blog = M('blog')->where($where)->find();
		 $this->blog = D('Home/BlogRelation')->relation('attr')->where($where)->find();
		 // p($this->blog); die;
		 $this->display();
	}

}