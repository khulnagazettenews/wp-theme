<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package khulnagazette
 */
?>


    <div class="col-md-3">
        <?php if( is_active_sidebar( 'live_news' ) ){
            dynamic_sidebar( 'live_news' );    
        } ?>

        <?php do_action( 'kg_tab_section' ); ?>      


       <div class="empty-20"></div>
       <?php if( is_active_sidebar( 'sidebar-1' ) ) {
        
            dynamic_sidebar( 'sidebar-1' );
    
        } ?>
        <div class="empty-20"></div>
    </div>