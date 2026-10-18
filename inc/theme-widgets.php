<?php
function khulnagazette_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'khulnagazette' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'khulnagazette' ),
			'before_widget' => '<div class="single-main-sidebar">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2>',
		)
	);
    
    register_sidebar(
        array(
            'name'          => esc_html__( 'Khulna Gazette Special News', 'khulnagazette' ),
            'id'            => 'special_news',
            'description'   => esc_html__( 'Special news (1200X400 image size) ', 'khulnagazette' ),
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '<h2 style="display:none">',
            'after_title'   => '</h2>',
        )
    );
    
    register_sidebar(
        array(
            'name'          => esc_html__( 'Khulna Gazette Live', 'khulnagazette' ),
            'id'            => 'live_news',
            'description'   => esc_html__( ' Khulna Gazette Live ', 'khulnagazette' ),
            'before_widget' => '<div class="single-main-sidebar">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2>',
            'after_title'   => '</h2>',
        )
    );
    
    register_sidebar(
        array(
            'name'          => esc_html__( 'Khulna Gazette Footer Widgets', 'khulnagazette' ),
            'id'            => 'footer_widgets',
            'description'   => esc_html__( ' Khulna Gazette Footer Widgets ', 'khulnagazette' ),
            'before_widget' => '<div class="col-md-2 col-sm-6 col-xs-6">
                                    <div class="footer-menu">',
            'after_widget'  => '</div></div>',
            'before_title'  => '<h2 style="display:none;">',
            'after_title'   => '</h2>',
        )
    );
    
    register_sidebar(
        array(
            'name'          => esc_html__( 'Khulna Gazette Footer Bottom', 'khulnagazette' ),
            'id'            => 'footer_bottom_widgets',
            'description'   => esc_html__( ' Khulna Gazette Footer Widgets ', 'khulnagazette' ),
            'before_widget' => '<div class="footer-contact-editor-area-fix">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 style="display:none;">',
            'after_title'   => '</h2>',
        )
    );
    
    register_sidebar(
        array(
            'name'          => esc_html__( 'KG Footer Top Three Column', 'khulnagazette' ),
            'id'            => 'footer_top_three_column_widgets',
            'description'   => esc_html__( ' Khulna Gazette Footer Top Three Column ', 'khulnagazette' ),
            'before_widget' => '<div>',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 style="display:none;">',
            'after_title'   => '</h2>',
        )
    );
    
    register_sidebar(
        array(
            'name'          => esc_html__( 'Home Page Widgets', 'khulnagazette' ),
            'id'            => 'home_page_widgets',
            'description'   => esc_html__( ' Khulna Gazette Home Widgets ', 'khulnagazette' ),
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '',
            'after_title'   => '',
        )
    );
    
	register_sidebar(
		array(
			'name'          => esc_html__( 'News Page Sidebar', 'khulnagazette' ),
			'id'            => 'kg_news_page_sidebar',
			'description'   => esc_html__( 'News page sidebar widgets', 'khulnagazette' ),
			'before_widget' => '<div class="single-main-sidebar">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2>',
		)
	);
    
    register_sidebar(
        array(
            'name'          => esc_html__( 'News Page Advertisement', 'khulnagazette' ),
            'id'            => 'kg_news_page_widgets',
            'description'   => esc_html__( 'News Page Widgets', 'khulnagazette' ),
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '',
            'after_title'   => '',
        )
    );
    
    
    register_sidebar(
        array(
            'name'          => esc_html__( 'News Page Top', 'khulnagazette' ),
            'id'            => 'kg_news_page_top_image',
            'description'   => esc_html__( 'News Page Top Advertisement', 'khulnagazette' ),
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '',
            'after_title'   => '',
        )
    );
}
add_action( 'widgets_init', 'khulnagazette_widgets_init' );