<?php
/**
 * WooCommerce pages: product catalogue, categories, product search and single products.
 */
get_header();

if ( is_product() ) :
	?>
	<section class="page-hero page-hero--slim">
		<div class="container"><?php woocommerce_breadcrumb( array( 'delimiter' => '<span class="sep">/</span>' ) ); ?></div>
	</section>
	<section class="section section--product">
		<div class="container">
			<?php woocommerce_content(); ?>
		</div>
	</section>
	<?php
else :
	$current = is_product_category() ? get_queried_object() : null;
	$lead    = $current && $current->description
		? wp_strip_all_tags( $current->description )
		: 'Quality industrial chemicals and raw materials available in Kampala. Request a quote or order on WhatsApp.';
	if ( is_search() ) {
		$title = sprintf( 'Search results for "%s"', get_search_query() );
	} else {
		$title = woocommerce_page_title( false );
	}
	get_template_part( 'template-parts/page-hero', null, array(
		'title'      => $title,
		'lead'       => esc_html( $lead ),
		'breadcrumb' => true,
	) );

	$cats = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true, 'exclude' => array( (int) get_option( 'default_product_cat' ) ) ) );
	?>
	<section class="section section--shop">
		<div class="container">
			<div class="shop-toolbar">
				<nav class="cat-pills" aria-label="Product categories">
					<a class="cat-pill<?php echo ( ! $current && ! is_search() ) ? ' is-active' : ''; ?>" href="<?php echo esc_url( wipaco_shop_url() ); ?>">All</a>
					<?php if ( ! is_wp_error( $cats ) ) : foreach ( $cats as $cat ) : ?>
						<a class="cat-pill<?php echo ( $current && $current->term_id === $cat->term_id ) ? ' is-active' : ''; ?>" href="<?php echo esc_url( get_term_link( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></a>
					<?php endforeach; endif; ?>
				</nav>
				<form class="product-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<label class="screen-reader-text" for="product-search">Search products</label>
					<?php wipaco_icon( 'search' ); ?>
					<input id="product-search" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="Search chemicals, e.g. caustic soda">
					<input type="hidden" name="post_type" value="product">
				</form>
			</div>

			<?php woocommerce_content(); ?>

			<div class="shop-help">
				<div>
					<h2>Can't find what you need?</h2>
					<p>We can source other industrial chemicals on request. Tell us what you are looking for.</p>
				</div>
				<div class="shop-help__actions">
					<a class="btn btn--primary" href="<?php echo esc_url( wipaco_quote_url( 'Other / several products' ) ); ?>">Ask for a product</a>
					<a class="btn btn--whatsapp" href="<?php echo esc_url( wipaco_whatsapp_url() ); ?>" target="_blank" rel="noopener"><?php wipaco_icon( 'whatsapp' ); ?>WhatsApp</a>
				</div>
			</div>
		</div>
	</section>
	<?php
endif;

get_footer();
