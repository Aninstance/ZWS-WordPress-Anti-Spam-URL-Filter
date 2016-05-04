<?php

/**
 * Runs on Uninstall of ZWS Wordpress Anti Spam & URL Filter
 *
 * @copyright Copyright (c) 2015, Zaziork Web Solutions
 * @author    Zaziork Web Solutions
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @link https://www.zaziork.com/zws-wordpress-anti-spam-filter-plugin/
 */
global $wpdb;
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}
$stored_table_name = get_site_option('zws_filter_table_name');
$table_name = $wpdb->prefix . $stored_table_name;
// remove database
$wpdb->query("DROP TABLE IF EXISTS $table_name");
// remove options
$options = array('zws_filter_db_version', 'zws_filter_table_name', 'zws_filter_reject_text', 'zws_filter_reject_text_color');
foreach ($options as $option) {
    delete_site_option($option);
}
?>