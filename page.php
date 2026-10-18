<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
           <?php if( have_posts() ) { ?>
            <div class="kg-single-article">
               
                <?php while( have_posts() ) {
    
                    the_post();
                    
                    get_template_part( 'template-parts/content', 'page');
                    
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