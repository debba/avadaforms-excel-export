<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.dueclic.com
 * @since      1.0.0
 *
 * @package    Avadaforms_Excel_Export
 * @subpackage Avadaforms_Excel_Export/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Avadaforms_Excel_Export
 * @subpackage Avadaforms_Excel_Export/includes
 * @author     dueclic <info@dueclic.com>
 */
class Avadaforms_Excel_Export_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        if ( ! class_exists('Fusion_Form_DB_Submissions')
            || ! class_exists(
                'Fusion_Form_DB_Entries'
            )
            || ! class_exists('Fusion_Form_DB_Forms')
        ) {
            wp_die(
                __('Looks like Avada or Fusion Forms are not installed.', 'avadaforms-excel-export'),
                __('Avada Forms to Excel / CSV was not activated.', 'avadaforms-excel-export')
            );
        }
	}

}
