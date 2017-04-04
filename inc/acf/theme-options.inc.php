<?php

class rm_theme_options{
	public function __construct(){
		if( function_exists('acf_add_options_sub_page') )
		{
		    acf_add_options_sub_page(array(
		        'title' 	 => 'Theme Options',
		        'parent' 	 => 'themes.php',
		        'capability' => 'manage_options',
		        'post_id'	 => 'rm-theme-settings'
		    ));
		    
		}
	}
}
$rm_theme_options = new rm_theme_options();

function get_mythemeoption($string = null , $prefix = null){
	$parts = explode('/',$string);
	$parts = array_filter($parts);
	$parts = array_values($parts);
	$prefix = ($prefix) ? $prefix : 'rm';
	if(function_exists('get_field') && count($parts) > 0):
		$parts[0] = $prefix .'_'. $parts[0];
		$options = get_field($parts[0], "{$prefix}-theme-settings");				
		if(empty($options)) return;
		switch ($parts[0]):
			case "{$prefix}_social":	
				foreach($options as $option):
					if(isset($parts[1]) && $option['name'] == $parts[1]):
						return $option['url'];
					endif;
				endforeach;
			break;
			case "{$prefix}_wp_links":	
				foreach($options as $option):
					if(isset($parts[1]) && $option['name'] == $parts[1]):
						return $option['link'];
					endif;
				endforeach;
			break;
			case "{$prefix}_globallinks":	
				foreach($options as $option):
					if(isset($parts[1]) && $option['name'] == $parts[1]):
						return $option['link'];
					endif;
				endforeach;
			break;
			case "{$prefix}_content_types":
				foreach($options as $option):
					if(isset($parts[1]) && $option['name'] == $parts[1]):
						return (isset( $option[$option['acf_fc_layout']] )) ? $option[$option['acf_fc_layout']] : '';
					endif;
				endforeach;
			break;
		endswitch;
	endif;
	return;
}

add_shortcode('getmythemeopt',function($atts){
	extract( shortcode_atts( array(
		'option'	=> '',
	), $atts , 'getmythemeopt' ) );
	return get_mythemeoption($option);
});