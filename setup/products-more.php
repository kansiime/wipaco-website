<?php
/**
 * Additional products. Required from content.php (uses its $cat_* category IDs).
 * Specs come from the product labels; uses are general industry uses.
 */

$spec_list = function ( $attrs ) {
	$html = '<ul>';
	foreach ( $attrs as $label => $value ) {
		$html .= '<li><strong>' . esc_html( $label ) . ':</strong> ' . esc_html( $value ) . '</li>';
	}
	return $html . '</ul>';
};

$more = array(
	array(
		'name'  => 'SLES 70% (Texapon)',
		'slug'  => 'sles-70-texapon',
		'image' => 'sles-70.jpg',
		'alt'   => 'Drums of SLES 70% (Texapon) sodium lauryl ether sulphate',
		'cats'  => array( $cat_soap, $cat_cosmetic ),
		'attrs' => array( 'Chemical name' => 'Sodium lauryl ether sulphate (SLES)', 'Active content' => '70%', 'Also known as' => 'Texapon', 'Form' => 'Thick white paste', 'Packing' => 'Drums' ),
		'desc'  => '<p><strong>SLES 70%</strong> (sodium lauryl ether sulphate), widely known in Uganda as <strong>Texapon</strong>, is the main foaming and cleaning agent in liquid soaps, shampoos and dishwashing liquids. It gives rich foam and also helps thicken the final product.</p><h3>Common uses</h3><ul><li>Liquid soap and hand wash</li><li>Dishwashing liquid</li><li>Shampoo, body wash and bubble bath</li><li>Car wash and multipurpose cleaners</li></ul><h3>Handling tip</h3><p>SLES 70% is a thick paste. Add it slowly to water while stirring gently and allow time for it to dissolve completely before adding other ingredients.</p><p>Irritating to eyes and skin in concentrated form - wear gloves and goggles.</p>',
		'seo'   => array(
			'title'         => 'SLES 70% (Texapon) Supplier in Kampala, Uganda %sep% %sitename%',
			'description'   => 'Buy SLES 70% (Texapon, sodium lauryl ether sulphate) in Kampala. Foaming agent for liquid soap, shampoo and dishwashing liquid. Quote from Wipaco Investiments.',
			'focus_keyword' => 'SLES 70% Uganda',
		),
	),
	array(
		'name'  => 'CDEA / KDS (Coconut Diethanolamide)',
		'slug'  => 'cdea-coconut-diethanolamide',
		'image' => 'cdea.jpg',
		'alt'   => 'Drums of CDEA coconut diethanolamide',
		'cats'  => array( $cat_soap, $cat_cosmetic ),
		'attrs' => array( 'Chemical name' => 'Coconut fatty acid diethanolamide (CDEA)', 'Also known as' => 'KDS', 'Form' => 'Viscous liquid', 'Packing' => 'Drums' ),
		'desc'  => '<p><strong>CDEA</strong> (coconut diethanolamide), also sold as <strong>KDS</strong>, is a foam booster and thickener. A small amount makes liquid soaps and shampoos thicker, with richer and longer-lasting foam.</p><h3>Common uses</h3><ul><li>Liquid soap and hand wash</li><li>Dishwashing liquid</li><li>Shampoo and body wash</li><li>Car wash and cleaning products</li></ul>',
		'seo'   => array(
			'title'         => 'CDEA / KDS Foam Booster in Kampala, Uganda %sep% %sitename%',
			'description'   => 'CDEA (coconut diethanolamide, KDS) foam booster and thickener for liquid soap, shampoo and dishwashing liquid. Available in Kampala from Wipaco Investiments.',
			'focus_keyword' => 'CDEA Uganda',
		),
	),
	array(
		'name'  => 'Sodium Tripolyphosphate (STPP)',
		'slug'  => 'sodium-tripolyphosphate-stpp',
		'image' => 'stpp.jpg',
		'alt'   => '25kg bag of sodium tripolyphosphate STPP with white powder and granules',
		'cats'  => array( $cat_soap ),
		'attrs' => array( 'Chemical name' => 'Sodium tripolyphosphate (Na5P3O10)', 'CAS number' => '7758-29-4', 'Form' => 'White powder / granules', 'Packing' => '25 kg bags' ),
		'desc'  => '<p><strong>STPP</strong> (sodium tripolyphosphate) is a detergent "builder". It softens hard water so that soap and detergent can clean better, and keeps dirt from settling back on fabrics.</p><h3>Common uses</h3><ul><li>Washing powder and laundry detergents</li><li>Dishwashing powders</li><li>Industrial and institutional cleaners</li><li>Dispersant in ceramics and paints</li></ul>',
		'seo'   => array(
			'title'         => 'Sodium Tripolyphosphate (STPP) in Kampala, Uganda %sep% %sitename%',
			'description'   => 'STPP (sodium tripolyphosphate) in 25kg bags, available in Kampala. Detergent builder for washing powder and cleaners. Get a quote from Wipaco Investiments.',
			'focus_keyword' => 'STPP Uganda',
		),
	),
	array(
		'name'  => 'CMC (Sodium Carboxymethyl Cellulose)',
		'slug'  => 'cmc-sodium-carboxymethyl-cellulose',
		'image' => 'cmc.jpg',
		'alt'   => '25kg bags of CMC sodium carboxymethyl cellulose',
		'cats'  => array( $cat_soap ),
		'attrs' => array( 'Chemical name' => 'Sodium carboxymethyl cellulose (CMC)', 'CAS number' => '9004-32-4', 'Form' => 'White to off-white powder', 'Origin' => 'China', 'Packing' => '25 kg bags' ),
		'desc'  => '<p><strong>CMC</strong> (sodium carboxymethyl cellulose) is a thickener and stabiliser. In washing powder it stops dirt from settling back onto clothes; in liquid products it adds body and smoothness.</p><h3>Common uses</h3><ul><li>Washing powder and detergents</li><li>Thickening liquid soaps and cleaners</li><li>Paints, adhesives and textile sizing</li><li>Paper and ceramics</li></ul><h3>Handling tip</h3><p>Sprinkle CMC slowly into water while stirring to avoid lumps, then allow time for it to fully swell.</p>',
		'seo'   => array(
			'title'         => 'CMC (Carboxymethyl Cellulose) Supplier in Kampala %sep% %sitename%',
			'description'   => 'CMC sodium carboxymethyl cellulose in 25kg bags, available in Kampala, Uganda. Thickener for detergents, liquid soap, paints and adhesives.',
			'focus_keyword' => 'CMC Uganda',
		),
	),
	array(
		'name'  => 'Sodium Metasilicate Pentahydrate',
		'slug'  => 'sodium-metasilicate-pentahydrate',
		'image' => 'sodium-metasilicate.jpg',
		'alt'   => '25kg bag of sodium metasilicate pentahydrate, product of China',
		'cats'  => array( $cat_soap, $cat_alkalis ),
		'attrs' => array( 'Chemical name' => 'Sodium metasilicate pentahydrate (Na2SiO3·5H2O)', 'CAS number' => '10213-79-3', 'Hazard class' => 'UN 3253, Class 8 (corrosive)', 'Shelf life' => 'Two years', 'Origin' => 'China', 'Packing' => '25 kg bags' ),
		'desc'  => '<p><strong>Sodium metasilicate pentahydrate</strong> is a strong alkaline cleaning agent and detergent builder. It removes grease and oil, softens water and protects metal surfaces from corrosion.</p><h3>Common uses</h3><ul><li>Washing powder and laundry detergents</li><li>Industrial degreasers and floor cleaners</li><li>Metal cleaning before painting or plating</li><li>Textile processing</li></ul><h3>Safety &amp; storage</h3><p>Corrosive (UN 3253, Class 8). Wear gloves and eye protection. Keep bags closed and dry.</p>',
		'seo'   => array(
			'title'         => 'Sodium Metasilicate Pentahydrate in Kampala, Uganda %sep% %sitename%',
			'description'   => 'Sodium metasilicate pentahydrate in 25kg bags, available in Kampala. Detergent builder and degreaser for washing powder and industrial cleaners.',
			'focus_keyword' => 'sodium metasilicate Uganda',
		),
	),
	array(
		'name'  => 'Perfumes & Fragrances',
		'slug'  => 'perfumes-fragrances',
		'image' => 'perfumes-fragrances-square.jpg',
		'alt'   => 'Aluminium bottles of perfume and fragrance oils for soaps and cosmetics',
		'cats'  => array( $cat_soap, $cat_cosmetic ),
		'attrs' => array( 'Product' => 'Fragrance oils / perfume compounds', 'For' => 'Soaps, detergents, cosmetics and air fresheners', 'Packing' => 'Aluminium bottles' ),
		'desc'  => '<p>Concentrated <strong>perfumes and fragrance oils</strong> that give your products a pleasant, lasting scent. Ask us for the scents currently in stock.</p><h3>Common uses</h3><ul><li>Liquid soap, bar soap and hand wash</li><li>Washing powder and detergents</li><li>Dishwashing liquid and cleaners</li><li>Lotions, creams and hair products</li><li>Air fresheners</li></ul><h3>Tip</h3><p>Add fragrance at the end of your process, when the mixture has cooled, and test a small batch first to find the right amount.</p>',
		'seo'   => array(
			'title'         => 'Soap & Detergent Perfumes and Fragrances in Kampala %sep% %sitename%',
			'description'   => 'Perfumes and fragrance oils for liquid soap, bar soap, detergents, cosmetics and air fresheners. Available in Kampala, Uganda from Wipaco Investiments.',
			'focus_keyword' => 'soap perfume Uganda',
		),
	),
	array(
		'name'  => 'Glycerine',
		'slug'  => 'glycerine',
		'image' => 'glycerine.jpg',
		'alt'   => 'Blue drum of glycerine',
		'cats'  => array( $cat_cosmetic, $cat_soap ),
		'attrs' => array( 'Chemical name' => 'Glycerol (glycerine)', 'CAS number' => '56-81-5', 'Form' => 'Clear, viscous liquid', 'Packing' => 'Drums' ),
		'desc'  => '<p><strong>Glycerine</strong> (glycerol) is a clear, odourless liquid that attracts and holds moisture. It keeps skin soft and is one of the most used ingredients in personal care products.</p><h3>Common uses</h3><ul><li>Body lotions, creams and petroleum jelly</li><li>Hair products</li><li>Transparent soaps and liquid hand wash</li><li>Hand sanitisers</li><li>Industrial uses such as antifreeze and lubricants</li></ul>',
		'seo'   => array(
			'title'         => 'Glycerine Supplier in Kampala, Uganda %sep% %sitename%',
			'description'   => 'Buy glycerine (glycerol) in drums in Kampala. For lotions, creams, soaps, hand sanitiser and industrial use. Quote from Wipaco Investiments.',
			'focus_keyword' => 'glycerine Uganda',
		),
	),
	array(
		'name'  => 'White Oil (Liquid Paraffin Oil)',
		'slug'  => 'white-oil-liquid-paraffin',
		'image' => 'white-oil.jpg',
		'alt'   => 'Drum of white liquid paraffin oil',
		'cats'  => array( $cat_wax, $cat_cosmetic ),
		'attrs' => array( 'Product' => 'White mineral oil (liquid paraffin)', 'Form' => 'Clear, colourless, odourless liquid', 'Packing' => 'Drums' ),
		'desc'  => '<p><strong>White oil</strong>, also called <strong>liquid paraffin oil</strong>, is a clear, colourless and odourless mineral oil. It moisturises, adds shine and blends easily with waxes.</p><h3>Common uses</h3><ul><li>Petroleum jelly and baby oil</li><li>Hair oils, creams and lotions</li><li>Polishes</li><li>Lubricants, textile and rubber processing</li></ul>',
		'seo'   => array(
			'title'         => 'White Oil / Liquid Paraffin Oil in Kampala, Uganda %sep% %sitename%',
			'description'   => 'White oil (liquid paraffin oil) in drums, available in Kampala. For petroleum jelly, baby oil, hair products, cosmetics and industrial use.',
			'focus_keyword' => 'white oil Uganda',
		),
	),
	array(
		'name'  => 'Paraffin Wax (Fully Refined No. 58)',
		'slug'  => 'paraffin-wax',
		'image' => 'paraffin-wax.jpg',
		'alt'   => 'Carton of Kunlun No. 58 fully refined paraffin wax',
		'cats'  => array( $cat_wax ),
		'attrs' => array( 'Product' => 'Fully refined paraffin wax', 'Grade' => 'No. 58 (melting point about 58 °C)', 'Brand' => 'Kunlun', 'Use' => 'Industrial', 'Packing' => 'Cartons' ),
		'desc'  => '<p><strong>Fully refined paraffin wax</strong>, Kunlun No. 58 grade. A clean, white wax that is easy to melt, mould and colour, and the base material for most candles.</p><h3>Common uses</h3><ul><li>Candle making</li><li>Shoe and floor polish</li><li>Petroleum jelly and cosmetic blends</li><li>Crayons, packaging and waterproofing</li></ul><p>For stronger candles that crack less, blend with our <a href="/product/microcrystalline-wax-wx-160s/">microcrystalline wax</a>.</p>',
		'seo'   => array(
			'title'         => 'Paraffin Wax Supplier in Kampala, Uganda %sep% %sitename%',
			'description'   => 'Fully refined paraffin wax (Kunlun No. 58) in cartons, available in Kampala. For candles, polishes and petroleum jelly. Get a quote from Wipaco.',
			'focus_keyword' => 'paraffin wax Uganda',
		),
	),
	array(
		'name'  => 'Hydrochloric Acid 33%',
		'slug'  => 'hydrochloric-acid-33',
		'image' => 'hydrochloric-acid.jpg',
		'alt'   => '40kg jerrycan of hydrochloric acid 33%, UN 1789',
		'cats'  => array( $cat_acids, $cat_water ),
		'attrs' => array( 'Chemical name' => 'Hydrochloric acid (HCl)', 'Concentration' => '33%', 'CAS number' => '7647-01-0', 'Hazard class' => 'UN 1789, Class 8 (corrosive)', 'Origin' => 'India', 'Packing' => '40 kg jerrycans' ),
		'desc'  => '<p><strong>Hydrochloric acid 33%</strong> (HCl), also called muriatic acid, is a strong acid used across industry for cleaning, descaling and pH control.</p><h3>Common uses</h3><ul><li>pH adjustment and water treatment</li><li>Metal cleaning and pickling</li><li>Descaling boilers and equipment</li><li>Toilet, tile and heavy-duty cleaners</li><li>Chemical processing</li></ul><h3>Safety &amp; storage</h3><p>Corrosive with irritating fumes. Use gloves, goggles and good ventilation. Always add acid to water, never water to acid. <strong>Never mix with chlorine or bleach</strong> - this releases toxic chlorine gas. Store closed, away from alkalis and metals.</p>',
		'seo'   => array(
			'title'         => 'Hydrochloric Acid 33% Supplier in Kampala, Uganda %sep% %sitename%',
			'description'   => 'Hydrochloric acid 33% (HCl) in 40kg jerrycans, available in Kampala. For water treatment, cleaning, descaling and processing. Quote from Wipaco Investiments.',
			'focus_keyword' => 'hydrochloric acid Uganda',
		),
	),
	array(
		'name'  => 'Citric Acid (Monohydrate & Anhydrous)',
		'slug'  => 'citric-acid',
		'image' => 'citric-acid.jpg',
		'alt'   => '25kg bags of TTCA citric acid monohydrate and anhydrous',
		'cats'  => array( $cat_acids, $cat_soap ),
		'attrs' => array( 'Chemical name' => 'Citric acid (C6H8O7)', 'Grades' => 'Monohydrate and anhydrous, E330 (USP / FCC / BP / EP as labelled)', 'CAS number' => '77-92-9 (anhydrous)', 'Manufacturer' => 'TTCA Co., Ltd, China', 'Packing' => '25 kg bags' ),
		'desc'  => '<p><strong>Citric acid</strong> is a mild, natural acid supplied in two forms: <strong>monohydrate</strong> and <strong>anhydrous</strong> (water-free). Both are made by TTCA in China and labelled E330.</p><h3>Common uses</h3><ul><li>pH adjustment in liquid soaps and detergents</li><li>Descaling and kettle cleaners</li><li>Water treatment</li><li>Cosmetics and personal care</li><li>Food and beverages (E330)</li></ul>',
		'seo'   => array(
			'title'         => 'Citric Acid Monohydrate & Anhydrous in Kampala %sep% %sitename%',
			'description'   => 'Citric acid monohydrate and anhydrous (TTCA, E330) in 25kg bags, available in Kampala. For detergents, descalers, cosmetics and food processing.',
			'focus_keyword' => 'citric acid Uganda',
		),
	),
	array(
		'name'    => 'Chlorine 65% (Calcium Hypochlorite)',
		'slug'    => 'chlorine-65-calcium-hypochlorite',
		'image'   => 'chlorine-65.jpg',
		'gallery' => array( 'chlorine-65-bucket.jpg', 'chlorine-65-drum.jpg' ),
		'alt'     => 'Jal Aqua Aquatick calcium hypochlorite chlorine in bucket and 45kg drum',
		'cats'    => array( $cat_water ),
		'attrs'   => array( 'Chemical name' => 'Calcium hypochlorite', 'Strength' => '65% chlorine', 'Brand' => 'Jal Aqua - Aquatick', 'Packing' => 'Buckets and 45 kg drums' ),
		'desc'    => '<p><strong>Chlorine 65%</strong> (calcium hypochlorite), Jal Aqua Aquatick brand, is a powerful disinfectant for water and surfaces. It kills bacteria and other germs quickly and is easy to store and dose.</p><h3>Common uses</h3><ul><li>Drinking water disinfection</li><li>Swimming pools</li><li>Cleaning and sanitising water tanks</li><li>Sanitation in farms, food factories, hotels and hospitals</li><li>Bleaching</li></ul><h3>Safety &amp; storage</h3><p>Strong oxidiser. Store in a cool, dry place with the lid closed, away from heat. <strong>Never mix with acids, ammonia or other chemicals</strong> - this can release toxic gas or start a fire. Wear gloves and goggles, and add chlorine to water, never water to chlorine.</p>',
		'seo'     => array(
			'title'         => 'Chlorine 65% (Calcium Hypochlorite) in Kampala, Uganda %sep% %sitename%',
			'description'   => 'Chlorine 65% calcium hypochlorite (Aquatick) in buckets and 45kg drums, available in Kampala. For water treatment, swimming pools and sanitation.',
			'focus_keyword' => 'chlorine 65% Uganda',
		),
	),
	array(
		'name'  => 'Formalin (Formaldehyde 37%)',
		'slug'  => 'formalin-formaldehyde-37',
		'image' => 'formalin.jpg',
		'alt'   => 'Jerrycan of formalin, formaldehyde 37% from India',
		'cats'  => array( $cat_specialty ),
		'attrs' => array( 'Chemical name' => 'Formaldehyde solution 37% (formalin)', 'CAS number' => '50-00-0', 'Origin' => 'India', 'Packing' => 'Jerrycans (about 36.8 kg gross)' ),
		'desc'  => '<p><strong>Formalin</strong> is a 37% solution of formaldehyde in water. It is a strong preservative and disinfectant and a raw material for resins and adhesives.</p><h3>Common uses</h3><ul><li>Resins and adhesives for wood and board</li><li>Preservation and disinfection</li><li>Textile finishing and leather processing</li><li>Laboratories</li></ul><h3>Safety &amp; storage</h3><p>Toxic and flammable - for industrial use only. Avoid breathing vapours and work in a well-ventilated area with gloves and goggles. Keep the container closed and away from heat, sparks and flames.</p>',
		'seo'   => array(
			'title'         => 'Formalin (Formaldehyde 37%) Supplier in Kampala %sep% %sitename%',
			'description'   => 'Formalin (formaldehyde 37%) in jerrycans, available in Kampala, Uganda. For resins, adhesives, preservation and textile processing. Industrial use.',
			'focus_keyword' => 'formalin Uganda',
		),
	),
	array(
		'name'  => 'Titanium Dioxide R1930',
		'slug'  => 'titanium-dioxide-r1930',
		'image' => 'titanium-dioxide-r1930.jpg',
		'alt'   => '25kg bag of titanium dioxide R1930, made in China',
		'cats'  => array( $cat_specialty ),
		'attrs' => array( 'Chemical name' => 'Titanium dioxide (TiO2)', 'Grade' => 'R1930', 'CAS number' => '13463-67-7', 'Origin' => 'China', 'Packing' => '25 kg bags' ),
		'desc'  => '<p><strong>Titanium dioxide</strong> (TiO2), grade R1930, is a bright white pigment. It gives paints, plastics and other products strong whiteness and good coverage (opacity).</p><h3>Common uses</h3><ul><li>Paints and coatings</li><li>Plastics and rubber</li><li>Printing inks</li><li>Paper</li><li>Whitening soaps and other products</li></ul>',
		'seo'   => array(
			'title'         => 'Titanium Dioxide R1930 Supplier in Kampala, Uganda %sep% %sitename%',
			'description'   => 'Titanium dioxide (TiO2) R1930 in 25kg bags, available in Kampala. White pigment for paints, coatings, plastics and inks. Quote from Wipaco Investiments.',
			'focus_keyword' => 'titanium dioxide Uganda',
		),
	),
);

