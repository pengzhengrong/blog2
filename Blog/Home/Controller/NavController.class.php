<?php

namespace Home\Controller;
use Think\Controller;

Class NavController extends CommonController {

	public function index() {
		$name = C('NAVIGATION')=='en_name' ? 'en_name' : 'zn_name';
		$field = array('id','pid',$name);
		$rest = M('navigation')->field( $field )->order( 'sort' )->select();
		$this->rest = node_merge( $rest );
		// p($this->rest); die;
		$this->name = $name;
		$this->display();
	}

	public function add() {
		if( IS_POST ) {
			$data = array(
				'en_name' => I('en_name'),
				'zn_name' => I('zn_name'),
				'color' => I('color'),
				'url' => I('url'),
				'level' => I('level',1,'intval'),
				'pid' => I('pid' , 0 ,'intval'),
				'sort' => I('sort')
				);
			$rest = M('navigation')->data($data)->add();
			$rest || $this->error( 'INSERT ERROR' );
			$this->redirect( 'index' ) ;
			return;
		}
		$this->pid = I('pid');
		$this->level = I('level');
		$this->display();
	}

	public function edit() {
		if( IS_POST ){
			$rest = M('navigation')->save( I('post.') );
			$rest || $this->error( 'UPDATE FAILED' );
			$this->redirect( 'index' ) ;
			return;
		}
		$this->rest = M('navigation')->find( I('id') );
		$this->display();
	}

	public function delete() {
		$rest = M('navigation')->delete( I('id') );
		$rest || $this->error( 'DELETE FAILED' );
		$this->redirect( 'index' ) ;
	}



}