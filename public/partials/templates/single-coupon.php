<?php get_header(); ?>

<div class="main-coupon">
    <?php while (have_posts()) :
        the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >

            <header class="coupon-header">
                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
            </header>

            <div class="coupon-content">
                <?php echo get_the_content(); ?>
            </div>

            <div class="coupon-detail">
                <?php do_action('coupons_display'); ?>
            </div>

        </article>

        <?php
        the_post_navigation(array(
            'prev_text' => __('Old Coupons', ''),
            'next_text' => __('Next Coupons', '')
        ));
    endwhile;
    ?>
</div>

<?php get_footer(); ?>
