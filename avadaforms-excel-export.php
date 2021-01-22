<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.dueclic.com
 * @since             1.0.0
 * @package           Avadaforms_Excel_Export
 *
 * @wordpress-plugin
 * Plugin Name:       Avada Forms to Excel / CSV
 * Plugin URI:        https://www.dueclic.com
 * Description:       Easily export your Avada Forms data to Excel / CSV
 * Version:           1.0.0
 * Author:            dueclic
 * Author URI:        https://www.dueclic.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       avadaforms-excel-export
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('AVADAFORMS_EXCEL_EXPORT_VERSION', '1.0.0');
define('AVADAFORMS_EXCEL_EXPORT_FORMID_PARAM', 'form_id');
define( 'AVADAFORMS_EXCEL_EXPORT_FILE', __FILE__ );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-avadaforms-excel-export-activator.php
 */
function activate_avadaforms_excel_export()
{
    require_once plugin_dir_path(__FILE__)
        .'includes/class-avadaforms-excel-export-activator.php';
    Avadaforms_Excel_Export_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-avadaforms-excel-export-deactivator.php
 */
function deactivate_avadaforms_excel_export()
{
    require_once plugin_dir_path(__FILE__)
        .'includes/class-avadaforms-excel-export-deactivator.php';
    Avadaforms_Excel_Export_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_avadaforms_excel_export');
register_deactivation_hook(__FILE__, 'deactivate_avadaforms_excel_export');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__).'includes/class-avadaforms-excel-export.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_avadaforms_excel_export()
{
    $plugin = new Avadaforms_Excel_Export();
    $plugin->run();
}

run_avadaforms_excel_export();
