<?php

namespace Admin\Widget;
use Think\Controller;

Class CommentWidget  extends Controller {

	public  function unlimitComments( $comment ) {
		foreach ($comment as  $k=>$v) {
			$id = $v['id'];
			$pid = $v['pid'];
			// $padding_left = 'padding-left:'.($k+1)*15 .'px';
			if( $pid==0 ){
				$floor =  '<span class="iconfont">&#xe608;</span>';
				echo " <font  color='".fontColor()."'>";
			}else{
				$floor = '<span class="iconfont">&#xe60d;</span>';
				echo "<div style='display:none;$padding_left;'  class='comment_{$pid}'>";
				echo '<hr style="height:1px;border:none;border-top:1px dashed #0066CC;" />';
			}
			echo "<li>";
			echo ($k+1).$floor.'    '.$v['username'].'    '.date('Y-m-d H:i',$v['created']);
			echo '<p>'.$v['content'].'</p>';
			// if( $v['child'] ){
			echo "<span onclick='showComment({$id})'  title='show' class='fa'><span class='iconfont'>&#xe606;</span>(".count($v['child']).")</span> ";
			// }
			//ding
			echo '<span class="iconfont" title="顶" onclick="vote_comment('.$id.',1)">&#xe60a;('.$v['top_num'].')</span>  ';
			//cai
			echo '<span class="iconfont" title="踩" onclick="vote_comment('.$id.',-1)">&#xe609;('.$v['base_num'].')</span>  ';
			//huifu
			echo '<span id="'.$id.'" title="'.$v['username'].'"  class="reply iconfont">&#xe607;</span>';
			echo "</li>";
			if( $v['child'] ){
				$this->unlimitComments( $v['child'] );
			}
			if( $pid==0 )
				{echo "</font>";echo '<hr style="">';}
			else
				{echo "</div>";}
		}
		
	}
}