<?php

namespace Home\Controller;
use Think\Controller;
use Library;
require_once('Blog/Library/vendor/autoload.php'); 
Class BlogController extends CommonController {

	public $elastic;
	public function _initialize(){
		$param = C('DEFAULT_HOST');
		$this->client = new \Elasticsearch\Client($param);
		$this->elastic = new \Library\Elastic($param);
	}

	public function index() {
		if( I('cat_id') == 0 ){
			$this->blog_cache();
		}else{
			$where = $this->blog_search( array('status'=>0) );
			$this->getBlog($where);
		}
		$this->get_cat_attr();
		$this->display();
	} 

	public function add() {
		if( IS_POST ){
			// $data = I('post.');
			$data = $_POST;
			// p($data);die;
			$data['created'] = time();
			$data['update_time'] = time();
			$rest = M('blog')->add( $data );
			// my_log( 'id' , $rest );
			$rest || $this->error( 'INSERT ERROR' );
			if( C('ELASTIC_ON') ){
				$fields = array(
					'content' => dataclean($data['content']),
					'title' => $data['title'],
					'status' => 0,
					'cat_id' => I('cat_id')
					);
				$params = array(
					'id' => $rest
					);
				// p($fields);die;
				$rst = $this->elastic->create_index_one($fields , $params);
				if( empty($rst['_id']) ){
					//log
				}
			}
			$cate_blog = array(
				'cat_id' => I('cat_id'),
				'blog_id' => $rest
				);
			$result = M('cate_blog')->add( $cate_blog );
			$result || $this->error( 'BLOG RELATION CATEGORY FAILED' );
			$attr_ids = I('attr_id');
			$this->insert_blog_attr( $attr_ids , $rest );
			// p($rst);die;
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
			//update ES 
			// p($data['cat_id']);die;
			if( C('ELASTIC_ON') ){
				$content = dataclean($data['content']);
				$this->update_index($data['id'] , $data['content']);
			}
			
			$rest || $this->error( 'UPDATE FAILED' );
			$delete = M('blog_attr')->where(array('blog_id'=>I('id')))->delete();
			// $delete || $this->error('DELETE BLOG ATTR '.I('id').' FAILED');
			$this->insert_blog_attr(I('attr_id') , I('id'));
			$this->blog_cache(true);
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
			if( C('ELASTIC_ON') ){
				@$this->update_index(I('id'),0,'status');
			}
			$this->blog_cache(true);
			$this->redirect('gc');
		}
		notice( 'Confirm to Delete Blog?' );
		$rest = M('blog')->save( array('id'=>I('id'),'status'=>1) );
		$rest || $this->error( 'GC FAILED',1 );
		if( C('ELASTIC_ON') ){
			@$this->update_index(I('id'),1,'status');
		}
		$this->blog_cache(true);
		$this->redirect('index');
	}

	public function  _after_delete( $blog_id ) {
		$rest = M('blog_comment')->where( array('blog_id'=>I('id')) )->delete();
		if( C('ELASTIC_ON') ){
			$params = array(
				'index' => C('DEFAULT_INDEX'),
				'type' => C('DEFAULT_TYPE'),
				'id' => I('id')
				);
			$data = $this->elastic->delete($params);
			//log
		}
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
		$field = array('id','cat_id','title','click','created','sort','update_time');
		$totalRows = D('BlogRelation')->relation(true)->where( $where )->count();
		$page = new \Think\Page( $totalRows , C('PAGE_SIZE') , $url);
		// p( I('p',1,'intval') );
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
		$this->cate = A('Cat')->cat_cache();
		$this->category = node_merge( $this->cate );
		$this->attr = A('Attr')->attr_cache();
		// p($this->category);die;
	}

	private function blog_search($where=''){
		if( I('cat_id',0,'intval') != 0 ){
			$cat_id = I('cat_id');
			// $rest = M('category')->field('id,pid')->select();
			$rest = A('Cat')->cat_cache();
			// p( $rest ); die;
			$cat_ids = getChildrens( $rest , $cat_id);
			// p($cat_ids);die;
			$where['cat_id'] = array('in' , $cat_ids);
			$this->cat_id = $cat_id;
		}
		// p($where);die;
		return $where;
	}

	private function blog_cache( $refresh = false){
		$this->p = I('p',1,'intval');
		$cache_key = 'BLOG_PAGE_'.$this->p;
		
		$field = array('id','cat_id','title','click','created','sort','update_time');
		$where=array('status'=>0) ;
		$totalRows = D('BlogRelation')->relation(true)->where( $where )->count();
		$page = new \Think\Page( $totalRows , C('PAGE_SIZE') , $url);
		if( !$refresh && S($cache_key) ){
			$this->rest = S( $cache_key );
		}else{
			$limit = $page->firstRow.','.$page->listRows;
			$this->rest = D('BlogRelation')->relation(true)->field($field)->where($where)->limit($limit)->select();
			S( $cache_key , $this->rest , 60*3600 );
		}
		$this->page = $page->show();
	}

	//ES update
	private function update_index($id ,$value , $key='content'){
		$params = array(
			'id' => $id,
			'index' => 'test',
			'type' => 'think_blog',
			'script' => "ctx._source.$key =  \"$value\""
			);
		$data = $this->client->update($params);
		// p($data);die;
		/*if( $data['_id'] == $id ){
			notice('索引同步成功','index',1,'update');
		}*/
	}

	private function delete_index( $id ){
		$params = array(
			'id' => $id,
			'index' => 'test',
			'type' => 'think_blog'
			);
		$data = $this->client->delete($params);
		// if( $data['_id'] == $id ){
		// 	notice('索引删除成功','index',1,'update');
		// }
	}

	private function add_index( $id ){

	}

}