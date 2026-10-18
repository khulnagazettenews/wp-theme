<?php 
/**
* Template Name: Photo Gallery
*/
get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
           <?php if( have_posts() ) { ?>
            <div class="kg-single-article">
               
                <?php while( have_posts() ) {
    
                    $id = get_the_ID();
    
                    the_post();
    
                    setPostViews($id);
                    
                    get_template_part( 'template-parts/content', 'photogallery');
                    
                 } ?>
                    
            </div>
                
            <?php }
                else{
                    get_template_part('template-parts/content', 'none');
                }
            ?>    
        </div>
        
        <?php get_sidebar(); ?>
    </div>
</div>
   


<?php get_footer(); ?>