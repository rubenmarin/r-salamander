<?php

/**
 * Use like: [bloginfo key='url']
 */

function digwp_bloginfo_shortcode( $atts ) {
	extract(shortcode_atts(array(
		'key' => '',
	), $atts));
	return get_bloginfo($key);
}

add_shortcode('bloginfo', 'digwp_bloginfo_shortcode');