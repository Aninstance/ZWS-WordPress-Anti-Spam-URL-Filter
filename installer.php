<?php

/**
 * Installation file for ZWS Wordpress Anti Spam & URL Filter
 *
 * @copyright Copyright (c) 2015, Zaziork Web Solutions
 * @author    Zaziork Web Solutions
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @link https://www.zaziork.com/zws-wordpress-anti-spam-filter-plugin/
 */
Class ZwsInstaller {

    // defaults
    private static $table_name_no_prefix = 'zws_antispam';
    private static $reject_text_color = 'red';
    private static $reject_text = 'Your comment has been rejected due to attempted inclusion of a banned URL, word or phrase!';

    public static function zws_filter_install() {

// set or update table name option if necessary
        if (!get_site_option('zws_filter_table_name')) {
            add_site_option('zws_filter_table_name', self::$table_name_no_prefix);
        } else {
            if (get_site_option('zws_filter_table_name') != self::$table_name_no_prefix) {
                update_site_option('zws_filter_table_name', self::$table_name_no_prefix);
            }
        }

// set reject text if does not exist
        if (!get_site_option('zws_filter_reject_text')) {
            add_site_option('zws_filter_reject_text', self::$reject_text);
        }

// set reject text color if does not exist
        if (!get_site_option('zws_filter_reject_text_color')) {
            add_site_option('zws_filter_reject_text_color', self::$reject_text_color);
        }

// initiate db
        require_once(__DIR__ . '/db.php');
        ZwsDatabaseAdmin::create_database();

// set the initial blacklist if emtpy
        $resultset = ZwsDatabaseAdmin::get_blacklist();
        if (empty($resultset)) {
            ZwsDatabaseAdmin::set_blacklist(self::get_default_blacklist());
        }
    }

    private static function get_default_blacklist() {
        $blacklist = array('http://', 'https://', 'ftp://', 'www.', '[url', '.com', '.net', '.ru',
            '.org', '.de', '.jp', '.uk', '.br', '.pl', '.in', '.it', '.fr', '.info', '.cn',
            '.au', '.nl', '.ir', '.biz', '.es', '.kr', '.eu', '.ca', '.ua', '.za');
        return $blacklist;
    }

}
