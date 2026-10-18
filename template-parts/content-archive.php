<?php
$is_epaper = ( get_post_type() === 'epaper' || is_post_type_archive( 'epaper' ) );
$thumb_size = $is_epaper ? 'full' : 'khulna_gazette_post_thumb';
$img_url = function_exists( 'kg_get_the_post_thumbnail_url' ) ? kg_get_the_post_thumbnail_url( get_the_ID(), $thumb_size ) : ( has_post_thumbnail() ? wp_get_attachment_image_url( get_post_thumbnail_id(), $thumb_size ) : get_template_directory_uri().'/assets/img/kg-home-image.jpg' );
$default_img = esc_url( get_template_directory_uri().'/assets/img/kg-home-image.jpg' );
$epaper_img_style = $is_epaper ? ' style="width:100%; height:auto; display:block; object-fit:contain; float:none;"' : '';
?>
<div class="col-md-4 <?php echo $is_epaper ? 'col-sm-6 col-12 kg-epaper-archive-col' : ''; ?>">
   <a href="<?php the_permalink();?>">
        <div class="slider-content-box <?php echo $is_epaper ? 'kg-epaper-content-box' : ''; ?>">
            <figure class="kg-single-news-figure <?php echo $is_epaper ? 'kg-epaper-figure' : ''; ?>">
                <img src="<?php echo esc_url( $img_url ); ?>" onerror="this.onerror=null;this.src='<?php echo $default_img; ?>';" loading="lazy" decoding="async" alt="<?php the_title_attribute(); ?>"<?php echo $epaper_img_style; ?> class="<?php echo $is_epaper ? 'kg-epaper-img' : ''; ?>">
            </figure> 
            <h5><?php the_title();?></h5>
        </div>
    </a>
</div>