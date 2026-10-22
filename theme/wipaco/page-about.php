<?php
/**
 * About Us page (slug: about). The main text is edited in Pages > About Us.
 */
get_header();
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/page-hero', null, array( 'lead' => 'Supplying quality industrial chemicals to Ugandan businesses from the heart of Kampala.' ) );
	?>
	<section class="section">
		<div class="container split split--top">
			<div class="split__body prose">
				<?php the_content(); ?>
			</div>
			<div class="split__media">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/hero-drums.webp' ); ?>" alt="Wipaco chemical drums ready for delivery" width="646" height="1400" loading="lazy">
			</div>
		</div>
	</section>

	<section class="section section--tint">
		<div class="container">
			<div class="section__head">
				<p class="eyebrow">What we stand for</p>
				<h2 class="section__title">Our values</h2>
			</div>
			<div class="features__grid">
				<div class="feature"><span class="feature__icon"><?php wipaco_icon( 'award' ); ?></span><h3 class="feature__title">Quality</h3><p>Genuine products from established manufacturers, in original sealed packaging.</p></div>
				<div class="feature"><span class="feature__icon"><?php wipaco_icon( 'check' ); ?></span><h3 class="feature__title">Integrity</h3><p>Fair prices, honest advice and correct weights, every time.</p></div>
				<div class="feature"><span class="feature__icon"><?php wipaco_icon( 'shield' ); ?></span><h3 class="feature__title">Safety</h3><p>Proper storage and clear guidance on safe handling.</p></div>
				<div class="feature"><span class="feature__icon"><?php wipaco_icon( 'package' ); ?></span><h3 class="feature__title">Reliability</h3><p>Consistent stock so your production keeps running.</p></div>
			</div>
		</div>
	</section>

	<section class="section">
		<div class="container split split--top">
			<div class="split__body">
				<p class="eyebrow">Safety &amp; quality</p>
				<h2 class="section__title">Handled with care</h2>
				<p>Many industrial chemicals are corrosive or need careful storage. We make sure the products you receive are in good condition and that you know how to use them safely.</p>
			</div>
			<ul class="checklist checklist--cards">
				<li><?php wipaco_icon( 'check' ); ?><span><strong>Original labelled packaging</strong> with manufacturer details, batch numbers and hazard markings.</span></li>
				<li><?php wipaco_icon( 'check' ); ?><span><strong>Dry, organised storage</strong> on pallets, away from water and direct sun.</span></li>
				<li><?php wipaco_icon( 'check' ); ?><span><strong>Handling guidance</strong> on protective gear (gloves, goggles) and safe dilution.</span></li>
				<li><?php wipaco_icon( 'check' ); ?><span><strong>Product information on request</strong> so you can choose the right grade for your process.</span></li>
			</ul>
		</div>
	</section>

	<section class="cta-band">
		<div class="container cta-band__inner">
			<h2>Need chemicals for your business?</h2>
			<div class="cta-band__actions">
				<a class="btn btn--accent btn--lg" href="<?php echo esc_url( wipaco_quote_url() ); ?>">Request a Quote</a>
				<a class="btn btn--outline-light btn--lg" href="<?php echo esc_url( wipaco_shop_url() ); ?>">View Products</a>
			</div>
		</div>
	</section>
	<?php
endwhile;
get_footer();
