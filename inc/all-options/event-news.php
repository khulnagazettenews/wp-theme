<?php
	// Create a top-tab
	  CSF::createSection( $prefix, array(
		'id'    => 'event_news', // Set a unique slug-like ID
		'title' => 'Event news settings',
	  ) );
  

	// Create a sub-tab
  CSF::createSection( $prefix, array(
    'parent' => 'event_news', // The slug id of the parent section
    'title'  => 'Event news',
    'fields' => array(
	
		array(
		  'title'       	=> 'Show/Hide',
		  'id'          	=> 'kg_event_news_showhide',
		  'type'        	=> 'select',
		  'options'			=> array(
		  			'1'=>'Show',
					'0'=>'Hide',
		  			
		  			),
			
		  
		),

      // A text field
		array(
		  'id'          => 'kg_event_news_title',
		  'type'        => 'text',
		  'title'       => 'Event Title',
		),
		
		array(
		  'id'          	=> 'kg_event_news_category',
		  'type'  			=> 'select',
		  'options'			=> 'categories',
		  'title'			=>'Select event category',
		  'placeholder'		=> 'Select category'
		),
		
    )
  ) );



