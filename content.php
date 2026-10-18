<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php if( is_single() ){
            
            if( function_exists( 'get_secondary_title' ) ) { ?>
               
                <h3 class="kg-sub-title"> <?php get_secondary_title(); ?> </h3>
                
            <?php }
    
            the_title('<h2>', '</h2>');  
        } 
        
        ?>
        
        
    </header>
    
    <div class="row">
        <div class="col-md-12">
            <?php 
                $kg_author_title = get_field('kg_news_author_title');

                if(!empty($kg_author_title)){
                    echo '<h2 style="font-size:22px; margin-bottom:5px;">' . $kg_author_title . '</h2>';
                }
            ?>
        </div>
        
        <div class="col-md-8">
            <?php kg_post_meta(); ?>
        </div>
        <div class="col-md-4">
            <h2 class="social-share"><?php echo do_shortcode('[TheChamp-Sharing]'); ?><div class="kg-print"><?php echo do_shortcode('[print-me]'); ?></div></h2>
        </div>
    </div>
    

    
    <?php $is_single_epaper = ( get_post_type() === 'epaper' ); ?>
    <figure class="kg-single-news-figure <?php echo $is_single_epaper ? 'kg-epaper-figure kg-epaper-single-figure' : ''; ?>">
        <?php kg_post_thumbnail( $is_single_epaper ? 'full' : 'khulna_gazette_post_thumb' ); ?>
    </figure>
    <div class="kg-news-figcaption"><?php echo do_shortcode( '[ccfic]' ); ?></div>
       
    <div class="entry-content" style="font-size:20px; text-align:justify;">
        <?php the_content(); ?>
        
        <div class="kg-posts-views">
             <p><?php the_views();?></p>
        </div>
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

<?php 
    /**
    * Related Articles
    */
    get_template_part('template-parts/content', 'related');
?>