<?php
/**
 * Extra content: product FAQs, guides (blog), Privacy Policy, Product List page.
 * Loaded by content.php (uses its helpers wsetup_page / wsetup_seo / wsetup_image). Safe to re-run.
 */

/* ---------- Product FAQs ---------- */

$faqs = array(
	'caustic-soda-flakes' => "What is caustic soda used for in soap making?
Caustic soda reacts with oils and fats to make bar soap (saponification). In liquid soap it is used to neutralise LABSA.

How should I store caustic soda flakes?
Keep bags tightly closed in a dry place, off the floor. Caustic soda absorbs moisture from the air and becomes sticky and lumpy if left open.

What is the difference between caustic soda flakes and pearls?
They are the same chemical, sodium hydroxide. Pearls are small round beads that pour and measure more easily; flakes are thin pieces. Read our guide on choosing between them.",

	'caustic-soda-pearls' => "Are caustic soda pearls stronger than flakes?
No. Both are sodium hydroxide. Our pearls are 99% pure; the main difference is the shape, which makes pearls easier to pour, measure and dissolve evenly.

Why must caustic soda be added to water, and not water to caustic soda?
Dissolving caustic soda releases a lot of heat. Adding water onto caustic soda can make it boil and splash. Always add caustic soda slowly to cold water while stirring.",

	'soda-ash-dense' => "Is soda ash the same as caustic soda?
No. Soda ash is sodium carbonate, a milder alkali. Caustic soda is sodium hydroxide, which is much stronger. Both are used in detergents and water treatment.

What does 'dense' soda ash mean?
Dense soda ash has larger, heavier granules than light soda ash. It is less dusty and is preferred for washing powder and glass making.

Can this soda ash be used in food?
No. This is industrial grade soda ash and is not for edible or medicinal use.",

	'labsa-linear-alkyl-benzene-sulphonic-acid' => "What is LABSA used for?
LABSA is the main cleaning (foaming and grease-removing) ingredient in liquid soap, washing powder, dishwashing liquid and many household cleaners.

Does LABSA need to be neutralised?
Yes. LABSA is an acid. It is neutralised with caustic soda or soda ash to a pH of about 7 to 8 before use. Our liquid soap guide explains how.

How should LABSA drums be stored?
Keep drums closed and upright, in the shade and away from alkalis such as caustic soda. LABSA is corrosive, so wear gloves and goggles when handling it.",

	'microcrystalline-wax-wx-160s' => "How is microcrystalline wax different from paraffin wax?
Microcrystalline wax has much finer crystals. It is more flexible, slightly sticky and holds oil better, so it is often blended with paraffin wax to improve strength and finish.

Can I use microcrystalline wax for candles?
Yes, usually blended with paraffin wax. It reduces cracking and improves how the candle holds fragrance. Ask us for advice on blend ratios for your product.",

	'sles-70-texapon' => "What is the difference between SLES and LABSA?
Both are cleaning and foaming agents. LABSA is an acid that must be neutralised and is cheaper; SLES is already neutral, gentler on skin and gives richer foam. Many liquid soaps use both.

Why is SLES 70% so thick?
It is a concentrated paste. Add it slowly to water while stirring and give it time to dissolve fully.",

	'chlorine-65-calcium-hypochlorite' => "What is chlorine 65% used for?
It disinfects drinking water, swimming pools and water tanks, and sanitises premises such as farms, food factories and hospitals.

Can chlorine be mixed with other chemicals?
No. Never mix chlorine with acids (such as hydrochloric acid), ammonia or other cleaning products - this can release toxic gas. Always add chlorine to water.

How should chlorine be stored?
Keep the container tightly closed in a cool, dry and shaded place, away from heat, acids and anything that can burn.",

	'hydrochloric-acid-33' => "What is hydrochloric acid 33% used for?
Water treatment and pH control, cleaning and descaling metal and equipment, making toilet and tile cleaners, and chemical processing.

How do I dilute hydrochloric acid safely?
Wear gloves and goggles, work in a ventilated area, and always pour the acid slowly into water - never water into acid.",

	'micro-wax-odourless' => "Why choose odourless micro wax?
It has no smell, so it does not affect the fragrance of cosmetics, ointments or scented candles.

How is it packed?
In cartons of 24 kg net weight.",
);

