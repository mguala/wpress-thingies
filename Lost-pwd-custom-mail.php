<?php
/**
 *	Create a custom WordPress "Lost Password" email
 *	@author Ren Ventura <EngageWP.com>
 *	@link http://www.engagewp.com/create-custom-lost-password-email-wordpress
 */
// Change "From" email address
add_filter( 'wp_mail_from', function( $email ) {
	return 'hello@mydomain.com';
});
// Change "From" email name
add_filter( 'wp_mail_from_name', function( $name ) {
	return __( 'My Website' );
});
// Change Subject
add_filter( 'retrieve_password_title', function( $title, $user_login, $user_data ) {
	return __( 'Password Recovery' );
}, 10, 3 );
// Change email type to HTML
add_filter( 'wp_mail_content_type', function( $content_type ) {
	return 'text/html';
});
// Change the message/body of the email
add_filter( 'retrieve_password_message', 'rv_new_retrieve_password_message', 10, 4 );
function rv_new_retrieve_password_message( $message, $key, $user_login, $user_data ){
	/**
	 *	Assemble the URL for resetting the password
	 *	see line 330 of wp-login.php for parameters
	 */
	$reset_url = add_query_arg( array(
		'action' => 'rp',
		'key' => $key,
		'login' => rawurlencode( $user_login )
	), wp_login_url() );
	ob_start();
	
	printf( '<p>%s</p>', __( 'Hi, ' ) . get_user_meta( $user_data->ID, 'first_name', true ) );
	printf( '<p>%s</p>', __( 'It looks like you need to reset your password on the site. If this is correct, simply click the link below. If you were not the one responsible for this request, ignore this email and nothing will happen.' ) );
	printf( '<p><a href="%s">%s</a></p>', $reset_url, __( 'Reset Your Password' ) );
	
	$message = ob_get_clean();
	return $message;
}
