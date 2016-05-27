<?php

namespace Admin\Controller;
use Think\Controller;
use Library;
// require_once('Blog/Library/vendor/autoload.php');
Class SearchController extends Controller {
public $elastic;
public function _initialize(){
	$param = C('DEFAULT_HOST');
	$this->elastic = new \Library\Elastic($param);
}
	
public function index() {
	$this->module_name = MODULE_NAME;
	$rest = $this->search();
	$fields = array(
		'id' => '_id',
		'score' => '_score',
		'title' => 'title',
		'cat_id' => 'cat_id'
		);
	$this->rest = getSearch( $rest , $fields);
	// p($rest);die;
	$this->display();
}

public function search(){ 
		//Elastic search php client 
		$search_value = I('search_key');
		
		$params_arr = array(
			'index' => 'test',
			'type' => 'think_blog',
			'fields' => array('_id','cat_id','title'),
			'search_value' => $search_value,
			'search_key' => 'content',
			'max_expansions' => 20,
			// 'slop' => 0, 
			// 'operator' => 'and',	
			'highlight' => true,
			'highlight_fields' => array(
				'title' => array(),
				'content' => array( 'pre_tags'=>array('<b>'),'post_tags'=>array('</b>') )
				),
			'search_fields' => array('title','content'), //query_string
			); 
		// $params = $this->elastic->match_phrase_prefix_search($params_arr);
		
		// $rtn = $this->elastic->search($params); 

		$params = $this->elastic->query_string_search($params_arr);
		// p($params);die;
		$rtn = $this->elastic->search($params);

		// var_dump($rtn); 
		return $rtn;
	} 

}
