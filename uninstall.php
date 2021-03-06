<?php 

/*
 * @package AccessKey
 */

if(!defined('WP_UNINSTALL_PLUGIN')) die ("You dont have privilege to uninstall this plugin");

if(file_exists(dirname(__FILE__).'/vendor/autoload.php'))
{
    require_once dirname(__FILE__).'/vendor/autoload.php';
}

use Inc\Constants;


global $wpdb;

delete_option( Constants::SUB_PRODUCT_ID );
delete_option( Constants::ADMINAPIKEY_METAKEY );
delete_option( Constants::TOKEN_STATUS_SUCCESS );
delete_option( Constants::TOKEN_STATUS_INVALID );
delete_option( Constants::TOKEN_STATUS_EXPIRED );
delete_option( Constants::EMAIL_SENDER_NAME );
delete_option( Constants::EMAIL_SENDER_EMAIL );
delete_option( Constants::REFRESH_TOKEN_EMAIL_SUBJECT );
delete_option( Constants::NEW_USER_EMAIL_SUBJECT );
delete_option( Constants::RENEW_SUB_EMAIL_SUBJECT );
delete_option( Constants::REFRESH_TOKEN_EMAIL_BODY );
delete_option( Constants::NEW_USER_EMAIL_BODY );
delete_option( Constants::RENEW_SUB_EMAIL_BODY );
delete_option( Constants::REFRESH_TOKEN_SEND_EMAIL );
delete_option( Constants::NEW_USER_SEND_EMAIL );
delete_option( Constants::RENEW_SUB_SEND_EMAIL );


$sql = "DELETE FROM ".$wpdb->prefix."usermeta WHERE meta_key = '".Constants::ACCESSKEY_METAKEY."'";
$wpdb->query($sql);

flush_rewrite_rules();