// Melt & pour soap bases: same how-to text, different type.
$soap_base_howto = '<h3>How to use</h3><ol><li>Cut the base into small cubes.</li><li>Melt gently in a double boiler or in short bursts in a microwave - do not let it boil.</li><li>Stir in colour, fragrance or additives.</li><li>Pour into moulds and leave to set, then unmould and wrap.</li></ol><p>No caustic soda handling is needed, which makes soap bases ideal for beginners and small producers.</p>';
$soap_bases = array(
	array( 'Glycerin', 'glycerin', 'soap-base-glycerin.jpg', 'Clear, translucent', 'A clear base that shows off colours and embedded items, and leaves skin feeling soft.', array( 'soap-bases-all.jpg', 'soap-bases-blocks.jpg', 'soap-bases-bars.jpg' ) ),
	array( "Goat's Milk", 'goats-milk', 'soap-base-goats-milk.jpg', 'Creamy white, opaque', "A rich, creamy white base made with goat's milk, popular for gentle and moisturising soaps.", array( 'soap-bases-all.jpg', 'soap-bases-blocks.jpg', 'soap-bases-bars.jpg' ) ),
	array( 'Charcoal', 'charcoal', 'soap-base-charcoal.jpg', 'Black', 'A striking black base with charcoal, popular for face and deep-cleansing soaps.', array( 'soap-bases-all.jpg' ) ),
	array( 'Aloe Vera', 'aloe-vera', 'soap-base-aloe-vera.jpg', 'Light green, translucent', 'A light green base with aloe vera, popular for soothing everyday soaps.', array( 'soap-bases-all.jpg', 'soap-bases-blocks.jpg', 'soap-bases-bars.jpg' ) ),
);
foreach ( $soap_bases as list( $type, $slug, $image, $look, $intro, $gallery ) ) {
	$more[] = array(
		'name'    => "$type Soap Base (Melt & Pour)",
		'slug'    => "$slug-soap-base",
		'image'   => $image,
		'gallery' => $gallery,
		'alt'     => "Block of $type melt and pour soap base",
		'cats'    => array( $cat_soapbase, $cat_cosmetic ),
		'attrs'   => array( 'Product' => "$type melt and pour soap base", 'Appearance' => $look, 'Packing' => 'Wrapped blocks' ),
		'desc'    => "<p><strong>$type soap base</strong> is a ready-made melt and pour soap. $intro Melt it, add your colour and fragrance, and pour into moulds to make beautiful bars in minutes.</p><h3>Popular for</h3><ul><li>Handmade and natural soaps</li><li>Hotel and guest soaps</li><li>Gift and wedding favours</li><li>Soap-making classes and small businesses</li></ul>" . $soap_base_howto,
		'seo'     => array(
			'title'         => "$type Soap Base (Melt & Pour) in Kampala, Uganda %sep% %sitename%",
			'description'   => "$type melt and pour soap base available in Kampala, Uganda. Melt, add colour and fragrance, and pour - no caustic soda needed. Quote from Wipaco Investiments.",
			'focus_keyword' => strtolower( $type ) . ' soap base Uganda',
		),
	);
}

