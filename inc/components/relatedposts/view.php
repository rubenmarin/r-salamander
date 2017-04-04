<div class="clearfix"></div>
<div class="on-page-related-posts is-newsfeed">
<?php
	global $post;
	$custom_fields = get_post_custom($post->ID);
	$my_custom_field = $custom_fields['relatedMetaBox'];

	if (isset($my_custom_field )):
		foreach ( $my_custom_field as $key => $value )
		if (isset($my_custom_field)) {
			echo "<div class=\"col-xs-12\"><h2>Related Posts</h2></div>";
		}
		$args = array(
			'post_type' => 'post',
			'category__and' => array( $value ),
			'posts_per_page' => 3
		);
		// the query
		$the_query = new WP_Query( $args );
		?>
		<?php if ( $the_query->have_posts() ) : ?>
	   		<!-- the loop -->
		    <?php $count = 1; ?>
		    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
				
				<div class="post-item col-xs-12 col-sm-6 col-md-4 item-<?=($count);?>">
					<?php
						$postExcerpt = wp_trim_words( $post->post_content, $num_words = 8, $more = ' [...]' );
						$postExcerpt = strip_shortcodes(  $postExcerpt );
						if(has_post_thumbnail( $post->ID )):
							echo get_the_post_thumbnail( $post->ID , 'thumbnail', $attr = array('class'=>'alignleft') );
						else:
							echo '<img width="110" height="110" src="'.get_template_directory_uri().'/images/post-thumb.jpg" class="alignleft wp-post-image">';
						endif;
					?>

					<p><?php the_title(); ?> <br> <?=($postExcerpt);?> <br> <a href="<?=(get_permalink( $post->ID ));?>">Read More</a></p>
				</div>
				<?/*?>
				<div class="rm-rpost clearfix">	
				  <div class="rm-postImg inline-block">
					  <?php if ('' != get_the_post_thumbnail() ) {?>
						  <a href="<?php the_permalink(); ?>"> <?php the_post_thumbnail(array(75,75)); ?> </a>
				    <?php } else { ?>
						 <a href="<?php the_permalink(); ?>"><img src="<?php echo $placeholder_img;?>" class="wp-post-image" width="75"></a> 
				    <?php } ?>
				  </div>
				  <div class="rm-postContent inline-block">
			      	<h4><strong><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></strong></h4>	
				  	<p>
				  		<?php $content = get_the_content(); echo wp_trim_words( $content , '20' ); ?> <a href="<?php the_permalink(); ?>">Read More</a>
				  	</p>
				  </div>
				</div> 
				<?*/?> 
			<?php $count++; ?>
			<?php endwhile; ?>
			<div class="col-xs-12">
				<p class="text-center" style="margin-top:50px;"><a class="button" href="<?=(home_url('/blog/'));?>" href="">More Articles</a></p>
			</div>
		    <!-- end of the loop -->
		    <?php wp_reset_postdata(); ?>
		<?php else: endif; ?>
	<?php endif; ?>
</div>