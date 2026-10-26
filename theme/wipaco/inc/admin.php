<?php
/**
 * Wipaco-branded admin: custom dashboard, simplified menu in plain words, brand colours,
 * and less WordPress / plugin noise. Hidden screens still work by direct link.
 */

/* ---------- Brand styles ---------- */

add_action( 'admin_enqueue_scripts', function () {
	$dir = get_template_directory();
	wp_enqueue_style( 'wipaco-admin', get_template_directory_uri() . '/assets/css/admin.css', array(), filemtime( $dir . '/assets/css/admin.css' ) );
} );
// Same styles for the top bar when staff view the website while logged in.
add_action( 'wp_enqueue_scripts', function () {
	if ( is_admin_bar_showing() ) {
		$dir = get_template_directory();
		wp_enqueue_style( 'wipaco-admin-bar', get_template_directory_uri() . '/assets/css/admin.css', array(), filemtime( $dir . '/assets/css/admin.css' ) );
	}
} );

/* ---------- Posts are "Guides" ---------- */

add_filter( 'register_post_type_args', function ( $args, $type ) {
	if ( $type === 'post' ) {
		$args['labels'] = array(
			'name'          => 'Guides',
			'singular_name' => 'Guide',
			'menu_name'     => 'Guides',
			'all_items'     => 'All Guides',
			'add_new'       => 'Write a Guide',
			'add_new_item'  => 'Write a Guide',
			'edit_item'     => 'Edit Guide',
			'new_item'      => 'New Guide',
			'view_item'     => 'View Guide',
			'search_items'  => 'Search Guides',
			'not_found'     => 'No guides found',
		);
		$args['menu_icon'] = 'dashicons-book-alt';
	}
	return $args;
}, 10, 2 );

/* ---------- Simplified menu ---------- */

add_action( 'admin_menu', function () {
	global $menu;

	add_menu_page( 'Contact Details', 'Contact Details', 'edit_theme_options', 'customize.php?autofocus[section]=wipaco_contact', '', 'dashicons-phone', 26 );
	remove_menu_page( 'edit-comments.php' ); // comments are switched off

	// Plugin screens not used in catalogue mode (still reachable by direct link).
	foreach ( (array) $menu as $item ) {
		$slug = $item[2] ?? '';
		if ( preg_match( '#wc-admin&path=/(analytics|payments|wc-pay|marketing)|woocommerce-marketing|wc-settings&tab=checkout#', $slug ) ) {
			remove_menu_page( $slug );
		}
	}

	// Plain names.
	foreach ( $menu as $i => $item ) {
		$label = array(
			'rank-math'   => 'SEO',
			'woocommerce' => 'Shop Settings',
			'upload.php'  => 'Photos &amp; Files',
			'themes.php'  => 'Design',
		)[ $item[2] ] ?? null;
		if ( $label ) {
			$menu[ $i ][0] = $label;
		}
	}
}, 9999 );

add_filter( 'custom_menu_order', '__return_true' );
// Late priority: WooCommerce re-sorts the menu with its own filter, so ours runs after it.
add_filter( 'menu_order', function () {
	return array(
		'index.php',
		'edit.php?post_type=wipaco_enquiry',
		'edit.php?post_type=product',
		'edit.php',
		'edit.php?post_type=page',
		'upload.php',
		'customize.php?autofocus[section]=wipaco_contact',
		'separator1',
		'rank-math',
		'woocommerce',
		'themes.php',
		'users.php',
		'plugins.php',
		'tools.php',
		'options-general.php',
		'separator2',
		'separator-last',
	);
}, 9999 );

// Sub-menus not used by Wipaco (still reachable by direct link).
add_action( 'admin_menu', function () {
	remove_submenu_page( 'edit.php?post_type=product', 'edit-tags.php?taxonomy=product_brand&amp;post_type=product' );
	remove_submenu_page( 'edit.php?post_type=product', 'edit-tags.php?taxonomy=product_tag&amp;post_type=product' );
	remove_submenu_page( 'edit.php?post_type=product', 'product_attributes' );
	remove_submenu_page( 'edit.php?post_type=product', 'product-reviews' );
	remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' );
	remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );
}, 9999 );

/* ---------- Simpler lists ---------- */

