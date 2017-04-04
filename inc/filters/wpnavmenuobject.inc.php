<?php 

/******************
*
* Add 'last' class to last item in 1st level navigation & 'first' to first item in 1st level
*
******************/
add_filter('wp_nav_menu_objects', function($items){
	$items[1]->classes[] = 'first';
    $items[count($items)]->classes[] = 'last';
    return $items;
});