<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php if( is_page() ){
            the_title('<h2>', '</h2>'); 
        } ?>
    </header>
    
    <?php if( has_post_thumbnail() ) {  ?>
        <figure class="kg-single-news-figure">
            <?php kg_post_thumbnail('khulna_gazette_post_thumb'); ?>
        </figure>
    <?php } ?>
    
    <div class="entry-content">
        <?php the_content(); ?>
    </div>
    
</article>
