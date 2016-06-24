<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){

            // echo session_save_path();
            // p( $_SESSION );die;

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

     public function welcome(){
           $this->username = session('username');
           $uid = session(C('USER_AUTH_KEY'));
           $rest = D('UserRelation')->relation( true )->where("id=$uid")->select();
           // p($rest);
           if( $rest ){
                $role_desc = array();
                 foreach ($rest[0]['role'] as $key => $value) {
                   $role_desc[] = $value['remark'];
                }
                $this->login_time = $rest[0]['login_time'];
                $this->login_ip = $rest[0]['login_ip'];
                $this->role = implode(',', $role_desc);
           }
          if( in_array($this->username, explode(',',C('RBAC_SUPERADMIN')) ) ){
            $this->role = '超级管理员';
          }
          $this->display();
     }

     Public function test() {
        $image = new \Home\Library\Image();
        $image->imageHandler();
     }
     
}