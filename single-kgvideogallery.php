<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
           <?php if( have_posts() ) { ?>
            <div class="kg-single-article">
               <div class="breadcrumb"><?php get_breadcrumb(); ?></div>
                <?php while( have_posts() ) {
                    
                    the_post();
                ?>
                
                
                
                <?php
                    get_template_part( 'template-parts/content', 'singlevideo' );
                    
                 } ?>
                    
            </div>
                
            <?php }
                else{
                    get_template_part('template-parts/content', 'none');
                }
            ?>
            
                   
        </div>
        
        
        
        <div class="col-md-4">
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