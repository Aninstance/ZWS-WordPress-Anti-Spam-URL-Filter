<?php

/**
 * Administration file for ZWS Wordpress Anti Spam & URL Filter
 *
 * @copyright Copyright (c) 2015, Zaziork Web Solutions
 * @author    Zaziork Web Solutions
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @link https://www.zaziork.com/zws-wordpress-anti-spam-filter-plugin/
 */
Class ZwsAdminPage {

    public static function my_setup_menu() {
        add_menu_page('ZWS Wordpress Anti-Spam & URL Filter', 'ZWS Anti-Spam', 'manage_options', 'zws-anti-spam-url-filter', array('AdminPage', 'zws_antispam_settings_page'));
        add_action('admin_init', array('AdminPage', 'display_settings_panel_fields'));
    }

    public function zws_antispam_settings_page() {
        ?>
        <h1>ZWS Wordpress URL & Anti-Spam Filter Settings Panel</h1>
        <div class="wrap" style="margin:1em;">
            <form method="post" action="">
                <?php
                settings_fields("blacklist_fields");
                do_settings_sections("blacklist_configs");
                submit_button();
                ?>          
            </form>
        </div>
        <div class="wrap" style="margin:1em;">
            <form method="post" action="options.php">
                <?php
                settings_fields("display_fields");
                do_settings_sections("display_configs");
                submit_button();
                ?>          
            </form>
        </div>
        <p>Thank you for using ZWS Wordpress Anti-Spam & URL Filter. <a href="/donate/">Donations are much appeciated!</a></p>
        <?php
    }

    public function display_reject_message_text_element() {
        ?>
        <small class="zws-anti-spam-settings-form-helper" style="display:block;margin-bottom:1em;">Plain text or html.</small>      
        <input type="text" name="zws_filter_reject_text" size="55" id="zws_filter_reject_text" value="<?php echo get_site_option('zws_filter_reject_text'); ?>" />
        <?php
    }

    public function display_reject_message_text_color_element() {
        ?>
        <small class="zws-anti-spam-settings-form-helper" style="display:block;margin-bottom:1em;">Hex code (e.g. #666666) or html value (e.g. red).</small>
        <input type="text" name="zws_filter_reject_text_color" size="55" id="zws_filter_reject_text_color" value="<?php echo get_site_option('zws_filter_reject_text_color'); ?>" />
        <?php
    }

    public function update_blacklist() {
        ?>
        <small class="zws-anti-spam-settings-form-helper" style="display:block;margin-bottom:1em;">Comma separated list. Be sure to leave spaces between values, (e.g. value1, value2).</small>
        <textarea name="updated_blacklist" rows="4" cols="55" id="updated_blacklist"><?php echo self::display_blacklist_string(); ?></textarea>
        <small class="zws-anti-spam-settings-form-helper" style="display:block;margin-bottom:1em;">
            Note on the default filter: The default is intended block attempts to submit <strong> clickable </strong> URLs in comments.<br>
            This default also includes 25 of the most popular TLDs, so that attempts to post a range of links in non-clickable form is also blocked.<br>
        </small>
        <?php
    }

    public function display_settings_panel_fields() {
        add_settings_section('display_fields', 'Rejection Text Settings', null, 'display_configs');
        add_settings_section('blacklist_fields', 'Filter Blacklist Settings', null, 'blacklist_configs');

        add_settings_field('zws_filter_reject_text', 'Reject Message Text', array('AdminPage', 'display_reject_message_text_element'), 'display_configs', 'display_fields');
        add_settings_field('zws_filter_reject_text_color', 'Reject Message Text Colour', array('AdminPage', 'display_reject_message_text_color_element'), 'display_configs', 'display_fields');
        add_settings_field('updated_blacklist', 'Filter Blacklist', array('AdminPage', 'update_blacklist'), 'blacklist_configs', 'blacklist_fields');

        register_setting('display_fields', 'zws_filter_reject_text_color');
        register_setting('display_fields', 'zws_filter_reject_text');
        register_setting('blacklist_fields', 'updated_blacklist');
    }

    function display_blacklist_string() {
        require_once(__DIR__ . '/db.php');
        $blacklist = ZwsDatabaseAdmin::get_blacklist();
        $blacklist_string = '';
        if (!empty($blacklist)) {
            foreach ($blacklist as $phrase) {
                $blacklist_string .= $phrase->banned . ', ';
            }
            $blacklist_string = rtrim($blacklist_string);
            $blacklist_string = rtrim($blacklist_string, ',');
        } else {
            $blacklist_string = 'No blacklist is set!';
        }
        return $blacklist_string;
    }
    
    
function update_db() {
    $blacklist_string = sanitize_text_field($_POST['updated_blacklist']);
    // remove trailing whitespace
    $blacklist_string = rtrim($blacklist_string);
    // remove trailing commas
    $blacklist_string = rtrim($blacklist_string, ',');
    // split string into array of values
    $blacklist = explode(', ', $blacklist_string);
    // add to database
    require_once(__DIR__ . '/db.php');
    ZwsDatabaseAdmin::set_blacklist($blacklist);
}

}

if (isset($_POST['updated_blacklist'])) {
    ZwsAdminPage::update_db();
}