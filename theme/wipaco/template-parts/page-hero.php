<?php
/**
 * Page title banner. $args: title, lead (optional), breadcrumb (bool).
 */
?>
<section class="page-hero">
	<div class="container">
		<?php
		if ( ! empty( $args['breadcrumb'] ) && function_exists( 'woocommerce_breadcrumb' ) ) {
			woocommerce_breadcrumb( array( 'delimiter' => '<span class="sep">/</span>' ) );
		}
		?>
		<h1 class="page-hero__title"><?php echo esc_html( $args['title'] ?? get_the_title() ); ?></h1>
		<?php if ( ! empty( $args['lead'] ) ) : ?>
			<p class="page-hero__lead"><?php echo wp_kses_post( $args['lead'] ); ?></p>
		<?php endif; ?>
	</div>
</section>
