<?php
/*
Plugin Name: WP Instant
Plugin URI: http://kau-boys.de/wordpress/wp-instant-plugin
Description: Integrates a google instant search to your blog. The wp-instant pluing uses the Ajax.Updater function of script.aculo.us and the Form.Element.DelayedObserver class. A jQuery implementation will be following soon.
Version: 1.1.1
Author: Bernhard Kau
Author URI: http://kau-boys.de
*/


define('WP_INSTANT_URL', WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)));
define('WP_INSTANT_DIR', WP_PLUGIN_DIR.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)));
define('WP_INSTANT_SEARCHFIELD_ID', get_option('wp_instant_id'));

function init_wp_instant() {
	load_plugin_textdomain('wp-instant', false, dirname(plugin_basename(__FILE__)));
	
	$searchfield_id = get_option('wp_instant_id');
	$selectortype = get_option('wp_instant_selectortype');
	$content_id = get_option('wp_instant_content_id');
	if(empty($searchfield_id)) $searchfield_id = 's';
	if(empty($selectortype)) $selectortype = 'id';
	if(empty($content_id)) $content_id = 'content';
	
	$wp_instant_options = array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'searchfield_id' => $searchfield_id,
		'selectortype' => $selectortype,
		'content_id' => $content_id,
		'lang' => $_REQUEST['lang']
	);

	if(!is_admin()){
		wp_enqueue_script( 'wp_instant', WP_INSTANT_URL . 'wp-instant.js', array( 'scriptaculous' ), null, true );
		wp_localize_script( 'wp_instant', 'WP_Instant', $wp_instant_options );
	}
}

function wp_instant_results() {
	global $wpdb; // this is how you get access to the database

	include( WP_PLUGIN_DIR . '/wp-instant/wp-instant-results.php' );

	die(); // this is required to return a proper result
}
add_action('wp_ajax_wp_instant_results', 'wp_instant_results');
add_action('wp_ajax_nopriv_wp_instant_results', 'wp_instant_results');

function wp_instant_admin_menu(){
	add_options_page("WP-Instant settings", 'WP-Instant', 8, __FILE__, 'wp_instant_admin_settings');	
}

function wp_instant_filter_plugin_actions($links, $file){
	static $this_plugin;
	if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);
	
	if ($file == $this_plugin){
		$settings_link = '<a href="options-general.php?page=wp-instant/wp-instant.php">'.__('Settings').'</a>';
		array_unshift($links, $settings_link);
	}
	return $links;
}

function wp_instant_admin_settings(){
	if(isset($_POST['save'])){	
		update_option('wp_instant_id', $_POST['wp_instant_id']);
		update_option('wp_instant_selectortype', $_POST['wp_instant_selectortype']);
		update_option('wp_instant_choices', $_POST['wp_instant_choices']);
		update_option('wp_instant_content_id', $_POST['wp_instant_content_id']);
		$settings_saved = true;
	}
	$searchfield_id = get_option('wp_instant_id');
	$selectortype = get_option('wp_instant_selectortype');
	$choices = get_option('wp_instant_choices');
	$content_id = get_option('wp_instant_content_id');
	
	// set default if values haven't been recieved from the database
	if(empty($searchfield_id)) $searchfield_id = 's';
	if(empty($selectortype)) $selectortype = 'id';
	if(empty($choices)) $choices = 10;
	if(empty($content_id)) $content_id = 'content';
	
?>

<div class="wrap">
	<?php screen_icon(); ?>
	<h2>WP-Instant</h2>
	<?php if($settings_saved) : ?>
	<div id="message" class="updated fade"><p><strong><?php _e('Options saved.') ?></strong></p></div>
	<?php endif ?>
	<p>
		<?php _e('Here you can customize the plugin for your needs.', 'wp-instant') ?>
	</p>
	<form method="post" action="">
		<p>
			<label for="wp_instant_selectortype" style="width: 200px; display: inline-block;"><?php _e('Selectortype', 'wp-instant') ?></label>
			<select id="wp_instant_selectortype" name="wp_instant_selectortype" style="width: 147px;">
				<option<?php echo ($selectortype == 'id')? ' selected="selected"' : '' ?>>id</option>
				<option<?php echo ($selectortype == 'name')? ' selected="selected"' : '' ?>>name</option>
			</select>
			<span class="description"><?php _e('Here you can set if you select the input by the id or name attribute (default = id).', 'wp-instant') ?></span>
		</p>
		<p>
			<label for="wp_instant_id" style="width: 200px; display: inline-block;"><?php _e('Search field attribute value', 'wp-instant') ?></label>
			<input type="text" id="wp_instant_id" name="wp_instant_id" value="<?php echo $searchfield_id ?>" />
			<span class="description"><?php _e('Here you can set the value of the id or name attribute from the search input used in your template (default = s).', 'wp-instant') ?></span>
		</p>
		<p>
			<label for="wp_instant_choices" style="width: 200px; display: inline-block;"><?php _e('Number of results', 'wp-instant') ?></label>
			<input type="text" id="wp_instant_choices" name="wp_instant_choices" value="<?php echo $choices ?>" />
			<span class="description"><?php _e('Here you can set the number of posts that will be shown (default = 10).', 'wp-instant') ?></span>
		</p>
		<p>
			<label for="wp_instant_content_id" style="width: 200px; display: inline-block;"><?php _e('Content tag ID', 'wp-instant') ?></label>
			<input type="text" id="wp_instant_content_id" name="wp_instant_content_id" value="<?php echo $content_id ?>" />
			<span class="description"><?php _e('Here you can set the value of the id of the tag in which the content should be included (default = content).', 'wp-instant') ?></span>
		</p>
		<p class="submit">
			<input class="button-primary" name="save" type="submit" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
	<div>
		<?php _e('You have to create a file called <code>wp-instant-search-template.php</code> in your theme folder to show the search result with your theme settings.
				A detailed tutorial can be found on this post: <a href="http://kau-boys.de/wordpress/das-wp-instant-plugin-fuer-euer-theme-anpassen?lang=en">Customize the WP-Instant Plugin for your theme</a>', 'wp-instant'); ?>
	</div>
</div>

<?php
}

/**
 * Add deprecation notice in WP Admin.
 */
function wp_instant_deprecation_notice() {
	// Only show notice for users who can actually uninstall or update plugins.
	if ( ! current_user_can( 'delete_plugins' ) && ! current_user_can( 'update_plugins' ) ) {
		return;
	}

	global $wp_version;
	?>
	<div class="notice notice-warning">
		<p>
			<?php echo wp_kses(
				__( 'WP Instant <b>is deprecated and will be removed</b> from the plugin directory on <b>October 9, 2023</b>, 12 years after its first release. You can find my other plugins <a href="https://profiles.wordpress.org/kau-boy/#content-plugins">on my WordPress profile page</a>.', 'wp-instant' ),
				array( 'a' => array( 'href' => array() ), 'b' => array() )
			); ?>
		</p>
	</div>
	<?php
}

add_action('init', 'init_wp_instant');
add_action('admin_menu', 'wp_instant_admin_menu');
add_filter('plugin_action_links', 'wp_instant_filter_plugin_actions', 10, 2);
add_action( is_network_admin() ? 'network_admin_notices' : 'admin_notices', 'wp_instant_deprecation_notice' );