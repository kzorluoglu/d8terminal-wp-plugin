<?php
/*
 * Plugin Name: D8 Linux Terminal Plugin
 * Plugin URI: http://d8devs.com/d8-linux-terminal-wordpress-plugin
 * Update URI: http://d8devs.com/d8-linux-terminal-wordpress-plugin
 * Author: d8devs
 * Author URI: http://d8devs.com
 * Description: A terminal widget WordPress plugin.
 * Version: 1.0
 * Requires at least: 7.4
 * Requires PHP:      7.4
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: d8-linux-terminal-plugin
*/

// Security check to ensure the file is being called from within WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/**
 * Enqueue plugin scripts and styles.
 */
function my_terminal_enqueue_scripts() {
	wp_enqueue_script( 'my-terminal-script', plugin_dir_url( __FILE__ ) . 'js/script.js', [], '1.0.0', true );
	wp_enqueue_style( 'my-terminal-style', plugin_dir_url( __FILE__ ) . 'css/style.css', [], '1.0.0', 'all' );

	// Localize the script with new data
	$script_data = array(
		'baseUrl'         => get_site_url(),
		'siteTitle'       => get_bloginfo( 'name' ), // Retrieves the site title
		'siteDescription' => get_bloginfo( 'description' ), // Retrieves the site description
		'memoryUsage'     => size_format( memory_get_usage(), 2 ),
		'currentTheme'    => wp_get_theme()->get( 'Name' ),
		'serverSoftware'  => $_SERVER['SERVER_SOFTWARE'] ?? '',
		'ipAddress'       => $_SERVER['REMOTE_ADDR'] ?? '',
		'requestTime'     => $_SERVER['REQUEST_TIME'] ?? '',
	);
	wp_localize_script( 'my-terminal-script', 'wpData', $script_data );
}

add_action( 'wp_enqueue_scripts', 'my_terminal_enqueue_scripts' );

function render_terminal_html() {
	?>
    <div id="terminal-container" class="collapsed">
        <div id="terminal">
            <div id="history"></div>
        </div>
        <button id="toggle-terminal">Toggle Terminal</button>
    </div>
	<?php
}

add_action( 'wp_footer', 'render_terminal_html' );
