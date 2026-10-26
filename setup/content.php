<?php
/**
 * Creates the starting content for the Wipaco site (safe to re-run: existing items are updated).
 * Run with:  wp eval-file /setup/content.php
 */

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

/* ---------- Helpers ---------- */

function wsetup_image( $path, $alt ) {
	$name     = basename( $path );
	$existing = get_posts( array( 'post_type' => 'attachment', 'meta_key' => '_wipaco_source', 'meta_value' => $name, 'numberposts' => 1, 'fields' => 'ids' ) );
	if ( $existing ) {
		return $existing[0];
	}
	$tmp = wp_tempnam( $name );
	copy( $path, $tmp );
	$id = media_handle_sideload( array( 'name' => $name, 'tmp_name' => $tmp ), 0, $alt );
	if ( is_wp_error( $id ) ) {
		WP_CLI::error( $id->get_error_message() );
	}
	update_post_meta( $id, '_wp_attachment_image_alt', $alt );
	update_post_meta( $id, '_wipaco_source', $name );
	return $id;
}

function wsetup_page( $slug, $title, $content = '', $seo = array() ) {
	$page = get_page_by_path( $slug );
	$data = array(
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_name'    => $slug,
		'post_title'   => $title,
		'post_content' => $content,
	);
	if ( $page ) {
		$data['ID'] = $page->ID;
	}
	$id = wp_insert_post( $data );
	wsetup_seo( $id, $seo );
	return $id;
}

function wsetup_seo( $post_id, $seo ) {
	foreach ( array( 'title', 'description', 'focus_keyword' ) as $key ) {
		if ( ! empty( $seo[ $key ] ) ) {
			update_post_meta( $post_id, 'rank_math_' . $key, $seo[ $key ] );
		}
	}
}

function wsetup_term( $name, $slug, $description ) {
	$term = get_term_by( 'slug', $slug, 'product_cat' );
	if ( $term ) {
		wp_update_term( $term->term_id, 'product_cat', array( 'name' => $name, 'description' => $description ) );
		return $term->term_id;
	}
	$result = wp_insert_term( $name, 'product_cat', array( 'slug' => $slug, 'description' => $description ) );
	return $result['term_id'];
}

/* ---------- WooCommerce settings (catalogue mode, Uganda) ---------- */

$options = array(
	'woocommerce_currency'                   => 'UGX',
	'woocommerce_price_num_decimals'         => 0,
	'woocommerce_price_thousand_sep'         => ',',
	'woocommerce_currency_pos'               => 'left_space',
	'woocommerce_default_country'            => 'UG',
	'woocommerce_store_address'              => 'Shop No. L5 02, TransNile Link Building, Plot 10, Johnson Street',
	'woocommerce_store_city'                 => 'Kampala',
	'woocommerce_enable_reviews'             => 'no',
	'woocommerce_calc_taxes'                 => 'no',
	'woocommerce_coming_soon'                => 'no',
	'woocommerce_store_pages_only'           => 'no',
	'woocommerce_show_marketplace_suggestions' => 'no',
	'woocommerce_allow_tracking'             => 'no',
	'woocommerce_task_list_hidden'           => 'yes',
	'woocommerce_onboarding_profile'         => array( 'skipped' => true ),
	'woocommerce_thumbnail_cropping'         => '1:1',
);
foreach ( $options as $key => $value ) {
	update_option( $key, $value );
}

WC_Install::create_pages();

// The shop page becomes "Products". Cart/checkout/account stay as drafts until online payments (phase 2).
$shop_id = wc_get_page_id( 'shop' );
wp_update_post( array( 'ID' => $shop_id, 'post_title' => 'Products', 'post_name' => 'products' ) );
wsetup_seo( $shop_id, array(
	'title'       => 'Industrial Chemicals for Sale in Kampala, Uganda %sep% %sitename%',
	'description' => 'Browse industrial chemicals available at Wipaco Investiments, Kampala: caustic soda flakes & pearls, soda ash, LABSA, microcrystalline wax. Request a quote or order on WhatsApp.',
) );
foreach ( array( 'cart', 'checkout', 'myaccount' ) as $wc_page ) {
	wp_update_post( array( 'ID' => wc_get_page_id( $wc_page ), 'post_status' => 'draft' ) );
}

