<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
         <div class="row">
             <div class="col-md-12">
                 <h2 style="border-bottom:solid 2px #FF0000; margin-bottom:30px;">টপ টেন নিউজ</h2>
             </div>
         </div>
          <div class="row">
           <?php if( have_posts() ) { ?>
            
               
                <?php while( have_posts() ) {
    
                    the_post(); ?>
                    
                     <?php get_template_part('template-parts/content', 'archive'); ?>   
                    
                <?php } ?>
                    
            
                
            <?php }
                else{
                    get_template_part('template-parts/content', 'none');
                }
            
            ?>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="kg-pagination-wrapper">
                    <?php 
                        if(function_exists('wp_paginate')):
                            wp_paginate();  
                        endif;
                    ?>
                </div>
            </div>
        </div>
        </div>      
        <?php get_sidebar(); ?>
        
    
</div>
</div>
<?php get_footer(); ?>