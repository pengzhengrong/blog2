<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {

     public function _initialize () {
      $this->module_name = MODULE_NAME;
      $uid = session( C('USER_AUTH_KEY') );
      // echo $uid; die;
      if( empty( session('username') ) /*|| empty( $uid ) */ ){
                                   if( C('URL_ROUTER_ON') ){
                                        $this->error('Please Login ',U('/login'));
                                   }else{
                                        $this->error('Please Login ',U(MODULE_NAME.'/Login/index'));
                                   }  
      }
      $Rbac = new \Org\Util\Rbac;
      $handle = strpos( ACTION_NAME , '_' )>0?1:0;
  $noAuth = in_array( CONTROLLER_NAME, explode( ',', C('NOT_AUTH_MODULE'))) 
    || in_array( ACTION_NAME , explode( ',', C('NOT_AUTH_ACTION')) )
    || $handle;
  // echo CONTROLLER_NAME.'-'.MODULE_NAME.'-'.ACTION_NAME."\n" ;
      if(  C('USER_AUTH_ON') && !$noAuth){
        $Rbac::saveAccessList();
        $rest = $Rbac::AccessDecision();
        // var_dump($rest); 
        $rest || $this->error('NO MISSION');
       }
      
     } 


}