<?php
/**
 * Home page.
 */
get_header();
$img = get_template_directory_uri() . '/assets/img/';
?>

<section class="hero" style="--hero-img: url('<?php echo esc_url( $img . 'hero-drums.webp' ); ?>')">
	<div class="container hero__inner">
		<p class="eyebrow eyebrow--light">Wipaco Investiments Limited</p>
		<h1 class="hero__title">Industrial Chemicals Supplier in Kampala, Uganda</h1>
		<p class="hero__lead">Caustic soda, LABSA, SLES, soda ash, chlorine, acids, waxes and other raw materials for soap &amp; detergent makers, manufacturers and water treatment across Uganda.</p>
		<div class="hero__actions">
			<a class="btn btn--accent btn--lg" href="<?php echo esc_url( wipaco_shop_url() ); ?>">View Products<?php wipaco_icon( 'arrow' ); ?></a>
			<a class="btn btn--whatsapp btn--lg" href="<?php echo esc_url( wipaco_whatsapp_url() ); ?>" target="_blank" rel="noopener"><?php wipaco_icon( 'whatsapp' ); ?>WhatsApp Us</a>
		</div>
		<ul class="hero__points">
			<li><?php wipaco_icon( 'check' ); ?>Bulk &amp; wholesale quantities</li>
			<li><?php wipaco_icon( 'check' ); ?>Original sealed packaging</li>
			<li><?php wipaco_icon( 'check' ); ?>Central Kampala location</li>
		</ul>
	</div>
</section>

<section class="features">
	<div class="container features__grid">
		<div class="feature">
			<span class="feature__icon"><?php wipaco_icon( 'award' ); ?></span>
			<h2 class="feature__title">Quality imported products</h2>
			<p>Sourced from established manufacturers in India, Korea and Kenya.</p>
		</div>
		<div class="feature">
			<span class="feature__icon"><?php wipaco_icon( 'package' ); ?></span>
			<h2 class="feature__title">Bags, cartons &amp; drums</h2>
			<p>Buy the quantity your production needs, from a few bags to full loads.</p>
		</div>
		<div class="feature">
			<span class="feature__icon"><?php wipaco_icon( 'shield' ); ?></span>
			<h2 class="feature__title">Safe handling advice</h2>
			<p>We guide you on storage and safe use of every product we sell.</p>
		</div>
		<div class="feature">
			<span class="feature__icon"><?php wipaco_icon( 'message' ); ?></span>
			<h2 class="feature__title">Fast quotations</h2>
			<p>Send a request or WhatsApp us and get prices quickly.</p>
		</div>
	</div>
</section>

<?php
$cats = get_terms( array(
	'taxonomy'   => 'product_cat',
	'hide_empty' => true,
	'exclude'    => array( (int) get_option( 'default_product_cat' ) ),
) );
if ( $cats && ! is_wp_error( $cats ) ) :
	?>
	<section class="section">
		<div class="container">
			<div class="section__head">
				<p class="eyebrow">What we supply</p>
				<h2 class="section__title">Product categories</h2>
			</div>
			<div class="cat-grid">
				<?php
				foreach ( $cats as $cat ) :
					$thumb = get_term_meta( $cat->term_id, 'thumbnail_id', true );
					?>
					<a class="cat-card" href="<?php echo esc_url( get_term_link( $cat ) ); ?>">
						<?php
						if ( $thumb ) {
							echo wp_get_attachment_image( $thumb, 'woocommerce_thumbnail', false, array( 'class' => 'cat-card__img', 'loading' => 'lazy' ) );
						}
						?>
						<span class="cat-card__body">
							<span class="cat-card__name"><?php echo esc_html( $cat->name ); ?></span>
							<span class="cat-card__count"><?php echo esc_html( sprintf( _n( '%d product', '%d products', $cat->count ), $cat->count ) ); ?></span>
						</span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<section class="section section--tint">
	<div class="container">
		<div class="section__head section__head--split">
			<div>
				<p class="eyebrow">In stock</p>
				<h2 class="section__title">Our products</h2>
			</div>
			<a class="link-arrow" href="<?php echo esc_url( wipaco_shop_url() ); ?>">See all products<?php wipaco_icon( 'arrow' ); ?></a>
		</div>
		<?php echo do_shortcode( '[products limit="6" columns="3" orderby="menu_order" order="ASC"]' ); ?>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="section__head">
			<p class="eyebrow">Who we serve</p>
			<h2 class="section__title">Industries we supply</h2>
		</div>
		<ul class="industries">
			<li class="industry"><?php wipaco_icon( 'droplet' ); ?><h3>Soap &amp; detergent makers</h3><p>LABSA, caustic soda and soda ash for bar soap, liquid soap and washing powder.</p></li>
			<li class="industry"><?php wipaco_icon( 'flame' ); ?><h3>Candle &amp; polish makers</h3><p>Microcrystalline waxes for candles, shoe polish and floor polish.</p></li>
			<li class="industry"><?php wipaco_icon( 'star' ); ?><h3>Cosmetics &amp; personal care</h3><p>Odourless waxes for creams, jellies, ointments and hair products.</p></li>
			<li class="industry"><?php wipaco_icon( 'filter' ); ?><h3>Water treatment</h3><p>Alkalis for pH correction and water softening.</p></li>
			<li class="industry"><?php wipaco_icon( 'layers' ); ?><h3>Textile &amp; paper</h3><p>Caustic soda and soda ash for processing, scouring and bleaching.</p></li>
			<li class="industry"><?php wipaco_icon( 'factory' ); ?><h3>General manufacturing</h3><p>Raw materials for glass, cleaning products and chemical processing.</p></li>
		</ul>
	</div>
