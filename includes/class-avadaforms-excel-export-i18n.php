<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.dueclic.com
 * @since      1.0.0
 *
 * @package    Avadaforms_Excel_Export
 * @subpackage Avadaforms_Excel_Export/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Avadaforms_Excel_Export
 * @subpackage Avadaforms_Excel_Export/includes
 * @author     dueclic <info@dueclic.com>
 */
class Avadaforms_Excel_Export_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'avadaforms-excel-export',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
