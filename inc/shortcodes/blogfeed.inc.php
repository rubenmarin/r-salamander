<?php  
add_shortcode('blogfeed' , 'sc__blogfeed');
function sc__blogfeed( $atts , $content = null ){
	extract( shortcode_atts( array(
		'limit'		=> -1,
		'categ'		=> '',
		'exclude'	=> '',
		'tmpl' 		=> '',
		'category'  => ''

	), $atts , 'blogfeed' ) );
		ob_start();	
		$relatedArgs = array(
			'posts_per_page' => $limit,
			'post_type'		=> 'post'
		);
		
		$theposts = get_posts($relatedArgs);
		
		if(file_exists(get_template_directory()."/parts/sc-tmpl/{$tmpl}.php")):
			include get_template_directory()."/parts/sc-tmpl/{$tmpl}.php";
		$output = ob_get_contents();
		ob_end_clean();
		return $output;	
		endif;

		

		if(!empty($theposts)):
			$c = 1;
			echo '<div class="row blogfeed-imgs">';
				foreach($theposts as $thepost):
				

				?>
					<div class="col-xs-12 col-sm-4 index-<?php echo $c++;?> post-item post-itemimg post-item-<?php echo $thepost->ID;?>">
						
						<?php if( has_post_thumbnail($thepost->ID) ):?>
							<?php 
								$img = get_the_post_thumbnail( $thepost->ID , 'thumbnail' ); 
								echo "<span class=\"imgwrap\">" . $img . "</span>";
							?>
						<?php endif; ?>	
					</div>
				<?
				endforeach;
			echo '</div>';

			$c = 1;
			echo '<div class="row blogfeed-contents">';
				foreach($theposts as $thepost):
				?>
					<div class="col-xs-12 col-sm-4 index-<?php echo $c++;?> post-item post-item-<?php echo $thepost->ID;?>">

						<div class="post-item-contents">
							<?php $excerpt = wp_trim_words( $thepost->post_content , 20 , '...' ); ?>
							<?php $excerpt = strip_shortcodes(  $excerpt ); ?>
							<?php $permalink = get_permalink($thepost);?>
							<h3 class="the-post-title"><a href="<?php echo $permalink;?>"><?php echo get_the_title($thepost);?></a></h3>
							<div class="the-post-content">
								<p class="content-box"><?php echo $excerpt; ?></p>
								<p><a class="the-post-link button" href="<?php echo $permalink;?>">Read More</a></p>
							</div>
							
						</div>
					</div>
				<?php
				endforeach;
			echo '</div>';
		endif;
		$output = ob_get_contents();
		ob_end_clean();
	return $output;
}
