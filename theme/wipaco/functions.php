<?php
/**
 * Wipaco theme functions.
 *
 * Phase 1 (Business Website): WooCommerce runs in catalogue mode - customers browse products
 * and send quote requests / WhatsApp orders. Phase 2 (E-commerce): set WIPACO_CATALOGUE_MODE
 * to false, then add a payment gateway plugin (Flutterwave / Pesapal) to enable cart & checkout.
 */

define( 'WIPACO_VERSION', '1.0.0' );
define( 'WIPACO_CATALOGUE_MODE', true );

require get_template_directory() . '/inc/icons.php';
require get_template_directory() . '/inc/enquiry-pdf.php';
require get_template_directory() . '/inc/login.php';
require get_template_directory() . '/inc/admin-url.php';
require get_template_directory() . '/inc/admin.php';
require get_template_directory() . '/inc/admin-editor.php';

/* -------------------------------------------------------------------------
 * Theme setup
 * ---------------------------------------------------------------------- */

function wipaco_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 600,
		'single_image_width'    => 900,
	) );
	add_theme_support( 'wc-product-gallery-lightbox' );

	register_nav_menus( array(
		'primary' => __( 'Main menu', 'wipaco' ),
	) );
}
add_action( 'after_setup_theme', 'wipaco_setup' );

function wipaco_assets() {
	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	wp_enqueue_style( 'wipaco', get_stylesheet_uri(), array(), filemtime( $dir . '/style.css' ) );
	wp_enqueue_script( 'wipaco', $uri . '/assets/js/main.js', array(), filemtime( $dir . '/assets/js/main.js' ), array( 'strategy' => 'defer' ) );

	// Not using WooCommerce blocks, so their stylesheet is dead weight.
	wp_dequeue_style( 'wc-blocks-style' );
}
add_action( 'wp_enqueue_scripts', 'wipaco_assets', 20 );

function wipaco_head() {
	$uri = get_template_directory_uri();
	// Fonts are self-hosted (assets/fonts): no request to Google, faster on mobile data.
	foreach ( array( 'inter', 'montserrat' ) as $font ) {
		echo '<link rel="preload" href="' . esc_url( "$uri/assets/fonts/$font-latin-wght-normal.woff2" ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
	}
	if ( is_front_page() ) {
		echo '<link rel="preload" href="' . esc_url( "$uri/assets/img/hero-drums.webp" ) . '" as="image" fetchpriority="high">' . "\n";
	}
	echo '<meta name="theme-color" content="#2160d2">' . "\n";
	if ( ! has_site_icon() ) {
		$icon = esc_url( get_template_directory_uri() . '/assets/img/icon.png' );
		echo '<link rel="icon" href="' . $icon . '" type="image/png">' . "\n";
		echo '<link rel="apple-touch-icon" href="' . $icon . '">' . "\n";
	}
}
add_action( 'wp_head', 'wipaco_head', 1 );

/* -------------------------------------------------------------------------
 * Contact details - editable in Appearance > Customize > Wipaco Contact Details
 * ---------------------------------------------------------------------- */

function wipaco_contact_fields() {
	return array(
		'phone_1'      => array( 'Main phone', '+256 786 876637' ),
		'phone_2'      => array( 'Second phone (leave empty to hide)', '' ),
		'other_phones' => array( 'Other phone numbers (comma separated)', '' ),
		'whatsapp'     => array( 'WhatsApp number (digits only, with 256)', '256707555500' ),
		'email'        => array( 'Email (quote requests are sent here)', 'wipacoinvestiments@gmail.com' ),
		'address'      => array( 'Address', 'Shop No. L5 02, TransNile Link Building, Plot 10, Johnson Street, Kampala, Uganda' ),
		'hours'        => array( 'Opening hours (leave empty to hide)', '' ),
		'facebook'     => array( 'Facebook page link', '' ),
		'instagram'    => array( 'Instagram link', '' ),
		'tiktok'       => array( 'TikTok link', '' ),
		'ga_id'        => array( 'Google Analytics ID (G-XXXXXXXXXX) - leave empty to turn off', '' ),
	);
}

function wipaco_contact( $key ) {
	$fields = wipaco_contact_fields();
	return trim( (string) get_theme_mod( 'wipaco_' . $key, $fields[ $key ][1] ?? '' ) );
}

function wipaco_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'wipaco_contact', array(
		'title'    => __( 'Wipaco Contact Details & Analytics', 'wipaco' ),
		'priority' => 30,
	) );
	foreach ( wipaco_contact_fields() as $key => list( $label, $default ) ) {
		$wp_customize->add_setting( 'wipaco_' . $key, array(
			'default'           => $default,
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'wipaco_' . $key, array(
			'label'   => $label,
			'section' => 'wipaco_contact',
			'type'    => 'text',
		) );
	}
}
add_action( 'customize_register', 'wipaco_customize_register' );

