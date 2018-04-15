<?php

/**
* 
*/
class Ajax
{
	

	public static function setToken()
	{
		require_once ACCESSKEY_PLUGIN_PATH.'inc/TokenHelper.php';
		require_once ACCESSKEY_PLUGIN_PATH.'inc/SubscriberHelper.php';
		require_once ACCESSKEY_PLUGIN_PATH.'inc/Constants.php';
		
		$id = $_POST['user_id'];
		$token = TokenHelper::setSubscriberToken($id);
		$subscriberHelper = new SubscriberHelper();
		$sub = $subscriberHelper->getSubscriberById($id);

		$end_date = $sub['end'];
		$start_date = $sub['start'];
		$user_email = $sub['email'];
		$user_name = $sub['name'];

		$email_sender_name = get_option( Constants::EMAIL_SENDER_NAME, "" );
		$sender_email = get_option( Constants::EMAIL_SENDER_EMAIL, "" );
		$email_subject = get_option( Constants::REFRESH_TOKEN_EMAIL_SUBJECT, "" );
		$email_body = get_option( Constants::REFRESH_TOKEN_EMAIL_BODY, "" );
		$send_email = get_option( Constants::REFRESH_TOKEN_SEND_EMAIL, "" );

		$headers[] = 'From: '.$email_sender_name.' <'.$sender_email.'>';
		$headers[] = "Content-Type: text/html; charset=UTF-8";

		$message = str_replace("{token}", $token, $email_body);
		$message = str_replace("{end_date}", $end_date, $message);
		$message = str_replace("{name}", $user_name, $message);
		$message = str_replace("{start_date}", $start_date, $message);

		if($user_email != "" &&  $email_subject != "" && $message != "" && $email_sender_name != "" && $sender_email != "" && $send_email == "true")
		{
			wp_mail( $user_email, $email_subject, $message, $headers, array( '' ) );
		}
		

		die(json_encode(array("status"=>"ok", "token"=>$token)));
	}

	public static function updateAdminAPIKey()
	{
		require_once ACCESSKEY_PLUGIN_PATH.'inc/Constants.php';
		$key = $_POST['key'];
		$resp = update_option( Constants::ADMINAPIKEY_METAKEY, $key );

		die($resp);
	}

	public static function updateOtherSettings()
	{
		require_once ACCESSKEY_PLUGIN_PATH.'inc/Constants.php';

		$token_status_success = $_POST['token_status_success'];
		$token_status_invalid = $_POST['token_status_invalid'];
		$token_status_expired = $_POST['token_status_expired'];

		$email_sender_name = $_POST['email_sender_name'];
		$email_sender_email = $_POST['email_sender_email'];

		$refresh_email_subject = $_POST['refresh_email_subject'];
		$refresh_email_body = $_POST['refresh_email_body'];
		$send_refresh_email = $_POST['send_refresh_email'];

		$new_email_subject = $_POST['new_email_subject'];
		$new_email_body = $_POST['new_email_body'];
		$send_new_email = $_POST['send_new_email'];

		$renew_email_subject = $_POST['renew_email_subject'];
		$renew_email_body = $_POST['renew_email_body'];
		$send_renew_email = $_POST['send_renew_email'];

		$product_id = $_POST['product_id'];

		update_option( Constants::SUB_PRODUCT_ID, $product_id, null );

		update_option( Constants::TOKEN_STATUS_SUCCESS, $token_status_success, null );
		update_option( Constants::TOKEN_STATUS_INVALID, $token_status_invalid, null );
		update_option( Constants::TOKEN_STATUS_EXPIRED, $token_status_expired, null );

		update_option( Constants::EMAIL_SENDER_NAME, $email_sender_name, null );
		update_option( Constants::EMAIL_SENDER_EMAIL, $email_sender_email, null );

		update_option( Constants::REFRESH_TOKEN_EMAIL_SUBJECT, $refresh_email_subject, null );
		update_option( Constants::REFRESH_TOKEN_EMAIL_BODY, $refresh_email_body, null );
		update_option( Constants::REFRESH_TOKEN_SEND_EMAIL, $send_refresh_email, null );

		update_option( Constants::NEW_USER_EMAIL_SUBJECT, $new_email_subject, null );
		update_option( Constants::NEW_USER_EMAIL_BODY, $new_email_body, null );
		update_option( Constants::NEW_USER_SEND_EMAIL, $send_new_email, null );

		update_option( Constants::RENEW_SUB_EMAIL_SUBJECT, $renew_email_subject, null );
		update_option( Constants::RENEW_SUB_EMAIL_BODY, $renew_email_body, null );
		update_option( Constants::RENEW_SUB_SEND_EMAIL, $send_renew_email, null );

		die('ok');
	}
}