<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.ifourtechnolab.com/
 * @since      1.0.0
 *
 * @package    Magic_Coupon_And_Deal
 * @subpackage Magic_Coupon_And_Deal/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Magic_Coupon_And_Deal
 * @subpackage Magic_Coupon_And_Deal/public
 * @author     ifourtechnolab <info@ifourtechnolab.com>
 */
class Magic_Coupon_And_Deal_Public
{

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
     * The fields of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      array    $obj_fields   The meta-field of this plugin.
     */
    private $obj_fields;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version     = $version;
        $this->obj_fields  = new Magic_Coupon_And_Deal_Coupons_Fields();
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        wp_enqueue_style($this->plugin_name,
            plugin_dir_url(__FILE__).'css/magic-coupon-and-deal-public.css',
            array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        wp_enqueue_script($this->plugin_name,
            plugin_dir_url(__FILE__).'js/magic-coupon-and-deal-public.js',
            array('jquery'), $this->version, false);
    }

    public function single_coupon_template($single_template)
    {

        global $post;

        if ('coupons' !== $post->post_type) {
            return $single_template;
        }

        $single_template = locate_template(array('single-coupon.php'));

        if ($single_template) {
            return $single_template;
        }

        if (file_exists(dirname(__FILE__).'/partials/templates/single-coupon.php')) {
            $single_template = dirname(__FILE__).'/partials/templates/single-coupon.php';
        }

        return $single_template;
    }

    public function coupon_dispaly()
    {

        $cc = get_post_meta(get_the_ID(),
            $this->obj_fields->get_coupun_code_identity(), true);

        if (empty($cc) || '' === $cc || null === $cc) {
            return;
        }

        $cw = get_post_meta(get_the_ID(),
            $this->obj_fields->get_coupun_link_identity(), true);
        $cd = get_post_meta(get_the_ID(),
            $this->obj_fields->get_coupun_desc_identity(), true);

        do_action('start_coupon_container');

        do_action('coupon_code_display', $cc);

        if (!empty($cw) || '' !== $cw || null !== $cw) {
            do_action('coupon_code_link_dispaly', $cw);
        }

        if (!empty($cd) || '' !== $cd || null !== $cd) {
            do_action('coupon_code_description_display', $cd);
        }

        do_action('close_coupon_container');
    }

    public function start_coupon_container()
    {
        echo '<div class="coupon-detail" id="main-coupon">';
    }

    public function close_coupon_container()
    {
        echo '</div>';
    }

    public function coupon_code_display($coupon_code)
    {

        do_action('before_coupon_code');

        echo sprintf('<p><strong>%1$s</strong>&nbsp;:-&nbsp;%2$s</p>',
            esc_html('Code'), esc_html($coupon_code));

        do_action('after_coupon_code');
    }

    public function before_coupon_code()
    {
        echo '<div class="before-content">';
    }

    public function after_coupon_code()
    {
        echo '</div>';
    }

    public function coupon_code_link_dispaly($link)
    {

        do_action('before_coupon_code');

        echo sprintf('<p><strong>%1$s</strong>&nbsp;:-&nbsp;<a href="%2$s" target="_blank">%3$s</a></p>',
            esc_html__('Site', 'magic-coupon-and-deal'), esc_url($link),
            esc_html__('Go to Deal', 'magic-coupon-and-deal'));

        do_action('after_coupon_code');
    }

    public function coupon_code_description_display($description)
    {

        do_action('before_coupon_code');

        echo '<strong>'.esc_html__('Coupon Description', 'magic-coupon-and-deal').'</strong>&nbsp;:-&nbsp;'.$description;

        do_action('after_coupon_code');
    }

    public function register_mcad_coupons_rest_field()
    {
        foreach ($this->obj_fields->get_mcad_fields_identities() as $mcad) :
            register_rest_field('coupons', $mcad,
                array(
                'get_callback' => function ($object, $field_name) {
                    return get_post_meta($object['id'], $field_name, true);
                }
            ));
        endforeach;
    }
}
