<div class="row">
   <div class="col-md-12">
       <h2 style="margin-top:15px; border-bottom:solid 2px red;">আরও সংবাদ</h2>
   </div>
<?php
    $current_post_id = get_the_ID();
    $categories = wp_get_post_categories( $current_post_id );

    $related = array(
        'posts_per_page' => 12,
        'post__not_in'   => array( $current_post_id ),
        'post_status'    => 'publish',
        'no_found_rows'  => true,
    );
    if ( ! empty( $categories ) ) {
        $related['category__in'] = $categories;
    }
	
    $query = new WP_Query( $related );
?>


<?php if( $query->have_posts() ):?>

<?php while( $query->have_posts() ): $query->the_post();?>


<div class="col-md-4">
   <a href="<?php the_permalink();?>">
        <div class="slider-content-box">
        <figure class="kg-single-news-figure">
        <?php
            $rel_img_url = function_exists( 'kg_get_the_post_thumbnail_url' ) ? kg_get_the_post_thumbnail_url( get_the_ID(), 'khulna_gazette_post_thumb' ) : ( has_post_thumbnail() ? wp_get_attachment_image_url( get_post_thumbnail_id(), 'khulna_gazette_post_thumb' ) : get_template_directory_uri().'/assets/img/kg-home-image.jpg' );
            $default_img = esc_url( get_template_directory_uri().'/assets/img/kg-home-image.jpg' );
        ?>
        <img src="<?php echo esc_url( $rel_img_url ); ?>" onerror="this.onerror=null;this.src='<?php echo $default_img; ?>';" loading="lazy" decoding="async" alt="<?php the_title_attribute(); ?>">
        </figure>
            <h5><?php the_title();?></h5>
        </div>
    </a>

</div>

<?php endwhile; ?>

<?php endif; ?>


<?php wp_reset_postdata();?>

</div>
<section class="empty-30"></section>