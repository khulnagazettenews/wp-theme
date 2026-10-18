<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-md-9">
         <div class="row">
             <div class="col-md-12">
                 <h2 style="border-bottom:solid 2px #FF0000; margin-bottom:30px;">ই-পেপার</h2>
             </div>
         </div>
          <div class="row">
           <?php

            if( have_posts() ) {
            
               
                while( have_posts() ) {
    
                    the_post();
                    
                      get_template_part('template-parts/content', 'epaper');    
                    
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
                        else:
                            the_posts_pagination( array(
                                'mid_size'  => 2,
                                'prev_text' => __( '&laquo; পূর্ববর্তী', 'khulnagazette' ),
                                'next_text' => __( 'পরবর্তী &raquo;', 'khulnagazette' ),
                            ) );
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
