<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" href="<?php echo esc_url( get_template_directory_uri() . '/assets/font-face/Bangla.woff' ); ?>" as="font" type="font/woff" crossorigin>
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>



<?php get_template_part('template-parts/content', 'eventsection'); ?>

<?php if( is_active_sidebar('special_news') ){ 
	
	if(is_front_page()){
	
		do_action( 'kg_special_news_section_widgets' );
	} 
} ?>

<!-- End Slider Section -->
<section class="empty-15"></section>