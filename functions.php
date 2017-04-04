<?php

if( !defined('TMPL_DIR')):
	define('TMPL_DIR' , get_template_directory() );
endif;
if( !defined('TMPL_DIR_URI')):
	define('TMPL_DIR_URI' , get_template_directory_uri() );
endif;

/**
*	rm-functions.php must be included before anything else
**/
include TMPL_DIR . '/inc/functions.php';

/* NAV WALKER */
if(file_exists(TMPL_DIR . '/inc/walkers/walkerpagecustom.php')):
	include TMPL_DIR . '/inc/walkers/walkerpagecustom.php';
endif;


function __themesetup(){
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	/**
	 * Add thumbnail functionality
	 */
	add_theme_support('post-thumbnails');	

}
add_action( 'after_setup_theme', '__themesetup' );

function __themescripts(){
	global $wp_scripts;
	
	/* CSS */
	wp_register_style( 'fancybx' , TMPL_DIR_URI . '/js/libs/fancybox/jquery.fancybox.css' , '' , '1' );
	wp_register_style( 'fontawesome' , TMPL_DIR_URI . '/vendor/fontawesome/css/font-awesome.css' , '' , '1' );
	wp_register_style( 'rmtheme' , get_stylesheet_uri() , array('fancybx','fontawesome') , '1' );
	wp_enqueue_style( 'rmtheme' );

	/* JAVASCRIPT */
	wp_deregister_script('jquery');
	wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js", false, "2.1.3", true);
	wp_register_script( 'modernizr', TMPL_DIR_URI . '/js/libs/modernizr.min.js', false, '2.8.3', false );
	wp_register_script('theme-js', TMPL_DIR_URI . '/js/theme.js', array('jquery','modernizr'), '1.0', true );
	wp_enqueue_script( 'theme-js');
}
add_action('wp_enqueue_scripts','__themescripts');



/************************* 
	Your Custom Code Below
*************************/

add_filter('inline/css' , function($tag = null ,$handle = null ,$src = null){
	
	if( !in_array($_SERVER['HTTP_HOST'] , array('rosemontdev.com','rubenito.co'))):
		/* 
			RUN ONLY ON LIVE (not dev)
		*/
		if($handle == 'rmtheme'):
			$newtag = miniCSS::file( 'style.css' , array('echo'=>false));		
		endif;
		if($handle == 'fancybx'):
			$newtag = miniCSS::file( '/js/libs/fancybox/jquery.fancybox.css' , array('echo'=>false));	
		endif;
		if($handle == 'fontawesome'):
			$newtag = miniCSS::file( '/vendor/fontawesome/css/font-awesome.css' , array(
				'echo'=>false,
				'default_searchreplace' => false,
				'regex' => array(
				array(
					'search' => '/\.\./i',
					'replacewith' => get_template_directory_uri() . '/fonts/fontawesome'
				))
			));	
		endif;
		if(!empty($newtag)):
			return $newtag;
		endif;
	endif;
	return $tag;
},1,3);


/* 
	WALKER: has-child append to 'a'
*/

// add_filter('walkernavmenu/startel/has_child',function($html){
// 	// $svg = '';
// 	// ob_start();
// 	// 	$file = get_template_directory() . '/images/svg/arrow.svg';
// 	// 	if(file_exists($file)): include $file; endif;
// 	// $svg = ob_get_contents();
// 	// ob_end_clean();
// 	$html = '<span class="toggle-sub-menu"><i>></i></span>';
// 	return $html;
// });



// add_filter('script_loader_tag' , function( $tag , $handle , $src ){
// 	global $wp_version;
// 	if($wp_version >= '4.1.0'):
// 		if(!preg_match('/<!--/i' , $tag )):
// 				$homeurl  = apply_filters('removefromurl/protocol-www' , home_url() );
// 				$cleansrc = apply_filters('removefromurl/protocol-www-query' , $src );
// 				$regexurl = preg_replace('/\//i' , '\/' , $homeurl );
// 				if(preg_match("/$regexurl/" , $cleansrc )):
// 					$cleansrc = preg_replace("/$regexurl/" , '' , $cleansrc );
// 					$filepath = rtrim(ABSPATH , '/') .'/'. ltrim($cleansrc , '/');
// 					if(file_exists($filepath)):
// 						/* 
// 							rm_cookie , rm_scripts 
// 						*/
// 						//echo $handle;
// 						// if(in_array( $handle , array('core_scripts'))):
// 						// 	if(!is_admin()):
// 						// 		$filecontents = file_get_contents($filepath);
// 						// 		$newtag = "<script class=\"inlinejs_{$handle}\">{$filecontents}</script>";
// 						// 		return $newtag;
// 						// 	endif;
// 						// endif;
					
// 					endif;
// 				endif;
// 			return $tag;
// 		endif;
// 	endif;
// 	return $tag;
// }, 100 , 3);