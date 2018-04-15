<?php 

/*
 * @package AccessKey
 */

namespace Inc;

use Inc\SubscriberHelper;
use Inc\TokenHelper;
use Inc\Constants;

class Admin
{
	public  function ztobs_admin_menu()
	{
		add_menu_page( 
	        __( 'API Key Tool', 'accesskey' ),
	        __( 'API Key Tool', 'accesskey' ),
	        'manage_options',
	        'ztobs_accesskey',
	        array($this, 'admin_index'),
	        plugins_url( 'access-key/ap1.png' ),
	        4
	    ); 
	}

	public function admin_index()
	{

        if(get_option(Constants::SUB_PRODUCT_ID, "") == "") Admin::admin_notice("Set the Product for your subscription in 'Other Settings' tab in order for tool to work properly", 'error');

		$subscriber = new SubscriberHelper();
		$_GET['CONSTANTS'] = new Constants();
		include ACCESSKEY_PLUGIN_PATH.'templates/adminPage.php';
	}

	public static function admin_notice($message, $type)
	{
		if($type == 'error') $class = 'notice notice-error';
		elseif($type == 'success') $class = 'notice notice-success is-dismissible';
		elseif($type == 'warning') $class = 'notice notice-warning is-dismissible';
		elseif($type == 'info') $class = 'notice notice-info is-dismissible';
		else $class = 'notice notice-info is-dismissible';

		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message  ); 
	}
}
