<?php




function explode_arr( $node_id ){
		return explode( '_' , $node_id);
	}

function version() {
	return '1.0';
}


/*function getParentsName( $categorys , $category ) {
	$databack = array();
	if( $category['pid']==0 ) return $category;
	// my_log( 'categorys' , json_encode($categorys) );
	foreach ($categorys as $key => $value) {
		if( $category['pid'] == $value['id'] ){
			$category['parent'] = getParentsName( $categorys , $value);
			// $category['parent'] = $value;
			my_log('category' , json_encode($category));
			$databack[] = $category;
		}
	}

	// return json_encode($databack);
}*/

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


?>