<?php
/**
 * @package  omoi
 */
namespace inc\base;

class Deactivate
{
	public static function deactivate() {
		flush_rewrite_rules();
		delete_option('widget_title');
		delete_option('company_id');
        delete_option('omoi_host');
        delete_option('update_script_url');
        delete_option('omoi_bothook');
	}
}