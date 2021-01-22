<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.dueclic.com
 * @since      1.0.0
 *
 * @package    Avadaforms_Excel_Export
 * @subpackage Avadaforms_Excel_Export/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Avadaforms_Excel_Export
 * @subpackage Avadaforms_Excel_Export/admin
 * @author     dueclic <info@dueclic.com>
 */
class Avadaforms_Excel_Export_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Avadaforms_Excel_Export_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Avadaforms_Excel_Export_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/avadaforms-excel-export-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Avadaforms_Excel_Export_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Avadaforms_Excel_Export_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/avadaforms-excel-export-admin.js', array( 'jquery' ), $this->version, false );

	}

    public function export_form()
    {
        if (isset($_GET[AVADAFORMS_EXCEL_EXPORT_FORMID_PARAM])
            && isset($_GET['avadaform_export'])
        ) {

            $form_id = intval($_GET[AVADAFORMS_EXCEL_EXPORT_FORMID_PARAM]);

            $submissions = new Fusion_Form_DB_Submissions();

            $fusion_forms = new Fusion_Form_DB_Forms();
            $form_fields  = $fusion_forms->get_form_fields($form_id);

            $form_submissions = $submissions->get(
                [
                    'where'    => [ 'form_id' => $form_id ],
                    'order by' => 'id DESC',
                ]
            );

            $data         = [];
            $form_entries = [];

            $fusion_entries = new Fusion_Form_DB_Entries();

            foreach ($form_submissions as $submission) {
                $form_entries[$submission->id] = $fusion_entries->get(
                    [
                        'where' => ['submission_id' => $submission->id],
                    ]
                );
            }

            $keys = [];

            foreach ($form_entries as $key => $entries) {
                $entries = (array)$entries;

                foreach ($entries as $entry) {
                    $entry = (array)$entry;
                    foreach ($form_fields as $field) {
                        if (isset($entry['field_id'])
                            && $entry['field_id'] === $field->id
                        ) {
                            $field_label              = ''
                            !== $field->field_label
                                ? $field->field_label : $field->field_name;
                            $field_label              = apply_filters(
                                'avadaforms_export_fieldname', $field_label,
                                $form_id, $field
                            );
                            $field_data               = $entry['value'];
                            $data[$key][$field_label] = $field_data;
                            $keys[]                   = $field_label;
                            break;
                        }
                    }
                }

                if ( ! isset($data[$key])) {
                    $data[$key] = [];
                }
            }

            $ext = (isset($_GET['format']) && $_GET['format'] == 'csv') ? 'csv' : 'xlsx';

            $fileLocation = apply_filters(
                    'avadaforms_export_filename', 'export-'.date("YmdHis"), $form_id
                ).'.'.$ext;

            // # prepare the data set
            $data = array_merge(
                [ array_keys($data[array_key_first($data)]) ],
                $data
            );

            if ($ext == 'csv') {
                $fp = fopen($fileLocation, 'wb');

                foreach ($data as $fields) {
                    fputcsv($fp, $fields);
                }

                fclose($fp);
            } else {
                $writer = new XLSXWriter();
                $writer->writeSheet($data);
                $writer->writeToFile($fileLocation);
            }

            // # prompt download popup
            header('Content-Description: File Transfer');
            header(
                "Content-Type: ".($ext == 'csv' ? 'text/csv' : 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            );
            header(
                "Content-Disposition: attachment; filename="
                .basename($fileLocation)
            );
            header("Content-Transfer-Encoding: binary");
            header("Expires: 0");
            header("Pragma: public");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header('Content-Length: '.filesize($fileLocation));

            ob_clean();
            flush();

            readfile($fileLocation);
            unlink($fileLocation);
            exit;
        }
    }

    public function add_exportbutton()
    {
        if (isset($_GET[AVADAFORMS_EXCEL_EXPORT_FORMID_PARAM])) {
            ?>
            <div style="margin-top:20px;margin-bottom:20px">
                <h2>
                    <?php
                    _e("Export options", "avadaforms-excel-export");
                    ?>
                </h2>

                <label class="form-heading-inline" for="avada_export">
                    <?php
                    _e("Export as", "avadaforms-excel-export");
                    ?>
                    <select id="avada_export_format">
                        <option class="fusion-form">-- <?php
                            _e("Select", "avadaforms-excel-export");
                            ?> --
                        </option>
                        <option class="fusion-form" value="csv">
                            CSV
                        </option>
                        <option class="fusion-form"
                                value="xlsx">
                            XLSX
                        </option>
                    </select>
                    <button class="button" role="button" onclick="document.location='<?php
                    echo admin_url(); ?>?form_id=<?php
                    echo absint(
                        $_GET[AVADAFORMS_EXCEL_EXPORT_FORMID_PARAM]
                    ); ?>&avadaform_export=1&format='+document.getElementById('avada_export_format').value">
                        <?php
                        _e("Export", "avadaforms-excel-export");
                        ?>
                    </button>
                </label>
            </div>
            <?php
        }
    }

    public function add_action_links($links){
        return array_merge(
                $links,
            [
                    '<a href="'.admin_url().'admin.php?page=avada-forms">'.__('Avada Forms', 'avadaforms-excel-export').'</a>'
            ]
        );
    }


}
