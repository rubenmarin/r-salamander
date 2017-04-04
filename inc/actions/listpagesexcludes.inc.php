<?php

/*404 EXCLUDE UPDATES WP LIST PAGES WITH SQL ID ARRAY BY TITLE RATHER THAN USING EXCLUDE=1,2,3...*/
add_filter('wp_list_pages_excludes','page_filter');
function page_filter($exclude_array) {
	global $wpdb;
	$table = "wp_posts";
	$sql = "SELECT ID FROM ".$table." WHERE post_title ='Responder' OR post_title LIKE '%Landing%' OR post_title LIKE '%Review%' OR post_title LIKE '%giveaway%' OR post_title LIKE '%Contest%' OR post_title LIKE '%facebook%' OR post_title LIKE '%reviews%' OR post_title LIKE '%phone%'";
	$id_array = $wpdb->get_col($sql);
	$exclude_array=array_merge($id_array, $exclude_array);
	return $exclude_array;
}