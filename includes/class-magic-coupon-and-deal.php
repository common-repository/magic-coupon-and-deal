<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.ifourtechnolab.com/
 * @since      1.0.0
 *
 * @package    Magic_Coupon_And_Deal
 * @subpackage Magic_Coupon_And_Deal/includes
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
 * @package    Magic_Coupon_And_Deal
 * @subpackage Magic_Coupon_And_Deal/includes
 * @author     ifourtechnolab <info@ifourtechnolab.com>
 */
class Magic_Coupon_And_Deal
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Magic_Coupon_And_Deal_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
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

        $this->plugin_name = 'magic-coupon-and-deal';
        $this->version     = '1.0.0';

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
     * - Magic_Coupon_And_Deal_Loader. Orchestrates the hooks of the plugin.
     * - Magic_Coupon_And_Deal_i18n. Defines internationalization functionality.
     * - Magic_Coupon_And_Deal_Admin. Defines all hooks for the admin area.
     * - Magic_Coupon_And_Deal_Public. Defines all hooks for the public side of the site.
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
        require_once plugin_dir_path(dirname(__FILE__)).'includes/class-magic-coupon-and-deal-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)).'includes/class-magic-coupon-and-deal-i18n.php';

        /**
         * Custom Fields.
         */
        require_once plugin_dir_path(dirname(__FILE__)).'includes/class-magic-coupon-and-deal-coupons-fields.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)).'admin/class-magic-coupon-and-deal-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)).'public/class-magic-coupon-and-deal-public.php';

        $this->loader = new Magic_Coupon_And_Deal_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Magic_Coupon_And_Deal_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {

        $plugin_i18n = new Magic_Coupon_And_Deal_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n,
            'load_plugin_textdomain');
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

        $plugin_admin = new Magic_Coupon_And_Deal_Admin($this->get_plugin_name(),
            $this->get_version());

        $this->loader->add_action('admin_menu', $plugin_admin,
            'mcad_plugin_menu');

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin,
            'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin,
            'enqueue_scripts');
        $this->loader->add_action('init', $plugin_admin,
            'cptui_register_coupons_cpts');
        $this->loader->add_action('add_meta_boxes_coupons', $plugin_admin,
            'add_meta_box_to_coupuns');
        $this->loader->add_action('save_post', $plugin_admin, 'save_mcad_meta');
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

        $plugin_public = new Magic_Coupon_And_Deal_Public($this->get_plugin_name(),
            $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public,
            'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public,
            'enqueue_scripts');
        $this->loader->add_action('single_template', $plugin_public,
            'single_coupon_template');

        /**
         * List of all coupon hooks.
         */
        $this->loader->add_action('coupons_display', $plugin_public,
            'coupon_dispaly');

        $this->loader->add_action('start_coupon_container', $plugin_public,
            'start_coupon_container');

        $this->loader->add_action('coupon_code_display', $plugin_public,
            'coupon_code_display');

        $this->loader->add_action('coupon_code_link_dispaly', $plugin_public,
            'coupon_code_link_dispaly');

        $this->loader->add_action('coupon_code_description_display',
            $plugin_public, 'coupon_code_description_display');

        $this->loader->add_action('before_coupon_code', $plugin_public,
            'before_coupon_code');

        $this->loader->add_action('after_coupon_code', $plugin_public,
            'after_coupon_code');

        $this->loader->add_action('close_coupon_container', $plugin_public,
            'close_coupon_container');

        $this->loader->add_action('rest_api_init', $plugin_public,
            'register_mcad_coupons_rest_field', 25);
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
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Magic_Coupon_And_Deal_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }
}
