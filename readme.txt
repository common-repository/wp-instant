=== WP Instant ===
Contributors: Kau-Boy
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6104701
Tags: ajax, search, prototype, scriptaculous, jquery, instant, google
Requires at least: 3.0
Stable tag: 1.1.1


Integrates a google instant search to your blog. The wp-instant pluing uses the Ajax.Updater function of script.aculo.us and the Form.Element.DelayedObserver class. A jQuery implementation will be following soon.

== Description ==

**WP Instant is deprecated and will be removed from the plugin directory on October 9, 2023, 12 years after its first release. You can find my other plugins [on my WordPress profile page](https://profiles.wordpress.org/kau-boy/#content-plugins).**

Integrates a Google Instant Search to your blog. The wp-instant plugin uses the Ajax.Updater function of script.aculo.us and the Form.Element.DelayedObserver class. A jQuery implementation will be following soon.

A list of all of my plugins can be found on the [WordPress Plugin page](http://kau-boys.de/wordpress-plugins?lang=en "WordPress Plugins") on my blog [kau-boys.de](http://kau-boys.de).

== Installation ==

= Installation through WordPress admin pages: = 

1. Go to the admin page `Plugins -> Add New` 
2. Search for `wp-instant`
3. Choose the action `install`
4. Click on `Install now`
5. Activate the plugin after install has finished (with the link or trough the plugin page)
6. You might have to edit the settings, especially the "Content tag ID" value
7. Create a wp-instant-search-template.php file including the part of the "search loop" within the "Content ID tag"

= Installation using WordPress admin pages: =

1. Download the plugin zip file
2. Go to the admin page `Plugins -> Add New`
3. Choose the `Upload` link under the `Install Plugins` headline
4. Browse for the zip file and click `Install Now`
5. Activate the plugin after install has finished (with the link or trough the plugin page)
6. You might have to edit the settings, especially the "Content tag ID" value
7. Create a wp-instant-search-template.php file including the part of the "search loop" within the "Content ID tag"

= Installation using ftp: =

1. Unzip und upload the files to your `/wp-content/plugins/` directory
2. Activate the plugin through the `Plugins` menu in WordPress
3. You might have to edit the settings, especially the "Content tag ID" value
4. Create a wp-instant-search-template.php file including the part of the "search loop" within the "Content ID tag"

== Change Log ==

* **1.1.1** Adding deprecation warning
* **1.1** Fixing bug with uninitialized variables 
* **1.0** Use AJAX the way it's described here: http://codex.wordpress.org/AJAX_in_Plugins
* **0.2** Using STYLESHEETPATH as primary folder to search for search result template
* **0.1** First stable release