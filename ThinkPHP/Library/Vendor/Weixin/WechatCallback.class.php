<?php

define('TOKEN','pengzhengrong');
Class WechatCallback {
	
	Public function valid() {
		if( $this->checkSignature() ) {
			ob_clean();
			$echoStr = $_GET['echostr'];
			echo $echoStr;
			exit;
		}
	}

	private function checkSignature()
	{
		$signature = $_GET["signature"];
		$timestamp = $_GET["timestamp"];
		$nonce = $_GET["nonce"];

		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}

}