$more[] = array(
	'name'  => 'Hydrogen Peroxide 50%',
	'slug'  => 'hydrogen-peroxide-50',
	'image' => 'hydrogen-peroxide-50.jpg',
	'alt'   => 'Jerrycan of hydrogen peroxide 50%, UN 2014',
	'cats'  => array( $cat_specialty, $cat_water ),
	'attrs' => array( 'Chemical name' => 'Hydrogen peroxide solution (H2O2)', 'Concentration' => '50%', 'CAS number' => '7722-84-1', 'Hazard class' => 'UN 2014, Class 5.1 (oxidiser) and 8 (corrosive)', 'Packing' => 'Jerrycans' ),
	'desc'  => '<p><strong>Hydrogen peroxide 50%</strong> is a strong oxidising agent used for bleaching and disinfection. It breaks down into water and oxygen, leaving no harmful residue.</p><h3>Common uses</h3><ul><li>Bleaching textiles, paper and pulp</li><li>Disinfection and sanitation</li><li>Water and wastewater treatment</li><li>Chemical processing</li></ul><h3>Safety &amp; storage</h3><p>Strong oxidiser and corrosive. Wear gloves, goggles and protective clothing. Store upright in a cool, shaded, ventilated place, away from heat, metals, flammable and organic materials. Never return unused product to the original container. For industrial use - dilute before most applications.</p>',
	'seo'   => array(
		'title'         => 'Hydrogen Peroxide 50% Supplier in Kampala, Uganda %sep% %sitename%',
		'description'   => 'Hydrogen peroxide 50% (H2O2) in jerrycans, available in Kampala. For bleaching, disinfection and water treatment. Get a quote from Wipaco Investiments.',
		'focus_keyword' => 'hydrogen peroxide Uganda',
	),
);

