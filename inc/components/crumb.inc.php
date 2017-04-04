<?php
//<em class=\"crumb-sep\">»</em>
function __salaciouscrumb( $settings = array() , $print = true){
	//defaults
	/*
		hometext
		crumbsep
		crumbwrap
	*/
	$settingsDefault = array('hometext'=>'Home','crumbsep'=>"<em class=\"crumb-sep\">»</em>" , 'crumbwrap' => "<p id=\"selaciousCrumb\" class=\"rm-component\">%s</p>");
	//merge default with custom
	$settings = array_merge( $settingsDefault , $settings);
	//create our array to object
	$settings = json_encode($settings);
	$settings = json_decode($settings);

	$hometext = $settings->hometext;

	$crumb = array('home'=>array());
	/* can modify through filter*/
	$crumb['home'][] = apply_filters( 'rmc/crumb/home' , $hometext , $settings );
	/* filter is used by default*/
	$crumb = apply_filters( 'rmc/crumb' , $crumb , $settings );

	$crumbString = array();
	// create a usable array of crumbs
	foreach($crumb as $crumbstack):
		foreach($crumbstack as $crumbitem):
			$crumbString[] = $crumbitem;
		endforeach;
	endforeach;
	//merge items
	$crumbString = implode( $settings->crumbsep , $crumbString );
	/* wrap items */
	$crumbString = sprintf($settings->crumbwrap , $crumbString );

	if($print == true):
		echo $crumbString; return;
	endif;
	
	return $crumbString;

}
add_filter('rmc/crumb/home' , function($hometext , $settings){
	$hometext = "<a class=\"crumb-go-home\" href=".home_url().">{$settings->hometext}</a>";
	return $hometext;
},10,2);

add_filter('rmc/crumb' , function($crumb , $settings){
	global $post , $wp_query;

	if(is_page()):
		$ancestors = get_ancestors($post->ID , 'page');
		$ancestors = array_reverse($ancestors);
		
		if(!isset($crumb['page'])): $crumb['page'] = array(); endif;
		if(!empty($ancestors)):
			foreach($ancestors as $ancestor):
				$title = get_the_title($ancestor);
				$link = get_permalink($ancestor);
				$crumb['page'][] = "<a href=\"{$link}\">{$title}</a>";
			endforeach;
		endif;
		$crumb['page'][] = "<span class=\"current-crumb-item\">".get_the_title($post->ID)."</span>";
	endif;
	if(get_post_type() =='post'):
		if(!isset($crumb['post'])): $crumb['post'] = array(); endif;
			
		if(is_single()):
			$crumb['post'][] = "<span class=\"current-crumb-item\">".get_the_title($post->ID)."</span>";
		endif;
		if(is_category() || is_archive() || is_home()):
			if(is_category()):
				$title = single_cat_title( '', false );
				$crumb['post'][] = "<span class=\"current-crumb-item\">".$title."</span>";
			elseif(is_archive()):
				$title = (isset($wp_query->query['monthnum'])) ? get_the_time('F Y') : get_the_time('Y') ;
				$crumb['post'][] = "<span class=\"current-crumb-item\">".$title."</span>";
			else:
				$crumb['post'][] = "<span class=\"current-crumb-item\">Blog</span>";
			endif;
		endif;

	endif;
	return $crumb;
},10,2);