foreach ( $faqs as $slug => $text ) {
	$product = get_page_by_path( $slug, OBJECT, 'product' );
	if ( $product ) {
		update_post_meta( $product->ID, '_wipaco_faq', $text );
	}
}

/* ---------- Guides ---------- */

$guides_page = wsetup_page( 'guides', 'Guides', '', array(
	'title'       => 'Chemical Guides for Manufacturers in Uganda %sep% %sitename%',
	'description' => 'Practical guides from Wipaco Investiments: making liquid soap with LABSA, choosing caustic soda, and handling industrial chemicals safely.',
) );
update_option( 'page_for_posts', $guides_page );
update_option( 'posts_per_page', 9 );

$guides = array(
	array(
		'slug'     => 'how-to-make-liquid-soap-with-labsa',
		'title'    => 'How to Make Liquid Soap with LABSA: A Beginner\'s Guide',
		'image'    => 'labsa-drum.jpg',
		'alt'      => 'LABSA drums used for making liquid soap',
		'products' => 'labsa-linear-alkyl-benzene-sulphonic-acid,sles-70-texapon,soda-ash-dense',
		'excerpt'  => 'A step-by-step guide to making liquid soap with LABSA in Uganda: ingredients, neutralising with soda ash or caustic soda, and checking pH.',
		'seo'      => array(
			'title'         => 'How to Make Liquid Soap with LABSA in Uganda (Step by Step) %sep% %sitename%',
			'description'   => 'Learn how to make liquid soap with LABSA: ingredients, how to neutralise with soda ash or caustic soda, pH testing and safety. Buy LABSA in Kampala from Wipaco.',
			'focus_keyword' => 'how to make liquid soap with LABSA',
		),
		'content'  => <<<HTML
<!-- wp:paragraph -->
<p>Liquid soap is one of the easiest cleaning products to start making, and LABSA (Linear Alkyl Benzene Sulphonic Acid) is the ingredient that does most of the cleaning. This guide explains the basic process used by many small producers in Uganda.</p>
<!-- /wp:paragraph -->

<!-- wp:html -->
<div class="callout"><p><strong>Safety first:</strong> LABSA is an acid and caustic soda is a strong alkali. Wear gloves, goggles and long sleeves, work in a ventilated area and keep children away. See our <a href="/safe-handling-caustic-soda-and-labsa/">safe handling guide</a>.</p></div>
<!-- /wp:html -->

<!-- wp:heading -->
<h2 class="wp-block-heading">What you need</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul><li><strong>LABSA</strong> - the active cleaning ingredient</li><li><strong>A neutraliser</strong> - soda ash (sodium carbonate) or caustic soda (sodium hydroxide)</li><li><strong>Clean water</strong></li><li><strong>A thickener</strong> - commonly SLES or a little common salt</li><li><strong>Optional:</strong> colour, perfume and a preservative</li><li><strong>Equipment:</strong> plastic drums or buckets and a plastic or wooden stirrer (not aluminium), measuring jugs, a kitchen scale and pH strips</li></ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Why LABSA must be neutralised</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>LABSA is acidic, so on its own it would irritate skin. Adding an alkali (soda ash or caustic soda) turns it into a mild, neutral detergent. As a rough guide, 1 kg of LABSA needs about <strong>120-130 g of caustic soda</strong> or about <strong>160 g of soda ash</strong> to neutralise it. The exact amount depends on the strength of your LABSA, so always finish by testing the pH.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Step by step</h2>
<!-- /wp:heading -->

<!-- wp:list {"ordered":true} -->
<ol><li><strong>Add water first.</strong> Pour most of your water (for example 15 litres for a 20 litre batch) into a clean plastic drum.</li><li><strong>Add the LABSA slowly</strong> while stirring gently until it is fully mixed. Stir slowly to avoid too much foam.</li><li><strong>Dissolve the neutraliser separately.</strong> Dissolve the soda ash or caustic soda in 1-2 litres of water in a separate container. Always add the chemical to the water, never the other way round. Caustic soda solution gets hot.</li><li><strong>Neutralise gradually.</strong> Add the neutraliser solution a little at a time, stirring after each addition. Check with a pH strip. Stop when the pH is about <strong>7 to 8</strong>.</li><li><strong>Thicken.</strong> Add your thickener slowly. If you use salt, dissolve it in water first and add in small amounts, because too much salt makes the soap thin again.</li><li><strong>Finish.</strong> Add colour, perfume and preservative, then top up with water to your final volume.</li><li><strong>Rest.</strong> Cover and leave overnight so the foam settles and the soap clears, then pack into clean bottles.</li></ol>
<!-- /wp:list -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Tips for a better product</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul><li>Make a small test batch first and write down exact quantities, so every batch is the same.</li><li>Use clean, preferably treated water. Hard water reduces foam.</li><li>Label your product and store it out of direct sunlight.</li><li>If you plan to sell your soap, check the Uganda National Bureau of Standards (UNBS) requirements for certification.</li></ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>Need LABSA, soda ash or caustic soda? Wipaco Investiments supplies all three from our shop on Johnson Street, Kampala. <a href="/request-quote/">Request a quote</a> or message us on WhatsApp.</p>
<!-- /wp:paragraph -->
HTML,
	),
	array(
		'slug'     => 'caustic-soda-flakes-vs-pearls',
		'title'    => 'Caustic Soda Flakes vs Pearls: Which Should You Buy?',
		'image'    => 'caustic-soda-pearls-bags.jpg',
		'alt'      => 'Bags of caustic soda pearls',
		'products' => 'caustic-soda-flakes,caustic-soda-pearls',
		'excerpt'  => 'Flakes and pearls are both caustic soda (sodium hydroxide). Here is how they differ in handling, measuring and dissolving, and which suits your business.',
		'seo'      => array(
			'title'         => 'Caustic Soda Flakes vs Pearls: Which Is Better? %sep% %sitename%',
			'description'   => 'Caustic soda flakes or pearls? Both are sodium hydroxide. Compare handling, measuring, dissolving and storage to choose the right one for soap making and industry.',
			'focus_keyword' => 'caustic soda flakes vs pearls',
		),
		'content'  => <<<HTML
<!-- wp:paragraph -->
<p>Customers often ask whether they should buy caustic soda <strong>flakes</strong> or <strong>pearls</strong>. The short answer: they are the same chemical, sodium hydroxide (NaOH), and do the same job. The difference is mainly in the shape, which affects handling.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Side by side</h2>
<!-- /wp:heading -->

<!-- wp:table -->
<figure class="wp-block-table"><table><thead><tr><th></th><th>Flakes</th><th>Pearls</th></tr></thead><tbody><tr><td><strong>Chemical</strong></td><td>Sodium hydroxide (NaOH)</td><td>Sodium hydroxide (NaOH)</td></tr><tr><td><strong>Shape</strong></td><td>Thin, irregular flakes</td><td>Small round beads</td></tr><tr><td><strong>Measuring</strong></td><td>Best weighed on a scale</td><td>Pours freely, easy to scoop and weigh</td></tr><tr><td><strong>Dissolving</strong></td><td>Dissolves quickly</td><td>Dissolves evenly</td></tr><tr><td><strong>Dust</strong></td><td>Can break into fine pieces</td><td>Less dusty</td></tr><tr><td><strong>Storage</strong></td><td colspan="2">Both absorb moisture from the air - keep bags sealed and dry</td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Which should you choose?</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul><li><strong>Choose pearls</strong> if you measure small amounts often, for example small-scale soap making, or if you want less dust when handling.</li><li><strong>Choose flakes</strong> if you dissolve large quantities at once, for example in bulk soap production or industrial cleaning, and price per kilogram matters most.</li></ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>Whichever you choose, the safety rules are the same: wear gloves and goggles, always add caustic soda to water (never water to caustic soda), and store it sealed and dry.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Not sure which is right for your process? Call or WhatsApp us and we will advise. We stock both <a href="/product/caustic-soda-flakes/">caustic soda flakes</a> and <a href="/product/caustic-soda-pearls/">caustic soda pearls 99%</a> in Kampala.</p>
<!-- /wp:paragraph -->
HTML,
	),
	array(
		'slug'     => 'safe-handling-caustic-soda-and-labsa',
		'title'    => 'Safe Handling and Storage of Caustic Soda and LABSA',
		'image'    => 'caustic-soda-flakes-bag.jpg',
		'alt'      => 'Caustic soda bags with corrosive hazard labels',
		'products' => 'caustic-soda-flakes,labsa-linear-alkyl-benzene-sulphonic-acid,caustic-soda-pearls',
		'excerpt'  => 'Protective gear, mixing rules, storage, spills and first aid: what every soap and detergent maker should know when working with caustic soda and LABSA.',
		'seo'      => array(
			'title'         => 'Safe Handling of Caustic Soda and LABSA: Storage & First Aid %sep% %sitename%',
			'description'   => 'How to handle caustic soda and LABSA safely: protective gear, mixing rules, storage, spills and first aid. Practical safety guide for soap and detergent makers.',
			'focus_keyword' => 'caustic soda safety',
		),
		'content'  => <<<HTML
<!-- wp:paragraph -->
<p>Caustic soda (sodium hydroxide) and LABSA are essential raw materials for soap and detergent makers, but both are corrosive. They can burn skin and seriously damage eyes. Following a few simple rules keeps you and your workers safe.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">1. Wear protective gear</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul><li>Chemical-resistant gloves (rubber or nitrile)</li><li>Safety goggles - eyes are the most at risk</li><li>Long sleeves, long trousers and closed shoes; an apron for larger batches</li><li>Work in a well-ventilated area</li></ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2 class="wp-block-heading">2. Follow the mixing rules</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul><li><strong>Always add the chemical to water</strong>, slowly and while stirring. Never pour water onto caustic soda or LABSA.</li><li>Dissolving caustic soda produces strong heat. Use cold water and heat-resistant plastic containers.</li><li>Do not use aluminium or zinc containers - caustic soda attacks these metals.</li><li>Never mix caustic soda and LABSA directly in concentrated form. Dilute each in water first.</li></ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2 class="wp-block-heading">3. Store correctly</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul><li>Keep bags and drums tightly closed, in a dry, shaded and ventilated place.</li><li>Store on pallets, off the floor, so bags do not absorb moisture.</li><li>Keep acids (LABSA) and alkalis (caustic soda, soda ash) apart.</li><li>Keep original labels on all containers and lock chemicals away from children.</li></ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2 class="wp-block-heading">4. Dealing with spills</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul><li><strong>Caustic soda (dry):</strong> sweep up carefully while dry and put it back in a closed container. Do not wet it first.</li><li><strong>LABSA:</strong> soak it up with sand or soil, collect it into a container, then wash the area with plenty of water.</li><li>Wear your gloves and goggles while cleaning up.</li></ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2 class="wp-block-heading">5. First aid</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul><li><strong>On skin:</strong> remove contaminated clothing and rinse with plenty of running water for at least 15 minutes.</li><li><strong>In eyes:</strong> rinse immediately with clean running water for at least 15 minutes, holding the eyelids open, and get medical help straight away.</li><li><strong>If swallowed:</strong> rinse the mouth with water, do not make the person vomit, and get medical help immediately.</li></ul>
<!-- /wp:list -->

<!-- wp:html -->
<div class="callout"><p>Keep a container of clean water near your work area at all times, so you can rinse immediately if there is a splash.</p></div>
<!-- /wp:html -->

<!-- wp:paragraph -->
<p>Have a question about a specific product? Our team in Kampala is happy to advise. <a href="/contact/">Contact us</a>.</p>
<!-- /wp:paragraph -->
HTML,
	),
);

