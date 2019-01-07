<?php
/**
 * Created by PhpStorm.
 * User: ir
 * Date: 2019-01-04
 * Time: 14:03
 */

/**
 * @package omoi
 */

namespace inc\api;

use WP_REST_Controller;
use WP_REST_Request;
use WP_REST_Server;

class CustomEndpoint extends WP_REST_Controller
{

    //The namespace and version for the REST SERVER
    var $my_namespace = 'omoi/v';
    var $my_version = '1';

    public function register_routes()
    {
        $namespace = $this->my_namespace . $this->my_version;
        $base = 'script';
        register_rest_route($namespace, '/' . $base, array(
            array(
                'methods' => WP_REST_Server::ALLMETHODS,
                'callback' => array($this, 'create_script_tag'),
            ),
        ));

        register_rest_route($namespace, '/' . $base . '/update', array(
            array(
                'methods' => WP_REST_Server::ALLMETHODS,
                'callback' => array($this, 'update_script_tag'),
            ),
        ));

        update_option('update_script_url', home_url() . "/wp-json/omoi/v1/script/update");
    }

    // Register our REST Server
    public function register()
    {
        add_action('rest_api_init', array($this, 'register_routes'));
    }

    public function create_script_tag(WP_REST_Request $request)
    {

        $omoiHost = $request->get_param('omoiHost');
        $wpHost = $request->get_param('wpHost');
        $bothook = $request->get_param('bothook');
        $companyId = $request->get_param('companyId');
        $wpUrl = $request->get_param('wpUrl');
        $widgetTitle = $request->get_param('widgetTitle');
        $knowledgebase = $request->get_param('entries');

        update_option('company_id', $companyId, true);
        update_option('widget_title', $widgetTitle, true);
        update_option('omoi_bothook', $bothook);

        set_transient('admin-notice-connection', true, 5);

        if (!$knowledgebase) {
            set_transient('admin-notice-no-knowledgebase', true, 5);
        }

        $scriptUrl = $omoiHost . $bothook . "?companyId=" . $companyId;

        wp_redirect($wpHost . $wpUrl);
        exit();
    }

    public function update_script_tag($widgetTitle)
    {
        global $pagenow;
        update_option('widget_title', $widgetTitle);
        $omoiUrl = "/manage/integrate/website/update-title?";
        $widgetTitle = str_replace(" ", "%20", $widgetTitle);
        $args = "?webWidgetTitle=" . $widgetTitle .
            "&wpUrl=" . home_url() . "/wp-admin/admin.php?page=omoi" .
            "&company_id=" . get_option('company_id');
        wp_redirect(get_option('omoi_host') . $omoiUrl . $args);
    }
}