<?php
/**
 * Share buttons for the current product or guide. Plain share links - no third-party scripts.
 * $args: url, title (both optional; default to the current post).
 */
$url   = $args['url'] ?? get_permalink();
// get_the_title() returns HTML entities (e.g. &#8217;) - decode so shared text reads "Beginner’s".
$title = $args['title'] ?? html_entity_decode( wp_strip_all_tags( get_the_title() ), ENT_QUOTES, 'UTF-8' );
$text  = $title . ' - Wipaco Investiments, Kampala';

$networks = array(
	'whatsapp' => array( 'WhatsApp', 'https://wa.me/?text=' . rawurlencode( $text . ' ' . $url ) ),
	'facebook' => array( 'Facebook', 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode( $url ) ),
	'x'        => array( 'X', 'https://twitter.com/intent/tweet?url=' . rawurlencode( $url ) . '&text=' . rawurlencode( $text ) ),
	'linkedin' => array( 'LinkedIn', 'https://www.linkedin.com/sharing/share-offsite/?url=' . rawurlencode( $url ) ),
);
?>
<div class="share" data-share-url="<?php echo esc_attr( $url ); ?>" data-share-title="<?php echo esc_attr( $text ); ?>">
	<span class="share__label">Share:</span>
	<button class="share__btn share__btn--native" type="button" data-share-native hidden aria-label="Share"><?php wipaco_icon( 'share' ); ?><span>Share</span></button>
	<?php foreach ( $networks as $key => list( $label, $href ) ) : ?>
		<a class="share__btn share__btn--<?php echo esc_attr( $key ); ?>" href="<?php echo esc_url( $href ); ?>" target="_blank" rel="noopener" data-share-network="<?php echo esc_attr( $key ); ?>" aria-label="Share on <?php echo esc_attr( $label ); ?>" title="Share on <?php echo esc_attr( $label ); ?>"><?php wipaco_icon( $key ); ?></a>
	<?php endforeach; ?>
	<button class="share__btn share__btn--copy" type="button" data-share-copy aria-label="Copy link" title="Copy link"><?php wipaco_icon( 'link' ); ?><span class="share__copied" aria-live="polite"></span></button>
</div>