</section>

<section class="section section--tint">
	<div class="container split">
		<div class="split__media">
			<img src="<?php echo esc_url( $img . 'warehouse.webp' ); ?>" alt="Drums of industrial chemicals in the Wipaco store, Kampala" width="787" height="1400" loading="lazy">
		</div>
		<div class="split__body">
			<p class="eyebrow">About Wipaco</p>
			<h2 class="section__title">Your reliable partner for industrial chemicals</h2>
			<p>Wipaco Investiments Limited supplies industrial chemicals and manufacturing raw materials from our shop on Johnson Street in central Kampala. We serve manufacturers, small-scale producers and businesses across Uganda with products in original, sealed and labelled packaging.</p>
			<ul class="checklist">
				<li><?php wipaco_icon( 'check' ); ?>Genuine products from known manufacturers</li>
				<li><?php wipaco_icon( 'check' ); ?>Wholesale and bulk quantities</li>
				<li><?php wipaco_icon( 'check' ); ?>Honest advice on the right product for your process</li>
				<li><?php wipaco_icon( 'check' ); ?>Easy ordering by phone, WhatsApp or online request</li>
			</ul>
			<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/about/' ) ); ?>">More about us<?php wipaco_icon( 'arrow' ); ?></a>
		</div>
	</div>
</section>

<?php
$guides = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 3, 'ignore_sticky_posts' => true ) );
if ( $guides->have_posts() ) :
	?>
	<section class="section">
		<div class="container">
			<div class="section__head section__head--split">
				<div>
					<p class="eyebrow">Learn</p>
					<h2 class="section__title">Guides for manufacturers</h2>
				</div>
				<a class="link-arrow" href="<?php echo esc_url( get_permalink( (int) get_option( 'page_for_posts' ) ) ); ?>">All guides<?php wipaco_icon( 'arrow' ); ?></a>
			</div>
			<div class="guide-grid">
				<?php
				while ( $guides->have_posts() ) :
					$guides->the_post();
					get_template_part( 'template-parts/guide-card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
<?php endif; ?>

<section class="section section--tint">
	<div class="container faq-wrap">
		<div class="section__head">
			<p class="eyebrow">Questions</p>
			<h2 class="section__title">Frequently asked questions</h2>
		</div>
		<?php wipaco_render_faqs( wipaco_general_faqs() ); ?>
	</div>
</section>

<section class="section cta-quote">
	<div class="container cta-quote__grid">
		<div class="cta-quote__intro">
			<p class="eyebrow">Get prices</p>
			<h2 class="section__title">Request a quotation</h2>
			<p>Tell us the product and quantity you need and we will send you our best price. Don't see a chemical on our list? Ask us anyway.</p>
			<ul class="contact-list">
				<li><?php wipaco_icon( 'phone' ); ?><a href="<?php echo esc_attr( wipaco_tel( wipaco_contact( 'phone_1' ) ) ); ?>"><?php echo esc_html( wipaco_contact( 'phone_1' ) ); ?></a></li>
				<li><?php wipaco_icon( 'whatsapp' ); ?><a href="<?php echo esc_url( wipaco_whatsapp_url() ); ?>" target="_blank" rel="noopener">Chat on WhatsApp</a></li>
				<li><?php wipaco_icon( 'mail' ); ?><a href="mailto:<?php echo esc_attr( wipaco_contact( 'email' ) ); ?>"><?php echo esc_html( wipaco_contact( 'email' ) ); ?></a></li>
			</ul>
		</div>
		<div class="card">
			<?php get_template_part( 'template-parts/quote-form' ); ?>
		</div>
	</div>
</section>

<?php
get_footer();
