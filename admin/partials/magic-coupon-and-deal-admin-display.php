<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.ifourtechnolab.com/
 * @since      1.0.0
 *
 * @package    Magic_Coupon_And_Deal
 * @subpackage Magic_Coupon_And_Deal/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<h1>
    <?php _e('Magic Coupon and Deal', 'magic-coupon-and-deal');
    ?>
</h1>

<div class="wrap">

    <div id="icon-options-general" class="icon32"></div>
    <h1><?php esc_attr_e('Heading', 'magic-coupon-and-deal'); ?></h1>

    <div id="poststuff">

        <div id="post-body" class="metabox-holder columns-2">

            <!-- main content -->
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <div class="postbox">
                        <h2>
                            <span>
                                <?php esc_attr_e('Main Content Header',
                                    'magic-coupon-and-deal'); ?>
                            </span>
                        </h2>
                        <div class="inside">
                            <p>
                                <code>single-coupon.php</code>
                                <?php
                                esc_attr_e(
                                    ' is display your single coupon in front-end side. you can Override this template by adding it in to your theme as ',
                                    'magic-coupon-and-deal'
                                );
                                ?>
                                <code>single-coupon.php</code>
                            </p>

                            <p>
                                <?php
                                esc_attr_e(
                                    "Use", 'magic-coupon-and-deal'
                                );
                                ?>

                                <code>add_action('start_coupon_container', 'callback')</code>

                                <?php
                                esc_attr_e(
                                    "action for change default coupon container html layout. And",
                                    'magic-coupon-and-deal'
                                );
                                ?>

                                <code>add_action('close_coupon_container', 'callback')</code>
                                <?php
                                esc_attr_e(
                                    "action for closing coupon container html layout.",
                                    'magic-coupon-and-deal'
                                );
                                ?>
                            </p>

                            <p>
                                <?php
                                esc_attr_e(
                                    "Use", 'magic-coupon-and-deal'
                                );
                                ?>
                                <code>add_action('before_coupon_code', 'callback')</code>

                                <?php
                                esc_attr_e(
                                    "action for change default coupon details starting layout. And",
                                    'magic-coupon-and-deal'
                                );
                                ?>

                                <code>add_action('after_coupon_code', 'callback')</code>
                                <?php
                                esc_attr_e(
                                    "action for closing coupon details layouts.",
                                    'magic-coupon-and-deal'
                                );
                                ?>
                            </p>
                        </div>
                        <!-- .inside -->
                    </div>
                    <!-- .postbox -->
                </div>
                <!-- .meta-box-sortables .ui-sortable -->
            </div>
            <!-- post-body-content -->

        </div>
        <!-- #post-body .metabox-holder .columns-2 -->

        <br class="clear">
    </div>
    <!-- #poststuff -->

</div> <!-- .wrap -->