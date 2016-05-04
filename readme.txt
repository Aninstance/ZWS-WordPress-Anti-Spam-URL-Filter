=== ZWS Wordpress Anti Spam & URL Filter === 
Donate link: https://www.zaziork.com/donate
Contributors: zaziork
Tags: comments, spam, hyperlink blocker, hyperlinks, filter, comments filter, url filter, anti-spam
Requires at least: 3.0 
Tested up to: 4.4
Stable tag: 2.4
License: GPLv2 or later

Reduces spam comments submissions by filtering URLs and/or blacklist terms. Initially configured to prohibit clickable URLs.

== Description ==

This is a very simple WordPress plugin, designed to reduce the number of spam comment submissions in WordPress websites and blogs.

The plugin works in two ways:

* Removes the website field from the comment form.
* Prevents the posting of comments that contain any word or phrase in the blacklist (which includes clickable URL links by default).

Because the plugin blocks the submission of comments containing the blacklisted words/phrases at source (rather than just adds them to spam), this plugin prevents spam comments from ever reaching the database. This saves the website administrator the task of reviewing and deleting these spam posts.

If submission of a comment containing a blacklisted item is attempted, the submitter is presented with an error message (configurable) explaining that the comment was rejected.

This plugin was originally developed solely to prevent the inclusion of clickable hyperlinks within the comments field, and this remains the default configuration, as per the blacklist.

The blacklist may be edited from the Settings page, as can the rejection message text and colour.

Users with the role of "administrator" are exempt from the blacklist filter.

Please note: Use of this plugin may also invoke the filtering on web form plugins which rely on the Wordpress commenting system code.

For example, the filtering is applied to messages sent from the "Clean & Simple Contact Form" plugin.

== Plugin Website ==

The URL of this plugin's website is: https://www.zaziork.com/zws-wordpress-anti-spam-filter-plugin/
The URL of this plugin's Wordpress page is: https://wordpress.org/plugins/zws-wp-comments-anti-spam-hyperlink-blocker/

== Installation ==

To install search for "ZWS Wordpress Anti Spam & URL Filter" in the WordPress Plugins Directory, then click the "Install Now" button. 

When it's installed, simply activate, then navigate to the Settings page to update the defaults to your liking.

Alternatively, the plugin may be installed via a zip file, available here: https://www.zaziork.com/zws-wordpress-anti-spam-filter-plugin/

After downloading the zip, upload the plugin to the '/wp-content/plugins/' directory, then activate through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

There are no frequently asked questions as yet.

== Current version ==

The current version is: 2.4

== Changelog ==

= 2.4 =
Updated versioning info and donations URL.

= 2.3 =
Fixed bug where database was not being created on upgrade from 1.x versions.

= 2.2 =
Enclosed remaining exposed functions within classes to avoid possible name clashes with other plugins.

= 2.1 =
Fixed a bug in db.php that resulted in a PHP log warning.

= 2.0 =
Filter blacklist now stored in database table. Options added for admin user to configure blacklist, rejection message text, and rejection message colour.

= 1.3 =
Added the ability to easily customise the filter "blacklist" through a CSV file.

= 1.2 =
Added ability for users with the role of "administrator" to add links to comments.

= 1.1 =
Small update to include https and ftp protocols in the filter.

= 1.0 =
Initial full version of plugin.

== Upgrade Notice ==

= 2.3 =
Fixed bug where database was not being created on upgrade from 1.x versions.

= 2.2 =
Enclosed remaining exposed functions within classes to avoid possible name clashes with other plugins.

= 2.1 =
Fixed a bug in db.php that resulted in a PHP log warning.

= 2.0 =
Filter blacklist now stored in database table. Options added for admin user to configure blacklist, rejection message text, and rejection message colour.

= 1.3 =
Added the ability to easily customise the filter "blacklist" through a CSV file.

= 1.2 =
Added ability for users with the role of administrator to add links to comments.

= 1.1 =
Update to include https and ftp protocols in filter.

= 1.0 =
Initial full version of plugin.

== Support ==

The plugin is to be used entirely at the user's own risk.

Support and/or implementation of feature requests are not guaranteed, however comments and/or requests for free support are welcome. 

For premium support, please contact the author via the plugin website: https://www.zaziork.com/contact
