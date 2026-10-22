<?php
/**
 * Guides (blog) listing.
 */
get_header();
get_template_part( 'template-parts/page-hero', null, array(
	'title' => get_the_title( (int) get_option( 'page_for_posts' ) ) ?: 'Guides',
	'lead'  => 'Practical guides on using, choosing and safely handling industrial chemicals.',
) );
?>
<section class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="guide-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/guide-card' );
				endwhile;
				?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p>New guides are coming soon.</p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
