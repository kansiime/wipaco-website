<?php
/**
 * Request a Quote page (slug: request-quote).
 */
get_header();
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/page-hero', null, array( 'lead' => 'Tell us what you need. We reply with prices and availability as quickly as possible.' ) );
	?>
	<section class="section">
		<div class="container cta-quote__grid">
			<div class="cta-quote__intro">
				<div class="prose"><?php the_content(); ?></div>
				<ul class="contact-list">
					<li><?php wipaco_icon( 'phone' ); ?><a href="<?php echo esc_attr( wipaco_tel( wipaco_contact( 'phone_1' ) ) ); ?>"><?php echo esc_html( wipaco_contact( 'phone_1' ) ); ?></a></li>
					<li><?php wipaco_icon( 'whatsapp' ); ?><a href="<?php echo esc_url( wipaco_whatsapp_url() ); ?>" target="_blank" rel="noopener">Order on WhatsApp</a></li>
					<li><?php wipaco_icon( 'mail' ); ?><a href="mailto:<?php echo esc_attr( wipaco_contact( 'email' ) ); ?>"><?php echo esc_html( wipaco_contact( 'email' ) ); ?></a></li>
				</ul>
			</div>
			<div class="card">
				<?php get_template_part( 'template-parts/quote-form' ); ?>
			</div>
		</div>
	</section>
	<?php
endwhile;
get_footer();
