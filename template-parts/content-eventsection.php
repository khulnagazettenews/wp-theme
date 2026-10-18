<?php
if ( is_front_page() ):

    $options = get_option('cn_framework');
    if ( ! is_array( $options ) ) {
        $options = array();
    }
    $show_hide = isset($options['kg_event_news_showhide']) ? $options['kg_event_news_showhide'] : 0;

    if ( $show_hide == 1 ):

        $title = isset($options['kg_event_news_title']) ? $options['kg_event_news_title'] : '';
        $event_category = isset($options['kg_event_news_category']) ? $options['kg_event_news_category'] : '';

?>

<div class="kg-lead-widgets-wrapper">
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="kg-lead-widgets-title">
                    <h1><?php echo esc_html($title); ?></h1>
                </div>
            </div>

            <?php
            $led_args = array(
                'post_type'      => 'post',
                'cat'            => $event_category,
                'posts_per_page' => 5,
                'post_status'    => 'publish',
                'no_found_rows'  => true,
            );

            $led_query = new WP_Query($led_args);
            $sl = 0;

            if ( $led_query->have_posts() ):
            ?>

            <div class="col-md-3">
                <div class="row">

                    <?php
                    while ( $led_query->have_posts() ):
                        $led_query->the_post();

                        $sl++;
                        $post_id = get_the_ID();

                        $post_img = wp_get_attachment_image_src(
                            get_post_thumbnail_id($post_id),
                            'khulna_gazette_post_thumb'
                        );
                    ?>

                        <?php if ( $sl == 2 ): ?>

                            <div class="col-md-12">
                                <div class="kg-lead-single-article">

                                    <a href="<?php echo esc_url(get_the_permalink()); ?>">
                                        <?php
                                            $event_img_src = function_exists( 'kg_get_the_post_thumbnail_url' ) ? kg_get_the_post_thumbnail_url( $post_id, 'khulna_gazette_post_thumb' ) : ( ! empty( $post_img[0] ) ? $post_img[0] : get_template_directory_uri() . '/assets/img/kg-home-image.jpg' );
                                            $default_img = esc_url( get_template_directory_uri() . '/assets/img/kg-home-image.jpg' );
                                        ?>
                                        <img
                                            src="<?php echo esc_url($event_img_src); ?>"
                                            onerror="this.onerror=null;this.src='<?php echo $default_img; ?>';"
                                            loading="lazy"
                                            decoding="async"
                                            alt="<?php the_title_attribute(); ?>"
                                        >
                                    </a>

                                    <h5>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h5>

                                </div>
                            </div>

                        <?php endif; ?>

                    <?php endwhile; ?>

                </div>
            </div>

            <?php
            /*
             * Second post loop.
             * WP_Query rewind_posts() is used because the first loop
             * has already reached the end of the query.
             */
            $led_query->rewind_posts();
            $sl = 0;
            ?>

            <div class="col-md-3">
                <div class="row">

                    <?php
                    while ( $led_query->have_posts() ):
                        $led_query->the_post();

                        $sl++;
                        $post_id = get_the_ID();

                        $post_img = wp_get_attachment_image_src(
                            get_post_thumbnail_id($post_id),
                            'khulna_gazette_post_thumb'
                        );
                    ?>

                        <?php if ( $sl == 3 ): ?>

                            <div class="col-md-12">
                                <div class="kg-lead-single-article">

                                    <a href="<?php the_permalink(); ?>">
                                        <?php
                                            $event_img_src = function_exists( 'kg_get_the_post_thumbnail_url' ) ? kg_get_the_post_thumbnail_url( $post_id, 'khulna_gazette_post_thumb' ) : ( ! empty( $post_img[0] ) ? $post_img[0] : get_template_directory_uri() . '/assets/img/kg-home-image.jpg' );
                                            $default_img = esc_url( get_template_directory_uri() . '/assets/img/kg-home-image.jpg' );
                                        ?>
                                        <img
                                            src="<?php echo esc_url($event_img_src); ?>"
                                            onerror="this.onerror=null;this.src='<?php echo $default_img; ?>';"
                                            loading="lazy"
                                            decoding="async"
                                            alt="<?php the_title_attribute(); ?>"
                                            title="<?php the_title_attribute(); ?>"
                                        >
                                    </a>

                                    <h5>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h5>

                                </div>
                            </div>

                        <?php endif; ?>

                    <?php endwhile; ?>

                </div>
            </div>

            <?php
            /*
             * Third loop - main/featured post.
             */
            $led_query->rewind_posts();
            $sl = 0;
            ?>

            <?php
            while ( $led_query->have_posts() ):
                $led_query->the_post();

                $sl++;
                $post_id = get_the_ID();

                $post_img = wp_get_attachment_image_src(
                    get_post_thumbnail_id($post_id),
                    'khulna_gazette_post_thumb'
                );
            ?>

                <?php if ( $sl == 1 ): ?>

                    <div class="col-md-6">
                        <div class="kg-lead-single-article">

                            <a href="<?php the_permalink(); ?>">
                                <?php
                                    $event_img_src = function_exists( 'kg_get_the_post_thumbnail_url' ) ? kg_get_the_post_thumbnail_url( $post_id, 'khulna_gazette_lead_thumb' ) : ( ! empty( $post_img[0] ) ? $post_img[0] : get_template_directory_uri() . '/assets/img/kg-home-image.jpg' );
                                    $default_img = esc_url( get_template_directory_uri() . '/assets/img/kg-home-image.jpg' );
                                ?>
                                <img
                                    src="<?php echo esc_url($event_img_src); ?>"
                                    onerror="this.onerror=null;this.src='<?php echo $default_img; ?>';"
                                    loading="lazy"
                                    decoding="async"
                                    alt="<?php the_title_attribute(); ?>"
                                    title="<?php the_title_attribute(); ?>"
                                >
                            </a>

                            <h5>
                                <a
                                    href="<?php the_permalink(); ?>"
                                    style="font-size:30px"
                                >
                                    <?php the_title(); ?>
                                </a>
                            </h5>

                        </div>
                    </div>

                <?php endif; ?>

            <?php endwhile; ?>

            <?php
            /*
             * Fourth loop - fourth post.
             */
            $led_query->rewind_posts();
            $sl = 0;
            ?>

            <div class="col-md-3">
                <div class="row">

                    <?php
                    while ( $led_query->have_posts() ):
                        $led_query->the_post();

                        $sl++;
                        $post_id = get_the_ID();

                        $post_img = wp_get_attachment_image_src(
                            get_post_thumbnail_id($post_id),
                            'khulna_gazette_post_thumb'
                        );
                    ?>

                        <?php if ( $sl == 4 ): ?>

                            <div class="col-md-12">
                                <div class="kg-lead-single-article">

                                    <a href="<?php echo esc_url(get_the_permalink()); ?>">
                                        <?php
                                            $event_img_src = function_exists( 'kg_get_the_post_thumbnail_url' ) ? kg_get_the_post_thumbnail_url( $post_id, 'khulna_gazette_post_thumb' ) : ( ! empty( $post_img[0] ) ? $post_img[0] : get_template_directory_uri() . '/assets/img/kg-home-image.jpg' );
                                            $default_img = esc_url( get_template_directory_uri() . '/assets/img/kg-home-image.jpg' );
                                        ?>
                                        <img
                                            src="<?php echo esc_url($event_img_src); ?>"
                                            onerror="this.onerror=null;this.src='<?php echo $default_img; ?>';"
                                            loading="lazy"
                                            decoding="async"
                                            alt="<?php the_title_attribute(); ?>"
                                        >
                                    </a>

                                    <h5>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h5>

                                </div>
                            </div>

                        <?php endif; ?>

                    <?php endwhile; ?>

                    <?php
                    /*
                     * Fifth loop - fifth post.
                     */
                    $led_query->rewind_posts();
                    $sl = 0;
                    ?>

                    <?php
                    while ( $led_query->have_posts() ):
                        $led_query->the_post();

                        $sl++;
                        $post_id = get_the_ID();

                        $post_img = wp_get_attachment_image_src(
                            get_post_thumbnail_id($post_id),
                            'khulna_gazette_post_thumb'
                        );
                    ?>

                        <?php if ( $sl == 5 ): ?>

                            <div class="col-md-12">
                                <div class="kg-lead-single-article">

                                    <a href="<?php echo esc_url(get_the_permalink()); ?>">
                                        <?php
                                            $event_img_src = function_exists( 'kg_get_the_post_thumbnail_url' ) ? kg_get_the_post_thumbnail_url( $post_id, 'khulna_gazette_post_thumb' ) : ( ! empty( $post_img[0] ) ? $post_img[0] : get_template_directory_uri() . '/assets/img/kg-home-image.jpg' );
                                            $default_img = esc_url( get_template_directory_uri() . '/assets/img/kg-home-image.jpg' );
                                        ?>
                                        <img
                                            src="<?php echo esc_url($event_img_src); ?>"
                                            onerror="this.onerror=null;this.src='<?php echo $default_img; ?>';"
                                            loading="lazy"
                                            decoding="async"
                                            alt="<?php the_title_attribute(); ?>"
                                        >
                                    </a>

                                    <h5>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h5>

                                </div>
                            </div>

                        <?php endif; ?>

                    <?php endwhile; ?>

                </div>
            </div>

            <?php
            endif;

            wp_reset_postdata();
            ?>

        </div>
    </div>
