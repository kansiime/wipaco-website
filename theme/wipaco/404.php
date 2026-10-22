<?php
/**
 * Page not found.
 */
get_header();
get_template_part( 'template-parts/page-hero', null, array(
	'title' => 'Page not found',
	'lead'  => 'The page you are looking for may have moved. Try our products or contact us.',
) );
?>
<section class="section">
	<div class="container hero__actions">
		<a class="btn btn--primary btn--lg" href="<?php echo esc_url( wipaco_shop_url() ); ?>">View Products</a>
		<a class="btn btn--whatsapp btn--lg" href="<?php echo esc_url( wipaco_whatsapp_url() ); ?>" target="_blank" rel="noopener"><?php wipaco_icon( 'whatsapp' ); ?>WhatsApp Us</a>
	</div>
</section>
<?php
get_footer();
