<?php
/**
 * Product List (slug: product-list). Always up to date with the catalogue;
 * "Download PDF" uses the browser's Save as PDF, styled by the print CSS.
 */
get_header();
$products = wc_get_products( array( 'status' => 'publish', 'limit' => -1, 'orderby' => 'menu_order title', 'order' => 'ASC' ) );
$by_cat   = array();
foreach ( $products as $product ) {
	$term  = wipaco_primary_cat( $product->get_id() );
	$cat   = $term ? $term->name : 'Other';
	$by_cat[ $cat ][] = $product;
}
ksort( $by_cat );
?>
<section class="page-hero no-print">
	<div class="container">
		<h1 class="page-hero__title"><?php the_title(); ?></h1>
		<p class="page-hero__lead">All our products on one page. Save it as a PDF or print it for your purchasing team.</p>
		<p class="hero__actions" style="margin-top:22px">
			<button class="btn btn--accent btn--lg" type="button" data-print><?php wipaco_icon( 'package' ); ?>Download PDF / Print</button>
		</p>
	</div>
</section>

<section class="section product-list">
	<div class="container">
		<header class="print-only product-list__head">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo.png' ); ?>" alt="Wipaco Investiments Limited" width="1300" height="480">
			<div>
				<strong>Product List &middot; <?php echo esc_html( wp_date( 'F Y' ) ); ?></strong><br>
				<?php echo esc_html( wipaco_contact( 'address' ) ); ?><br>
				Tel: <?php echo esc_html( implode( ' / ', array_filter( array( wipaco_contact( 'phone_1' ), wipaco_contact( 'phone_2' ) ) ) ) ); ?> &middot; WhatsApp: <?php echo esc_html( wipaco_whatsapp_display() ); ?> &middot; <?php echo esc_html( wipaco_contact( 'email' ) ); ?>
			</div>
		</header>

		<?php foreach ( $by_cat as $cat => $items ) : ?>
			<h2 class="product-list__cat"><?php echo esc_html( $cat ); ?></h2>
			<table class="product-table">
				<thead><tr><th>Product</th><th>Details</th><th>Price</th></tr></thead>
				<tbody>
					<?php foreach ( $items as $product ) : ?>
						<tr>
							<td><a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a></td>
							<td>
								<?php
								// Short description is a <ul> of specs: show them as one line each.
								preg_match_all( '#<li>(.*?)</li>#s', $product->get_short_description(), $specs );
								$lines = $specs[1] ?: array( $product->get_short_description() );
								echo wp_kses( implode( '<br>', array_map( fn( $s ) => wp_kses( $s, array( 'strong' => array(), 'sub' => array() ) ), $lines ) ), array( 'br' => array(), 'strong' => array(), 'sub' => array() ) );
								?>
							</td>
							<td><?php echo $product->get_price() !== '' ? wp_kses_post( wc_price( $product->get_price() ) ) : 'On request'; ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endforeach; ?>

		<p class="product-list__note">Prices and availability change - contact us for a current quotation. WhatsApp: <?php echo esc_html( wipaco_whatsapp_display() ); ?> &middot; <?php echo esc_html( preg_replace( '#^https?://#', '', home_url() ) ); ?></p>
	</div>
</section>
<?php
get_footer();
