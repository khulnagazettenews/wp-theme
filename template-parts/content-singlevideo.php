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
                $url = function_exists('get_field') ? get_field('video_url') : get_post_meta(get_the_ID(), 'video_url', true);
                $id = '';
                if ( ! empty( $url ) ) {
                    $id = preg_replace('/^.*(\?|\&)v\=/', '', $url);
                    $id = preg_replace('/[^\w\-\_].*$/', '', $id);
                }
            ?>
            <a href="<?php the_permalink(); ?>">
            <div class="video-embedd-wrap">
                <div class="video-item">
                    <?php if ( ! empty( $id ) ): ?>
                    <iframe width="100%" height="400" src="https://www.youtube.com/embed/<?php echo esc_attr( $id ); ?>" frameborder="0" allowfullscreen loading="lazy"></iframe>
                    <?php endif; ?>
                </div>

            </div>
            </a>

        </figure>     

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
