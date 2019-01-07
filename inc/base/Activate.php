<?php
/**
 * @package  omoi
 */
namespace inc\base;

class Activate
{
	public static function activate() {
	    add_option('widget_title', 'omoi', '', 'yes');
        add_option('company_id', '0', '', 'yes');
        add_option('omoi_host', 'http://localhost:8080', '', 'yes');
        add_option('update_script_url', '','', 'yes');
        add_option('omoi_bothook', '', 'yes');
        flush_rewrite_rules();
        set_transient( 'admin-notice-activation', true, 5 );

	}

}