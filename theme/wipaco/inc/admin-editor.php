<?php
/**
 * Editing screens organised around how Wipaco works: products, guides, pages and quote requests
 * each show only their own sections, with plain names, in a fixed order.
 */

// Guides and pages use the same simple editor as products (no WordPress block editor or its welcome tour).
add_filter( 'use_block_editor_for_post_type', fn( $use, $type ) => in_array( $type, array( 'post', 'page' ), true ) ? false : $use, 10, 2 );

/* ---------- Sections per screen: [ id => new title ] (false = remove) ---------- */

function wipaco_editor_boxes() {
	$seo = 'Google search appearance (SEO)';
	return array(
		'product' => array(
			'boxes' => array(
				'submitdiv'                          => 'Publish',
				'product_catdiv'                     => 'Category',
				'postimagediv'                       => 'Main photo',
				'woocommerce-product-images'         => 'More photos (optional)',
				'postexcerpt'                        => 'Key specifications - shown beside the photo',
				'woocommerce-product-data'           => 'Price & details',
				'wipaco_faq'                         => 'Questions & answers (FAQs)',
				'rank_math_metabox'                  => $seo,
				'product_branddiv'                   => false,
				'tagsdiv-product_tag'                => false,
				'rank_math_metabox_content_ai'       => false,
				'rank_math_metabox_link_suggestions' => false,
				'postcustom'                         => false,
				'slugdiv'                            => false,
				'commentsdiv'                        => false,
				'commentstatusdiv'                   => false,
			),
			'order' => array(
				'side'   => 'submitdiv,product_catdiv,postimagediv,woocommerce-product-images',
				'normal' => 'postexcerpt,woocommerce-product-data,wipaco_faq,rank_math_metabox',
			),
		),
		'post'    => array(
			'boxes' => array(
				'submitdiv'                          => 'Publish',
				'postimagediv'                       => 'Cover photo',
				'postexcerpt'                        => 'Short summary - shown on guide cards',
				'wipaco_guide_products'              => 'Products mentioned in this guide',
				'rank_math_metabox'                  => $seo,
				'categorydiv'                        => false,
				'tagsdiv-post_tag'                   => false,
				'formatdiv'                          => false,
				'authordiv'                          => false,
				'revisionsdiv'                       => false,
				'rank_math_metabox_content_ai'       => false,
				'rank_math_metabox_link_suggestions' => false,
				'postcustom'                         => false,
				'slugdiv'                            => false,
				'trackbacksdiv'                      => false,
				'commentsdiv'                        => false,
				'commentstatusdiv'                   => false,
			),
			'order' => array(
				'side'   => 'submitdiv,postimagediv,wipaco_guide_products',
				'normal' => 'postexcerpt,rank_math_metabox',
			),
		),
		'page'    => array(
			'boxes' => array(
				'submitdiv'                          => 'Publish',
				'rank_math_metabox'                  => $seo,
				'pageparentdiv'                      => false,
				'postimagediv'                       => false,
				'authordiv'                          => false,
				'revisionsdiv'                       => false,
				'rank_math_metabox_content_ai'       => false,
				'rank_math_metabox_link_suggestions' => false,
				'postcustom'                         => false,
				'slugdiv'                            => false,
				'commentsdiv'                        => false,
				'commentstatusdiv'                   => false,
			),
			'order' => array( 'side' => 'submitdiv', 'normal' => 'rank_math_metabox' ),
		),
		'wipaco_enquiry' => array(
			'boxes' => array(
				'wipaco_enquiry_details' => 'Request details',
				'wipaco_enquiry_actions' => 'Reply',
				'submitdiv'              => false, // blog-style publish options make no sense here; delete link is in "Reply"
				'slugdiv'                => false,
			),
			'order' => array( 'side' => 'wipaco_enquiry_actions', 'normal' => 'wipaco_enquiry_details' ),
		),
	);
}

// Runs as each column is drawn, so boxes added on add_meta_boxes_{type} (FAQs, Reply) are included too.
add_action( 'do_meta_boxes', function ( $post_type ) {
	global $wp_meta_boxes;
	$config = wipaco_editor_boxes()[ $post_type ] ?? null;
	if ( ! $config ) {
		return;
	}
	foreach ( $config['boxes'] as $id => $title ) {
		foreach ( array( 'normal', 'side', 'advanced' ) as $context ) {
			if ( $title === false ) {
				remove_meta_box( $id, $post_type, $context );
				continue;
			}
			foreach ( array( 'high', 'core', 'default', 'low' ) as $priority ) {
				if ( ! empty( $wp_meta_boxes[ $post_type ][ $context ][ $priority ][ $id ] ) ) {
					$wp_meta_boxes[ $post_type ][ $context ][ $priority ][ $id ]['title'] = $title;
				}
			}
		}
	}
}, 9999 );

// Same section order for everyone (ignores drag-and-drop rearranging), and no "Screen Options" tab.
foreach ( array_keys( wipaco_editor_boxes() ) as $type ) {
	add_filter( "get_user_option_meta-box-order_{$type}", fn() => wipaco_editor_boxes()[ $type ]['order'] + array( 'advanced' => '' ) );
	add_filter( "get_user_option_closedpostboxes_{$type}", fn() => array() );
}
add_filter( 'screen_options_show_screen', fn( $show, $screen ) => $screen->base === 'post' ? false : $show, 10, 2 );