$more[] = array(
	'name'  => 'SLS Powder (Sodium Lauryl Sulphate)',
	'slug'  => 'sls-powder-sodium-lauryl-sulphate',
	'image' => 'sls-powder.jpg',
	'alt'   => 'Bag of sodium lauryl sulfate SLS powder, detergent grade, made in India',
	'cats'  => array( $cat_soap ),
	'attrs' => array( 'Chemical name' => 'Sodium lauryl sulphate (SLS)', 'Grade' => 'Industrial / detergent grade', 'Active matter' => '85% - 95%', 'CAS number' => '151-21-3', 'Origin' => 'India', 'Packing' => 'Bags' ),
	'desc'  => '<p><strong>SLS powder</strong> (sodium lauryl sulphate) is a powerful foaming and cleaning agent in dry powder form, with 85-95% active matter. Being a powder, it mixes easily into washing powders and solid products.</p><h3>Common uses</h3><ul><li>Washing powder and detergent bars</li><li>Carpet and upholstery cleaners</li><li>Industrial and household cleaning products</li><li>Foaming agent in cleaning formulations</li></ul><h3>Handling</h3><p>The fine powder can irritate the nose, eyes and skin. Wear a dust mask, gloves and goggles, and keep bags closed and dry.</p>',
	'seo'   => array(
		'title'         => 'SLS Powder (Sodium Lauryl Sulphate) in Kampala %sep% %sitename%',
		'description'   => 'SLS powder (sodium lauryl sulphate), detergent grade, 85-95% active, available in Kampala, Uganda. For washing powder and cleaning products.',
		'focus_keyword' => 'SLS powder Uganda',
	),
);

