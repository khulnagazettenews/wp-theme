<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div style="width:100%; height:auto;border-color:#ECEFFF; padding:5px; margin-bottom:10px;">
            <?php if( is_active_sidebar( 'kg_news_page_top_image' ) ){
                dynamic_sidebar( 'kg_news_page_top_image' );    
            } ?>
                
                
            </div>
           <?php if( have_posts() ) { ?>
            <div class="kg-single-article">
                
                
               
                <?php while( have_posts() ) {
                    
                    the_post();
                    
                    
                    setPostViews(get_the_ID());
					
                ?>
                <div class="breadcrumb"><?php get_breadcrumb(); ?></div>
                
                
                <?php
                    
                    get_template_part( 'template-parts/content', get_post_format() );
                    
                 } ?>
                    
            </div>
                
            <?php }
                else{
                    get_template_part('template-parts/content', 'none');
                }
            ?>
            
                   
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