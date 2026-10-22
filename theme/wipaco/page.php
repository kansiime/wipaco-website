<?php
/**
 * Default page template.
 */
get_header();
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/page-hero' );
	?>
	<section class="section">
		<div class="container prose">
			<?php the_content(); ?>
		</div>
	</section>
	<?php
endwhile;
get_footer();
