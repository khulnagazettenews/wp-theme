<?php
/*
* Top Ten News
*/
if(!function_exists('khulna_gazette_cpts')):
    function khulna_gazette_cpts() {        
	
    $kg_photo_labels = array(
		'name'                  => _x( 'Photo Gallery', 'Post Type General Name', 'khulnagazette' ),
		'singular_name'         => _x( 'Photo Gallery', 'Post Type Singular Name', 'khulnagazette' ),
		'menu_name'             => __( 'Photo Gallery', 'khulnagazette' ),
		'all_items'             => __( 'All Photo Gallery', 'khulnagazette' ),
		'add_new_item'          => __( 'New Photo Gallery', 'khulnagazette' ),
		'add_new'               => __( 'Add Photo Gallery', 'khulnagazette' ),
		'edit_item'             => __( 'Edit Photo Gallery', 'khulnagazette' ),

		
	);
    
	$kg_photo_gargs = array(
		'label'                 => __( 'All Photo Gallery', 'khulnagazette' ),
		'description'           => __( 'Top Photo Gallery', 'khulnagazette' ),
		'labels'                => $kg_photo_labels,
		'supports'              => array('title', 'editor', 'author', 'page-attributes', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_icon'           => 'dashicons-welcome-write-blog',
		'menu_position'         => 19,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
	);
        
    register_post_type( 'kgphotogallery', $kg_photo_gargs );
        
    //End photo gallery
    
        $kg_video_labels = array(
		'name'                  => _x( 'Video Gallery', 'Post Type General Name', 'khulnagazette' ),
		'singular_name'         => _x( 'Video Gallery', 'Post Type Singular Name', 'khulnagazette' ),
		'menu_name'             => __( 'Video Gallery', 'khulnagazette' ),
		'all_items'             => __( 'All Video Gallery', 'khulnagazette' ),
		'add_new_item'          => __( 'New Video Gallery', 'khulnagazette' ),
		'add_new'               => __( 'Add Video Gallery', 'khulnagazette' ),
		'edit_item'             => __( 'Edit Video Gallery', 'khulnagazette' ),

		
	);
    
	$kg_video_gargs = array(
		'label'                 => __( 'All Video Gallery', 'khulnagazette' ),
		'description'           => __( 'Top Video Gallery', 'khulnagazette' ),
		'labels'                => $kg_video_labels,
		'supports'              => array('title', 'author' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_icon'           => 'dashicons-welcome-write-blog',
		'menu_position'         => 20,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
	);
        
    register_post_type( 'kgvideogallery', $kg_video_gargs );
    
    
    //E Paper CPTS
        
        $kg_epaper_labels = array(
		'name'                  => _x( 'ই-পেপার', 'Post Type General Name', 'khulnagazette' ),
		'singular_name'         => _x( 'ই-পেপার', 'Post Type Singular Name', 'khulnagazette' ),
		'menu_name'             => __( 'ই-পেপার', 'khulnagazette' ),
		'all_items'             => __( 'সকল পাতা', 'khulnagazette' ),
		'add_new_item'          => __( 'নতুন পাতা', 'khulnagazette' ),
		'add_new'               => __( 'পাতা যোগ করুন', 'khulnagazette' ),
		'edit_item'             => __( 'পাতা সম্পাদনা', 'khulnagazette' ),
	);
    
	$kg_cpaper_gargs = array(
		'label'                 => __( 'All E-paper', 'khulnagazette' ),
		'description'           => __( 'E-paper', 'khulnagazette' ),
		'labels'                => $kg_epaper_labels,
		'supports'              => array('title', 'author', 'thumbnail','page-attributes' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_icon'           => 'dashicons-welcome-write-blog',
		'menu_position'         => 20,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
	);
        
    register_post_type( 'epaper', $kg_cpaper_gargs );
    
        
    }
add_action('init', 'khulna_gazette_cpts');
endif;