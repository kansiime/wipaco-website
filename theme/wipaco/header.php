<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main">Skip to content</a>

<div class="topbar">
	<div class="container topbar__inner">
		<span class="topbar__item topbar__address"><?php wipaco_icon( 'pin' ); ?>Johnson Street, Kampala</span>
		<a class="topbar__item" href="<?php echo esc_attr( wipaco_tel( wipaco_contact( 'phone_1' ) ) ); ?>"><?php wipaco_icon( 'phone' ); ?><?php echo esc_html( wipaco_contact( 'phone_1' ) ); ?></a>
		<a class="topbar__item topbar__email" href="mailto:<?php echo esc_attr( wipaco_contact( 'email' ) ); ?>"><?php wipaco_icon( 'mail' ); ?><?php echo esc_html( wipaco_contact( 'email' ) ); ?></a>
	</div>
</div>

<header class="site-header">
	<div class="container site-header__inner">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo.webp' ); ?>" alt="Wipaco Investiments Limited" width="600" height="222">
		</a>

		<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav" aria-label="Open menu">
			<?php wipaco_icon( 'menu', 'icon icon--open' ); ?><?php wipaco_icon( 'close', 'icon icon--close' ); ?>
		</button>

		<nav id="site-nav" class="site-nav" aria-label="Main">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'fallback_cb'    => 'wipaco_fallback_menu',
				'depth'          => 1,
			) );
			?>
			<a class="btn btn--primary site-nav__cta" href="<?php echo esc_url( wipaco_quote_url() ); ?>">Request a Quote</a>
		</nav>
	</div>
</header>

<main id="main" class="site-main">