/* ---------- Pages ---------- */

$home = wsetup_page( 'home', 'Home', '', array(
	'title'         => 'Wipaco Investiments Ltd %sep% Industrial Chemicals Supplier in Kampala, Uganda',
	'description'   => 'Wipaco Investiments Limited supplies industrial chemicals in Kampala, Uganda: caustic soda, LABSA, SLES, soda ash, chlorine, acids, waxes, glycerine and raw materials for soap, detergent & manufacturing.',
	'focus_keyword' => 'industrial chemicals supplier Kampala',
) );

$about_content = <<<HTML
<!-- wp:heading -->
<h2 class="wp-block-heading">Who we are</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Wipaco Investiments Limited is a Kampala-based supplier of industrial chemicals and manufacturing raw materials. From our shop at TransNile Link Building on Johnson Street, we serve soap and detergent manufacturers, candle and polish makers, cosmetics producers, water treatment operators and many other businesses across Uganda.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>We stock imported products from established manufacturers in India, Korea and Kenya, and supply them in original, sealed and labelled packaging - bags, cartons and drums - so you get consistent quality batch after batch.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Our mission</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>To supply Ugandan industry with genuine, consistent-quality chemicals at fair prices, backed by honest advice and dependable service.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Our vision</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>To be Uganda's most trusted partner for industrial chemicals and manufacturing raw materials.</p>
<!-- /wp:paragraph -->
HTML;

wsetup_page( 'about', 'About Us', $about_content, array(
	'title'       => 'About Wipaco Investiments Ltd %sep% Chemical Supplier in Kampala',
	'description' => 'Wipaco Investiments Limited is a Kampala-based supplier of industrial chemicals and raw materials for soap, detergent, cosmetics, candle and manufacturing businesses in Uganda.',
) );

wsetup_page( 'contact', 'Contact Us', '', array(
	'title'       => 'Contact Wipaco Investiments %sep% Johnson Street, Kampala',
	'description' => 'Visit Wipaco Investiments at TransNile Link Building, Plot 10 Johnson Street, Kampala. Call +256 786 876637, WhatsApp +256 707 555500 or email us for chemical prices.',
) );

$quote_content = <<<HTML
<!-- wp:paragraph -->
<p>Fill in the form and our sales team will reply with prices and availability. Include the quantity you need and your delivery location so we can give you an accurate quote.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Need it urgently? Call or WhatsApp us directly.</p>
<!-- /wp:paragraph -->
HTML;

wsetup_page( 'request-quote', 'Request a Quote', $quote_content, array(
	'title'       => 'Request a Quote for Industrial Chemicals %sep% %sitename%',
	'description' => 'Get prices for caustic soda, soda ash, LABSA, waxes and other industrial chemicals in Kampala. Send a quote request to Wipaco Investiments or order on WhatsApp.',
) );

update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $home );

/* ---------- Product categories ---------- */

$dir = '/setup/products/';

$cat_alkalis = wsetup_term( 'Alkalis & Caustic Soda', 'alkalis-caustic-soda',
	'Caustic soda flakes and pearls, soda ash (sodium carbonate) and sodium metasilicate for soap making, detergents, water treatment, textiles and manufacturing. Available in bulk in Kampala.' );
$cat_soap = wsetup_term( 'Soap & Detergent Raw Materials', 'soap-detergent-raw-materials',
	'LABSA, SLES, CDEA, STPP, CMC, caustic soda, soda ash and fragrances: the key raw materials for liquid soap, bar soap, washing powder and cleaning products. Supplied in Kampala, Uganda.' );
$cat_wax = wsetup_term( 'Waxes & Oils', 'industrial-waxes',
	'Paraffin wax, microcrystalline wax, odourless micro wax and white (liquid paraffin) oil for candles, polishes, petroleum jelly, cosmetics and industrial use. Bulk supply in Kampala.' );
$cat_acids = wsetup_term( 'Acids', 'acids',
	'Hydrochloric acid and citric acid for pH control, descaling, cleaning products, water treatment and processing. Supplied in Kampala, Uganda.' );
