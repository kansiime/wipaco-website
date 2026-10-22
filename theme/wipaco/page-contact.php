<?php
/**
 * Contact page (slug: contact).
 */
get_header();
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/page-hero', null, array( 'lead' => 'Call, WhatsApp, email or visit our shop on Johnson Street, Kampala.' ) );
	$other = array_filter( array_map( 'trim', explode( ',', wipaco_contact( 'other_phones' ) ) ) );
	?>
	<section class="section">
		<div class="container contact-grid">
			<div class="contact-cards">
				<div class="contact-card">
					<span class="feature__icon"><?php wipaco_icon( 'pin' ); ?></span>
					<div><h2>Visit us</h2><p><?php echo esc_html( wipaco_contact( 'address' ) ); ?></p></div>
				</div>
				<div class="contact-card">
					<span class="feature__icon"><?php wipaco_icon( 'phone' ); ?></span>
					<div>
						<h2>Call us</h2>
						<p>
							<a href="<?php echo esc_attr( wipaco_tel( wipaco_contact( 'phone_1' ) ) ); ?>"><?php echo esc_html( wipaco_contact( 'phone_1' ) ); ?></a>
							<?php if ( wipaco_contact( 'phone_2' ) ) : ?>
								<br><a href="<?php echo esc_attr( wipaco_tel( wipaco_contact( 'phone_2' ) ) ); ?>"><?php echo esc_html( wipaco_contact( 'phone_2' ) ); ?></a>
							<?php endif; ?>
							<?php foreach ( $other as $phone ) : ?>
								<br><a href="<?php echo esc_attr( wipaco_tel( $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
							<?php endforeach; ?>
						</p>
					</div>
				</div>
				<div class="contact-card">
					<span class="feature__icon feature__icon--green"><?php wipaco_icon( 'whatsapp' ); ?></span>
					<div><h2>WhatsApp</h2><p><a href="<?php echo esc_url( wipaco_whatsapp_url() ); ?>" target="_blank" rel="noopener"><?php echo esc_html( wipaco_whatsapp_display() ); ?></a></p></div>
				</div>
				<div class="contact-card">
					<span class="feature__icon"><?php wipaco_icon( 'mail' ); ?></span>
					<div><h2>Email</h2><p><a href="mailto:<?php echo esc_attr( wipaco_contact( 'email' ) ); ?>"><?php echo esc_html( wipaco_contact( 'email' ) ); ?></a></p></div>
				</div>
				<?php if ( wipaco_contact( 'hours' ) ) : ?>
					<div class="contact-card">
						<span class="feature__icon"><?php wipaco_icon( 'clock' ); ?></span>
						<div><h2>Opening hours</h2><p><?php echo esc_html( wipaco_contact( 'hours' ) ); ?></p></div>
					</div>
				<?php endif; ?>
			</div>

			<div class="card">
				<h2 class="card__title">Send us a message</h2>
				<?php get_template_part( 'template-parts/quote-form' ); ?>
			</div>
		</div>
	</section>

	<section class="map">
		<iframe title="Map to Wipaco Investiments, TransNile Link Building, Johnson Street, Kampala" src="https://maps.google.com/maps?q=<?php echo rawurlencode( 'TransNile Link Building, Johnson Street, Kampala, Uganda' ); ?>&amp;z=17&amp;output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
	</section>
	<?php
endwhile;
get_footer();
