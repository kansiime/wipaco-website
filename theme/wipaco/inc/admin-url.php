<?php
/**
 * Staff admin at /wipaco-staff/panel/ instead of /wp-admin/.
 *
 * The real files stay in /wp-admin (WordPress updates keep working). An Apache rewrite in .htaccess
 * maps the panel address onto them, links and redirects are rewritten to the panel address, and
 * logged-in staff who type /wp-admin are sent to the panel.
 *
 * Safety: it only switches on when the rewrite is in .htaccess on an Apache/LiteSpeed server, so a host
 * without it falls back to /wp-admin instead of locking anyone out. To switch it off manually:
 * define( 'WIPACO_PANEL', false ); in wp-config.php.
 */

function wipaco_panel_slug() {
	return trim( defined( 'WIPACO_PANEL_SLUG' ) ? WIPACO_PANEL_SLUG : wipaco_login_slug() . '/panel', '/' );
}

/** Site path prefix, e.g. "/" or "/shop/" when WordPress lives in a sub-folder. */
function wipaco_home_path() {
	return trailingslashit( (string) wp_parse_url( home_url(), PHP_URL_PATH ) ?: '/' );
}

function wipaco_panel_htaccess_rules() {
	$slug = preg_quote( wipaco_panel_slug(), '#' );
	return array(
		'<IfModule mod_rewrite.c>',
		'RewriteEngine On',
		'RewriteBase ' . wipaco_home_path(),
		"RewriteRule ^{$slug}/?$ wp-admin/ [L,QSA]",
		"RewriteRule ^{$slug}/(.*)$ wp-admin/\$1 [L,QSA]",
		'</IfModule>',
	);
}

function wipaco_htaccess_file() {
	return ABSPATH . '.htaccess';
}

function wipaco_panel_enabled() {
	static $enabled = null;
	if ( $enabled === null ) {
		$file    = wipaco_htaccess_file();
		$enabled = ! ( defined( 'WIPACO_PANEL' ) && ! WIPACO_PANEL )
			&& is_readable( $file )
			&& strpos( (string) file_get_contents( $file ), '# BEGIN Wipaco Panel' ) !== false;
	}
	return $enabled;
}

/**
 * Writes the rewrite block at the top of .htaccess (it must come before WordPress's own rules,
 * which would otherwise send the panel address to the 404 page). Only on Apache-compatible servers.
 */
function wipaco_panel_install_rules() {
	require_once ABSPATH . 'wp-admin/includes/misc.php';
	$file = wipaco_htaccess_file();
	if ( ! got_mod_rewrite() || ! is_writable( $file ) || ( defined( 'WIPACO_PANEL' ) && ! WIPACO_PANEL ) ) {
		return;
	}
	$current = (string) file_get_contents( $file );
	$block   = "# BEGIN Wipaco Panel\n" . implode( "\n", wipaco_panel_htaccess_rules() ) . "\n# END Wipaco Panel\n\n";
	$without = preg_replace( '/# BEGIN Wipaco Panel.*?# END Wipaco Panel\n*/s', '', $current );
	if ( $block . $without !== $current ) {
		file_put_contents( $file, $block . $without );
	}
}
add_action( 'after_switch_theme', 'wipaco_panel_install_rules' );
add_action( 'admin_init', function () {
	if ( ! wipaco_panel_enabled() && current_user_can( 'manage_options' ) ) {
		wipaco_panel_install_rules();
	}
} );

// Theme switched off: remove the rewrite so nothing points at the panel any more.
add_action( 'switch_theme', function () {
	$file = wipaco_htaccess_file();
	if ( is_writable( $file ) ) {
		file_put_contents( $file, preg_replace( '/# BEGIN Wipaco Panel.*?# END Wipaco Panel\n*/s', '', (string) file_get_contents( $file ) ) );
	}
} );

if ( ! wipaco_panel_enabled() ) {
	return;
}

/* ---------- Links and redirects use the panel address ---------- */

/** /wp-admin/... -> /wipaco-staff/panel/... (background endpoints keep their standard address). */
function wipaco_panel_rewrite_url( $url ) {
	if ( ! is_string( $url ) || strpos( $url, 'wp-admin' ) === false || preg_match( '#wp-admin/(admin-ajax|admin-post)\.php#', $url ) ) {
		return $url;
	}
	return preg_replace( '#(^|/)wp-admin(/|$)#', '$1' . wipaco_panel_slug() . '/', $url, 1 );
}
add_filter( 'admin_url', 'wipaco_panel_rewrite_url', 100 );
add_filter( 'wp_redirect', 'wipaco_panel_rewrite_url', 100 );
add_filter( 'site_url', fn( $url, $path ) => strpos( (string) $path, 'wp-admin' ) === 0 ? wipaco_panel_rewrite_url( $url ) : $url, 100, 2 );

/* ---------- Logged-in staff typing /wp-admin go to the panel ---------- */

add_action( 'wp_loaded', function () {
	global $pagenow;
	if ( ! is_admin() || ! is_user_logged_in() || wp_doing_ajax() || ( $_SERVER['REQUEST_METHOD'] ?? 'GET' ) !== 'GET'
		|| in_array( $pagenow, array( 'admin-ajax.php', 'admin-post.php', 'async-upload.php' ), true ) ) {
		return;
	}
	$uri = $_SERVER['REQUEST_URI'] ?? '';
	if ( strpos( $uri, wipaco_home_path() . 'wp-admin' ) === 0 ) {
		wp_safe_redirect( wipaco_panel_rewrite_url( $uri ) );
		exit;
	}
}, 0 );

/* ---------- Login cookie also valid for the panel address ---------- */

// WordPress limits its admin login cookie to /wp-admin; without a copy for the panel path, staff would appear logged out there.
function wipaco_panel_cookie_path() {
	return wipaco_home_path() . wipaco_panel_slug();
}
add_action( 'set_auth_cookie', function ( $cookie, $expire, $expiration, $user_id, $scheme ) {
	$secure = $scheme === 'secure_auth';
	setcookie( $secure ? SECURE_AUTH_COOKIE : AUTH_COOKIE, $cookie, $expire, wipaco_panel_cookie_path(), COOKIE_DOMAIN, $secure, true );
}, 10, 5 );
add_action( 'clear_auth_cookie', function () {
	foreach ( array( AUTH_COOKIE, SECURE_AUTH_COOKIE ) as $name ) {
		setcookie( $name, ' ', time() - YEAR_IN_SECONDS, wipaco_panel_cookie_path(), COOKIE_DOMAIN );
	}
} );
