<?php
if(!function_exists('cn_site_title')){
	function cn_site_title(){ ?>

		<a href="<?php echo esc_url( home_url('/') ); ?>">
			<?php 
				$options = get_option( 'cn_framework' );
				$site_title = ( is_array( $options ) && ! empty( $options['cn-site-title'] ) ) ? $options['cn-site-title'] : get_bloginfo( 'name' );
			?>

			<?php echo esc_html( $site_title ); ?>
		</a>

<?php								
	}
}
//End Site Title
if(!function_exists('cn_site_fb_profile')){
	function cn_site_fb_profile(){
		$options = get_option( 'cn_framework' );
		if ( ! is_array( $options ) ) {
			$options = array();
		}
		$fb   = ! empty( $options['cn-site-social-fb'] ) ? $options['cn-site-social-fb'] : ( ! empty( $options['kg_social_facebook_link'] ) ? $options['kg_social_facebook_link'] : '#' );
		$tw   = ! empty( $options['cn-site-social-twitter'] ) ? $options['cn-site-social-twitter'] : ( ! empty( $options['kg_social_twitter_link'] ) ? $options['kg_social_twitter_link'] : '#' );
		$insta= ! empty( $options['cn-site-social-instagram'] ) ? $options['cn-site-social-instagram'] : ( ! empty( $options['kg_social_instagram_link'] ) ? $options['kg_social_instagram_link'] : '#' );
		$pin  = ! empty( $options['cn-site-social-pinterest'] ) ? $options['cn-site-social-pinterest'] : ( ! empty( $options['kg_social_youtube_link'] ) ? $options['kg_social_youtube_link'] : '#' );
	?>
	
		<div class="cn-social-profile">
			<ul class="social-profile-link">
				<li><a href="<?php echo esc_url($fb); ?>"><i class="lab la-facebook-f"></i></a></li>
				<li><a href="<?php echo esc_url($tw); ?>"><i class="lab la-twitter"></i></a></li>
				<li><a href="<?php echo esc_url($insta); ?>"><i class="lab la-instagram"></i></a></li>
				<li><a href="<?php echo esc_url($pin); ?>"><i class="lab la-pinterest-p"></i></a></li>
			</ul>
		</div>

<?php								
	}
}

//Header Social Profile
if(!function_exists('cn_site_footer_social_profile')){
	function cn_site_footer_social_profile(){
		$options = get_option( 'cn_framework' );
		if ( ! is_array( $options ) ) {
			$options = array();
		}
		$fb   = ! empty( $options['cn-site-social-fb'] ) ? $options['cn-site-social-fb'] : ( ! empty( $options['kg_social_facebook_link'] ) ? $options['kg_social_facebook_link'] : '#' );
		$tw   = ! empty( $options['cn-site-social-twitter'] ) ? $options['cn-site-social-twitter'] : ( ! empty( $options['kg_social_twitter_link'] ) ? $options['kg_social_twitter_link'] : '#' );
		$insta= ! empty( $options['cn-site-social-instagram'] ) ? $options['cn-site-social-instagram'] : ( ! empty( $options['kg_social_instagram_link'] ) ? $options['kg_social_instagram_link'] : '#' );
		$pin  = ! empty( $options['cn-site-social-pinterest'] ) ? $options['cn-site-social-pinterest'] : ( ! empty( $options['kg_social_youtube_link'] ) ? $options['kg_social_youtube_link'] : '#' );
	?>
	
		<ul class="social-profile-link footer-social-icons">
			<li><a href="<?php echo esc_url($fb); ?>"><i class="lab la-facebook-f"></i></a></li>
			<li><a href="<?php echo esc_url($tw); ?>"><i class="lab la-twitter"></i></a></li>
			<li><a href="<?php echo esc_url($insta); ?>"><i class="lab la-instagram"></i></a></li>
			<li><a href="<?php echo esc_url($pin); ?>"><i class="lab la-pinterest-p"></i></a></li>
		</ul>
		

<?php								
	}
}

//Footer Social Profile

if(!function_exists( 'cn_footer_nav' )):

	function cn_footer_nav(){
		wp_nav_menu(
		['theme_location'=>'footer-links', 'menu_class'=>'cn-footer-nav']
		);
	}
endif;

//Footer Copyright Text
if(!function_exists('cn_footer_text')):
	function cn_footer_text(){
		$options = get_option( 'cn_framework' );
		$footer_text = ( is_array( $options ) && ! empty( $options['opt-footer-text'] ) ) ? $options['opt-footer-text'] : '&copy; ' . date('Y') . ' ' . get_bloginfo('name') . '. All rights reserved.';
		return $footer_text;
	}
endif;

