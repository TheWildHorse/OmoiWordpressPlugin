<?php 
/**
 * @package omoi
 */
namespace inc\api\callbacks;

use inc\base\BaseController;

class AdminCallbacks extends BaseController
{
	public function adminDashboard()
	{
		return require_once( "$this->plugin_path/templates/admin.php" );
	}


	public function omoiOptionsGroup( $input )
	{
		return $input;
	}

	public function omoiAdminSection()
	{
		echo 'Set title which will appear in widget header!';
	}

	public function companyId()
	{
		$value = esc_attr( get_option( 'company_id' ) );
		echo '<input type="text" class="regular-text" name="company_id" value="' . $value . '" placeholder="Enter your company ID here">';
	}

	public function widgetTitle()
	{
		$value = esc_attr( get_option( 'widget_title' ) );
		echo '<input type="text" class="regular-text" name="widget_title" value="' . $value . '" placeholder="Write your widget title">';
	}
}