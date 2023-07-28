<?php
/*
 * Plugin Name: Footer Putter
 * Plugin URI: https://www.diywebmastery.com/plugins/footer-putter/
 * Description: Put a footer on your site that boosts your credibility with both search engines and human visitors.
 * Version: 1.17
 * Author: Russell Jamieson
 * Author URI: https://www.diywebmastery.com/about/
 * Text Domain: footer-putter
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
define('FOOTER_PUTTER_VERSION','1.17');
define('FOOTER_PUTTER_NAME', 'Footer Putter') ;
define('FOOTER_PUTTER_SLUG', 'footer-putter');
define('FOOTER_PUTTER_PATH', plugin_basename(__FILE__));
define('FOOTER_PUTTER_PLUGIN_URL', plugins_url(FOOTER_PUTTER_SLUG));
define('FOOTER_PUTTER_CHANGELOG',' https://www.diywebmastery.com/plugins/footer-putter/footer-putter-version-history/');
define('FOOTER_PUTTER_HELP','https://www.diywebmastery.com/plugins/footer-putter/footer-putter-help/');
define('FOOTER_PUTTER_HOME','https://www.diywebmastery.com/plugins/footer-putter/');
define('FOOTER_PUTTER_ICON','dashicons-arrow-down-alt');
define('FOOTER_PUTTER_NEWS', 'https://www.diywebmastery.com/tags/newsfeed/feed/?images=1&featured_only=1');
require_once(dirname(__FILE__) . '/classes/class-plugin.php');
Footer_Putter_Plugin::get_instance();
