<?php

/**
* 
*/
class APIEndpointHelper
{

	public static function API()
	{
		register_rest_route( 
				'accesskey/v1',
				'/validate/key/(?P<key>[a-zA-Z0-9-]+)',
				array( 
					'methods'=>'POST',
					'callback'=>'APIEndpointHelper::validate'
				),
				true 
		);
	}

	

	public static function validate($data)
	{
		require_once ACCESSKEY_PLUGIN_PATH.'inc/Constants.php';
		require_once ACCESSKEY_PLUGIN_PATH.'inc/SubscriberHelper.php';

		$authkey = "Bearer ".get_option( Constants::ADMINAPIKEY_METAKEY, true );;
		$userKey = $data['key'];

		$headers = apache_request_headers();
		$auth = isset( $headers['Accesskey-Auth'] ) ? $headers['Accesskey-Auth'] : false;
		

		if ( !$auth || $auth!=$authkey ) {
			return "403 Forbidden";
		}
		

		$subscriberHelper = new SubscriberHelper();
		$sub = $subscriberHelper->getSubscriberByToken($userKey);

		$status_valid = (get_option(Constants::TOKEN_STATUS_SUCCESS, false)? get_option(Constants::TOKEN_STATUS_SUCCESS): "success");
		$status_invalid = (get_option(Constants::TOKEN_STATUS_INVALID, false)? get_option(Constants::TOKEN_STATUS_INVALID): "key not valid");
		$status_expired = (get_option(Constants::TOKEN_STATUS_EXPIRED, false)? get_option(Constants::TOKEN_STATUS_EXPIRED): "key valid but subscription expired");

		if(count($sub) > 0 )
		{
			if($sub['status'] == 'active') $status = $status_valid;
			else $status = $status_expired;

			$name = $sub['name'];
			$email = $sub['email'];
			$start = $sub['start'];
			$end = $sub['end'];
		}
		else
		{
			$status = $status_invalid;
			$name = $email = $start = $end = "";
		}
		$ret = array(
					'status' => $status,
					'data'	 => array(
									'name'		=>	$name, 
									'email'		=>	$email,
									'start_date'=>	$start,
									'end_date'	=>	$end
								)
				);

		return $ret;

	}
}