<?php
function khulnagazette_scripts() {
    
    wp_enqueue_style( 'bootstrap-min-css', get_template_directory_uri().'/assets/bootstrap/css/bootstrap.min.css', array(), '4.5.3', 'all' );

    wp_enqueue_style( 'font-awesome-min-css', get_template_directory_uri().'/assets/font-awesome/css/font-awesome.min.css', array(), '4.7.0', 'all' );
    wp_enqueue_style( 'bangla-fonts', get_template_directory_uri().'/assets/font-face/bangla-fonts.css', array(), 'null', 'all' );
    
    /*
    * Enqueue Main Stylesheet with auto-busting filemtime
    */
    $theme_version = wp_get_theme()->get( 'Version' );
    $style_path    = get_stylesheet_directory() . '/style.css';
    $resp_path     = get_template_directory() . '/assets/css/responsive.css';
    $style_ver     = file_exists( $style_path ) ? filemtime( $style_path ) : $theme_version;
    $resp_ver      = file_exists( $resp_path ) ? filemtime( $resp_path ) : $theme_version;

	wp_enqueue_style( 'theme-styles', get_stylesheet_uri(), array(), $style_ver );

    wp_enqueue_style( 'responsive-css', get_template_directory_uri().'/assets/css/responsive.css', array(), $resp_ver, 'all' );

    /*
    * Include JS in footer with core jQuery dependency
    */
    wp_enqueue_script( 'bootstrap-min-js', get_template_directory_uri().'/assets/bootstrap/js/bootstrap.min.js', array('jquery'), '4.5.3', true );
    wp_enqueue_script( 'khulnagazette-main-js', get_template_directory_uri().'/assets/js/main.js', array('jquery', 'bootstrap-min-js'), $theme_version, true );

    // Localize default image and home URL for instant prefetching and fallback images
    wp_localize_script( 'khulnagazette-main-js', 'kgData', array(
        'defaultImage' => esc_url( get_template_directory_uri() . '/assets/img/kg-home-image.jpg' ),
        'homeUrl'      => esc_url( home_url('/') ),
    ) );
}

add_action('wp_enqueue_scripts', 'khulnagazette_scripts');
//End enqueue scripts for front end


if(!function_exists('khulna_gazette_admin_scripts')):
    function khulna_gazette_admin_scripts( $hook ) {

        if( 'widgets.php' != $hook && 'edit.php' != $hook && 'post.php' != $hook && 'post-new.php' != $hook ) {
            return;
        }

        if ( function_exists( 'wp_enqueue_media' ) ) {
            wp_enqueue_media();
        }

        wp_enqueue_script( 'jquery-ui-button' );

        wp_enqueue_script( 'admin-scripts', get_template_directory_uri() .'/assets/js/admin-scripts.js', array('jquery'), '1.0.0', true );

        wp_enqueue_style( 'admin-styles', get_template_directory_uri() .'/assets/css/admin-styles.css', array(), '1.0.0' );
    }
add_action( 'admin_enqueue_scripts', 'khulna_gazette_admin_scripts' );
endif;