<?php
/**
* Template Name: Front page
*/
get_header();

?>
<section class="slider-content-section" style="width:100%;">
    <div class="container-fluid" style="padding-left:0px!important; padding-right:0px!important;">
        <div class="row">
            <div class="col-md-9">
                
                <?php do_action( 'khulna_gazettet_top_ten_news_section' ); ?>
                
                <?php do_action( 'khulna_gazettet_top_ten_news_section_mobile' ); ?>
               
               <?php if( is_active_sidebar('home_page_widgets')){
                    
                        dynamic_sidebar('home_page_widgets');
    
                } ?>     
                
                          
            </div> <!-- End Col-9 -->
            <?php get_sidebar(); ?>
        </div>
    </div>
            
            <div class="container-fluid" style="padding-left:0px; padding-right:0px;">
                <div class="row">
                    <div class="col-md-12" style="padding-left:0px; padding-right:0px;">
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
            <div class="container-fluid">
                <div class="row" style="padding-left:0px; padding-right:0px;">
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