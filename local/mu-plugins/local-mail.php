<?php
/**
 * Local development only: send all WordPress email to Mailpit (http://localhost:8025).
 * Do NOT upload this folder to the live server - use an SMTP plugin there instead.
 */
if ( wp_get_environment_type() === 'local' ) {
	add_action( 'phpmailer_init', function ( $mailer ) {
		$mailer->isSMTP();
		$mailer->Host     = 'mailpit';
		$mailer->Port     = 1025;
		$mailer->SMTPAuth = false;
	} );
	// The default sender "wordpress@localhost" is rejected as an invalid address.
	add_filter( 'wp_mail_from', fn() => 'website@wipaco.test' );
}
