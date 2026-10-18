<?php
	// Create a top-tab
	  CSF::createSection( $prefix, array(
		'id'    => 'breaking_news_show_hide', // Set a unique slug-like ID
		'title' => 'Breaking News',
	  ) );
  

	// Create a sub-tab
  CSF::createSection( $prefix, array(
    'parent' => 'breaking_news_show_hide', // The slug id of the parent section
    'title'  => 'Breaking News Show/Hide',
    'fields' => array(
	
		array(
		  'title'       	=> 'Show/Hide',
		  'id'          	=> 'kg_breaking_news_showhide',
		  'type'        	=> 'select',
		  'options'			=> array(
		  			'1'=>'Show',
					'0'=>'Hide',
		  			
		  			),
			
		  
		),
		
    )
  ) );