// Only the columns Wipaco uses. Priority 9999 so plugin columns (Rank Math, brands) are already added.
$wipaco_columns = array(
	'edit-product' => array( 'cb', 'thumb', 'name', 'price', 'product_cat', 'date' ),
	'edit-post'    => array( 'cb', 'title', 'date' ),
	'edit-page'    => array( 'cb', 'title', 'date' ),
);
foreach ( $wipaco_columns as $screen => $keep ) {
	add_filter( "manage_{$screen}_columns", fn( $columns ) => array_intersect_key( $columns, array_flip( $keep ) ), 9999 );
	add_filter( "views_{$screen}", function ( $views ) {
		unset( $views['pillar_content'], $views['byorder'] ); // Rank Math "Pillar Content", WooCommerce "Sorting"
		return $views;
	}, 9999 );
}
add_filter( 'woocommerce_products_admin_list_table_filters', function ( $filters ) {
	unset( $filters['product_type'], $filters['stock_status'] );
	return $filters;
} );

/* ---------- Top bar ---------- */

add_action( 'admin_bar_menu', function ( $bar ) {
	foreach ( array( 'wp-logo', 'comments', 'rank-math', 'woocommerce-site-visibility-badge', 'updates', 'customize', 'search', 'command-palette' ) as $node ) {
		$bar->remove_node( $node );
	}
	$bar->add_node( array(
		'id'     => 'wipaco-view-site',
		'title'  => 'View Website',
		'href'   => home_url( '/' ),
		'parent' => 'top-secondary',
		'meta'   => array( 'target' => '_blank' ),
	) );
}, 999 );

add_filter( 'gettext', function ( $translation, $text ) {
	return $text === 'Howdy, %s' ? 'Hello, %s' : $translation;
}, 10, 2 );

/* ---------- Less noise ---------- */

add_filter( 'woocommerce_helper_suppress_admin_notices', '__return_true' );
add_filter( 'woocommerce_allow_marketplace_suggestions', '__return_false' );
add_action( 'admin_head', function () {
	$screen = get_current_screen();
	if ( $screen ) {
		$screen->remove_help_tabs();
	}
} );

/* ---------- Dashboard ---------- */

// Replace every default and plugin box with Wipaco's own.
add_action( 'wp_dashboard_setup', function () {
	global $wp_meta_boxes;
	$wp_meta_boxes['dashboard'] = array();
	remove_action( 'welcome_panel', 'wp_welcome_panel' );

	wp_add_dashboard_widget( 'wipaco_enquiries', 'Latest quote requests', 'wipaco_dashboard_enquiries' );
	wp_add_dashboard_widget( 'wipaco_glance', 'Website at a glance', 'wipaco_dashboard_glance', null, null, 'side' );
	wp_add_dashboard_widget( 'wipaco_help', 'Quick help', 'wipaco_dashboard_help', null, null, 'side' );
}, 999 );

// Always show the welcome banner (WordPress hides it for new users by default).
add_filter( 'get_user_metadata', function ( $value, $user_id, $key ) {
	return $key === 'show_welcome_panel' ? array( 1 ) : $value;
}, 10, 3 );
add_action( 'welcome_panel', 'wipaco_dashboard_welcome' );

function wipaco_count_enquiries_since( $days ) {
	return count( get_posts( array(
		'post_type'   => 'wipaco_enquiry',
		'numberposts' => -1,
		'fields'      => 'ids',
		'date_query'  => array( array( 'after' => $days . ' days ago' ) ),
	) ) );
}

