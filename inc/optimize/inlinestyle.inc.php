<?php

add_filter('style_loader_tag' , function( $tag , $handle , $src ){
	global $wp_version;
	if($wp_version >= '4.1.0'):
		if(!preg_match('/<!--/i' , $tag )):
				$homeurl  = apply_filters('removefromurl/protocol-www' , home_url() );
				$cleansrc = apply_filters('removefromurl/protocol-www-query' , $src );
				$regexurl = preg_replace('/\//i' , '\/' , $homeurl );
				if(preg_match("/$regexurl/" , $cleansrc )):
					$cleansrc = preg_replace("/$regexurl/" , '' , $cleansrc );
					$filepath = rtrim(ABSPATH , '/') .'/'. ltrim($cleansrc , '/');
					if(file_exists($filepath)):
						$inlinetag = apply_filters('inline/css' , $tag , $handle  , $src );
						
						if(!preg_match('/<link/i' , $inlinetag )):
							return $inlinetag;
						endif;	
					endif;
				endif;
			return $tag;
		endif;
	endif;
	return $tag;
}, 100 , 3);