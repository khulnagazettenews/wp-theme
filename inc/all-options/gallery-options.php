<?php
	// Create a top-tab
	  CSF::createSection( $prefix, array(
		'id'    => 'gallery_settings', // Set a unique slug-like ID
		'title' => 'Gallery Settings',
	  ) );
  

	// Create a sub-tab
  CSF::createSection( $prefix, array(
    'parent' => 'gallery_settings', // The slug id of the parent section
    'title'  => 'Gallery Options',
    'fields' => array(

      // A text field
		array(
		  'id'          => 'photo_gallery_url',
		  'type'        => 'text',
		  'title'       => 'Photo gallery archive link',
		),
		
		array(
		  'id'          => 'video_gallery_url',
		  'type'        => 'text',
		  'title'       => 'Video gallery archive link',
		),
    )
  ) );



