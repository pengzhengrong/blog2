<?php
namespace Home\Controller;
use Think\Controller;
use Think;
class LoginController extends Controller {
    public function index(){
        $this->module_name = MODULE_NAME;
        $this->display();
     }

     public function verify() {
     	$verify = new  \Think\Verify;
     	$verify->codeSet = '0123456789';
     	// $verify->imageW = 100;
     	// $verify->imageH = 30;
     	$verify->length = 4;
     	$verify->fontSize = 16;
     	$verify->entry();
     }

     public function handle() {
     	$verify = new \Think\Verify;
                $where = array(
                    'username' => I('username'),
                    'password' => I('passwd',0,'md5')
                    );
                $rest = M('user')->where($where)->find();
                // p($rest) ; die;
     	$check = $verify->check( I('code') );
     	$check || $this->error('CODE ERROR');
             session( array( 'expire'=>3600*24 ) );
     	session('username', $rest['username']);
                session( C('USER_AUTH_KEY') , $rest['id'] );
                if( in_array($rest['username'],  explode(',', C('RBAC_SUPERADMIN'))) )
                        session( C('ADMIN_AUTH_KEY') , $rest['id'] );
                if( C('URL_ROUTER_ON') ){
     	      $this->redirect('/admin');
                }
                $this->redirect(U(MODULE_NAME.'/Index/index'));
     }

     public function logout() {
         session_unset( $_SESSION );
         session_destroy( $_SESSION );
         $this->redirect('index');
     }

}