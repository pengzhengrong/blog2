<?php


function baiduAccount(){
	echo '<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?e58ba1963b5a50dd007b97734b0dbfd8";
  var s = document.getElementsByTagName("script")[0];
  s.parentNode.insertBefore(hm, s);
})();
</script>
';
}

function node_merge ( $node , $access = null , $pid=0) {

	$arr  = array();
	foreach ($node as $key => $value) {
		if( is_array( $access )){
			$value['access'] = in_array($value['id'], $access )?1:0;
		}
		if( $value['pid'] == $pid ){
			$value['child'] = node_merge( $node , $access ,$value['id'] );
			$arr[] = $value;
		}
	}
	return $arr;
}


function  p( $param ) {

	if( is_array( $param )){
		dump( $param );
		return;
	}
	echo $param."<br />";

}

function my_log( $key='' , $value=null ) {
	$value = empty($value)?$key:$value;
	@error_log( "\n $key=".$value  ,3 , '/tmp/pzrlog.log');
}

/**
@param $arr
@param $id
*/
function getChildrens( $arr , $id ){
	$databack = $id;
	foreach ($arr as $key => $value) {
		if( $value['pid'] == $id ){
			$databack .=  ','.getChildrens( $arr , $value['id'] );
		}
	}
	return $databack;
}

function getSearch( $rest ,$fields, $key='hits'){

	$databack = array();
	$rest = $rest[$key];
	// P($rest);die;
	if( $key == 'hits' ){
		foreach ($rest['hits'] as  $k=>$v) {
			foreach ($fields as $kk=>$vv) {
				if( strpos($vv,'_') === 0){
					$databack[$k][$kk] = $v[$vv];
				}elseif( $kk=='highlight' ){
					$databack[$k][$kk] = $v[$vv];
				}else{
					$databack[$k][$kk] = $v['fields'][$vv][0];
				}
			}
		}
	}
	// P($databack);die;
	return $databack;
}

function cutHighlightContent( $content ,$len = 100){
	// p($content);
	// $content = '<em>hello</em>';
	// $content = preg_replace('/.*?(<em>.*?<\/em>\S{20}).*/', '$1...' ,$content);
	$mb_len = mb_detect_encoding($content) == 'UTF-8' ? 2 : 1;
	// $content = preg_replace('/[\s\S]*(<em>.*?<\/em>[\s\S]{20})[\s\S]*/', '$1...' ,$content);
	$content = preg_replace('/[\s\S]*(<em>.*?<\/em>([\x00-\x7f]|[\x80-\xff].{' . $mb_len . '}){'.$len.'})[\s\S]*/', '$1...' ,$content);
	// p($content);die;
	return $content;
}

function logger($msg , $file='blog.log') {
	\Think\Log::write($msg,'INFO','File','/home/pzr/workspace/blog/log/'.$file);
}