function wipaco_tel( $phone ) {
	return 'tel:+' . preg_replace( '/\D/', '', $phone );
}

/** WhatsApp number for display, e.g. "+256 707 555500". */
function wipaco_whatsapp_display() {
	$digits = preg_replace( '/\D/', '', wipaco_contact( 'whatsapp' ) );
	return preg_match( '/^(256)(\d{3})(\d{6})$/', $digits, $m ) ? "+$m[1] $m[2] $m[3]" : '+' . $digits;
}

function wipaco_whatsapp_url( $text = '' ) {
	$url = 'https://wa.me/' . preg_replace( '/\D/', '', wipaco_contact( 'whatsapp' ) );
	if ( $text === '' ) {
		$text = 'Hello Wipaco, I would like to enquire about your products.';
	}
	return $url . '?text=' . rawurlencode( $text );
}

function wipaco_quote_url( $product_name = '' ) {
	$page = get_page_by_path( 'request-quote' );
	$url  = $page ? get_permalink( $page ) : home_url( '/request-quote/' );
	// "item", not "product": ?product= is a reserved WooCommerce query var and would load the product instead.
	return $product_name ? add_query_arg( 'item', rawurlencode( $product_name ), $url ) : $url;
}

function wipaco_shop_url() {
	return function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/products/' );
}

/** Fallback menu used until a menu is assigned in Appearance > Menus. */
function wipaco_fallback_menu() {
	$links = array(
		home_url( '/' )          => 'Home',
		wipaco_shop_url()        => 'Products',
		home_url( '/about/' )    => 'About Us',
		home_url( '/contact/' )  => 'Contact',
	);
	echo '<ul class="menu">';
	foreach ( $links as $url => $label ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
	}
	echo '</ul>';
}

/* -------------------------------------------------------------------------
 * WooCommerce - catalogue mode
 * ---------------------------------------------------------------------- */

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
add_filter( 'woocommerce_show_page_title', '__return_false' ); // the page-hero banner already shows it
add_filter( 'loop_shop_columns', fn() => 3 );
add_filter( 'loop_shop_per_page', fn() => 48 );
// Keep one-result searches on the results page: the live search fetches that page and expects a product list.
add_filter( 'woocommerce_redirect_single_search_result', '__return_false' );
add_filter( 'woocommerce_empty_price_html', fn() => '<span class="price-request">Price on request</span>' );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
// The category description is already shown in the page banner (woocommerce.php).
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );

if ( WIPACO_CATALOGUE_MODE ) {
	add_filter( 'woocommerce_is_purchasable', '__return_false' );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	add_action( 'woocommerce_after_shop_loop_item', 'wipaco_loop_product_actions', 10 );
	add_action( 'woocommerce_single_product_summary', 'wipaco_single_product_actions', 30 );
}

// Share buttons under the product details (after categories, which are at priority 40).
add_action( 'woocommerce_single_product_summary', fn() => get_template_part( 'template-parts/share-buttons' ), 50 );

/**
 * A product's main category: the "Primary category" chosen in Rank Math's box on the product,
 * otherwise its first category. Used for card labels, breadcrumbs and the product list.
 */
function wipaco_primary_cat( $product_id ) {
	$primary = (int) get_post_meta( $product_id, 'rank_math_primary_product_cat', true );
	$term    = $primary ? get_term( $primary, 'product_cat' ) : null;
	if ( $term && ! is_wp_error( $term ) && has_term( $term->term_id, 'product_cat', $product_id ) ) {
		return $term;
	}
	$terms = get_the_terms( $product_id, 'product_cat' );
	return ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;
}

