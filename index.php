<?php

get_header(); ?>
<section class="slider-content-section">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
              
               <?php 
               do_action( 'khulna_gazettet_top_ten_news_section' ); 
               do_action( 'khulna_gazettet_top_ten_news_section_mobile' ); 
               ?>
               
               <?php if( is_active_sidebar('home_page_widgets')){
                    
                        dynamic_sidebar('home_page_widgets');
    
                } ?>     
                
                          
            </div> <!-- End Col-8 -->
            <?php get_sidebar(); ?>
        </div>
    </div>
            
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                       <div class="row">
                           <?php 
                           /**
                           * Hook Photo gallery
                           */
                           do_action( 'kg_photo_gallery_section' ); ?>
                            
                           <?php
                           /**
                           * Hook Video gallery
                           */
                           do_action( 'kg_video_gallery_section' ); ?> 
                       </div>
                        
                    </div>
                    
                </div>
            </div>
            
            <section class="empty-30"></section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        
                            <?php if( is_active_sidebar('footer_top_three_column_widgets') ) {
                                dynamic_sidebar( 'footer_top_three_column_widgets' );
                            }?>
                        
                    </div>
                </div>
            </div>  
            <section class="empty-30"></section>  
    </section>
<!-- End Slider Content Section -->
<?php
/**
* Get Footer
*/
    get_footer();
?>