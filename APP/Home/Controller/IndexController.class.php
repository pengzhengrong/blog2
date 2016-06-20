<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

	/*public function test() {
		$this->display('test');
		// print_r(TMPL_PATH);
	 }*/

	 Public function _initialize() {
	 	define('CACHE_TIME',empty(C('CACHE_TIME')?60:C('CACHE_TIME')));
	 	$this->cate = $this->category();
	 }

	 Public function page_blog() {
	 	
	 	$where = array(
	 		'status' => 0,
	 		);
	 	$fields = array('id','content','title','created');
	 	$count = M('blog')->where($where)->fetchSql(false)->count();
	 	$pageSize = I('n',C('PAGE_SIZE'),'intval');
	 	$page = new \Think\Page($count,$pageSize);
	 	$limit = $page->firstRow.','.$page->listRows;
	 	// P($limit);die;
	 	$rest = M('blog')->field($fields)->where($where)->order('created desc')->limit($limit)->fetchSql(false)->select();
	 	foreach ($rest as $k=>$v) {
	 		$rest[$k]['url'] = '/blog_'.$v['id'];
	 	}
	 	// P($rest);die;
	 	$this->rest = $rest;
	 	$page->setConfig('theme',  "%HEADER% %UP_PAGE%  %FIRST% %LINK_PAGE% %END% %DOWN_PAGE%");
	 	$this->show = $page->show();
	 	// P($this->show); die;
	 	$this->display();
	 }

	 Public function blog() {
	 	$id = I('id',0,'intval');
	 	$this->rest = M('blog')->find($id);
	 	// P($rest);
	 	$this->display();
	 }

	 Public function category() {
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
	 	// P($rest);die;
	 	// $this->display();
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
		'highlight' => 'highlight'
		);
		$this->rest = getSearch( $rtn , $fields);
		// P($this->rest); die;
		$this->display(); 
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
	 			'fields' => array('title','id','cat_id')

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