/** Category label above the product name on product cards. */
function wipaco_loop_category() {
	$term = wipaco_primary_cat( get_the_ID() );
	if ( $term ) {
		echo '<span class="product-card__cat">' . esc_html( $term->name ) . '</span>';
	}

	// Hidden keywords for the live product search: all categories and spec values,
	// so typing "NaOH", "Texapon" or "HCl" finds the right product.
	global $product;
	$words = wp_list_pluck( get_the_terms( get_the_ID(), 'product_cat' ) ?: array(), 'name' );
	foreach ( $product->get_attributes() as $attribute ) {
		if ( ! $attribute->is_taxonomy() ) {
			$words = array_merge( $words, $attribute->get_options() );
		}
	}
	echo '<span class="product-card__keywords" hidden>' . esc_html( implode( ' ', $words ) ) . '</span>';
}

add_filter( 'woocommerce_breadcrumb_main_term', function ( $main_term, $terms ) {
	$primary = is_product() ? wipaco_primary_cat( get_the_ID() ) : null;
	return $primary ?: $main_term;
}, 10, 2 );
add_action( 'woocommerce_shop_loop_item_title', 'wipaco_loop_category', 5 );

function wipaco_product_whatsapp_text( $product ) {
	return sprintf( 'Hello Wipaco, I would like a quotation for %s. Quantity needed: ', $product->get_name() );
}

function wipaco_loop_product_actions() {
	global $product;
	?>
	<div class="product-card__actions">
		<a class="btn btn--primary btn--sm" href="<?php echo esc_url( wipaco_quote_url( $product->get_name() ) ); ?>">Get Quote</a>
		<a class="btn btn--whatsapp btn--sm" href="<?php echo esc_url( wipaco_whatsapp_url( wipaco_product_whatsapp_text( $product ) ) ); ?>" target="_blank" rel="noopener" aria-label="Order <?php echo esc_attr( $product->get_name() ); ?> on WhatsApp"><?php wipaco_icon( 'whatsapp' ); ?>WhatsApp</a>
	</div>
	<?php
}

function wipaco_single_product_actions() {
	global $product;
	?>
	<div class="product-actions">
		<a class="btn btn--primary btn--lg" href="<?php echo esc_url( wipaco_quote_url( $product->get_name() ) ); ?>"><?php wipaco_icon( 'message' ); ?>Request a Quote</a>
		<a class="btn btn--whatsapp btn--lg" href="<?php echo esc_url( wipaco_whatsapp_url( wipaco_product_whatsapp_text( $product ) ) ); ?>" target="_blank" rel="noopener"><?php wipaco_icon( 'whatsapp' ); ?>Order on WhatsApp</a>
	</div>
	<p class="product-call">
		<?php wipaco_icon( 'phone' ); ?>
		Prefer to talk? Call <a href="<?php echo esc_attr( wipaco_tel( wipaco_contact( 'phone_1' ) ) ); ?>"><?php echo esc_html( wipaco_contact( 'phone_1' ) ); ?></a>
	</p>
	<?php
}

/* -------------------------------------------------------------------------
 * Quote / enquiry requests - saved in WP admin (Enquiries) and emailed
 * ---------------------------------------------------------------------- */

function wipaco_register_enquiries() {
	register_post_type( 'wipaco_enquiry', array(
		'labels'       => array(
			'name'          => 'Quote Requests',
			'singular_name' => 'Quote Request',
			'edit_item'     => 'Quote Request',
			'all_items'     => 'All Quote Requests',
			'menu_name'     => 'Quote Requests',
			'not_found'     => 'No quote requests yet',
			'search_items'  => 'Search quote requests',
		),
		'public'       => false,
		'show_ui'      => true,
		'menu_icon'    => 'dashicons-email-alt',
		'menu_position'=> 25,
		'supports'     => array( 'title', 'editor' ),
		'capabilities' => array( 'create_posts' => 'do_not_allow' ),
		'map_meta_cap' => true,
	) );
}
add_action( 'init', 'wipaco_register_enquiries' );

