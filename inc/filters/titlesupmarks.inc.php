<?php

/**
* FILTERING : wraps ® , ™ , © in <sup></sup>
* the_excerpt , the_title , wp_list_pages , the_content
*/
function wpFilterMarks($data){
	$data = preg_replace('/(®|&reg;|™|&trade;|©|&copy;)/i', "<sup>$1</sup>", $data);
	return $data;
}
// to prevent double wrapping
function wpFilterMarksTitle($data){
	if(!preg_match('/<sup>(®|&reg;|™|&trade;|©|&copy;)/i', $data)){
		$data = preg_replace('/(®|&reg;|™|&trade;|©|&copy;)/i', "<sup>$1</sup>", $data);
	}
	return $data;
}

if(!is_admin()):
	add_filter('wp_list_pages', 'wpFilterMarksTitle');
	add_filter('the_title', 'wpFilterMarksTitle');
	add_filter('the_excerpt', 'wpFilterMarks');
	add_filter('the_content', 'wpFilterMarks');
endif;
