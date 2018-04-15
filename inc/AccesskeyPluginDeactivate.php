<?php 

/*
 * @package AccessKey
 */

namespace Inc;



class AccesskeyPluginDeactivate
{
	public static function deactivate()
	{
		flush_rewrite_rules( true );
	}
}