function wipaco_handle_quote() {
	$back = remove_query_arg( array( 'quote', 'ref' ), wp_get_referer() ?: home_url( '/' ) );
	$done = function ( $status, $args = array() ) use ( $back ) {
		wp_safe_redirect( add_query_arg( array( 'quote' => $status ) + $args, $back ) . '#quote-form' );
		exit;
	};

	if ( ! isset( $_POST['wipaco_quote_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['wipaco_quote_nonce'] ), 'wipaco_quote' ) ) {
		$done( 'error' );
	}
	// Honeypot: bots fill the hidden "website" field, people don't.
	if ( ! empty( $_POST['website'] ) ) {
		$done( 'sent' );
	}

	$field = fn( $key ) => sanitize_text_field( wp_unslash( $_POST[ $key ] ?? '' ) );
	$data  = array(
		'Name'     => $field( 'name' ),
		'Company'  => $field( 'company' ),
		'Phone'    => $field( 'phone' ),
		'Email'    => sanitize_email( wp_unslash( $_POST['email'] ?? '' ) ),
		'Product'  => $field( 'product' ),
		'Quantity' => $field( 'quantity' ),
		'Message'  => sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) ),
	);

	if ( $data['Name'] === '' || $data['Phone'] === '' ) {
		$done( 'missing' );
	}

	$body = '';
	foreach ( $data as $label => $value ) {
		if ( $value !== '' ) {
			$body .= $label . ': ' . $value . "\n";
		}
	}
	$subject = 'Quote request: ' . ( $data['Product'] ?: 'General enquiry' ) . ' - ' . $data['Name'];

	$post_id = wp_insert_post( array(
		'post_type'    => 'wipaco_enquiry',
		'post_status'  => 'publish',
		'post_title'   => $subject,
		'post_content' => $body,
	) );
	update_post_meta( $post_id, '_wipaco_enquiry', $data );
	$ref     = wipaco_enquiry_ref( $post_id );
	$subject = '[' . $ref . '] ' . $subject;
	wp_update_post( array( 'ID' => $post_id, 'post_title' => $subject ) );

	// Email the company, with the request attached as a PDF (temp file, deleted after sending).
	$headers = array();
	if ( $data['Email'] ) {
		$headers[] = 'Reply-To: ' . $data['Name'] . ' <' . $data['Email'] . '>';
	}
	$attachments = array();
	try {
		$pdf_path = trailingslashit( get_temp_dir() ) . wipaco_enquiry_pdf_filename( $post_id );
		file_put_contents( $pdf_path, wipaco_enquiry_pdf( $post_id ) );
		$attachments[] = $pdf_path;
	} catch ( Throwable $e ) {
		error_log( 'Wipaco quote PDF failed: ' . $e->getMessage() ); // the email still goes out without it
	}
	$sent = wp_mail( wipaco_contact( 'email' ), $subject, "Reference: $ref\n" . $body . "\n--\nSent from the Wipaco website quote form. PDF attached.", $headers, $attachments );
	update_post_meta( $post_id, '_wipaco_email_sent', $sent ? 'yes' : 'no' );
	foreach ( $attachments as $file ) {
		wp_delete_file( $file );
	}

	// Ready-made WhatsApp message for the customer's "Also send on WhatsApp" button.
	// Kept in a short-lived transient behind a random token, so details never appear in the URL.
	$text = "Hello Wipaco, I have just sent a quote request on your website.\nRef: $ref\n";
	foreach ( $data as $label => $value ) {
		if ( $value !== '' ) {
			$text .= "$label: $value\n";
		}
	}
	$token = strtolower( wp_generate_password( 24, false ) ); // lowercase: read back via sanitize_key()
	set_transient( 'wipaco_wa_' . $token, array( 'ref' => $ref, 'text' => trim( $text ) ), 2 * HOUR_IN_SECONDS );

	$done( 'sent', array( 'ref' => $token ) );
}

/** The WhatsApp hand-off for the success message, or null if the token is missing/expired. */
function wipaco_quote_handoff() {
	$token = sanitize_key( $_GET['ref'] ?? '' );
	return $token ? ( get_transient( 'wipaco_wa_' . $token ) ?: null ) : null;
}
add_filter( 'wp_mail_from_name', fn() => 'Wipaco Website' );
add_action( 'admin_post_wipaco_quote', 'wipaco_handle_quote' );
add_action( 'admin_post_nopriv_wipaco_quote', 'wipaco_handle_quote' );

