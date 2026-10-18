<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php if( is_single() ){
            the_title('<h2>', '</h2>');
            
            
        } ?>
    </header>
    
    <div class="row">
        <div class="col-md-12">
          <h1>No content found!</h1>              
        </div>  
    </div>
</article>
