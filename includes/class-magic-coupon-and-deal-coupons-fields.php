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
 * @package    Magic_Coupon_And_Deal_Coupons_Fields
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
class Magic_Coupon_And_Deal_Coupons_Fields
{

    /**
     * Plugin Custom Field group
     */
    protected $custom_field = array();

    /**
     * Custom Field prefix
     */
    protected $prefix = 'mcad_';

    /**
     * Return Coupon code field identity.
     * @return string
     */
    public function get_coupun_code_identity()
    {
        return $this->prefix.'coupun';
    }

    /**
     * Return Coupon url link field identity.
     * @return string
     */
    public function get_coupun_link_identity()
    {
        return $this->prefix.'url_link';
    }

    /**
     * Return Coupon Description field identity.
     * @return string
     */
    public function get_coupun_desc_identity()
    {
        return $this->prefix.'coupun_description';
    }

    /**
     * Add Coupon Code meta fields.
     */
    protected function reg_mcad_coupun()
    {
        $this->custom_field[] = array(
            'label' => esc_attr__('Coupon Code', 'magic-coupon-and-deal'),
            'desc'  => esc_attr__('Description for this field',
                'magic-coupon-and-deal'),
            'id'    => $this->get_coupun_code_identity(),
            'type'  => 'input'
        );
    }

    /**
     * Add Coupon Link meta fields.
     */
    protected function reg_mcad_url_link()
    {
        $this->custom_field[] = array(
            'label' => esc_attr__('Website Link', 'magic-coupon-and-deal'),
            'desc'  => esc_attr__('Url ', 'magic-coupon-and-deal'),
            'id'    => $this->get_coupun_link_identity(),
            'type'  => 'input'
        );
    }

    /**
     * Add Coupon Description fields.
     */
    protected function reg_mcad_description()
    {
        $this->custom_field[] = array(
            'label' => esc_attr__('Deal or Coupon Description ',
                'magic-coupon-and-deal'),
            'desc'  => esc_attr__('Url ', 'magic-coupon-and-deal'),
            'id'    => $this->get_coupun_desc_identity(),
            'type'  => 'wp_editor'
        );
    }

    /**
     * Get Group of Coupon Meta fields.
     * @return array
     */
    public function get_mcad_fields()
    {
        $this->reg_mcad_coupun();
        $this->reg_mcad_url_link();
        $this->reg_mcad_description();

        return $this->custom_field;
    }

    /**
     * Get Group of Coupon meta Fields Identity.
     * @return array
     */
    public function get_mcad_fields_identities()
    {
        return[
            $this->get_coupun_code_identity(),
            $this->get_coupun_link_identity(),
            $this->get_coupun_desc_identity()
        ];
    }
}
