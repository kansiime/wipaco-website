</main>

<footer class="site-footer">
	<div class="container site-footer__grid">
		<div class="site-footer__about">
			<img class="site-footer__logo" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo.webp' ); ?>" alt="Wipaco Investiments Limited" width="600" height="222" loading="lazy">
			<p>Supplier of quality industrial chemicals and manufacturing raw materials in Kampala, Uganda.</p>
			<?php
			$socials = array_filter( array(
				'Facebook'  => wipaco_contact( 'facebook' ),
				'Instagram' => wipaco_contact( 'instagram' ),
				'TikTok'    => wipaco_contact( 'tiktok' ),
			) );
			if ( $socials ) :
				?>
				<p class="site-footer__social">
					<?php foreach ( $socials as $label => $url ) : ?>
						<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $label ); ?></a>
					<?php endforeach; ?>
				</p>
			<?php endif; ?>
		</div>

		<div>
			<h2 class="site-footer__heading">Products</h2>
			<ul class="site-footer__links">
				<?php
				$cats = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true, 'exclude' => array( (int) get_option( 'default_product_cat' ) ) ) );
				if ( ! is_wp_error( $cats ) ) {
					foreach ( $cats as $cat ) {
						printf( '<li><a href="%s">%s</a></li>', esc_url( get_term_link( $cat ) ), esc_html( $cat->name ) );
					}
				}
				?>
				<li><a href="<?php echo esc_url( wipaco_shop_url() ); ?>">All products</a></li>
			</ul>
		</div>

		<div>
			<h2 class="site-footer__heading">Company</h2>
			<ul class="site-footer__links">
				<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About Us</a></li>
				<li><a href="<?php echo esc_url( home_url( '/guides/' ) ); ?>">Guides</a></li>
				<li><a href="<?php echo esc_url( home_url( '/product-list/' ) ); ?>">Product List (PDF)</a></li>
				<li><a href="<?php echo esc_url( wipaco_quote_url() ); ?>">Request a Quote</a></li>
				<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact Us</a></li>
				<?php if ( get_privacy_policy_url() ) : ?>
					<li><a href="<?php echo esc_url( get_privacy_policy_url() ); ?>">Privacy Policy</a></li>
				<?php endif; ?>
			</ul>
		</div>

		<div>
			<h2 class="site-footer__heading">Contact</h2>
			<ul class="site-footer__contact">
				<li><?php wipaco_icon( 'pin' ); ?><span><?php echo esc_html( wipaco_contact( 'address' ) ); ?></span></li>
				<li><?php wipaco_icon( 'phone' ); ?><span>
					<a href="<?php echo esc_attr( wipaco_tel( wipaco_contact( 'phone_1' ) ) ); ?>"><?php echo esc_html( wipaco_contact( 'phone_1' ) ); ?></a>
					<?php if ( wipaco_contact( 'phone_2' ) ) : ?>
						<br><a href="<?php echo esc_attr( wipaco_tel( wipaco_contact( 'phone_2' ) ) ); ?>"><?php echo esc_html( wipaco_contact( 'phone_2' ) ); ?></a>
					<?php endif; ?>
				</span></li>
				<li><?php wipaco_icon( 'whatsapp' ); ?><a href="<?php echo esc_url( wipaco_whatsapp_url() ); ?>" target="_blank" rel="noopener">WhatsApp <?php echo esc_html( wipaco_whatsapp_display() ); ?></a></li>
				<li><?php wipaco_icon( 'mail' ); ?><a href="mailto:<?php echo esc_attr( wipaco_contact( 'email' ) ); ?>"><?php echo esc_html( wipaco_contact( 'email' ) ); ?></a></li>
				<?php if ( wipaco_contact( 'hours' ) ) : ?>
					<li><?php wipaco_icon( 'clock' ); ?><span><?php echo esc_html( wipaco_contact( 'hours' ) ); ?></span></li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
	<div class="site-footer__bottom">
		<div class="container">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Wipaco Investiments Limited. All rights reserved.</div>
	</div>
</footer>

<a class="whatsapp-float" href="<?php echo esc_url( wipaco_whatsapp_url() ); ?>" target="_blank" rel="noopener" aria-label="Chat with us on WhatsApp">
	<?php wipaco_icon( 'whatsapp' ); ?><span>Chat on WhatsApp</span>
</a>

<?php wp_footer(); ?>
</body>
</html>
