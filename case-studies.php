<?php

/**
 * The plugin bootstrap file
 *
 * Requires WordPress 3.5 or higher
 *
 * @link              https://www.dunncompany.com
 * @since             1.0.0
 * @package           CaseStudies
 *
 * @wordpress-plugin
 * Plugin Name:       Case Studies
 * Plugin URI:        http://www.github.com/dccmarketing/case-studies
 * Description:       Creates a directory of case studies.
 * Version:           1.0.0
 * Author:            DCC Marketing
 * Author URI:        https://www.dccmarketing.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       case-studies
 * Domain Path:       /languages
 */

use CaseStudies\Includes as Inc;
use CaseStudies\Admin as Admin;
use CaseStudies\Blocks as Blocks;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) { die; }

define( 'CASE_STUDIES_FILE', plugin_basename( __FILE__ ) );
define( 'CASE_STUDIES_VERSION', '1.0.0' );
define( 'CASE_STUDIES_SLUG', 'casestudies' );
define( 'CASE_STUDIES_SETTINGS', 'case_studies_settings' );

/**
 * Include the autoloader.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-autoloader.php';

/**
 * Activation and Deactivation Hooks.
 */
register_activation_hook( __FILE__, array( 'CaseStudies\Includes\Activator', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'CaseStudies\Includes\Deactivator', 'deactivate' ) );

/**
 * Initializes each class and adds the hooks action in each to the init hook.
 */
function case_studies_init() {

	$classes[] = new Inc\i18n();
	$classes[] = new Admin\CPT_CaseStudy();
	$classes[] = new Admin\Taxonomy_Service();
	$classes[] = new Blocks\Blocks( new Inc\Query );

	foreach ( $classes as $class ) {

		add_action( 'init', array( $class, 'hooks' ) );

	}

} // case_studies_init

add_action( 'plugins_loaded', 'case_studies_init' );
