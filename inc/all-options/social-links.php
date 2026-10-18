<?php
	// Create a top-tab
	  CSF::createSection( $prefix, array(
		'id'    => 'social_links', // Set a unique slug-like ID
		'title' => 'Social Links',
	  ) );
  

	// Create a sub-tab
  CSF::createSection( $prefix, array(
    'parent' => 'social_links', // The slug id of the parent section
    'title'  => 'Social Profiles',
    'fields' => array(

      // A text field
		array(
		  'id'          => 'kg_social_facebook_link',
		  'type'        => 'text',
		  'title'       => 'Facebook',
		),
		
		array(
		  'id'          => 'kg_social_twitter_link',
		  'type'        => 'text',
		  'title'       => 'Twitter',
		),
		
		array(
		  'id'          => 'kg_social_youtube_link',
		  'type'        => 'text',
		  'title'       => 'Youtube',
		),
		
		array(
		  'id'          => 'kg_social_instagram_link',
		  'type'        => 'text',
		  'title'       => 'Instagram',
		),
    )
  ) );



