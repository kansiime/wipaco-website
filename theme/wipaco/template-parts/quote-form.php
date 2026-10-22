<?php
/**
 * Quote request form. Optional $args['product'] preselects a product;
 * an ?item= query string does the same (used by the "Get Quote" buttons).
 */
$selected = $args['product'] ?? sanitize_text_field( wp_unslash( $_GET['item'] ?? '' ) );
$status   = sanitize_key( $_GET['quote'] ?? '' );
$products = function_exists( 'wc_get_products' )
	? wc_get_products( array( 'status' => 'publish', 'limit' => -1, 'orderby' => 'title', 'order' => 'ASC' ) )
	: array();
?>
<form id="quote-form" class="quote-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
	<?php if ( $status === 'sent' ) : ?>
		<?php $handoff = wipaco_quote_handoff(); ?>
		<div class="notice notice--success" role="status">
			<?php wipaco_icon( 'check' ); ?>
			<div>
				<strong>Thank you, your request has been sent.</strong>
				<?php if ( $handoff ) : ?>
					Your reference is <strong><?php echo esc_html( $handoff['ref'] ); ?></strong>. Our team will get back to you shortly.
					<p class="notice__action">For the fastest reply, send your request to us on WhatsApp too - it's already written for you:</p>
					<?php // esc_attr, not esc_url: esc_url strips the %0A line breaks. The URL is a fixed https://wa.me/ base plus a rawurlencoded text. ?>
					<a class="btn btn--whatsapp" href="<?php echo esc_attr( wipaco_whatsapp_url( $handoff['text'] ) ); ?>" target="_blank" rel="noopener"><?php wipaco_icon( 'whatsapp' ); ?>Also send on WhatsApp</a>
				<?php else : ?>
					Our team will get back to you shortly. For a faster reply, message us on <a href="<?php echo esc_url( wipaco_whatsapp_url() ); ?>" target="_blank" rel="noopener">WhatsApp</a>.
				<?php endif; ?>
			</div>
		</div>
	<?php elseif ( $status === 'missing' ) : ?>
		<div class="notice notice--error" role="alert">Please enter your name and phone number so we can reach you.</div>
	<?php elseif ( $status === 'error' ) : ?>
		<div class="notice notice--error" role="alert">Something went wrong. Please try again, or call us on <?php echo esc_html( wipaco_contact( 'phone_1' ) ); ?>.</div>
	<?php endif; ?>

	<input type="hidden" name="action" value="wipaco_quote">
	<?php wp_nonce_field( 'wipaco_quote', 'wipaco_quote_nonce', false ); ?>
	<p class="quote-form__hp" aria-hidden="true">
		<label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
	</p>

	<div class="form-grid">
		<p class="field">
			<label for="q-name">Full name <span class="req">*</span></label>
			<input id="q-name" name="name" type="text" required autocomplete="name">
		</p>
		<p class="field">
			<label for="q-company">Company / business</label>
			<input id="q-company" name="company" type="text" autocomplete="organization">
		</p>
		<p class="field">
			<label for="q-phone">Phone / WhatsApp <span class="req">*</span></label>
			<input id="q-phone" name="phone" type="tel" required autocomplete="tel" placeholder="07XX XXX XXX">
		</p>
		<p class="field">
			<label for="q-email">Email</label>
			<input id="q-email" name="email" type="email" autocomplete="email">
		</p>
		<p class="field">
			<label for="q-product">Product</label>
			<select id="q-product" name="product">
				<option value="">Select a product</option>
				<?php foreach ( $products as $product ) : ?>
					<option <?php selected( $selected, $product->get_name() ); ?>><?php echo esc_html( $product->get_name() ); ?></option>
				<?php endforeach; ?>
				<option <?php selected( $selected, 'Other / several products' ); ?>>Other / several products</option>
			</select>
		</p>
		<p class="field">
			<label for="q-qty">Quantity needed</label>
			<input id="q-qty" name="quantity" type="text" placeholder="e.g. 20 bags, 2 drums">
		</p>
		<p class="field field--full">
			<label for="q-message">Message</label>
			<textarea id="q-message" name="message" rows="4" placeholder="Tell us what you need, delivery location, or any questions."></textarea>
		</p>
	</div>
	<button class="btn btn--primary btn--lg" type="submit"><?php wipaco_icon( 'message' ); ?>Send Request</button>
	<?php if ( get_privacy_policy_url() ) : ?>
		<p class="quote-form__privacy">We only use your details to reply to your request. See our <a href="<?php echo esc_url( get_privacy_policy_url() ); ?>">Privacy Policy</a>.</p>
	<?php endif; ?>
</form>
