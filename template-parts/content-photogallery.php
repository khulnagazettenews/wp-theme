<div class="col-md-6">
    <div class="single-photo-gallery-item single-fancybox">
        <a href="<?php the_permalink(); ?>" title="<?php echo get_the_title(); ?>" alt="<?php echo get_the_title(); ?>">
            <?php the_post_thumbnail(); ?>
          
        <?php the_title( '<h5 class="photo-gallery-heading">', '</h5>' ); ?>
        </a>
    </div>
</div>