$cat_water = wsetup_term( 'Water Treatment & Disinfection', 'water-treatment',
	'Chlorine (calcium hypochlorite) and other chemicals for drinking water treatment, swimming pools, sanitation and disinfection. Available in Kampala.' );
$cat_cosmetic = wsetup_term( 'Cosmetics & Personal Care Ingredients', 'cosmetics-personal-care',
	'Glycerine, white oil, odourless micro wax and fragrances for lotions, creams, petroleum jelly, hair products and soaps. Supplied in Kampala, Uganda.' );
$cat_soapbase = wsetup_term( 'Soap Bases (Melt & Pour)', 'soap-bases',
	'Ready-made melt and pour soap bases - glycerin, goat\'s milk, charcoal and aloe vera - for handmade, hotel and gift soaps. No caustic soda needed. Available in Kampala.' );
$cat_specialty = wsetup_term( 'Industrial & Specialty Chemicals', 'industrial-specialty-chemicals',
	'Titanium dioxide, formalin and other specialty chemicals for paints, coatings, resins, preservation and manufacturing. Available in Kampala.' );

/* ---------- Products ---------- */

$products = array(
	array(
		'name'  => 'Caustic Soda Flakes',
		'slug'  => 'caustic-soda-flakes',
		'image' => 'caustic-soda-flakes-bag.jpg',
		'alt'   => '25kg bag of caustic soda flakes NaOH 99.5% membrane grade by Kutch Chemical Industries',
		'cats'  => array( $cat_alkalis, $cat_soap ),
		'attrs' => array( 'Chemical name' => 'Sodium hydroxide (NaOH)', 'Purity' => '99.5% min (on dry basis), membrane grade', 'Form' => 'White flakes', 'CAS number' => '1310-73-2', 'Hazard class' => 'UN 1823, Class 8 (corrosive)', 'Manufacturer' => 'Kutch Chemical Industries, India', 'Packing' => '25 kg bags' ),
		'short' => '<ul><li><strong>Chemical name:</strong> Sodium hydroxide (NaOH)</li><li><strong>Purity:</strong> 99.5% min, membrane grade</li><li><strong>CAS No:</strong> 1310-73-2 &middot; UN 1823 &middot; Class 8</li><li><strong>Manufacturer:</strong> Kutch Chemical Industries, India</li><li><strong>Packing:</strong> 25 kg bags</li></ul>',
		'desc'  => '<p><strong>Caustic soda flakes</strong> (sodium hydroxide, NaOH) are one of the most widely used industrial alkalis. Wipaco Investiments supplies caustic soda flakes in Kampala in bulk and wholesale quantities.</p><h3>Common uses</h3><ul><li>Soap making (bar soap and liquid soap)</li><li>Detergent and cleaning product manufacturing</li><li>Water treatment and pH control</li><li>Textile processing and bleaching</li><li>Paper and pulp processing</li><li>Degreasing and industrial cleaning</li></ul><h3>Safety &amp; storage</h3><p>Corrosive (UN 1823, Class 8). Wear gloves and eye protection when handling. Store sealed in a cool, dry place and keep away from water and acids.</p>',
		'seo'   => array(
			'title'         => 'Caustic Soda Flakes Supplier in Kampala, Uganda %sep% %sitename%',
			'description'   => 'Buy caustic soda flakes (sodium hydroxide, NaOH) in Kampala, Uganda. Bulk supply for soap making, detergents, water treatment & industry. Call +256 786 876637.',
			'focus_keyword' => 'caustic soda flakes Uganda',
		),
	),
	array(
		'name'  => 'Caustic Soda Pearls 99%',
		'slug'  => 'caustic-soda-pearls',
		'image' => 'caustic-soda-pearls-bags.jpg',
		'alt'   => '25kg bags of caustic soda pearls NaOH 99% and a scoop of white pearls',
		'cats'  => array( $cat_alkalis, $cat_soap ),
		'attrs' => array( 'Chemical name' => 'Sodium hydroxide (NaOH)', 'Purity' => '99%', 'Form' => 'Pearls (prills)', 'Hazard class' => 'UN 1823, Class 8 (corrosive)', 'Origin' => 'China', 'Packing' => '25 kg bags' ),
		'short' => '<ul><li><strong>Chemical name:</strong> Sodium hydroxide (NaOH)</li><li><strong>Purity:</strong> 99%</li><li><strong>Form:</strong> Pearls / prills</li><li><strong>Origin:</strong> China</li><li><strong>Packing:</strong> 25 kg bags</li></ul>',
		'desc'  => '<p><strong>Caustic soda pearls 99%</strong> are high-purity sodium hydroxide in small round pearls. They flow freely, measure easily and dissolve evenly, making them popular with soap and detergent makers.</p><h3>Common uses</h3><ul><li>Bar soap and liquid soap production</li><li>Detergents and cleaning products</li><li>Water treatment and pH adjustment</li><li>Textile, paper and chemical processing</li></ul><h3>Safety &amp; storage</h3><p>Corrosive. Wear gloves and eye protection. Always add caustic soda to water slowly (never water to caustic soda). Keep bags sealed and dry.</p>',
		'seo'   => array(
			'title'         => 'Caustic Soda Pearls 99% in Kampala, Uganda %sep% %sitename%',
			'description'   => 'High purity 99% caustic soda pearls (NaOH) available in Kampala. Ideal for soap and detergent making. Get a quote from Wipaco Investiments today.',
			'focus_keyword' => 'caustic soda pearls',
		),
	),
	array(
		'name'  => 'Soda Ash Dense (Standard Grade)',
		'slug'  => 'soda-ash-dense',
		'image' => 'soda-ash-dense.jpg',
		'alt'   => '50kg bag of dense soda ash standard grade by Tata Chemicals Magadi',
		'cats'  => array( $cat_alkalis, $cat_soap ),
		'attrs' => array( 'Chemical name' => 'Sodium carbonate (Na2CO3)', 'Purity' => '96% min Na2CO3', 'Grade' => 'Dense, standard grade', 'Manufacturer' => 'Tata Chemicals Magadi, Kenya', 'Packing' => '50 kg bags' ),
		'short' => '<ul><li><strong>Chemical name:</strong> Sodium carbonate (Na<sub>2</sub>CO<sub>3</sub>)</li><li><strong>Purity:</strong> &ge; 96% Na<sub>2</sub>CO<sub>3</sub>, dense</li><li><strong>Manufacturer:</strong> Tata Chemicals Magadi, Kenya (KEBS marked)</li><li><strong>Packing:</strong> 50 kg bags</li></ul>',
		'desc'  => '<p><strong>Soda ash dense</strong> (sodium carbonate) standard grade, manufactured by Tata Chemicals Magadi in Kenya. Natural soda ash with a minimum of 96% Na<sub>2</sub>CO<sub>3</sub>, supplied in 50 kg bags.</p><h3>Common uses</h3><ul><li>Washing powder and detergent manufacturing</li><li>Soap making</li><li>Glass manufacturing</li><li>Water treatment and softening</li><li>Textile processing</li><li>Chemical manufacturing</li></ul><p><em>Industrial grade - not for edible or medicinal use.</em></p>',
		'seo'   => array(
			'title'         => 'Soda Ash Dense (Sodium Carbonate) 50kg in Kampala %sep% %sitename%',
			'description'   => 'Soda ash dense standard grade (sodium carbonate, 96% Na2CO3) by Tata Chemicals Magadi in 50kg bags. Available in Kampala, Uganda for detergents, glass & water treatment.',
			'focus_keyword' => 'soda ash Uganda',
		),
	),
	array(
		'name'  => 'LABSA (Linear Alkyl Benzene Sulphonic Acid)',
		'slug'  => 'labsa-linear-alkyl-benzene-sulphonic-acid',
		'image' => 'labsa-drum.jpg',
		'alt'   => 'Blue drum of LABSA linear alkyl benzene sulphonic acid',
		'cats'  => array( $cat_soap ),
		'attrs' => array( 'Chemical name' => 'Linear alkyl benzene sulphonic acid', 'Origin' => 'India', 'Packing' => '250 kg net drums' ),
		'short' => '<ul><li><strong>Product:</strong> Linear Alkyl Benzene Sulphonic Acid (LABSA)</li><li><strong>Type:</strong> Anionic surfactant (active detergent)</li><li><strong>Origin:</strong> India</li><li><strong>Packing:</strong> 250 kg net drums</li></ul>',
		'desc'  => '<p><strong>LABSA</strong> (Linear Alkyl Benzene Sulphonic Acid) is the main active cleaning ingredient in most detergents. Wipaco supplies LABSA in 250 kg drums, imported from India.</p><h3>Common uses</h3><ul><li>Liquid soap and liquid detergent</li><li>Washing powder and detergent paste</li><li>Dishwashing liquid</li><li>Multipurpose and industrial cleaners</li></ul><h3>Safety &amp; storage</h3><p>LABSA is acidic and corrosive. Wear gloves and eye protection, and store drums closed, upright and out of direct sun.</p>',
		'seo'   => array(
			'title'         => 'LABSA Supplier in Kampala, Uganda (250kg Drums) %sep% %sitename%',
			'description'   => 'Buy LABSA (linear alkyl benzene sulphonic acid) in 250kg drums in Kampala. Key raw material for liquid soap, washing powder and detergents. Quote from Wipaco Investiments.',
			'focus_keyword' => 'LABSA Uganda',
		),
	),
	array(
		'name'  => 'Microcrystalline Wax WX-160S',
		'slug'  => 'microcrystalline-wax-wx-160s',
		'image' => 'microcrystalline-wax-wx160s-bag.jpg',
		'gallery' => array( 'microcrystalline-wax-wx160s-stack.jpg' ),
		'alt'   => '25kg bag of SJ Materials WX-160S microcrystalline wax, made in Korea',
		'cats'  => array( $cat_wax ),
		'attrs' => array( 'Grade' => 'WX-160S', 'Manufacturer' => 'SJ Materials, Korea', 'Packing' => '25 kg bags' ),
		'short' => '<ul><li><strong>Product:</strong> Microcrystalline wax, grade WX-160S</li><li><strong>Manufacturer:</strong> SJ Materials (made in Korea)</li><li><strong>Packing:</strong> 25 kg bags</li></ul>',
		'desc'  => '<p><strong>Microcrystalline wax WX-160S</strong> by SJ Materials, made in Korea. A flexible, fine-crystal wax that improves strength, gloss and oil retention when blended with other waxes.</p><h3>Common uses</h3><ul><li>Candle making (blending with paraffin wax)</li><li>Shoe polish and floor polish</li><li>Cosmetics, creams and petroleum jelly</li><li>Rubber, adhesives and coatings</li></ul>',
		'seo'   => array(
			'title'         => 'Microcrystalline Wax WX-160S in Kampala, Uganda %sep% %sitename%',
			'description'   => 'Microcrystalline wax WX-160S (SJ Materials, Korea) in 25kg bags, available in Kampala. For candles, polishes, cosmetics and industrial use. Request a quote today.',
			'focus_keyword' => 'microcrystalline wax Uganda',
		),
	),
	array(
		'name'  => 'Micro Wax (Odourless)',
		'slug'  => 'micro-wax-odourless',
		'image' => 'micro-wax-odourless.jpg',
		'alt'   => 'Cartons of odourless micro wax, 24kg net per carton',
		'cats'  => array( $cat_wax, $cat_cosmetic ),
		'attrs' => array( 'Product' => 'Odourless microcrystalline wax', 'Packing' => 'Cartons, 24 kg net' ),
		'short' => '<ul><li><strong>Product:</strong> Odourless microcrystalline wax</li><li><strong>Packing:</strong> Cartons, 24 kg net weight</li></ul>',
		'desc'  => '<p><strong>Odourless micro wax</strong> is a refined microcrystalline wax with no smell, making it suitable for products where fragrance and purity matter.</p><h3>Common uses</h3><ul><li>Cosmetics, creams and lip products</li><li>Petroleum jelly and ointments</li><li>Scented and decorative candles</li><li>Polishes and coatings</li></ul>',
		'seo'   => array(
			'title'         => 'Odourless Micro Wax in Kampala, Uganda %sep% %sitename%',
			'description'   => 'Odourless microcrystalline wax in 24kg cartons, available in Kampala. Ideal for cosmetics, petroleum jelly, candles and polishes. Get a quote from Wipaco.',
			'focus_keyword' => 'micro wax Kampala',
		),
	),
);

