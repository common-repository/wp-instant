<?php

	header('Content-Type: text/html; charset=utf-8');
	
	if(file_exists(STYLESHEETPATH.'/wp-instant-search-template.php')){
		$search_template = STYLESHEETPATH.'/wp-instant-search-template.php';
	} elseif(file_exists(TEMPLATEPATH.'/wp-instant-search-template.php')){
		$search_template = TEMPLATEPATH.'/wp-instant-search-template.php';
	} else {
		$search_template = WP_INSTANT_DIR.'wp-instant-search-template.php';
	}
	
	$choices = get_option('wp_instant_choices');
	if(empty($choices)) $choices = 10;
		
	query_posts('s='.$_REQUEST['s'].'&showposts='.$choices.'&post_status=publish');
		
	require_once($search_template);
	
?>