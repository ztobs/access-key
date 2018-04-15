<?php 

/*
 * @package AccessKey
 */

class AccesskeyPluginDeactivate
{
	public static function deactivate()
	{
		require_once ACCESSKEY_PLUGIN_PATH.'inc/Constants.php';

		flush_rewrite_rules( true );
	}
}