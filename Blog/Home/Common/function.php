<?php

function explode_arr( $node_id ){
	return explode( '_' , $node_id);
}

function version() {
	return '1.0';
}

function getParentsName( $categorys , $category ) {
	// $databack[] = $category;
	$databack = $category['title'];
	if( $category['pid']==0 ) return $category['title'];
	foreach ($categorys as $key => $value) {
		if( $category['pid'] == $value['id'] ){
			getParentsName( $categorys , $value);
			// $databack[] = $value;
			$databack = $value['title'].' => '. $databack;
		}
	}
	
	// return json_encode($databack);
	return $databack;
}

function notice( $msg='' , $jumpUrl='' , $waitSecond=0 ){
	if( empty($msg) ) $msg='Notice';
	if(I('_notice_')==1 ) return;
	if( empty($jumpUrl) ){
		$jumpUrl = __SELF__;
		if(   ($pos = strpos( __SELF__,  C('TMPL_TEMPLATE_SUFFIX') )) ){
			$jumpUrl =  substr( __SELF__, 0 ,$pos);
		}
	}
	// echo T('Common/notice','Tpl'); die;
	include  T('Common/notice','Tpl');
	exit;
}

function fixedSubmit(){
	return '<div class="fixed-bottom" >
			<div class="fixed-bottom fixed-but">
				<input   type="submit" value="SUBMIT" />
			</div>
		</div>';
}

