<?php
/**
 * Private staff login address and branded login page.
 *
 * - Staff log in at /wipaco-staff (change with define( 'WIPACO_LOGIN_SLUG', '...' ) in wp-config.php).
 * - For visitors who are not logged in, /wp-login.php, /wp-admin, /login and /admin show the normal 404 page.
 * - admin-ajax.php and admin-post.php stay open: the quote form posts to admin-post.php.
 * - Lives in the theme on purpose: if the theme is switched off, the default login returns (no lock-out).
 */

function wipaco_login_slug() {
	return trim( defined( 'WIPACO_LOGIN_SLUG' ) ? WIPACO_LOGIN_SLUG : 'wipaco-staff', '/' );
}

/** The staff login URL, keeping any query string (e.g. ?action=lostpassword). */
function wipaco_login_url( $query = '' ) {
	return trailingslashit( home_url( wipaco_login_slug() ) ) . ( $query !== '' ? '?' . $query : '' );
}

/** Rewrites any wp-login.php URL to the staff login URL. */
function wipaco_login_rewrite( $url ) {
	if ( ! is_string( $url ) || strpos( $url, 'wp-login.php' ) === false ) {
		return $url;
	}
	$parts = explode( '?', $url, 2 );
	return wipaco_login_url( $parts[1] ?? '' );
}

/** Is this request for the staff login address? Checked as early as the theme loads. */
function wipaco_is_login_request() {
	$path = wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH );
	$want = wp_parse_url( home_url( wipaco_login_slug() ), PHP_URL_PATH );
	return $path && untrailingslashit( $path ) === untrailingslashit( $want );
}

/** Sends the theme's normal 404 page and stops. */
function wipaco_login_not_found() {
	global $wp_query;
	status_header( 404 );
	nocache_headers();
	$wp_query->set_404();
	require get_404_template() ?: get_index_template();
	exit;
}

add_action( 'wp_loaded', function () {
	global $pagenow;

	// Serve the real login screen at the staff address. wp-login.php expects these as globals.
	if ( wipaco_is_login_request() ) {
		global $error, $interim_login, $action, $user_login;
		$pagenow = 'wp-login.php';
		require_once ABSPATH . 'wp-login.php';
		exit;
	}

	// The default login file: hidden, except the password form for protected posts.
	if ( $pagenow === 'wp-login.php' && ( $_GET['action'] ?? '' ) !== 'postpass' ) {
		wipaco_login_not_found();
	}

	// The admin area: hidden from visitors who are not logged in.
	if ( is_admin() && ! is_user_logged_in() && ! wp_doing_ajax() && ! in_array( $pagenow, array( 'admin-post.php', 'admin-ajax.php' ), true ) ) {
		wipaco_login_not_found();
	}
}, 1 );

// Every link and redirect WordPress makes to wp-login.php points to the staff address instead.
foreach ( array( 'site_url', 'network_site_url', 'wp_redirect', 'login_url', 'logout_url', 'lostpassword_url', 'register_url' ) as $hook ) {
	add_filter( $hook, 'wipaco_login_rewrite', 100 );
}
// Don't let /login, /admin and /dashboard redirect to the login page.
remove_action( 'template_redirect', 'wp_redirect_admin_locations', 1000 );

/* -------------------------------------------------------------------------
 * Branded login page
 * ---------------------------------------------------------------------- */

add_action( 'login_enqueue_scripts', function () {
	$dir = get_template_directory();
	wp_enqueue_style( 'wipaco-login', get_template_directory_uri() . '/assets/css/login.css', array(), filemtime( $dir . '/assets/css/login.css' ) );
} );

add_filter( 'login_headerurl', fn() => home_url( '/' ) );
add_filter( 'login_headertext', fn() => 'Wipaco Investiments Limited' );
add_filter( 'login_title', fn() => 'Staff Login - Wipaco Investiments' );
add_filter( 'login_display_language_dropdown', '__return_false' );
add_filter( 'login_body_class', fn( $classes ) => array_merge( $classes, array( 'wipaco-login' ) ) );

// One generic error, so the page never confirms whether a username exists.
add_filter( 'login_errors', function ( $errors ) {
	return isset( $_POST['log'] ) ? '<strong>Login failed.</strong> Check your username and password and try again.' : $errors;
} );

// Brand panel on the left of the login form.
add_action( 'login_header', function () {
	$img = get_template_directory_uri() . '/assets/img/hero-drums.webp';
	?>
	<aside class="wipaco-login__brand" style="--login-img: url('<?php echo esc_url( $img ); ?>')">
		<div class="wipaco-login__brand-inner">
			<p class="wipaco-login__eyebrow">Staff area</p>
			<h2>Industrial chemicals supplier in Kampala, Uganda</h2>
			<p>Manage products, prices, guides and quote requests.</p>
		</div>
	</aside>
	<?php
} );

add_filter( 'login_message', function ( $message ) {
	$action = $_REQUEST['action'] ?? 'login';
	if ( $message === '' && in_array( $action, array( 'login', '' ), true ) && empty( $_GET['loggedout'] ) ) {
		$message = '<p class="wipaco-login__welcome"><strong>Welcome back</strong>Sign in to manage the Wipaco website.</p>';
	}
	return $message;
} );

/* -------------------------------------------------------------------------
 * Light admin branding
 * ---------------------------------------------------------------------- */

add_action( 'admin_bar_menu', fn( $bar ) => $bar->remove_node( 'wp-logo' ), 999 );
add_filter( 'admin_footer_text', fn() => 'Wipaco Investiments Limited &middot; Website admin' );
add_filter( 'update_footer', fn() => '', 11 );
add_filter( 'admin_title', fn( $admin_title, $title ) => $title . ' &lsaquo; ' . get_bloginfo( 'name' ), 10, 2 );
