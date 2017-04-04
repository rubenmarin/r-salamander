<?php

function getThemeDirUrl($dir = null){
	$dir = (empty($dir)) ? dirname(__FILE__) : $dir ;
	preg_match('/\/theme(.*)/i' , $dir , $m);
	$currentPathUrl = content_url() . $m[0];
	return $currentPathUrl;
}

/**
*
* Convert an object to an array
*
* @param     object  $object The object to convert
* @reeturn   array
* @url       http://www.phpro.org/examples/Convert-Object-To-Array-With-PHP.html
*
*/
function objectToArray( $object ) {
    if( !is_object( $object ) && !is_array( $object ) ) {return $object; }
    if( is_object( $object ) ) { $object = get_object_vars( $object ); }
    return array_map( 'objectToArray', $object );
}

/**
*	Function to recursively include all files in a director
**/
function theFunctionRecurse( $dir = '' ){
	$directory = new RecursiveDirectoryIterator( $dir );
	$iterator = new RecursiveIteratorIterator($directory);
	$Regex = new RegexIterator($iterator, "/\.inc\.php|\.custom\.php/i", RecursiveRegexIterator::MATCH);
	foreach( $Regex as $filepath => $object ):
		include $filepath;
	endforeach;
}
/**
 * Recurses through the 'includes' folder and auto includes files that match the regex '.inc.php'
 * recurse function is in rm-functions.php
 **/
theFunctionRecurse( __DIR__ );

	
/**
 * Register template URL and use in js files
 * Use like: background-image: url('+rm_data.templateDirectoryUri+'/images/dd-meet-our-team.jpg)
 */
function rm_data_array(){
	$theme = wp_get_theme();
	$data = array( 
		'siteurl' => rtrim( site_url() , '/') ,
		'themename'	=> $theme['Template'] ,
		'tmpldiruri' => TMPL_DIR_URI,
	);	
	return $data;
}

/**
*	can be used in template parts to include other files within the theme
**/
function get_file_from_theme($file = ''){
	if(file_exists(dirname(__FILE__) .'/' .$file)){
		return dirname(__FILE__) .'/' .$file;
	}
}


/*=========================================================== 
	CLEAN URI / SLUG [!important]
	# used in  : check_url , bodyClass , check_existence
=============================================================*/
function clean_uri(){
	$ex = preg_replace('(^https?://)', '', get_bloginfo('url') ); // removes 'http(s)' from url
	$ex = preg_replace('/www./i' , '' , $ex ); // remove 'www.' from url
	$output = explode('/' , preg_replace( '(^'.$ex.')' , '' , preg_replace( '/www./i' , '' , $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ) ) ); //clean URI / SLUG
	return $output;
}





/******************** DEPRECATED : replaced by wordpress filter 'body_class'
* Add the slug segments as body classes on inside pages
* last - modified [ruben]
* #note : tested on dev  = Working
* #note : tested on live = Working
* no longer including the ID option
*********************/
function bodyClass( $active_home_id = '' , $home_name = '' , $new_classes = '' , $override = FALSE ) {
	$current = array_values( array_filter( clean_uri() ) ); // remove empty arrays at the beginning and end [removes any array that is empty] , then reset the index [0]
	$home_name =  ( !empty($home_name) ) ? $home_name : 'home';
	global $post;
	$parent_page = ( $post->post_parent ) ? $post->post_parent : $post->ID;

	$classes = array();
	$classes[] = (is_front_page()) ? $home_name : 'inside';

	foreach($current as $slug):
	$classes[] = ($slug != '') ? $slug : '';
	endforeach;
	if( is_page() || is_single() ): $classes[] = get_post_type().'-'.get_the_ID(); endif;
	/* this can also be used for inside page headers css vs php */
	if($parent_page): $classes[] = 'parent-'.$parent_page; endif;
	if( is_404() ): $classes[] = 'page-404'; endif;
	if( get_post_type() == 'post'): $classes[] = 'post from-blog'; else: /*to style everything else but the blog*/ $classes[] = 'not-blog'; endif;
	if( this_is('gallery')): $classes[] = 'rmgallery'; else: /* to style everything else but the rmgallery */ $classes[] = 'not-rmgallery'; endif;
	if( this_is('gallery-child')): $classes[] = 'rmgallery-child'; endif;
	if( is_page() ): $classes[] = 'is-page'; endif;
	global $template,$post; 
	$templateType = basename($template , ".php");
	$templateType = 'tmpl_type_' . preg_replace('/(\.|_|-)/i', '_' , $templateType);
	$classes[] = $templateType;
	/*
	for if whatever reason you wanted to include a class / classes from within your own function
	example
	function new_body_classes(){
		// YOUR SUPER SPECIAL CODE HERE
		ob_start();
			echo $class;
		return ob_get_clean();
	}
	bodyClass($active_home_id , $home_name  , $extra_class = 'new_body_classes');

	*/
	if($override == TRUE ){
		$classes = ( is_callable($new_classes) ) ? call_user_func($new_classes , $classes) : '' ;
	}
	else{
		$classes[] = ( is_callable($new_classes) ) ? call_user_func($new_classes , $classes) : '' ; // testing this out
	}


  echo '<body class="'.join(' ' , $classes).'">';
} /* end */


/**
 * Hide the admin bar when logged in
 *
 */







