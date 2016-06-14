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
			$this->blog_cache(true , 'add');
			$cate_blog = array(
				'cat_id' => I('cat_id'),
				'blog_id' => $rest
				);
			$result = M('cate_blog')->add( $cate_blog );
			$result || $this->error( 'BLOG RELATION CATEGORY FAILED' );
			$attr_ids = I('attr_id');
			$this->insert_blog_attr( $rest );
			$this->build_blog_attr( $attr_ids , $rest );
			// p($rst);die;
			$this->redirect( 'index',array('p'=>$this->p));
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
			$delete = M('blog_attr')->where(array('blog_id'=>I('id')))->save(array('status'=>1));
			// $delete || $this->error('DELETE BLOG ATTR '.I('id').' FAILED');
			$this->update_or_insert_attr(I('attr_id',0,'intval') , I('id'));
			$this->blog_cache(true);
			$this->redirect('index',array('p'=>I('p')));
			return;
		}

		$this->rest = D('BlogRelation')->relation(true)->find(I('id'));
		// p( $this->rest ); die;
		$this->get_cat_attr();
		$this->display();
	}

	/**
	* 删除博客
	* 彻底删除,恢复删除,逻辑删除
	 */
	public function delete() {
		//彻底删除
		if( I('delete') != null ){
			notice( 'Delete And Can\'t Reback ,Confirm?' );
			$rest = M('blog')->delete(I('id'));
			$rest || $this->error('DELETE FAILED');
			$this->_after_delete( I('id') );
			$this->redirect('gc');
			return;
		}
		//恢复删除
		if( I('reback') != null ){
			$rest = M('blog')->save( array('id'=>I('id'),'status'=>0) );
			$rest || $this->error( 'REBACK FAILED',1 );
			$this->blog_cache();
			$this->redirect('gc');
		}
		//逻辑删除
		notice( 'Confirm to Delete Blog?' );
		$rest = M('blog')->save( array('id'=>I('id'),'status'=>1) );
		$rest || $this->error( 'GC FAILED',1 );
		// \Think\Log::write('logic delete blog'.I('id'),'INFO','File','/tmp/blog.log');
		// \Think\Log::record('logic delete blog'.I('id'),'INFO');
		// \Think\Log::save('File','/tmp/blog.log');
		$this->blog_cache(true,'delete');
		$this->redirect('index',array('p'=>I('p')));
	}

	/**
	 * 
	 * @param  [type] $blog_id [description]
	 * @return [type]          [description]
	 */
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

	private function insert_blog_attr($blog_id) {
		$values = array();
		$attr = A('Attr')->attr_cache();
		// P($this->attr);die;
		foreach ($attr as $key => $value) {
			$values[] = "({$blog_id},{$value['id']},1)";
		}
		$insert_sql = 'insert into '.C('DB_NAME').'.'.C('DB_PREFIX').'blog_attr(`blog_id`,`attr_id`,`status`) values'.implode(',',$values);
		// p($insert_sql); die;
		$blog_attr = M('blog_attr')->query($insert_sql);
			// $blog_attr || $this->error('INSERT BLOG ATTR FAILED');
	}

	private function update_attr($ids , $blog_id){
		if( empty($ids) ){
			return;
		}
		$where = array(
			'attr_id' => array( 'in', $ids ),
			'blog_id' => $blog_id
			);
		$data = array(
			'status' => 0
			);
		$rest = M('blog_attr')->where($where)->fetchSql(false)->save($data);
	}

	private function insert_attr( $ids , $blog_id ){
		if( empty($ids) ){
			return;
		}
		$values = array();
		foreach ($ids as $v) {
			$values[] = "({$blog_id},{$v},0)";
		}
		if( !empty($values) ){
			$insert_sql = 'insert into '.C('DB_NAME').'.'.C('DB_PREFIX').'blog_attr(`blog_id`,`attr_id`,`status`) values'.implode(',',$values);
			// P($insert_sql);die;
			M('blog_attr')->query($insert_sql);
		}
	}

	private function update_or_insert_attr($attr_ids , $blog_id){
		// $attr_ids = implode(',', $attr_ids);
		$where = array(
			'attr_id' => array('in',$attr_ids),
			'blog_id' => $blog_id
			);
		// P($attr_ids);
		$rest = M('blog_attr')->field('attr_id')->fetchSql(false)->where($where)->select();
		$ids_exist = array();
		foreach ($rest as $v) {
			$ids_exist[] = $v['attr_id'];
		}
		$ids_not_exist = array_diff($attr_ids, $ids_exist);
		// P($attr_ids);P($ids_exist);P($ids_not_exist);die;
		$this->insert_attr($ids_not_exist , $blog_id);
		$this->update_attr($ids_exist , $blog_id);
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

	/**
	 * 博客缓存
	 * @param  boolean $refresh [description]
	 * @param  [type]  $operate [description]
	 * @return [type]           [description]
	 */
	private function blog_cache( $refresh = false , $operate=null){
		$field = array('id','cat_id','title','click','created','sort','update_time');
		$where=array('status'=>0) ;
		$totalRows = D('BlogRelation')->relation(true)->where( $where )->count();

		switch ($operate) {
			case 'add':
				$result = $totalRows%C('PAGE_SIZE');
				$pageSize = intval($totalRows/C('PAGE_SIZE'));
				$p = $result==0?$pageSize:$pageSize+1;
				// $_GET['p'] = $p;
				break;
			case 'delete':
				$p2 = I('p',1,'intval');
				while( 1 ) {
					$p2++;
					$cache_key = 'BLOG_PAGE_'.$p2;
					// P($cache_key);
					if(empty(S($cache_key))) {
						break;
					}
					S($cache_key,null);
				}
				break;
			default:
				$p = I('p',1,'intval');
				break;
		}
		$_GET['p'] = $p;
		$page = new \Think\Page( $totalRows , C('PAGE_SIZE') );
		$this->p = $p;
		// P($this->p); die;
		$cache_key = 'BLOG_PAGE_'.$this->p;

		if( !$refresh && S($cache_key) ){
			$this->rest = S( $cache_key );
		}else{
			$limit = $page->firstRow.','.$page->listRows;
			// P($limit);die;
			$this->rest = D('BlogRelation')->relation(true)->field($field)->where($where)->order('created')->limit($limit)->fetchSql(false)->select();
			// P($this->rest); die;
			S( $cache_key , $this->rest , 60*3600 );
		}
		$page->setConfig('theme',  "%HEADER% %UP_PAGE%  %FIRST% %LINK_PAGE% %END% %DOWN_PAGE%");
		$this->page = $page->show();
		// p($this->rest);die;
	}

	private function getBlog( $where ) {
		// p($where);
		$field = array('id','cat_id','title','click','created','sort','update_time');
		$totalRows = D('BlogRelation')->relation(true)->where( $where )->count();
		$page = new \Think\Page( $totalRows , C('PAGE_SIZE') );
		// p( I('p',1,'intval') );
		$limit = $page->firstRow.','.$page->listRows;
		$this->rest = D('BlogRelation')->relation(true)->field($field)->where($where)->limit($limit)->select();
		$page->setConfig('theme',  "%HEADER% %UP_PAGE%  %FIRST% %LINK_PAGE% %END% %DOWN_PAGE%");
		$this->page = $page->show();
		// p($this->rest ); die;
	}

	public function build_blog_attr(){
		$rest = M('blog')->field('id')->select();
		// $ids = implode(',', $rest);
		M('blog_attr')->delete();
		$values = array();
		foreach ($rest as $key => $value) {
			$values[] = "{$value},1,1";
			$values[] = "{$value},2,1";
			$values[] = "{$value},3,1";
		}
		$values = implode(',', $values);
		$insert_sql = "insert into test.think_blog_attr(`blog_id`,`attr_id`,`status`) values {$values} ";
		M('blog_attr')->query($insert_sql);
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



	/*private function update_blog_attr( $attr_ids , $blog_id ){
		if( empty($attr_ids) ){
			return;
		}
		$attr_ids = implode(',', $attr_ids);
		// P($attr_ids);
		$update_sql = 'update '.C('DB_NAME').'.'.C('DB_PREFIX')."blog_attr set `status`=0 where blog_id={$blog_id} and attr_id in({$attr_ids})" ;
		// P($update_sql);die;
		$blog_attr = M('blog_attr')->query($update_sql);
		// P($blog_attr);die;
		// $blog_attr || $this->error('UPDATE BLOG ATTR FAILED');
	}*/

	/*private function insert_blog_attr( $attr_ids , $blog_id) {
		$values = array();
		foreach ($attr_ids as $key => $value) {
			$values[] = "({$blog_id},{$value})";
		}
		$insert_sql = 'insert into '.C('DB_NAME').'.'.C('DB_PREFIX').'blog_attr(`blog_id`,`attr_id`) values'.implode(',',$values);
			// p($insert_sql); die;
		$blog_attr = M('blog_attr')->query($insert_sql);
			// $blog_attr || $this->error('INSERT BLOG ATTR FAILED');
	}*/

}