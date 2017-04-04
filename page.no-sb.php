<?
	// Template Name: Page : No Sidebar
?>

<?php get_header(); ?>
<div>
	<main>
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<article>
						<h1><?php the_title(); ?></h1>
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
							
							<?php the_content(); ?>

						<?php endwhile; ?>
						<!-- post navigation -->
						<?php else: ?>
						<!-- no posts found -->
						<?php endif; ?>
					</article>
				</div>
			</div>
		</div>
	</main>
</div>
<?php get_footer(); ?>