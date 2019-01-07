<?php 
/**
 * @package omoi
 */
namespace inc\pages;

use inc\api\SettingsApi;
use inc\base\BaseController;
use inc\api\callbacks\AdminCallbacks;

/**
* 
*/
class Admin extends BaseController
{
	public $settings;

	public $callbacks;

	public $pages = array();

	public $subpages = array();

	public function register() 
	{
		$this->settings = new SettingsApi();

		$this->callbacks = new AdminCallbacks();

		$this->setPages();

		$this->setSettings();
		$this->setSections();
		$this->setFields();

		$this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->addSubPages( $this->subpages )->register();
	}

	public function setPages() 
	{
		$this->pages = array(
			array(
				'page_title' => 'Omoi',
				'menu_title' => 'Omoi',
				'capability' => 'manage_options', 
				'menu_slug' => 'omoi',
				'callback' => array( $this->callbacks, 'adminDashboard' ),
				'icon_url' => $this->plugin_url . 'assets/icons/icon-small.png',
				'position' => 110
			)
		);
	}

	public function setSettings()
	{
		$args = array(
//			array(
//				'option_group' => 'omoi_options_group',
//				'option_name' => 'company_id',
//				'callback' => array( $this->callbacks, 'omoiOptionsGroup' )
//			),
			array(
				'option_group' => 'omoi_options_group',
				'option_name' => 'widget_title',
                'callback' => array( $this->callbacks, 'omoiOptionsGroup' )
			)
		);

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'omoi_admin_index',
				'title' => 'Settings',
				'callback' => array( $this->callbacks, 'omoiAdminSection' ),
				'page' => 'omoi_plugin'
			)
		);

		$this->settings->setSections( $args );
	}

	public function setFields()
	{
		$args = array(
//			array(
//				'id' => 'company_id',
//				'title' => 'Company ID',
//				'callback' => array( $this->callbacks, 'companyId' ),
//				'page' => 'omoi_plugin',
//				'section' => 'omoi_admin_index',
//				'args' => array(
//					'label_for' => 'company_id',
//					'class' => 'example-class',
//				)
//			),
			array(
				'id' => 'widget_title',
				'title' => 'Widget Title',
				'callback' => array( $this->callbacks, 'widgetTitle' ),
				'page' => 'omoi_plugin',
				'section' => 'omoi_admin_index',
				'args' => array(
					'label_for' => 'widget_title',
					'class' => 'example-class'
				)
			)
		);

		$this->settings->setFields( $args );
	}
}