$more[] = array(
	'name'  => 'Petroleum Jelly',
	'slug'  => 'petroleum-jelly',
	'image' => 'petroleum-jelly.jpg',
	'alt'   => 'Bowl of white petroleum jelly',
	'cats'  => array( $cat_cosmetic, $cat_wax ),
	'attrs' => array( 'Product' => 'Petroleum jelly (petrolatum)', 'CAS number' => '8009-03-8', 'Form' => 'Smooth, white semi-solid' ),
	'desc'  => '<p><strong>Petroleum jelly</strong> (petrolatum) is a smooth, white semi-solid that locks in moisture and protects the skin. It is the base of many body jellies and ointments, and is also used in industry.</p><h3>Common uses</h3><ul><li>Body jelly and skin care products</li><li>Baby care products</li><li>Lip balms and hair products</li><li>Lubrication and rust protection</li></ul><p>Making your own blends? Combine with our <a href="/product/white-oil-liquid-paraffin/">white oil</a> and <a href="/product/micro-wax-odourless/">odourless micro wax</a>.</p>',
	'seo'   => array(
		'title'         => 'Petroleum Jelly Supplier in Kampala, Uganda %sep% %sitename%',
		'description'   => 'Bulk petroleum jelly (petrolatum) available in Kampala, Uganda, for body jelly, skin care, baby care and industrial use. Quote from Wipaco Investiments.',
		'focus_keyword' => 'petroleum jelly Uganda',
	),
);

foreach ( $more as &$item ) {
	$item['short'] = $spec_list( $item['attrs'] );
}
unset( $item );

return $more;
