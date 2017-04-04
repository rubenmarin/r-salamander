<?php

add_action( 'admin_enqueue_scripts', '__mediaUploadExtended' );
function  __mediaUploadExtended($screen){

	global $current_screen;
	if( $current_screen->base != 'post' ) return;
		$assetsJs = get_template_directory_uri() . '/inc/js';
		$assetsCss = get_template_directory_uri() . '/inc/css';
		wp_register_script( $handle = 'mediauploadextended', $src = $assetsJs . '/extended-uploader.js', $deps = array('jquery') , $ver = '1', $in_footer = true );
		wp_enqueue_script( $handle = 'mediauploadextended' );
		wp_register_style( $handle = 'mediauploadextended' , $src = $assetsCss . '/extended-uploader.css' , $deps = array(), $ver = '1', $media = 'all' );
		wp_enqueue_style( $handle = 'mediauploadextended' );

}