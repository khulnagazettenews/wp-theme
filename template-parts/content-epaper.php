<?php
/**
 * Template part for displaying E-paper items in archive-epaper.php
 *
 * Shows full uploaded newspaper page image without cropping.
 */
$epaper_img_url = function_exists( 'kg_get_the_post_thumbnail_url' ) 
    ? kg_get_the_post_thumbnail_url( get_the_ID(), 'full' ) 
    : ( has_post_thumbnail() 
        ? wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' ) 
        : get_template_directory_uri() . '/assets/img/kg-home-image.jpg' );

$default_fallback = esc_url( get_template_directory_uri() . '/assets/img/kg-home-image.jpg' );
?>
<div class="col-md-4 col-sm-6 col-12 kg-epaper-archive-col">
    <a href="<?php the_permalink(); ?>">
        <div class="slider-content-box kg-epaper-content-box">
            <figure class="kg-single-news-figure kg-epaper-figure">
                <img src="<?php echo esc_url( $epaper_img_url ); ?>" onerror="this.onerror=null;this.src='<?php echo $default_fallback; ?>';" loading="lazy" decoding="async" alt="<?php the_title_attribute(); ?>" class="kg-epaper-img" style="width:100%; height:auto; display:block; object-fit:contain; float:none;">
            </figure> 
            <h5><?php the_title(); ?></h5>
        </div>
    </a>
</div>
