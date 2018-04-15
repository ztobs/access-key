<?php 

/*
 * @package AccessKey
 */

class AccesskeyPluginActivate
{
	public static function activate()
	{
		require_once ACCESSKEY_PLUGIN_PATH.'inc/Constants.php';
		require_once ACCESSKEY_PLUGIN_PATH.'inc/Conditions.php';

		$cond = new Conditions();
		$errMsg = $cond->check();
		if( $errMsg != "") wp_die( __( $errMsg ) );

		$key = bin2hex(random_bytes(16));

		if(!get_option( Constants::ADMINAPIKEY_METAKEY, false )) update_option( Constants::ADMINAPIKEY_METAKEY, $key );

		if(!get_option( Constants::TOKEN_STATUS_SUCCESS, false )) update_option( Constants::TOKEN_STATUS_SUCCESS, "Valid" );

		if(!get_option( Constants::TOKEN_STATUS_INVALID, false )) update_option( Constants::TOKEN_STATUS_INVALID, "Invalid Key" );

		if(!get_option( Constants::TOKEN_STATUS_EXPIRED, false )) update_option( Constants::TOKEN_STATUS_EXPIRED, "Expired Key" );

		if(!get_option( Constants::EMAIL_SENDER_NAME, false )) update_option( Constants::EMAIL_SENDER_NAME, get_option( "blogname", "User Accesskey Module" ) );

		if(!get_option( Constants::EMAIL_SENDER_EMAIL, false )) update_option( Constants::EMAIL_SENDER_EMAIL, get_option( 'admin_email', 'admin@example.com' ) );

		if(!get_option( Constants::REFRESH_TOKEN_EMAIL_SUBJECT, false )) update_option( Constants::REFRESH_TOKEN_EMAIL_SUBJECT, "Token Refresh Notification" );

		if(!get_option( Constants::NEW_USER_EMAIL_SUBJECT, false )) update_option( Constants::NEW_USER_EMAIL_SUBJECT, "Your New Access Token Has Arrived" );

		if(!get_option( Constants::RENEW_SUB_EMAIL_SUBJECT, false )) update_option( Constants::RENEW_SUB_EMAIL_SUBJECT, "Your Subscription Was Renewed" );

		if(!get_option( Constants::REFRESH_TOKEN_EMAIL_BODY, false )) update_option( Constants::REFRESH_TOKEN_EMAIL_BODY, "Hi {name},<br>Your access token was updated to <b>{token}</b> but validity still ends at <b>{end_date}</b><br><br>".get_option( "blogname", false )." Team" );

		if(!get_option( Constants::NEW_USER_EMAIL_BODY, false )) update_option( Constants::NEW_USER_EMAIL_BODY, "{name},<br>Here is your new access token <b>{token}</b>, it is valid till <b>{end_date}</b><br><br>".get_option( "blogname", false )." Team" );

		if(!get_option( Constants::RENEW_SUB_EMAIL_BODY, false )) update_option( Constants::RENEW_SUB_EMAIL_BODY, "Hi {name},<br>Your access to our app has been extended to <b>{end_date}</b> but your token remains the same <b>{token}</b><br>Thanks for renewing your subscription.<br><br>".get_option( "blogname", false )." Team" );

		if(!get_option( Constants::REFRESH_TOKEN_SEND_EMAIL, false )) update_option( Constants::REFRESH_TOKEN_SEND_EMAIL, "true" );

		if(!get_option(  Constants::NEW_USER_SEND_EMAIL, false )) update_option( Constants::NEW_USER_SEND_EMAIL, "false" );

		if(!get_option( Constants::RENEW_SUB_SEND_EMAIL, false )) update_option( Constants::RENEW_SUB_SEND_EMAIL, "false" );


		flush_rewrite_rules( true );
	}

	static function compatible_version() {
        if ( version_compare( $GLOBALS['wp_version'], '3.7', '<' ) ) {
             return false;
         }
	}



}