<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.dueclic.com
 * @since      1.0.0
 *
 * @package    Avadaforms_Excel_Export
 * @subpackage Avadaforms_Excel_Export/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Avadaforms_Excel_Export
 * @subpackage Avadaforms_Excel_Export/includes
 * @author     dueclic <info@dueclic.com>
 */
class Avadaforms_Excel_Export
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Avadaforms_Excel_Export_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        if (defined('AVADAFORMS_EXCEL_EXPORT_VERSION')) {
            $this->version = AVADAFORMS_EXCEL_EXPORT_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'avadaforms-excel-export';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Avadaforms_Excel_Export_Loader. Orchestrates the hooks of the plugin.
     * - Avadaforms_Excel_Export_i18n. Defines internationalization functionality.
     * - Avadaforms_Excel_Export_Admin. Defines all hooks for the admin area.
     * - Avadaforms_Excel_Export_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__))
            .'includes/class-avadaforms-excel-export-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__))
            .'includes/class-avadaforms-excel-export-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__))
            .'admin/class-avadaforms-excel-export-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__))
            .'public/class-avadaforms-excel-export-public.php';

        require_once plugin_dir_path(dirname(__FILE__))
            .'includes/xlswriter.class.php';

        $this->loader = new Avadaforms_Excel_Export_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Avadaforms_Excel_Export_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {
        $plugin_i18n = new Avadaforms_Excel_Export_i18n();

        $this->loader->add_action(
            'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain'
        );
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new Avadaforms_Excel_Export_Admin(
            $this->get_plugin_name(), $this->get_version()
        );

        $this->loader->add_action(
            'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles'
        );
        $this->loader->add_action(
            'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts'
        );
        $this->loader->add_action('admin_init', $plugin_admin, 'export_form');
        $this->loader->add_action(
            'fusion_form_admin_text', $plugin_admin, 'add_exportbutton'
        );

        $this->loader->add_action(
            'plugin_action_links_'.plugin_basename(AVADAFORMS_EXCEL_EXPORT_FILE),
            $plugin_admin,
            'add_action_links'
        );
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {
        $plugin_public = new Avadaforms_Excel_Export_Public(
            $this->get_plugin_name(), $this->get_version()
        );

        $this->loader->add_action(
            'wp_enqueue_scripts', $plugin_public, 'enqueue_styles'
        );
        $this->loader->add_action(
            'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts'
        );
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @return    string    The name of the plugin.
     * @since     1.0.0
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @return    Avadaforms_Excel_Export_Loader    Orchestrates the hooks of the plugin.
     * @since     1.0.0
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @return    string    The version number of the plugin.
     * @since     1.0.0
     */
    public function get_version()
    {
        return $this->version;
    }

}
