<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

	/*public function test() {
		$this->display('test');
		// print_r(TMPL_PATH);
	 }*/

	 public $ids = array();

	 Public function _initialize() {
	 	define('CACHE_TIME',empty(C('CACHE_TIME')?60:C('CACHE_TIME')));
	 	$this->cate = $this->getCategory();
	 }

	 Public function page_blog() {
	 	$where = array(
	 		'status' => 0,
	 		);
	 	$fields = array('id','content','title','created');
	 	$count = M('blog')->where($where)->fetchSql(false)->count();
	 	$pageSize = I('n',C('PAGE_SIZE'),'intval');
	 	$page = new \Think\Page($count,$pageSize);
	 	$page->url = '/'.ACTION_NAME.'?p='.urlencode('[PAGE]');
	 	$limit = $page->firstRow.','.$page->listRows;
	 	// P($limit);die;
	 	$rest = M('blog')->cache(true,CACHE_TIME)->field($fields)->where($where)->order('created desc')->limit($limit)->fetchSql(false)->select();
	 	// P($rest);die;
	 	$this->rest = $rest;
	 	$page->setConfig('theme',  "%HEADER% %UP_PAGE%  %FIRST% %LINK_PAGE% %END% %DOWN_PAGE%");
	 	$this->show = $page->show();
	 	// P($this->show); die;
	 	$this->display();
	 }

	 /**
	  * 栏目列表
	  * @return [type] [description]
	  */
	 Public function category() {
	 	$id= I('id',0,'intval');
	 	$cate = M('category')->field(array('id','pid'))->where('status=0')->select();
	 	// P($cate);
	 	$ids = getChildrens($cate,$id);
	 	// P($ids);die;
	 	$rest = M('blog')->cache(true,CACHE_TIME)->field(array('id','title','content','created'))->where("status=0 AND cat_id in ($ids)")->order('created desc')->select();
	 	$this->rest = $rest;
	 	$this->display();
	 	// P($blog);die;
	 }

	 Public function blog() {
	 	$id = I('id',0,'intval');
	 	$this->rest = M('blog')->find($id);
	 	// P($rest);
	 	$this->get_next_prev($id);
	 	$this->display();
	 }

	 Public function getCategory() {
	 	$cacheKey = 'CATE_CACHE';
	 	if( S($cacheKey) ) {
	 		return S($cacheKey);
	 	}
	 	$where = array(
	 		'status' => 0,
	 		'pid' => 0
	 		);
	 	$fields = array('id','title');
	 	$rest = M('category')->field($fields)->where($where)->order('sort')->select();
	 	S($cacheKey,$rest,C('CACHE_TIME'));
	 	return $rest;
	 }

	 Public function search() {
	 	vendor('Elastic/Elastic','','.class.php');
	 	$param = C('DEFAULT_HOST');
		$elastic = new \Elastic($param);

		$search_value = I('search_key');
		$this->search_key = $search_value;
		$params = $this->query_string($search_value);

		$rtn = $elastic->search($params);
		$fields = array(
		'id' => '_id',
		'score' => '_score',
		'title' => 'title',
		'cat_id' => 'cat_id',
		'highlight' => 'highlight',
		'created' => 'created'
		);
		$this->rest = getSearch( $rtn , $fields);
		// P($this->rest); die;
		$this->display();
	 }

	 Private function get_next_prev($id) {
	 	$rest = M('blog')->cache(true,CACHE_TIME)->field(array('id','title'))->where('status=0')->order('created desc')->select();
	 	// P($rest);
	 	foreach ($rest as $k => $v) {
	 		if( $v['id'] == $id ) {
	 			$this->prev = $rest[$k-1];
	 			$this->next = $rest[$k+1];
	 		}
	 	}
	 	// return $rest;
	 	return;
	 }

	 Private function query_string($search_value) {
	 	$param = array(
	 		'index' => C('DEFAULT_INDEX'),
	 		'type' => C('DEFAULT_TYPE'),
	 		'from' => 0,
	 		'size' => C('PAGE_SIZE'),
	 		'body' => array(
	 			'query' => array(
		 			'query_string' => array(
		 				'query' => $search_value,
		 				'default_operator' => 'and',
		 				'fields' => array('title','content')
		 				)
		 			),
	 			'highlight' => array(
		 			'term_vector' => 'with_positions_offsets',
		 			'fields' => array(
		 				'title'=>array(
							'fragment_size' => 10
		 					),
		 				'content'=>array(
		 					'fragment_size' => 10,
		 					// 'pre_tags' => array('<font color="red">'),
		 					// 'post_tags' => array('</font>')
		 					)
		 				)
	 			),
	 			'fields' => array('title','id','cat_id','created')

	 		)

	 		);
	 	return $param;
	 }



}










/*$params_arr = array(
			'index' => 'test',
			'type' => 'think_blog',
			'fields' => array('_id','cat_id','title'),
			'search_value' => $search_value,
			'search_key' => 'content',
			'max_expansions' => 20,
			// 'slop' => 0,
			'operator' => 'and',
			'highlight' => true,
			'highlight_fields' => array(
				'title' => array('fragment_size' => 10),
				'content' => array( 'pre_tags'=>array('<em>'),'post_tags'=>array('</em>'),'fragment_size' => 10 )
				),
			'search_fields' => array('title','content'), //query_string
			);
		// $params = $elastic->match_phrase_prefix_search($params_arr);
		$params = $elastic->query_string_search($params_arr);
		p($params);
		$rtn = $elastic->search($params);
			*/

		// var_dump($rtn);

		// return $rtn;
		/*$data = array(
			'status' => 200,
			'msg' => 'ok',
			'data' => $rtn
			);
		$this->ajaxReturn($data);*/