// Hide WooCommerce's built-in "Uncategorized" category (it can't be deleted) from the Category box.
add_action( 'admin_head-post.php', 'wipaco_hide_default_cat' );
add_action( 'admin_head-post-new.php', 'wipaco_hide_default_cat' );
function wipaco_hide_default_cat() {
	$id = (int) get_option( 'default_product_cat' );
	if ( $id ) {
		// Element ids get numeric suffixes, so match the checkbox by its value (the category id).
		printf( '<style>#product_catchecklist li:has(> label > input[value="%1$d"]), #product_catchecklist-pop li:has(input[value="%1$d"]), #newproduct_cat_parent option[value="%1$d"] { display: none; }</style>', $id );
	}
}

/* ---------- Product: Price & details panel ---------- */

add_filter( 'product_type_selector', fn( $types ) => array( 'simple' => $types['simple'] ) );
add_filter( 'product_type_options', fn() => array() ); // "Virtual" / "Downloadable" boxes
add_filter( 'woocommerce_product_data_tabs', function ( $tabs ) {
	unset( $tabs['shipping'], $tabs['linked_product'], $tabs['advanced'], $tabs['variations'] );
	$tabs['general']['label']   = 'Price';
	$tabs['inventory']['label'] = 'Stock (optional)';
	$tabs['attribute']['label'] = 'Specifications table';
	return $tabs;
}, 99 );

// A short "how to" at the top of the product and guide screens.
add_action( 'edit_form_after_title', function ( $post ) {
	$steps = array(
		'product' => 'Fill in the <strong>name</strong> and <strong>full description</strong>, then the <strong>key specifications</strong> below. On the right, choose the <strong>category</strong> and add the <strong>main photo</strong>. Leave the price empty to show "Price on request". Click <strong>Publish</strong> when ready.',
		'post'    => 'Write the <strong>title</strong> and the guide below. Add a <strong>cover photo</strong> and tick the <strong>products mentioned</strong> on the right, so readers can request a quote. Click <strong>Publish</strong> when ready.',
	)[ $post->post_type ] ?? '';
	if ( $steps ) {
		echo '<div class="wipaco-steps"><span class="dashicons dashicons-lightbulb"></span><p>' . wp_kses( $steps, array( 'strong' => array() ) ) . '</p></div>';
	}
} );

/* ---------- Guide: products mentioned ---------- */

add_action( 'add_meta_boxes_post', function () {
	add_meta_box( 'wipaco_guide_products', 'Products mentioned in this guide', function ( $post ) {
		$chosen = array_filter( array_map( 'trim', explode( ',', (string) get_post_meta( $post->ID, '_wipaco_products', true ) ) ) );
		wp_nonce_field( 'wipaco_guide_products', 'wipaco_guide_products_nonce' );
		echo '<p class="description">Shown under the guide with quote buttons (up to 3).</p><div class="wipaco-checklist">';
		foreach ( wc_get_products( array( 'status' => 'publish', 'limit' => -1, 'orderby' => 'title', 'order' => 'ASC' ) ) as $product ) {
			printf(
				'<label><input type="checkbox" name="wipaco_products[]" value="%s" %s> %s</label>',
				esc_attr( $product->get_slug() ),
				checked( in_array( $product->get_slug(), $chosen, true ), true, false ),
				esc_html( $product->get_name() )
			);
		}
		echo '</div>';
	}, 'post', 'side' );
} );

add_action( 'save_post_post', function ( $post_id ) {
	if ( ! isset( $_POST['wipaco_guide_products_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['wipaco_guide_products_nonce'] ), 'wipaco_guide_products' ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$slugs = array_map( 'sanitize_title', (array) wp_unslash( $_POST['wipaco_products'] ?? array() ) );
	update_post_meta( $post_id, '_wipaco_products', implode( ',', array_slice( $slugs, 0, 3 ) ) );
} );

/* ---------- Quote request: read-only details ---------- */

add_action( 'init', fn() => remove_post_type_support( 'wipaco_enquiry', 'editor' ), 20 );

add_action( 'add_meta_boxes_wipaco_enquiry', function () {
	add_meta_box( 'wipaco_enquiry_details', 'Request details', function ( $post ) {
		$data = wipaco_enquiry_data( $post->ID );
		if ( ! $data ) {
			echo wpautop( esc_html( $post->post_content ) );
			return;
		}
		echo '<table class="wipaco-details"><tbody>';
		printf( '<tr><th>Reference</th><td><strong>%s</strong></td></tr>', esc_html( wipaco_enquiry_ref( $post->ID ) ) );
		printf( '<tr><th>Received</th><td>%s</td></tr>', esc_html( get_post_time( 'j F Y, H:i', false, $post ) ) );
		foreach ( $data as $label => $value ) {
			if ( $value === '' ) {
				continue;
			}
			if ( $label === 'Phone' ) {
				$value_html = '<a href="' . esc_attr( wipaco_tel( $value ) ) . '">' . esc_html( $value ) . '</a>';
			} elseif ( $label === 'Email' ) {
				$value_html = '<a href="mailto:' . esc_attr( $value ) . '">' . esc_html( $value ) . '</a>';
			} else {
				$value_html = nl2br( esc_html( $value ) );
			}
			printf( '<tr><th>%s</th><td>%s</td></tr>', esc_html( $label ), $value_html );
		}
		$sent = get_post_meta( $post->ID, '_wipaco_email_sent', true );
		printf( '<tr><th>Email notification</th><td>%s</td></tr>', $sent === 'yes' ? 'Sent to ' . esc_html( wipaco_contact( 'email' ) ) : 'Not sent - check the email settings' );
		echo '</tbody></table>';
	}, 'wipaco_enquiry', 'normal', 'high' );
} );
