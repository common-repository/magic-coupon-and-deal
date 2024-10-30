<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.ifourtechnolab.com/
 * @since      1.0.0
 *
 * @package    Magic_Coupon_And_Deal
 * @subpackage Magic_Coupon_And_Deal/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Magic_Coupon_And_Deal
 * @subpackage Magic_Coupon_And_Deal/admin
 * @author     ifourtechnolab <info@ifourtechnolab.com>
 */
class Magic_Coupon_And_Deal_Admin
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
     * Plugin Custom Field
     */
    private $custom_field;

    /**
     *
     */
    private $prefix = 'mcad_';

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name  = $plugin_name;
        $this->version      = $version;
        $field              = new Magic_Coupon_And_Deal_Coupons_Fields();
        $this->custom_field = $field->get_mcad_fields();
    }

    public function mcad_plugin_menu()
    {
        add_plugins_page(__('Magic Coupon And Deal', 'magic-coupon-and-deal'),
            __('Magic Coupon And Deal', 'magic-coupon-and-deal'), 'edit_posts',
            'mcad', array(&$this, 'callback'));
    }

    public function callback()
    {
        include_once 'partials/magic-coupon-and-deal-admin-display.php';
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        wp_enqueue_style($this->plugin_name,
            plugin_dir_url(__FILE__).'css/magic-coupon-and-deal-admin.css',
            array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        wp_enqueue_script($this->plugin_name,
            plugin_dir_url(__FILE__).'js/magic-coupon-and-deal-admin.js',
            array('jquery'), $this->version, false);
    }

    function cptui_register_coupons_cpts()
    {

        /**
         * Post Type: Coupons.
         */
        $labels = array(
            "name"          => __('Coupons', 'magic-coupon-and-deal'),
            "singular_name" => __('coupon', 'magic-coupon-and-deal'),
        );

        $args = array(
            "label"               => __('Coupons', 'magic-coupon-and-deal'),
            "labels"              => $labels,
            "description"         => "",
            "public"              => true,
            "publicly_queryable"  => true,
            "show_ui"             => true,
            "show_in_rest"        => true,
            "rest_base"           => "",
            "has_archive"         => true,
            "show_in_menu"        => true,
            "exclude_from_search" => false,
            "capability_type"     => "post",
            "map_meta_cap"        => true,
            "hierarchical"        => false,
            "rewrite"             => array("slug" => "coupons", "with_front" => true),
            "query_var"           => true,
            "supports"            => array("title", "editor", "thumbnail"),
        );

        register_post_type("coupons", $args);
    }

    public function add_meta_box_to_coupuns()
    {
        add_meta_box(
            'mcad-meta-box', __('Coupon Box'),
            array(&$this, 'render_mcad_meta_box'), 'coupons', 'advanced',
            'default'
        );
    }

    public function render_mcad_meta_box()
    {
        global $post;

        wp_nonce_field('mcad_meta_box_action', 'mcad_meta_box_nonce');

        echo '<table class="form-table">';
        foreach ($this->custom_field as $field) :
            $meta = get_post_meta($post->ID, $field['id'], true);

            echo '<tr>
                    <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                    <td>';
            switch ($field['type']) :
                case 'select':
                    echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
                    foreach ($field['options'] as $option) :
                        echo '<option '.selected($meta, $option['value'], true).' value="'.$option['value'].'">'.$option['label'].'</option>';
                    endforeach;
                    echo '</select><br/><span class="description">'.$field['desc'].'</span>';
                    break;
                case 'input':
                    echo '<input value="'.$meta.'" name="'.$field['id'].'" id="'.$field['id'].'" class="regular-text" /><br/><span class="description">'.$field['desc'].'</span>';
                    break;
                case 'checkbox':
                    break;
                case 'wp_editor':
                    wp_editor($meta, $field['id'],
                        array(
                        'wpautop'       => true,
                        'media_buttons' => true,
                        'textarea_name' => $field['id'],
                        'textarea_rows' => 10,
                        'teeny'         => true
                    ));
                    break;
            endswitch;
            echo '</td></tr>';
        endforeach;
        echo '</table>';
    }

    public function save_mcad_meta($post_id)
    {
        $nonce_name   = isset($_POST['mcad_meta_box_nonce']) ? $_POST['mcad_meta_box_nonce']
                : '';
        $nonce_action = 'mcad_meta_box_action';

        // Check if nonce is set.
        if (!isset($nonce_name)) {
            return;
        }

        // Check if nonce is valid.
        if (!wp_verify_nonce($nonce_name, $nonce_action)) {
            return;
        }

        // Check if not an autosave.
        if (wp_is_post_autosave($post_id)) {
            return;
        }

        // Check if not a revision.
        if (wp_is_post_revision($post_id)) {
            return;
        }

        // check permissions
        if ('coupons' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return 'cannot edit page';
            }
        } elseif (!current_user_can('edit_post', $post_id)) {
            return 'cannot edit post';
        }

        // Check if user has permissions to save data.
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        foreach ($this->custom_field as $fied) :
            if ($_POST[$fied['id']] !== '') :
                switch ($fied['type']) :
                    case 'wp_editor':
                        $mydata = wp_kses_post($_POST[$fied['id']]);
                        update_post_meta($post_id, $fied['id'], $mydata);
                        break;

                    default:
                        // Sanitize the user input.
                        $mydata = sanitize_text_field($_POST[$fied['id']]);

                        // Update the meta field.
                        update_post_meta($post_id, $fied['id'], $mydata);
                endswitch;
            else :
                delete_post_meta($post_id, $fied['id']);
            endif;
        endforeach;
    }
}
