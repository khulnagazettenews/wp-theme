<?php
// Control core classes for avoid errors
if( class_exists( 'CSF' ) ) {

  //
  // Set a unique slug-like ID
  $prefix = 'cn_framework';

  //
  // Create options
  CSF::createOptions( $prefix, array(
    'menu_title' => 'Theme Options',
    'menu_slug'  => 'cn-theme-options',
  ) );

  
	// Create a top-tab
	CSF::createSection( $prefix, array(
		'id'    => 'news_category_settings', // Set a unique slug-like ID
		'title' => 'News category settings',
	) );

  
  // Create a sub-tab
  CSF::createSection( $prefix, array(
    'parent' => 'news_category_settings', // The slug id of the parent section
    'title'  => 'News categories',
    'fields' => array(

      
	array(
		'id'    		=> 'breaking_news_category',
		'type'  		=> 'select',
		'options'		=> 'categories',
		'multiple'    	=> false,
		'title' 		=> 'Select breaking news category',
		'placeholder'	=> 'Breaking news category', 
	),
	
	array(
		'id'    		=> 'number_of_breaking_news',
		'type'  		=> 'number',
		'title' 		=> 'Number of breaking news',
		
	),

	array(
		'id'    		=> 'lead_news_category',
		'type'  		=> 'select',
		'options'		=> 'categories',
		'title' 		=> 'Select lead news category',
		'placeholder'	=> 'Select category for lead news',

	  ),
		
	array(
		'id'    		=> 'number_of_leading_news',
		'type'  		=> 'number',
		'title' 		=> 'Number of lead news',
		
	),
	
	array(
		  'id'          => 'skip_category_for_latest_news',
		  'type'        => 'select',
		  'title'       => 'Skip categories from latest news',
		  'chosen'      => true,
		  'multiple'    => true,
		  'placeholder' => 'Select categories',
		  'options'     => 'categories',
		),
		
	
		
	)));

	//load all theme options
	require_once get_template_directory() . '/inc/all-options/gallery-options.php';
	require_once get_template_directory() . '/inc/all-options/social-links.php';
	require_once get_template_directory() . '/inc/all-options/event-news.php';
	require_once get_template_directory() . '/inc/all-options/show-hide-breaking-news.php';

}



