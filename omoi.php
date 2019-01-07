<?php
/**
 * @package omoi
 */
/*
 Plugin Name: omoi
 Plugin URI: https://omoi.me
 Description: Automate your customer messaging.
 Version: 1.0.0
 Author: IR
 Author URI: https://rinkovec.com
 License: GPLv2 or later 
 */
/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2019 IR
*/

defined('ABSPATH') or die;

// Require once the Composer Autoload
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

/**
 * The code that runs during plugin activation
 */
function activate_omoi_plugin()
{
    inc\base\Activate::activate();
}

register_activation_hook(__FILE__, 'activate_omoi_plugin');

/**
 * The code that runs during plugin deactivation
 */
function deactivate_omoi_plugin()
{
    inc\base\Deactivate::deactivate();
}

register_deactivation_hook(__FILE__, 'deactivate_omoi_plugin');

/**
 * Initialize all the core classes of the plugin
 */
if (class_exists('inc\\Init')) {
    inc\Init::register_services();
}

add_action('admin_notices', 'plugin_activation_notice');

add_action('admin_notices', 'plugin_connection_with_omoi_success_notice');

add_action('admin_notices', 'plugin_no_knowledgebase_notice');

add_action('admin_post_contact_form', 'update_script_tag');

add_action('wp_head', 'add_js_to_head_frontend');

function plugin_activation_notice()
{
    if (get_transient('admin-notice-activation')) {
        ?>
        <div class="updated notice is-dismissible">
            <p>Before you can use this plugin, you need to setup the <a href="admin.php?page=omoi">settings</a></p>
        </div>
        <?php
        delete_transient('admin-notice-activation');
    }
}


function plugin_connection_with_omoi_success_notice()
{
    if (get_transient('admin-notice-connection')) {
        ?>
        <div class="updated notice is-dismissible">
            <p>Successfully connected to Omoi!</p>
        </div>
        <?php
        delete_transient('admin-notice-connection');
    }
}

function plugin_no_knowledgebase_notice()
{
    if (get_transient('admin-notice-no-knowledgebase')) {
        ?>
        <div class="updated notice is-dismissible">
            <p>It looks like you haven't set up any knowledgebase yet, in order to use this plugin please set up
                <a href="<?php echo get_option('omoi_host'); ?>/manage/knowledgebase">knowledgebase</a>.</p>
        </div>
        <?php
        delete_transient('admin-notice-connection');
    }
}

function update_script_tag()
{
    $api = new \inc\api\CustomEndpoint;
    $api->update_script_tag($_POST['widget_title']);
}

function add_js_to_head_frontend()
{
    if(get_option('company_id') != 0)
    {
        $src = get_option('omoi_host') . get_option('omoi_bothook') . "?companyId=". get_option('company_id') ;
        echo '<script type="text/javascript" src="' . $src .'"></script>';
    }
}