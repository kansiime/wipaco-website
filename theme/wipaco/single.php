<?php
/**
 * Single guide (blog post).
 */
get_header();
while ( have_posts() ) :
	the_post();
	$guides = (int) get_option( 'page_for_posts' );
	?>
	<section class="page-hero">
		<div class="container">
			<nav class="woocommerce-breadcrumb" aria-label="Breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span>
				<?php if ( $guides ) : ?>
					<a href="<?php echo esc_url( get_permalink( $guides ) ); ?>"><?php echo esc_html( get_the_title( $guides ) ); ?></a><span class="sep">/</span>
				<?php endif; ?>
				<?php the_title(); ?>
			</nav>
			<h1 class="page-hero__title page-hero__title--article"><?php the_title(); ?></h1>
			<p class="page-hero__lead"><?php echo esc_html( get_the_date() ); ?> &middot; Wipaco Investiments</p>
		</div>
	</section>

	<section class="section">
		<div class="container article">
			<div class="article__body prose">
				<?php the_content(); ?>
				<?php get_template_part( 'template-parts/share-buttons' ); ?>
			</div>

			<aside class="article__aside">
				<div class="card card--compact">
					<h2 class="card__title">Need these chemicals?</h2>
					<p>Get prices and availability from our Kampala shop.</p>
					<a class="btn btn--primary" href="<?php echo esc_url( wipaco_quote_url() ); ?>">Request a Quote</a>
					<a class="btn btn--whatsapp" href="<?php echo esc_url( wipaco_whatsapp_url( 'Hello Wipaco, I read your guide "' . get_the_title() . '" and would like a quotation.' ) ); ?>" target="_blank" rel="noopener"><?php wipaco_icon( 'whatsapp' ); ?>WhatsApp Us</a>
				</div>
			</aside>
		</div>
	</section>

	<?php
	$products = wipaco_guide_products( get_the_ID() );
	if ( $products ) :
		?>
		<section class="section section--tint">
			<div class="container">
				<div class="section__head">
					<p class="eyebrow">Mentioned in this guide</p>
					<h2 class="section__title">Products you will need</h2>
				</div>
				<?php echo do_shortcode( '[products ids="' . esc_attr( implode( ',', array_map( fn( $p ) => $p->get_id(), $products ) ) ) . '" columns="3" orderby="post__in"]' ); ?>
			</div>
		</section>
	<?php endif; ?>
	<?php
endwhile;
get_footer();
