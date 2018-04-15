<?php 


/**
* 
*/
class TokenHelper 
{

	function __construct()
	{
		# code...
	}

	public static function setSubscriberToken(int $user_id)
	{
		require_once ACCESSKEY_PLUGIN_PATH.'inc/Constants.php';

		$random_token = bin2hex(random_bytes(8))."-".bin2hex(random_bytes(4));
		$resp = add_user_meta($user_id, Constants::ACCESSKEY_METAKEY, $random_token, true);

		while(!$resp)
		{
			$resp = update_user_meta($user_id, Constants::ACCESSKEY_METAKEY, $random_token);
		}

		return $random_token;
	}
}