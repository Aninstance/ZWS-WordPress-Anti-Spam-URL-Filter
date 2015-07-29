<?php

/**
 * Plugin Name: ZWS Wordpress Anti Spam & URL Filter
 * Plugin URI: https://www.zaziork.com/zws-wordpress-anti-spam-filter-plugin/
 * Description: Prevent spam in comments by filtering out URLs & blacklist.
 * Version: 2.4
 * Author: Zaziork Web Solutions
 * Author URI: http://www.zaziork.com
 * Copyright (c) 2015 Zaziork Web Solutions. All rights reserved.
 * License: Released under the GPL license: http://www.opensource.org/licenses/gpl-license.php
 *
 * @since     1.0
 * @copyright Copyright (c) 2015, Zaziork Web Solutions
 * @author    Zaziork Web Solutions
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * **********************************************************************
 */
Class ZwsFilter {

    public static function run_installer() {
        require_once(__DIR__ . '/installer.php');
// run installer
        ZwsInstaller::zws_filter_install();
    }

    public static function run_admin() {
        require_once(__DIR__ . '/admin.php');
// run the menu page code
        ZwsAdminPage::my_setup_menu();
    }

    public static function run_filter() {
        require_once(__DIR__ . '/filter.php');
// run the filter
        ZwsCommentsFilter::run_filter();
    }

    public static function add_action_links($links) {
        $mylinks = array(
            '<a href="' . admin_url('admin.php?page=zws-anti-spam-url-filter') . '">Settings</a>',
        );
        return array_merge($mylinks, $links);
    }

}

// add additional links on plugins page
add_filter('plugin_action_links_' . plugin_basename(__FILE__), array('ZwsFilter', 'add_action_links'));
// create the administration page
add_action('admin_menu', array('ZwsFilter', 'run_admin'));
// add the installer to the activation hook
register_activation_hook(__FILE__, array('ZwsFilter', 'run_installer'));
// run the filter (once plugins have loaded)
add_action('plugins_loaded', array('ZwsFilter', 'run_filter'));
