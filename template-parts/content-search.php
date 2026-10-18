<div class="col-md-4">
   <a href="<?php the_permalink();?>">
        <div class="slider-content-box">
            <figure class="kg-single-news-figure">
                <?php
                    $img_url = function_exists( 'kg_get_the_post_thumbnail_url' ) ? kg_get_the_post_thumbnail_url( get_the_ID(), 'khulna_gazette_post_thumb' ) : ( has_post_thumbnail() ? wp_get_attachment_image_url( get_post_thumbnail_id(), 'khulna_gazette_post_thumb' ) : get_template_directory_uri().'/assets/img/kg-home-image.jpg' );
                    $default_img = esc_url( get_template_directory_uri().'/assets/img/kg-home-image.jpg' );
                    echo '<img src="'.esc_url( $img_url ).'" onerror="this.onerror=null;this.src=\''.esc_url($default_img).'\';" loading="lazy" decoding="async" alt="'.esc_attr( get_the_title() ).'">';
                ?>
            </figure> 
            <h5><?php the_title();?></h5>
        </div>
    </a>
</div>