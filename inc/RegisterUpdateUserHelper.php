<?php

namespace Inc;

use Inc\SubscriberHelper;


/**
* 
*/
class RegisterUpdateUserHelper 
{


	public static function register($user_id)
	{

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