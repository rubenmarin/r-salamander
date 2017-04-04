<?php  
add_shortcode('clearfix' , 'sc__clearfixsc');
function sc__clearfixsc( $atts , $content = null ){
	extract( shortcode_atts( array(
		'spacer'	=> '',

	), $atts , 'clearfix' ) );
		$style = "";
		if(!empty($spacer)):
			$style = "display:inline-block;width:100%;height:{$spacer}px;";
		endif;	
		return "<div class=\"clearfix\" style=\"{$style}\"></div>";		
}