foreach ( array_reverse( $guides ) as $i => $g ) {
	$existing = get_page_by_path( $g['slug'], OBJECT, 'post' );
	$data     = array(
		'post_type'    => 'post',
		'post_status'  => 'publish',
		'post_name'    => $g['slug'],
		'post_title'   => $g['title'],
		'post_excerpt' => $g['excerpt'],
		'post_content' => $g['content'],
	);
	if ( $existing ) {
		$data['ID'] = $existing->ID;
	} else {
		// Space publish dates a day apart so the first guide in the list shows first.
		$data['post_date'] = wp_date( 'Y-m-d H:i:s', time() - ( count( $guides ) - $i ) * DAY_IN_SECONDS );
	}
	$id = wp_insert_post( $data );
	set_post_thumbnail( $id, wsetup_image( '/setup/products/' . $g['image'], $g['alt'] ) );
	update_post_meta( $id, '_wipaco_products', $g['products'] );
	wsetup_seo( $id, $g['seo'] );
	WP_CLI::log( "Guide: {$g['title']} (#$id)" );
}
wp_update_term( (int) get_option( 'default_category' ), 'category', array( 'name' => 'Guides', 'slug' => 'guides-category' ) );

/* ---------- Privacy Policy (Uganda Data Protection and Privacy Act, 2019) ---------- */