/* -------------------------------------------------------------------------
 * SEO - LocalBusiness structured data on the home page
 * (titles, meta descriptions and the sitemap come from the Rank Math plugin)
 * ---------------------------------------------------------------------- */

function wipaco_local_business_schema() {
	if ( ! is_front_page() ) {
		return;
	}
	$phones = array_filter( array_map( 'trim', array_merge(
		array( wipaco_contact( 'phone_1' ), wipaco_contact( 'phone_2' ) ),
		explode( ',', wipaco_contact( 'other_phones' ) )
	) ) );
	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'Store',
		'@id'         => home_url( '/#business' ),
		'name'        => 'Wipaco Investiments Limited',
		'description' => 'Supplier of industrial chemicals and raw materials in Kampala, Uganda: caustic soda, LABSA, SLES, soda ash, chlorine, acids, waxes, glycerine and more.',
		'url'         => home_url( '/' ),
		'logo'        => get_template_directory_uri() . '/assets/img/logo.png',
		'image'       => get_template_directory_uri() . '/assets/img/hero-drums.webp',
		'telephone'   => array_values( $phones ),
		'email'       => wipaco_contact( 'email' ),
		'address'     => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => 'Shop No. L5 02, TransNile Link Building, Plot 10, Johnson Street',
			'addressLocality' => 'Kampala',
			'addressCountry'  => 'UG',
		),
		'areaServed'  => 'Uganda',
		'sameAs'      => array_values( array_filter( array( wipaco_contact( 'facebook' ), wipaco_contact( 'instagram' ), wipaco_contact( 'tiktok' ) ) ) ),
	);
	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'wipaco_local_business_schema' );

/* -------------------------------------------------------------------------
 * Speed - uploaded photos are resized into WebP (smaller than JPEG at the same quality)
 * ---------------------------------------------------------------------- */

add_filter( 'image_editor_output_format', function ( $formats ) {
	$formats['image/jpeg'] = 'image/webp';
	return $formats;
} );

/**
 * Social link previews (Facebook, WhatsApp, X, LinkedIn) use the original JPEG upload:
 * WhatsApp and some apps don't reliably show WebP preview images.
 */
function wipaco_og_image_jpeg( $attachment ) {
	if ( empty( $attachment['url'] ) || ! str_ends_with( strtolower( $attachment['url'] ), '.webp' ) ) {
		return $attachment;
	}
	$id       = ! empty( $attachment['id'] ) ? (int) $attachment['id'] : attachment_url_to_postid( $attachment['url'] );
	$original = $id ? wp_get_original_image_url( $id ) : false;
	if ( $original && ! str_ends_with( strtolower( $original ), '.webp' ) ) {
		$attachment['url']  = $original;
		$attachment['type'] = wp_check_filetype( $original )['type'];
	}
	return $attachment;
}
add_filter( 'rank_math/opengraph/facebook/image_array', 'wipaco_og_image_jpeg' );
add_filter( 'rank_math/opengraph/twitter/image_array', 'wipaco_og_image_jpeg' );

/* -------------------------------------------------------------------------
 * FAQs - "Product FAQs" box on each product; shown as a tab with FAQPage structured data
 * ---------------------------------------------------------------------- */

/** Parses the FAQ box: blocks separated by a blank line, first line = question, the rest = answer. */
function wipaco_get_faqs( $post_id ) {
	$raw  = trim( (string) get_post_meta( $post_id, '_wipaco_faq', true ) );
	$faqs = array();
	if ( $raw === '' ) {
		return $faqs;
	}
	foreach ( preg_split( '/\R\s*\R/', $raw ) as $block ) {
		$lines = preg_split( '/\R/', trim( $block ), 2 );
		if ( count( $lines ) === 2 ) {
			$faqs[] = array( 'q' => trim( $lines[0] ), 'a' => trim( $lines[1] ) );
		}
	}
	return $faqs;
}

