<?php
/**
 * Fallback template (blog posts, archives, general search).
 */
get_header();
get_template_part( 'template-parts/page-hero', null, array(
	'title' => is_search() ? sprintf( 'Search results for "%s"', get_search_query() ) : ( is_home() ? 'News & Updates' : wp_strip_all_tags( get_the_archive_title() ) ),
) );
?>
<section class="section">
	<div class="container prose">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article class="post-summary">
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php is_singular() ? the_content() : the_excerpt(); ?>
				</article>
			<?php endwhile; ?>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p>Nothing found. Try our <a href="<?php echo esc_url( wipaco_shop_url() ); ?>">product catalogue</a>.</p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
