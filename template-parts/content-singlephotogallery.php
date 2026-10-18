<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php if( is_single() ){
            
            if( function_exists( 'get_secondary_title' ) ) { ?>
               
                <h3 class="kg-sub-title"> <?php get_secondary_title(); ?> </h3>
                
            <?php }
    
            the_title('<h2 style="font-size:18px; text-align:justify; font-weight:normal">', '</h2>');  
        } 
        
        ?>       
    </header>
    
    <div class="row">
        <div class="col-md-12">
            <?php 
                $kg_author_title = get_field('kg_news_author_title');

                if(!empty($kg_author_title)){
                    echo '<h2 class="author-title">' . $kg_author_title . '</h2>';
                }
            ?>
        </div>
        
        <div class="col-md-8">
            <?php kg_post_meta(); ?>
        </div>
       <div class="col-md-4">
            <h2 class="social-share"><?php echo do_shortcode('[Sassy_Social_Share]'); ?>
            <div class="kg-print"><?php echo do_shortcode('[print-me]'); ?></div></h2>
        </div>
    </div>
    

    
    <figure class="kg-single-news-figure">
        <?php
            $photo_img = function_exists( 'kg_get_the_post_thumbnail_url' ) ? kg_get_the_post_thumbnail_url( get_the_ID(), 'full' ) : ( has_post_thumbnail() ? wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' ) : get_template_directory_uri().'/assets/img/kg-home-image.jpg' );
            $default_img = esc_url( get_template_directory_uri().'/assets/img/kg-home-image.jpg' );
        ?>
        <img src="<?php echo esc_url( $photo_img ); ?>" onerror="this.onerror=null;this.src='<?php echo $default_img; ?>';" loading="lazy" decoding="async" alt="<?php the_title_attribute(); ?>">
    </figure>
    
    <div class="kg-news-figcaption">
        <?php echo do_shortcode( '[ccfic]' ); ?>
    </div>
       
    <div class="entry-content">        
        <?php if(function_exists( 'the_views' )){ ?>
            <div class="kg-posts-views">
                 <p><?php the_views(); ?></p>
            </div>
        <?php } ?>
    </div>
    
    
    
    
</article>
<div style="clear:both"></div>
<div class="row">
    <div class="col-md-12">
        <?php if( is_active_sidebar('kg_news_page_widgets')){
                    
            dynamic_sidebar('kg_news_page_widgets');
    
        } ?>
    </div>
</div>
