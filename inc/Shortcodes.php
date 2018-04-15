<?php

/**
* 
*/
class Shortcodes
{
	public $userTokenValue;

	public function userToken()
	{
		require_once ACCESSKEY_PLUGIN_PATH.'inc/SubscriberHelper.php';

		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;

		$subscriberHelper = new SubscriberHelper();
		$sub = $subscriberHelper->getSubscriberById($user_id);


		if(count($sub) > 0) $this->userTokenValue = $sub['key'];
		
		add_shortcode( 'accesskey_user_token', array($this, 'setUserToken') );
	}

	public function setUserToken()
	{
		return "<b>".$this->userTokenValue."</b>";
	}
}