<?php 

    /*
    Plugin Name: Access Key Tool
    Plugin URI: 
    Description: Generates access key aka token for customers and creating API Endpoint to validate the customer tonens from a thirdparty app.
    Author: Joseph Lukan
    Version: 1.0.1
    WC requires at least: 2.5.0
    WC tested up to: 3.3.0
    Author URI: http://tobilukan.com
    License: GPLv2 or Later
    Text Domain: accesskey
    */


if(!function_exists('add_action')) die ("We caught you!!");

if(file_exists(dirname(__FILE__).'/vendor/autoload.php'))
{
    require_once dirname(__FILE__).'/vendor/autoload.php';
}


define('ACCESSKEY_PLUGIN_PATH', plugin_dir_path( __FILE__ ));
define('ACCESSKEY_PLUGIN_BASENAME', plugin_basename( __FILE__ ));
define('ACCESSKEY_MIN_WP_VERSION', '3.0');




use Inc\AccesskeyPluginActivate;
use Inc\AccesskeyPluginDeactivate;
use Inc\Conditions;
use Inc\Shortcodes;
use Inc\Order;
use Inc\APIEndpointHelper;
use Inc\Admin;
use Inc\Ajax;


class ZtobsAccessKey 
{
    public $plugin;
    function __construct()
    {
        // For Admin
        if(is_admin()) 
        {
            add_action( 'admin_menu', array($this, 'adminPage') );  // Init Admin Page
            add_action( 'admin_enqueue_scripts', array($this, 'enqueue') );

            $this->plugin = plugin_basename( __FILE__ );
            add_filter( "plugin_action_links_$this->plugin", array($this, 'settings_link') );
            $this->process_ajax(); // Trigger Ajax
        }

        // Everybody
        add_action('admin_init', array($this, 'checkConditions'), 10, 1);
        add_action('init', array($this, 'doShortcodes'));
        add_action('rest_api_init', array($this, 'apiEndpoint'));
        add_action('woocommerce_order_status_changed', array($this, 'orderStatus'), 10, 3);

        
    }




    function activate()
    {
        AccesskeyPluginActivate::activate();
    }

    function deactivate()
    {
        AccesskeyPluginDeactivate::deactivate();
    }

    // The backup sanity check, in case the plugin is activated in a weird way,
    // or the versions change after activation.
    function checkConditions() 
    {
        $conditions = new Conditions();
        $conditions->check();
    }

    

    function doShortcodes()
    {
        $shortcodes = new Shortcodes();
        $shortcodes->userToken();
    }

    public function orderStatus($order_id, $old_status, $new_status)
    {
        if( $new_status == "completed" ) $order = new Order($order_id, $old_status, $new_status);
        
    }


    public function settings_link($links)
    {
        $settings_link = '<a href="?page=ztobs_accesskey">Settings</a>';
        array_push($links, $settings_link);
        return $links;
    }

    function apiEndpoint()
    {
        $APIEndpointHelper = new APIEndpointHelper();
        $APIEndpointHelper->API(); 
    }

    

    function adminPage()
    {
        $admin = new Admin();
        $admin->ztobs_admin_menu();
    }


 
    function enqueue()
    {
        wp_enqueue_style( 'ztobs_dt_style', '//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css', array() );
        wp_enqueue_style( 'ztobs_accesskey_style', plugins_url( '/assets/css/accesskey.css', __FILE__ ), array() );


        wp_enqueue_script( 'ztobs_dt_script', '//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js'  );
        wp_enqueue_script( 'ztobs_accesskey_script', plugins_url( '/assets/js/accesskey.js', __FILE__ ) );
        wp_enqueue_script( 'ztobs_tmc_script', '//cloud.tinymce.com/stable/tinymce.min.js' );

    }

    private function process_ajax()
    {
        $ajax = new Ajax();
        add_action('wp_ajax_ztobs_set_token', array($ajax, 'setToken'), 10);
        add_action('wp_ajax_ztobs_set_admin_api_key', array($ajax, 'updateAdminAPIKey'), 10);
        add_action('wp_ajax_ztobs_update_others', array($ajax, 'updateOtherSettings'), 10);
    }
}

$ztobsAccessKey = new ZtobsAccessKey();


// Activation
register_activation_hook(__FILE__, array($ztobsAccessKey, 'activate'));

// Deactivation
register_deactivation_hook( __FILE__, array($ztobsAccessKey, 'deactivate') );








