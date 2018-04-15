<?php

/**
* 
*/
class RegisterUpdateUserHelper 
{


	public static function register($user_id)
	{
		require_once ACCESSKEY_PLUGIN_PATH.'inc/SubscriberHelper.php';

		$subscriberHelper = new SubscriberHelper();
        $sub = $subscriberHelper->getSubscriberById($user_id);
        if(count($sub) > 0)
        {
            wp_mail( $sub['email'], "", $message, '', array( '' ) );
        }
	}


	public static function update()
	{

	}
}