$products = array_merge( $products, require '/setup/products-more.php' );

$cat_images = array();
foreach ( $products as $order => $p ) {
	$existing = get_page_by_path( $p['slug'], OBJECT, 'product' );
	$product  = $existing ? wc_get_product( $existing->ID ) : new WC_Product_Simple();

	$attributes = array();
	foreach ( $p['attrs'] as $label => $value ) {
		$attr = new WC_Product_Attribute();
		$attr->set_name( $label );
		$attr->set_options( array( $value ) );
		$attr->set_visible( true );
		$attributes[] = $attr;
	}

	$image_id = wsetup_image( $dir . $p['image'], $p['alt'] );
	$product->set_name( $p['name'] );
	$product->set_slug( $p['slug'] );
	$product->set_status( 'publish' );
	$product->set_catalog_visibility( 'visible' );
	$product->set_short_description( $p['short'] );
	$product->set_description( $p['desc'] );
	$product->set_category_ids( $p['cats'] );
	$product->set_image_id( $image_id );
	$product->set_gallery_image_ids( array_map( fn( $g ) => wsetup_image( $dir . $g, $p['alt'] ), $p['gallery'] ?? array() ) );
	$product->set_attributes( $attributes );
	$product->set_menu_order( $order );
	$product->set_reviews_allowed( false );
	$id = $product->save();
	wsetup_seo( $id, $p['seo'] );
	update_post_meta( $id, 'rank_math_primary_product_cat', $p['cats'][0] ); // main category = first listed

	// Category photo: the first product listed with that category as its main (first) category.
	$cat_images[ $p['cats'][0] ] = $cat_images[ $p['cats'][0] ] ?? $image_id;
	WP_CLI::log( "Product: {$p['name']} (#$id)" );
}
foreach ( $cat_images as $cat => $image_id ) {
	update_term_meta( $cat, 'thumbnail_id', $image_id );
}

