<?php

namespace Inc;


use Inc\Constants;
use Inc\TokenHelper;
use Inc\SubscriberHelper;


/**
* 
*/
class Order
{	

	public $order;

	function __construct($order_id, $old_status, $new_status)
	{
		global $wpdb;
		
		$this->order = wc_get_order($order_id);
		$order_key = $this->order->get_order_key();

		$product_found = false;
		$prods = $this->order->get_items();
		foreach ($prods as $prod) {
			if($prod->get_product_id() == get_option( Constants::SUB_PRODUCT_ID, "" ) )
				{
					$product_found = true;
				}
			
		}
		
		if(!$product_found) return;


		$post_id = $wpdb->get_var("SELECT `post_id` FROM `".$wpdb->prefix."postmeta` WHERE `meta_value` = '$order_key'")+1;

	
		
		$user_id = $wpdb->get_var("SELECT `meta_value` FROM `".$wpdb->prefix."postmeta` WHERE `meta_key` = '_recipient_user' AND `post_id` = '$post_id'");

		if($user_id == NULL) $user_id = $wpdb->get_var("SELECT `meta_value` FROM `".$wpdb->prefix."postmeta` WHERE `meta_key` = '_customer_user' AND `post_id` = '$post_id'");



		$msg = "Order-id is $order_key <br> Post-id is $post_id <br> User-id is $user_id";

		
		

		$user_token = get_user_meta( $user_id, Constants::ACCESSKEY_METAKEY, true );

		// Retrieving Admin set email details
		$email_sender_name = get_option( Constants::EMAIL_SENDER_NAME, "" );
		$sender_email = get_option( Constants::EMAIL_SENDER_EMAIL, "" );

		// Admin email details for newing subscribers
		$email_subject = get_option( Constants::RENEW_SUB_EMAIL_SUBJECT, "" );
		$email_body = get_option( Constants::RENEW_SUB_EMAIL_BODY, "" );
		$send_email = get_option( Constants::RENEW_SUB_SEND_EMAIL, "" );
		

		// If token wasnt set then its a new customer and then we will set new token and welcome email message
		if($user_token == "")
		{
			$user_token = TokenHelper::setSubscriberToken($user_id);
			$email_subject = get_option( Constants::NEW_USER_EMAIL_SUBJECT, "" );
			$email_body = get_option( Constants::NEW_USER_EMAIL_BODY, "" );
			$send_email = get_option( Constants::NEW_USER_SEND_EMAIL, "" );
		}

		// Retrieving user subscription data
		$subscriberHelper = new SubscriberHelper();
		$sub = $subscriberHelper->getSubscriberById($user_id);
		$token = $sub['key'];
		$end_date = $sub['end'];
		$start_date = $sub['start'];
		$user_email = $sub['email'];
		$user_name = $sub['name'];

		// Replace the psuedocodes for email body
		$email_body = str_replace("{token}", $token, $email_body);
		$email_body = str_replace("{end_date}", date("F j, Y, g:i a", strtotime($end_date)), $email_body);
		$email_body = str_replace("{name}", $user_name, $email_body);
		$email_body = str_replace("{start_date}", date("F j, Y, g:i a", strtotime($start_date)), $email_body);

		// Removing backslashes added by db
		$email_body = str_replace('\\', "", $email_body);


		// Setting email headers
		$headers[] = 'From: '.$email_sender_name.' <'.$sender_email.'>';
		$headers[] = "Content-Type: text/html; charset=UTF-8";

		if($user_email != "" &&  $email_subject != "" && $email_body != "" && $email_sender_name != "" && $sender_email != "" && $send_email == "true")
		{
			wp_mail( $user_email, $email_subject, $email_body, $headers, array( '' ) );
		}


		
	}
}