function wipaco_dashboard_welcome() {
	$user  = wp_get_current_user();
	$hour  = (int) current_time( 'G' );
	$greet = $hour < 12 ? 'Good morning' : ( $hour < 17 ? 'Good afternoon' : 'Good evening' );
	$week  = wipaco_count_enquiries_since( 7 );
	$tiles = array(
		array( 'Add a product', 'post-new.php?post_type=product', 'dashicons-plus-alt', '' ),
		array( 'Quote requests', 'edit.php?post_type=wipaco_enquiry', 'dashicons-email-alt', $week ? $week . ' this week' : '' ),
		array( 'All products', 'edit.php?post_type=product', 'dashicons-products', '' ),
		array( 'Contact details', 'customize.php?autofocus[section]=wipaco_contact', 'dashicons-phone', '' ),
		array( 'Write a guide', 'post-new.php', 'dashicons-book-alt', '' ),
	);
	?>
	<div class="wipaco-welcome">
		<div class="wipaco-welcome__intro">
			<p class="wipaco-welcome__eyebrow">Wipaco website</p>
			<h2><?php echo esc_html( $greet . ', ' . ( $user->first_name ?: $user->display_name ) ); ?></h2>
			<p>Manage your products, quote requests and website content from here.</p>
			<a class="button button-primary button-hero" href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" rel="noopener">View website</a>
		</div>
		<div class="wipaco-welcome__tiles">
			<?php foreach ( $tiles as list( $label, $url, $icon, $badge ) ) : ?>
				<a class="wipaco-tile" href="<?php echo esc_url( admin_url( $url ) ); ?>">
					<span class="dashicons <?php echo esc_attr( $icon ); ?>"></span>
					<span class="wipaco-tile__label"><?php echo esc_html( $label ); ?></span>
					<?php if ( $badge ) : ?><span class="wipaco-tile__badge"><?php echo esc_html( $badge ); ?></span><?php endif; ?>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}

function wipaco_dashboard_enquiries() {
	$items = get_posts( array( 'post_type' => 'wipaco_enquiry', 'numberposts' => 6 ) );
	if ( ! $items ) {
		echo '<p class="wipaco-empty">No quote requests yet. When customers send the form on the website, they appear here and in your email.</p>';
		return;
	}
	echo '<ul class="wipaco-list">';
	foreach ( $items as $post ) {
		$data = wipaco_enquiry_data( $post->ID );
		printf(
			'<li><a class="wipaco-list__main" href="%s"><strong>%s</strong><span>%s &middot; %s</span></a><span class="wipaco-list__meta">%s</span>%s</li>',
			esc_url( get_edit_post_link( $post->ID ) ),
			esc_html( ( $data['Name'] ?? '' ) ?: $post->post_title ),
			esc_html( ( $data['Product'] ?? '' ) ?: 'General enquiry' ),
			esc_html( ( $data['Quantity'] ?? '' ) ?: 'qty not given' ),
			esc_html( human_time_diff( get_post_time( 'U', true, $post ) ) . ' ago' ),
			$data ? '<a class="button button-small" href="' . esc_url( wipaco_enquiry_pdf_url( $post->ID ) ) . '" target="_blank">PDF</a>' : ''
		);
	}
	echo '</ul>';
	echo '<p class="wipaco-more"><a href="' . esc_url( admin_url( 'edit.php?post_type=wipaco_enquiry' ) ) . '">View all quote requests &rarr;</a></p>';
}

function wipaco_dashboard_glance() {
	$stats = array(
		array( wp_count_posts( 'product' )->publish, 'Products', 'edit.php?post_type=product' ),
		array( wp_count_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true ) ), 'Categories', 'edit-tags.php?taxonomy=product_cat&post_type=product' ),
		array( wp_count_posts( 'post' )->publish, 'Guides', 'edit.php' ),
		array( wipaco_count_enquiries_since( 30 ), 'Quote requests (30 days)', 'edit.php?post_type=wipaco_enquiry' ),
	);
	echo '<div class="wipaco-stats">';
	foreach ( $stats as list( $number, $label, $url ) ) {
		printf( '<a class="wipaco-stat" href="%s"><strong>%s</strong><span>%s</span></a>', esc_url( admin_url( $url ) ), esc_html( (string) $number ), esc_html( $label ) );
	}
	echo '</div>';
}

function wipaco_dashboard_help() {
	?>
	<ul class="wipaco-help">
		<li><strong>Add a product:</strong> Products &rarr; Add New. Fill the name, photo, category and short description, then click <em>Publish</em>.</li>
		<li><strong>Show a price:</strong> enter it in <em>Regular price</em>. Leave empty to show "Price on request".</li>
		<li><strong>Change phone numbers:</strong> Contact Details in the menu.</li>
		<li><strong>Reply to a request:</strong> open it and use <em>Reply on WhatsApp</em> or <em>Download PDF</em>.</li>
	</ul>
	<?php
}