function wipaco_general_faqs() {
	return array(
		array( 'q' => 'Where is Wipaco Investiments located?', 'a' => 'Our shop is at ' . wipaco_contact( 'address' ) . '.' ),
		array( 'q' => 'How do I get a price for a chemical?', 'a' => 'Send a quote request on this website, message us on WhatsApp, or call ' . wipaco_contact( 'phone_1' ) . '. Tell us the product and quantity you need.' ),
		array( 'q' => 'Can you supply a chemical that is not listed on the website?', 'a' => 'Yes, ask us. We regularly source other industrial chemicals for our customers and will tell you if we can supply what you need.' ),
		array( 'q' => 'Do you give advice on handling chemicals safely?', 'a' => 'Yes. We guide our customers on protective gear, storage and safe use of every product we sell.' ),
	);
}

function wipaco_render_faqs( $faqs ) {
	echo '<div class="faq">';
	foreach ( $faqs as $i => $faq ) {
		printf(
			'<details class="faq__item"%s><summary>%s</summary><div class="faq__answer">%s</div></details>',
			$i === 0 ? ' open' : '',
			esc_html( $faq['q'] ),
			wpautop( esc_html( $faq['a'] ) )
		);
	}
	echo '</div>';
}

function wipaco_faq_schema( $faqs ) {
	$schema = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => array_map( fn( $faq ) => array(
			'@type'          => 'Question',
			'name'           => $faq['q'],
			'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $faq['a'] ),
		), $faqs ),
	);
	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}

add_action( 'wp_head', function () {
	if ( is_front_page() ) {
		wipaco_faq_schema( wipaco_general_faqs() );
	} elseif ( is_product() && ( $faqs = wipaco_get_faqs( get_queried_object_id() ) ) ) {
		wipaco_faq_schema( $faqs );
	}
} );

add_filter( 'woocommerce_product_tabs', function ( $tabs ) {
	if ( wipaco_get_faqs( get_the_ID() ) ) {
		$tabs['faq'] = array(
			'title'    => 'FAQs',
			'priority' => 15,
			'callback' => fn() => wipaco_render_faqs( wipaco_get_faqs( get_the_ID() ) ),
		);
	}
	return $tabs;
} );

add_action( 'add_meta_boxes_product', function () {
	add_meta_box( 'wipaco_faq', 'Product FAQs', function ( $post ) {
		wp_nonce_field( 'wipaco_faq', 'wipaco_faq_nonce' );
		echo '<p>Write each question on its own line with the answer on the next line(s). Leave an empty line between questions.</p>';
		printf( '<textarea name="wipaco_faq" rows="12" style="width:100%%">%s</textarea>', esc_textarea( get_post_meta( $post->ID, '_wipaco_faq', true ) ) );
	}, 'product', 'normal' );
} );

add_action( 'save_post_product', function ( $post_id ) {
	if ( ! isset( $_POST['wipaco_faq_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['wipaco_faq_nonce'] ), 'wipaco_faq' ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	update_post_meta( $post_id, '_wipaco_faq', sanitize_textarea_field( wp_unslash( $_POST['wipaco_faq'] ?? '' ) ) );
} );

/* -------------------------------------------------------------------------
 * Google Analytics (only when an ID is set in the Customizer).
 * WhatsApp / call / email clicks and quote requests are sent as events by assets/js/main.js.
 * ---------------------------------------------------------------------- */

add_action( 'wp_head', function () {
	$id = wipaco_contact( 'ga_id' );
	if ( ! preg_match( '/^G-[A-Z0-9]+$/', $id ) || is_user_logged_in() ) {
		return;
	}
	?>
	<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $id ); ?>"></script>
	<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?php echo esc_js( $id ); ?>');</script>
	<?php
} );

/* -------------------------------------------------------------------------
 * Guides (blog)
 * ---------------------------------------------------------------------- */

add_filter( 'excerpt_length', fn() => 26 );
add_filter( 'excerpt_more', fn() => '&hellip;' );

/** Products linked to a guide (post meta "_wipaco_products": comma separated product slugs). */
function wipaco_guide_products( $post_id ) {
	$slugs = array_filter( array_map( 'trim', explode( ',', (string) get_post_meta( $post_id, '_wipaco_products', true ) ) ) );
	if ( ! $slugs ) {
		return array();
	}
	$ids = get_posts( array( 'post_type' => 'product', 'post_status' => 'publish', 'post_name__in' => $slugs, 'orderby' => 'post_name__in', 'numberposts' => 3, 'fields' => 'ids' ) );
	return array_filter( array_map( 'wc_get_product', $ids ) );
}
