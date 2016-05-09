<?php

namespace Home\Controller;
use Think\Controller;

Class BlogController extends CommonController {

	public function index() {
		$where = $this->blog_search( array('status'=>0) );
		$this->getBlog($where);
		$this->display();
	}

	public function add() {
		if( IS_POST ){
			// $data = I('post.');
			$data = $_POST;
			$data['created'] = time();
			$rest = M('blog')->add( $data );
			// my_log( 'id' , $rest );
			$rest || $this->error( 'INSERT ERROR' );
			$cate_blog = array(
				'cat_id' => I('cat_id'),
				'blog_id' => $rest
				);
			$result = M('cate_blog')->add( $cate_blog );
			$result || $this->error( 'BLOG RELATION CATEGORY FAILED' );
			$attr_ids = I('attr_id');
			$this->insert_blog_attr( $attr_ids , $rest );
			$this->redirect( 'index');
			return;
		}
		$this->get_cat_attr();
		$this->display();
	}

	public function edit() {
		if( IS_POST ){
			// $data = I('post.');
			$data = $_POST;
			$data['update_time'] = time();
			// p( $data );die;
			$rest = M('blog')->save($data);
			$rest || $this->error( 'UPDATE FAILED' );
			$delete = M('blog_attr')->where(array('blog_id'=>I('id')))->delete();
			// $delete || $this->error('DELETE BLOG ATTR '.I('id').' FAILED');
			$this->insert_blog_attr(I('attr_id') , I('id'));
			$this->redirect('index');
			return;
		}
		$this->rest = D('BlogRelation')->relation(true)->find(I('id'));
		// p( $this->rest ); die;
		$this->get_cat_attr();
		$this->display();
	}

	public function delete() {

		if( I('delete') != null ){
			notice( 'Delete And Can\'t Reback ,Confirm?' );
			$rest = M('blog')->delete(I('id'));
			$rest || $this->error('DELETE FAILED');
			$this->_after_delete( I('id') );
			$this->redirect('gc');
			return;
		}
		if( I('reback') != null ){
			$rest = M('blog')->save( array('id'=>I('id'),'status'=>0) );
			$rest || $this->error( 'REBACK FAILED',1 );
			$this->redirect('gc');
		}
		notice( 'Confirm to Delete Blog?' );
		$rest = M('blog')->save( array('id'=>I('id'),'status'=>1) );
		$rest || $this->error( 'GC FAILED',1 );
		$this->redirect('index');
	}

	public function  _after_delete( $blog_id ) {
		$rest = M('blog_comment')->where( array('blog_id'=>I('id')) )->delete();
		// $rest || $this->error('BLOG COMMENT DELETE FAILED');
	}

	public function gc() {
		$where = $this->blog_search( array('status'=>1) );
		$this->getBlog( $where);
		$this->gc = true;
		$this->display('Blog_index');
	}

	private function getBlog( $where ) {
		// p($where);
		$field = array('id','cat_id','title','click','created','sort');

		$this->get_cat_attr();

		$totalRows = D('BlogRelation')->relation(true)->where( $where )->count();
		$page = new \Think\Page( $totalRows , C('PAGE_SIZE') , $url);
		$limit = $page->firstRow.','.$page->listRows;
		$this->rest = D('BlogRelation')->relation(true)->field($field)->where($where)->limit($limit)->select();

		$this->page = $page->show();
		// p($this->rest ); die;
	}

	private function insert_blog_attr( $attr_ids , $blog_id) {
		$values = array();
			foreach ($attr_ids as $key => $value) {
				$values[] = "({$blog_id},{$value})";
			}
			$insert_sql = 'insert into '.C('DB_NAME').'.'.C('DB_PREFIX').'blog_attr(`blog_id`,`attr_id`) values'.implode(',',$values);
			// p($insert_sql); die;
			$blog_attr = M('blog_attr')->query($insert_sql);
			// $blog_attr || $this->error('INSERT BLOG ATTR FAILED');
	}

	private function get_cat_attr(){
		$this->category = A('Cat')->cat_cache();
		$this->attr = A('Attr')->attr_cache();
		// p($this->category);die;
	}

	private function blog_search($where=''){
		if( I('cat_id',0,'intval') != 0 ){
			$cat_id = I('cat_id');
			$rest = M('category')->field('id,pid')->select();
			// p( $rest ); die;
			$cat_ids = getChildrens( $rest , $cat_id);
			// p($cat_ids);die;
			$where['cat_id'] = array('in' , $cat_ids);
			$this->cat_id = $cat_id;
		}
		// p($where);die;
		return $where;
	}

}