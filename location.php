<?php

/*
 * param
 * 
 * parent_id int default 0 for root
 * hierarchical int default 0
 * 
 * return json encode
 * example : 
 * 
 */
$_args = array();
$_args = array_merge($_args, $_POST, $_GET);

define('WP_USE_THEMES', false);
/** Loads the WordPress Environment and Template */
require('../wp-blog-header.php');
include_once( get_template_directory() . '/includes/loader.php' );
include_once( 'function.php' );

$parent_id = isset($_args['parent_id']) ? $_args['parent_id'] : 0 ;
$hierarchical = isset($_args['hierarchical']) ? $_args['hierarchical'] : 0;
$autosuggest = isset($_args['autosuggest']) ? $_args['autosuggest'] : FALSE;

$data = array();
//echo $autosuggest;
if ($hierarchical == 1) {
     $result = _recgetLocation($data, $parent_id);

}elseif($autosuggest){
	$result = getLocationAutoSuggest('',0);

}else{

    $result = _nonrecgetLocation($parent_id);


}

echo json_encode($result);



?>