$privacy_content = <<<HTML
<!-- wp:paragraph -->
<p>Wipaco Investiments Limited ("we", "us") respects your privacy. This policy explains what personal information we collect through this website, why, and your rights under the Data Protection and Privacy Act, 2019 of Uganda.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Information we collect</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>When you send a quote request or message, we collect the details you enter: your name, company, phone number, email address, the product and quantity you are interested in, and your message. If you contact us on WhatsApp, by phone or by email, we receive the details you share there.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>If website statistics are switched on, Google Analytics collects anonymous usage information such as pages visited, device type and approximate location, using cookies. This helps us understand how the website is used.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">How we use your information</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul><li>To reply to your enquiry and send you quotations</li><li>To process and deliver your orders</li><li>To improve our website and services</li></ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>We do not sell or rent your personal information. We only share it where needed to serve you (for example with a transport provider delivering your order) or where required by law.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">How long we keep it</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>We keep enquiry details only for as long as needed to serve you and to meet our legal and accounting obligations, then delete them.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Your rights</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>You may ask us to show you the personal information we hold about you, to correct it, or to delete it. You may also object to us using it. To do so, contact us using the details below. If you are not satisfied with our response, you may complain to the Personal Data Protection Office (PDPO) of Uganda.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Security</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>We take reasonable steps to protect your information against loss, misuse and unauthorised access.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Contact us</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Wipaco Investiments Limited, Shop No. L5 02, TransNile Link Building, Plot 10, Johnson Street, Kampala. Email: wipacoinvestiments@gmail.com. Tel: +256 786 876637. WhatsApp: +256 707 555500.</p>
<!-- /wp:paragraph -->
HTML;

$privacy_id = wsetup_page( 'privacy-policy', 'Privacy Policy', $privacy_content, array(
	'description' => 'How Wipaco Investiments Limited collects, uses and protects your personal information, and your rights under Uganda\'s Data Protection and Privacy Act, 2019.',
) );
update_option( 'wp_page_for_privacy_policy', $privacy_id );

/* ---------- Product List (printable / PDF) ---------- */

wsetup_page( 'product-list', 'Product List', '', array(
	'title'       => 'Industrial Chemicals Product List (PDF) %sep% %sitename%',
	'description' => 'Download or print the full Wipaco Investiments product list: caustic soda, soda ash, LABSA, microcrystalline wax and more. Kampala, Uganda.',
) );

/* ---------- Not needed until online payments ---------- */

update_option( 'woocommerce_feature_order_attribution_enabled', 'no' );
