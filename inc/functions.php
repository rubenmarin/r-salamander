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




