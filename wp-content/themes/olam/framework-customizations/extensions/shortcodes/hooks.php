<?php if (!defined('FW')) die('Forbidden');
/** @internal */
function _filter_disable_default_shortcodes($to_disable)
{
        // disable the shortcodes you want like this
	$to_disable[] = 'contact-forms';
	$to_disable[] = 'calendar';
	$to_disable[] = 'notification';
	$to_disable[] = 'call_to_action';
	$to_disable[] = 'team_member';
	
	return $to_disable;
}
add_filter('fw_ext_shortcodes_disable_shortcodes', '_filter_disable_default_shortcodes');