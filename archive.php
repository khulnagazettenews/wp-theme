<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-md-9">
         <div class="row">
             <div class="col-md-12">
                 <?php
                 the_archive_title( '<h2 style="border-bottom:solid 2px #FF0000; margin-bottom:30px;">', '</h2>' );
                 ?>

             </div>
         </div>
          <div class="row">
           <?php

            if( have_posts() ) {
            
               
                while( have_posts() ) {
    
                    the_post();
                    
                    if ( get_post_type() === 'epaper' || is_post_type_archive( 'epaper' ) ) {
                        get_template_part('template-parts/content', 'epaper');
                    } else {
                        get_template_part('template-parts/content', 'archive');    
                    }
                    
                 } 
                    
                }
                 
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
        <div class="col-md-3">
           <?php do_action( 'kg_tab_section' ); ?>
           
           <div class="empty-20"></div>
            <?php
                if(is_active_sidebar( 'kg_news_page_sidebar' )){
                    dynamic_sidebar( 'kg_news_page_sidebar' );
                }
             ?>
        </div>
        
        <section class="empty-30"></section>
        
    
</div>
</div>
<?php get_footer(); ?>