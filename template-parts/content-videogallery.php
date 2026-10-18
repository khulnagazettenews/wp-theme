<div class="col-md-6">
    <div class="single-photo-gallery-item single-fancybox">
       <?php        
            $url = function_exists('get_field') ? get_field('video_url') : get_post_meta(get_the_ID(), 'video_url', true);
            $id = '';
            if ( ! empty( $url ) ) {
                $id = preg_replace('/^.*(\?|\&)v\=/', '', $url);
                $id = preg_replace('/[^\w\-\_].*$/', '', $id);
            }
        ?>
        <a href="<?php the_permalink(); ?>">
        <div class="video-embedd-wrap">
            <div class="video-item">
                <?php if ( ! empty( $id ) ): ?>
                <iframe width="100%" height="auto" src="https://www.youtube.com/embed/<?php echo esc_attr( $id ); ?>" frameborder="0" allowfullscreen loading="lazy"></iframe>
                <?php endif; ?>
                <?php the_title( '<h5 class="video-gallery-heading">', '</h5>' ); ?> 
            </div>
              
        </div>
        </a>    

        
    </div>
</div>