</div>


<!-- Mobile Version -->

<div class="kg-lead-widgets-wrapper-mobile">
    <div class="container">
        <div class="row">

            <div
                class="col-md-12"
                style="padding-left:5px; padding-right:5px;"
            >
                <div class="kg-lead-widgets-title">
                    <h1><?php echo esc_html($title); ?></h1>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">

                    <?php
                    $led_args_mob = array(
                        'post_type'      => 'post',
                        'cat'            => $event_category,
                        'posts_per_page' => 5,
                        'post_status'    => 'publish',
                        'no_found_rows'  => true,
                    );

                    $led_query_mob = new WP_Query($led_args_mob);
                    $sl = 0;

                    if ( $led_query_mob->have_posts() ):

                        while ( $led_query_mob->have_posts() ):
                            $led_query_mob->the_post();

                            $sl++;
                    ?>

                        <?php if ( $sl == 1 ): ?>

                            <div
                                class="col-md-12"
                                style="padding-left:5px; padding-right:5px;"
                            >
                                <div class="kg-lead-single-article">

                                    <a href="<?php echo esc_url(get_the_permalink()); ?>">
                                        <?php kg_post_thumbnail('post_image'); ?>
                                    </a>

                                    <h5>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h5>

                                </div>
                            </div>

                        <?php else: ?>

                            <div
                                class="col-6 col-sm-6 col-xs-6 col-md-6"
                                style="padding-left:5px; padding-right:5px;"
                            >
                                <div class="kg-lead-single-article">

                                    <a href="<?php echo esc_url(get_the_permalink()); ?>">
                                        <?php kg_post_thumbnail('post_image'); ?>
                                    </a>

                                    <h5
                                        style="line-height:15px; padding-top:10px;"
                                    >
                                        <a
                                            href="<?php the_permalink(); ?>"
                                            style="font-size:16px;"
                                        >
                                            <?php the_title(); ?>
                                        </a>
                                    </h5>

                                </div>
                            </div>

                        <?php endif; ?>

                    <?php
                        endwhile;
                    endif;

                    wp_reset_postdata();
                    ?>

                </div>
            </div>

        </div>
    </div>
</div>

<?php
    endif;
endif;
?>