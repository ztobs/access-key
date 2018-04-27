<?php 

namespace Inc;


/*
 * @package AccessKey
 */


class SubscriberHelper
{
	private $subscribers;
	private $id;
	private $email;
	private $name;
	private $subscriptionType;
	private $subscriptionStart;
	private $subscriptionEnd;
	private $APIkey;


	public function __construct()
	{
		$this->subscribers = $this->getSubscribers();
	}

	public function getSubscriberById($user_id)
	{
		if(isset($this->subscribers))
		{
			foreach ($this->subscribers as $sub) {
				if($sub['user_id'] == $user_id) return $sub;
			}
		}
		return array();
	}

	public function getSubscriberByToken($key)
	{

		foreach ($this->subscribers as $sub) {
			if($sub['key'] == $key) return $sub;
		}
		return array();
	}


	public function getSubscribers()
	{
		global $wpdb;
		$sql = "SELECT *
				FROM ".$wpdb->prefix."posts
				WHERE post_type = 'shop_subscription'
				AND post_status != 'auto-draft' AND post_status != 'trash'
				ORDER BY post_date DESC
				";
		
		$rs = $wpdb->get_results($sql);
		foreach ($rs as $r) 
		{
			$userId = get_post_meta( $r->ID, '_recipient_user', true );
			if($userId == "") $userId = get_post_meta( $r->ID, '_customer_user', true );
			$userData = get_userdata($userId);
			$next_pay = get_post_meta( $r->ID, '_schedule_next_payment', true );
			$end = get_post_meta( $r->ID, '_schedule_end', true );

			// woocomerce subscription is messing around with end_date of prorated payment was chosen. This fix will set end_date to next_payment date which is correct
			if($next_pay != 0) $end = $next_pay;
			update_post_meta( $r->ID, '_schedule_end', $end); 
			// End of fix

			$cancel = get_post_meta( $r->ID, '_schedule_cancelled', true );

			switch ($r->post_status) {
				case 'wc-on-hold':
					$status = 'hold';
					break;

				case 'wc-active':
					$status = 'active';
					break;

				case 'wc-pending-cancel':
					$status = 'pending-cancel';
					break;

				case 'wc-cancelled':
					$status = 'cancelled';
					break;
				
				default:
					$status = 'not active';
					break;
			}
			
			$subscribers[] = array(
									"user_id"	=>	$userId,
									"email"		=>	$userData->user_email,
									"name"		=>	$userData->display_name,
									"status"	=>	$status,
									"start"		=>	$r->post_date,
									"end"		=>	$end,
									"cancel"	=>	$cancel,
									"key"		=>	$userData->_ztobs_accesskey_token
									);
		}

		return $subscribers;
		
	}



}