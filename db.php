<?php

/**
 * Database administration file for ZWS Wordpress Anti Spam & URL Filter
 *
 * @copyright Copyright (c) 2015, Zaziork Web Solutions
 * @author    Zaziork Web Solutions
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @link https://www.zaziork.com/zws-wordpress-anti-spam-filter-plugin/
 */
Class ZwsDatabaseAdmin {

    // increment this when database structure changed or name changed
    public static $zws_filter_db_version = "1.0";

    public static function create_database() {
        // check version
        if (!get_site_option('zws_filter_db_version')) {
            add_site_option('zws_filter_db_version', self::$zws_filter_db_version);
        }
        // create the database if  necessary
        global $wpdb;
        $stored_table_name = get_site_option('zws_filter_table_name');
        $installed_ver = get_site_option("zws_filter_db_version");
        // if stored db version value matches hardcoded version above
        if ($installed_ver === self::$zws_filter_db_version) {
            // create the table if does not already exist
            $table_name = $wpdb->prefix . $stored_table_name;
            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        banned varchar(255) DEFAULT '' NOT NULL,
        UNIQUE KEY id (id)
	);";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta($sql);
        } else {
            // if a new database version, call some db upgrade method (not yet written).
            /* self::upgrade_db(); */
            // update the stored db version option
            update_site_option("zws_filter_db_version", self::$zws_filter_db_version);
        }
    }

    public static function get_blacklist() {
        global $wpdb;
        $stored_table_name = get_site_option('zws_filter_table_name');
        $table_name = $wpdb->prefix . $stored_table_name;
        // get blacklist from database
        $resultset = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name", ""));
        return $resultset;
    }

    public static function set_blacklist($blacklist) {
        global $wpdb;
        $table_name = $wpdb->prefix . get_site_option('zws_filter_table_name');
        // empty the table first
        self::empty_table();
        // now populate with new blacklist
        foreach ($blacklist as &$value) {
            $wpdb->insert(
                    $table_name, array(
                'time' => current_time('mysql'),
                'banned' => $value,
                    )
            );
        }
    }

    public static function empty_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . get_site_option('zws_filter_table_name');
        $wpdb->query($wpdb->prepare("TRUNCATE TABLE $table_name", ""));
    }

}
