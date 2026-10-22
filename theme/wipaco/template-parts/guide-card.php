<?php
/**
 * Guide (blog post) card, used inside the loop.
 */
?>
<article class="guide-card">
	<a class="guide-card__link" href="<?php the_permalink(); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'woocommerce_thumbnail', array( 'class' => 'guide-card__img', 'loading' => 'lazy' ) ); ?>
		<?php endif; ?>
		<span class="guide-card__body">
			<span class="guide-card__date"><?php echo esc_html( get_the_date() ); ?></span>
			<span class="guide-card__title"><?php the_title(); ?></span>
			<span class="guide-card__excerpt"><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></span>
			<span class="link-arrow">Read guide<?php wipaco_icon( 'arrow' ); ?></span>
		</span>
	</a>
</article>
