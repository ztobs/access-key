<?php

namespace Inc;


use Inc\Admin;


/**
* 
*/
class Conditions
{
	private $errMsg = "";

	public function check()
	{	

		if(!is_plugin_active('woocommerce-subscriptions-master/woocommerce-subscriptions.php'))
        {
            $this->errMsg .= '<li><b><a href="https://github.com/wp-premium/woocommerce-subscriptions/" >Woocommerce Subscription</a></b> plugin is required </li>';
        }

        // $headers = apache_request_headers();
        // if(!isset($headers['Authorization']))
        // {
        //     $this->errMsg .= '<li><b>Authorization</b> header is not available on your server.<br>Add <div style="background:#ddd; display:inline; font-family:cursive;">SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1</div> to your .htaccess file</li>';
        // }

        if($this->incompatible_version())
        {
        	$this->errMsg .= '<li>Plugin requires WordPress '.ACCESSKEY_MIN_WP_VERSION.' or higher! [Current='.$GLOBALS['wp_version'].']</li>';
        }

        if ( $this->errMsg != "" ) 
        {
			$this->errMsg = "<b>Access Key Tool Plugin disabled due to following reasons</b>:<br><ul>".$this->errMsg."</ul>";

            if ( is_plugin_active( ACCESSKEY_PLUGIN_BASENAME ) ) {
                deactivate_plugins( ACCESSKEY_PLUGIN_BASENAME );
                if(is_admin()) add_action( 'admin_notices', array($this, 'disabled_notice') );
                if ( isset( $_GET['activate'] ) ) {
                    unset( $_GET['activate'] );
                }
            }
        }

        return $this->errMsg;
	}


	public function disabled_notice() 
	{
		Admin::admin_notice($this->errMsg, 'error');
    }


    public function incompatible_version() {
        if ( version_compare( $GLOBALS['wp_version'], ACCESSKEY_MIN_WP_VERSION, '<' ) ) {
             return true;
         }
	}
}