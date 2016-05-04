<?php

/**
 * Filter file for ZWS Wordpress Anti Spam & URL Filter
 *
 * @copyright Copyright (c) 2015, Zaziork Web Solutions
 * @author    Zaziork Web Solutions
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @link https://www.zaziork.com/zws-wordpress-anti-spam-filter-plugin/
 */

Class ZwsCommentsFilter {

    private static function is_site_admin() {
        $currentUser = wp_get_current_user();
        return in_array('administrator', $currentUser->roles);
    }

    public static function comment_link_blocker($commentdata) {

        // do the database calls
        $reject_text = get_site_option('zws_filter_reject_text');
        require_once(__DIR__ . '/db.php');
        $blacklist = ZwsDatabaseAdmin::get_blacklist();
        
        // get blacklist
        if (!empty($blacklist)) {
            // iterate the dataset of banned phrases 
            foreach ($blacklist as $phrase) {
                if (strpos($commentdata['comment_content'], $phrase->banned) !== false) {
                    wp_die('<strong style="color:' . get_site_option('zws_filter_reject_text_color') . ';">' . $reject_text . '</strong>');
                }
            }
        }

        // reject if URL is submitted as a 'comment author url'
        if (!empty($commentdata['comment_author_url'])) {
            wp_die('<strong style="color:' . $alert_color . ';">' . $reject_text . '</strong>');
        }

        return $commentdata;
    }

    public static function remove_website_field($fields) {
        if (isset($fields['url'])) {
            unset($fields['url']);
        }
        return $fields;
    }

    public static function run_filter() {
        // call the blocker method every time a comment submitted (preprocess) if submitter not admin
        if (!self::is_site_admin()) {
            add_action('preprocess_comment', array('ZwsCommentsFilter', 'comment_link_blocker'));
        }
        // remove website field from form
        add_filter('comment_form_default_fields', array('ZwsCommentsFilter', 'remove_website_field'));
    }

}