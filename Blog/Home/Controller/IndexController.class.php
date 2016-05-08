<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
    	$rest = M('navigation')->field( $field)->order('sort')->select();
    	$this->rest = node_merge( $rest ) ;
    	$name = C('NAVIGATION')=='en_name'?'en_name':'zn_name';
    	$field = array('id',$name,'url','pid');
    	$rest = M('navigation')->field( $field)->order('sort')->select();
    	// $rest = M('navigation')->query('select * from think_navigation');
    	// echo M('navigation')->getlastsql();
    	// p($rest); die;
    	$this->rest = node_merge( $rest ) ;
    	// p($this->rest);die;
    	$this->name = $name;
        	$this->display();
     }
}