/* ---------- FAQs, guides, privacy policy, product list ---------- */

require '/setup/content-extra.php'; // absolute: eval-file code has no usable __DIR__

/* ---------- Menu ---------- */

$menu = wp_get_nav_menu_object( 'Main menu' );
$menu_id = $menu ? $menu->term_id : wp_create_nav_menu( 'Main menu' );
foreach ( wp_get_nav_menu_items( $menu_id ) ?: array() as $item ) {
	wp_delete_post( $item->ID, true );
}
$items = array(
	$home                                => 'Home',
	$shop_id                             => 'Products',
	get_page_by_path( 'about' )->ID      => 'About Us',
	get_page_by_path( 'guides' )->ID     => 'Guides',
	get_page_by_path( 'contact' )->ID    => 'Contact',
);
foreach ( $items as $page_id => $label ) {
	wp_update_nav_menu_item( $menu_id, 0, array(
		'menu-item-title'     => $label,
		'menu-item-object'    => 'page',
		'menu-item-object-id' => $page_id,
		'menu-item-type'      => 'post_type',
		'menu-item-status'    => 'publish',
	) );
}
set_theme_mod( 'nav_menu_locations', array( 'primary' => $menu_id ) );

/* ---------- Rank Math: skip the account-connect wizard so SEO output and the sitemap are active ---------- */

update_option( 'rank_math_registration_skip', 1 );
update_option( 'rank_math_wizard_completed', 1 );
// Only the SEO features Wipaco uses: sitemap, structured data and WooCommerce SEO (no Content AI, link suggestions, analytics).
update_option( 'rank_math_modules', array( 'sitemap', 'rich-snippet', 'woocommerce' ) );
delete_option( 'rewrite_rules' );

/* ---------- Site icon (favicon) ---------- */

$icon_id = wsetup_image( get_template_directory() . '/assets/img/icon.png', 'Wipaco icon' );
update_option( 'site_icon', $icon_id );

WP_CLI::success( 'Wipaco content created.' );
