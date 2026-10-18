<?php

if(!function_exists('khulna_gazette_tab_start')):
    function khulna_gazette_tab_start() { ?>
    <div class="slider-tab">
        <div class="bd-example bd-example-tabs">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active show" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">সর্বশেষ</a>
                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="true">সর্বাধিক পঠিত</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade active show" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <?php
						$cats = function_exists('kg_skip_latest_news_category') ? kg_skip_latest_news_category() : '';
						$tab_one_args = array(
							'post_type'      => 'post',
							'posts_per_page' => 20,
							'post_status'    => 'publish',
							'no_found_rows'  => true,
						);
						if ( ! empty( $cats ) ) {
							$cat_array = array_filter( array_map( 'intval', explode( ',', $cats ) ) );
							if ( ! empty( $cat_array ) ) {
								$tab_one_args['category__not_in'] = $cat_array;
							}
						}
                        
                        $query_one = new WP_Query( $tab_one_args );
                        if( $query_one->have_posts() ){
                            while($query_one->have_posts()){
                                $query_one->the_post();
                                $post_id = get_the_ID();
                                $post_img_one = wp_get_attachment_image_src(get_post_thumbnail_id($post_id),'khulna_gazette_post_thumb');
                                $post_img_url = function_exists( 'kg_get_the_post_thumbnail_url' ) ? kg_get_the_post_thumbnail_url( $post_id, 'khulna_gazette_post_thumb' ) : ( !empty($post_img_one[0]) ? $post_img_one[0] : get_template_directory_uri().'/assets/img/kg-home-image.jpg' );
                                $default_img = esc_url( get_template_directory_uri().'/assets/img/kg-home-image.jpg' );
                                echo '<a href="' . esc_url( get_the_permalink() ) . '">
                                <div class="tab-content-box">
                                    <img src="'.esc_url($post_img_url).'" onerror="this.onerror=null;this.src=\''.$default_img.'\';" alt="' . esc_attr( get_the_title() ) . '" title="'. esc_attr( get_the_title() ) . '" width="120" height="66" loading="lazy" decoding="async">
                                    <p>'.esc_html( get_the_title() ).'</p>
                                </div> 
                                </a>
                                <br>';
                            }
                            wp_reset_postdata();
                        }
                    ?>
                   
                </div>
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                   
                   <?php
                        $popular_post_ids = get_transient( 'kg_popular_post_ids_tab' );
                        if ( false === $popular_post_ids ) {
                            $pop_args = array(
                                'post_type'      => 'post',
                                'posts_per_page' => 10,
                                'post_status'    => 'publish',
                                'meta_key'       => 'post_views_count',
                                'orderby'        => 'meta_value_num',
                                'order'          => 'DESC',
                                'fields'         => 'ids',
                                'no_found_rows'  => true,
                            );
                            $query_pop = new WP_Query( $pop_args );
                            $popular_post_ids = ! empty( $query_pop->posts ) ? $query_pop->posts : array();
                            set_transient( 'kg_popular_post_ids_tab', $popular_post_ids, 15 * MINUTE_IN_SECONDS );
                        }

                        if ( ! empty( $popular_post_ids ) ) {
                            $query_two = new WP_Query( array(
                                'post_type'      => 'post',
                                'post__in'       => $popular_post_ids,
                                'orderby'        => 'post__in',
                                'posts_per_page' => 10,
                                'no_found_rows'  => true,
                            ) );
                        } else {
                            $query_two = new WP_Query( array(
                                'post_type'      => 'post',
                                'posts_per_page' => 10,
                                'post_status'    => 'publish',
                                'no_found_rows'  => true,
                            ) );
                        }
                        if( $query_two->have_posts() ){
                            while($query_two->have_posts()){
                                $query_two->the_post();
                                $post_id_two = get_the_ID();
                                $post_img_two = wp_get_attachment_image_src(get_post_thumbnail_id( $post_id_two ),'khulna_gazette_post_thumb');
                                
                                $post_img_url_two = function_exists( 'kg_get_the_post_thumbnail_url' ) ? kg_get_the_post_thumbnail_url( $post_id_two, 'khulna_gazette_post_thumb' ) : ( !empty($post_img_two[0]) ? $post_img_two[0] : get_template_directory_uri().'/assets/img/kg-home-image.jpg' );
                                $default_img = esc_url( get_template_directory_uri().'/assets/img/kg-home-image.jpg' );
                                echo '<a href="' . esc_url( get_the_permalink() ) . '">
                                <div class="tab-content-box">
                                    <img src="'.esc_url($post_img_url_two).'" onerror="this.onerror=null;this.src=\''.$default_img.'\';" alt="' . esc_attr( get_the_title() ) . '" title="'. esc_attr( get_the_title() ) . '" width="120" height="66" loading="lazy" decoding="async">
                                    <p>'.esc_html( get_the_title() ).'</p>
                                </div> 
                                </a>
                                <br>';
                            }
                            wp_reset_postdata();
                        }
                    ?>

                </div>
            </div>
            </div>
    </div>
    
    
<?php  }  
endif;
add_action('kg_tab_section', 'khulna_gazette_tab_start', 5);
//End tab menu news


if(!function_exists('khulna_gazettet_top_ten_news')):
    function khulna_gazettet_top_ten_news() {
		$options = get_option('cn_framework');
		$cat = ( is_array( $options ) && ! empty( $options['lead_news_category'] ) ) ? $options['lead_news_category'] : '';
		$number_of_post = ( is_array( $options ) && ! empty( $options['number_of_leading_news'] ) ) ? intval( $options['number_of_leading_news'] ) : 15;
        
        $args = array(
			'post_type'         => 'post',
            'posts_per_page'    => $number_of_post,
            'post_status'       => 'publish',
            'no_found_rows'     => true,
        );
		if ( ! empty( $cat ) ) {
			$args['cat'] = $cat;
		}
?>
        
<div class="kg-lead-news-section">

	<?php	
		$query_two = new WP_Query( $args );
            if( $query_two->have_posts() ){
    ?>

	<div class="row kg-lead-hero-row">
 
		<div class="col-md-4 kg-lead-left-col">
			<?php 
			$query_two->rewind_posts();
			$sl = 0; 
			while($query_two->have_posts()) {
				$query_two->the_post();	
				$sl = $sl+1;
				if($sl==2 || $sl==3){ 
					$post_id_one = get_the_ID();
					$post_img = wp_get_attachment_image_src(get_post_thumbnail_id( $post_id_one ),'khulna_gazette_post_thumb');  
					$lead_img_one = function_exists( 'kg_get_the_post_thumbnail_url' ) ? kg_get_the_post_thumbnail_url( $post_id_one, 'khulna_gazette_post_thumb' ) : ( !empty($post_img[0]) ? $post_img[0] : get_template_directory_uri().'/assets/img/kg-home-image.jpg' );
					$default_img = esc_url( get_template_directory_uri().'/assets/img/kg-home-image.jpg' );
					?> 
					<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="kg-lead-left-item">
						<div class="kg-lead-news-left">
							<img src="<?php echo esc_url($lead_img_one); ?>" onerror="this.onerror=null;this.src='<?php echo $default_img; ?>';" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" decoding="async">
							<p><?php echo esc_html( get_the_title() ); ?></p>
						</div>
					</a>
				<?php }
				if( $sl >= 3 ) {
					break;
				}
			} ?>

		</div>

		<div class="col-md-8 kg-lead-main-col">
			<?php 
			$query_two->rewind_posts();
			$sl = 0; 
			while($query_two->have_posts()) {
				$query_two->the_post();
				$sl = $sl+1;
				if($sl==1){ 
					$post_id_two = get_the_ID();
					$lead_img_hero = function_exists( 'kg_get_the_post_thumbnail_url' ) ? kg_get_the_post_thumbnail_url( $post_id_two, 'khulna_gazette_lead_thumb' ) : get_template_directory_uri().'/assets/img/kg-home-image.jpg';
					$default_img = esc_url( get_template_directory_uri().'/assets/img/kg-home-image.jpg' );
					?>

					<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="kg-lead-main-item">
						<div class="slide-thumb">
							<img src="<?php echo esc_url($lead_img_hero); ?>" onerror="this.onerror=null;this.src='<?php echo $default_img; ?>';" style="width:100%" loading="eager" fetchpriority="high" decoding="async">
							<div class="centered"><?php echo esc_html( get_the_title() ); ?></div>
						</div>
					</a>

					<?php 
					break;
				}
			} ?>
		</div> 

	</div>
	<section class=" empty-30"></section>

	<div class="row">
		<?php 
		$query_two->rewind_posts();
		$sl = 0; 
		while($query_two->have_posts()) {
			$query_two->the_post();
			$sl = $sl+1;
			if($sl>3) { 
				$post_id_one = get_the_ID();
				$lead_img_grid = function_exists( 'kg_get_the_post_thumbnail_url' ) ? kg_get_the_post_thumbnail_url( $post_id_one, 'khulna_gazette_post_thumb' ) : get_template_directory_uri().'/assets/img/kg-home-image.jpg';
				$default_img = esc_url( get_template_directory_uri().'/assets/img/kg-home-image.jpg' );
				?>

				<div class="col-md-4">
					<div class="slider-content-box">
						<a href="<?php echo esc_url( get_the_permalink() ); ?>">
							<img src="<?php echo esc_url($lead_img_grid); ?>" onerror="this.onerror=null;this.src='<?php echo $default_img; ?>';" loading="lazy" decoding="async">
							<h5><?php echo esc_html( get_the_title() ); ?></h5>
						</a>

					</div>

				</div>

			<?php }
		} ?>

	</div>
</div>

<?php
            wp_reset_postdata();
        }
    }
endif;

add_action('khulna_gazettet_top_ten_news_section', 'khulna_gazettet_top_ten_news', 5);

// End Top Ten Lead News Section


if(!function_exists('kg_photo_gallery')):
    function kg_photo_gallery(){ 
        $options = get_option('cn_framework');
        $archive_url = '';
        if ( is_array($options) && !empty($options['photo_gallery_url']) ) {
            $archive_url = $options['photo_gallery_url'];
        } else {
            $archive_url = get_theme_mod('kg_photo_gallery_archive_url');
        }
        if ( empty($archive_url) ) {
            $archive_url = get_post_type_archive_link('kgphotogallery');
        }
    ?>
        <div class="col-md-8">
            <div class="photo-gallary">
                <a href="<?php echo esc_url( $archive_url );?>"><h2>ফটো গ্যালারি</h2></a>
                <div class="slider">
                   <?php 
                        $kg_gallery = array(
                            'post_type'			=>'kgphotogallery',
                            'posts_per_page'	=> 10,
                            'order'				=>'DESC',
                            'post_status'       =>'publish',
                            'no_found_rows'     => true,
                        );

                        $kg_photo_query = new WP_Query($kg_gallery);
                        if( $kg_photo_query->have_posts() ){
                            $s = -1;
                            $sl =-1;
                        ?>
                        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">

                        <ol class="carousel-indicators">
                             <?php while($kg_photo_query->have_posts()):               
								$kg_photo_query->the_post();
                              	$sl = $sl+1;  
                                ?>
                              <li data-target="#carouselExampleCaptions" data-slide-to="<?php echo $sl; ?>"></li>
                              <?php endwhile; ?>

                        </ol>
                        <div class="carousel-inner">
                            <?php while($kg_photo_query->have_posts()):                $kg_photo_query->the_post();
                              $s = $s+1;
                            $post_id_three = get_the_ID();
                            $post_img_three = wp_get_attachment_image_src(get_post_thumbnail_id( $post_id_three ),'khulna_gazette_post_thumb'); 
                            $img_src = !empty($post_img_three[0]) ? $post_img_three[0] : get_template_directory_uri().'/assets/img/kg-home-image.jpg';
                                ?>
                          <div class="carousel-item <?php if($s==0){ echo "active"; }?>">
                            <img class="d-block w-100" src="<?php echo esc_url($img_src); ?>" alt="<?php the_title_attribute(); ?>" title="<?php the_title_attribute(); ?>" loading="lazy">
                          </div>
                          <?php endwhile; ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="sr-only">Next</span>
                        </a>
                      </div>
                <?php
                            wp_reset_postdata();
                    }
                ?>  

        </div>
    </div>
</div>
    <?php }
endif;
add_action('kg_photo_gallery_section', 'kg_photo_gallery', 5);


if(!function_exists('kg_video_gallery')):
    function kg_video_gallery() { 
        $options = get_option('cn_framework');
        $archive_url = '';
        if ( is_array($options) && !empty($options['video_gallery_url']) ) {
            $archive_url = $options['video_gallery_url'];
        } else {
            $archive_url = get_theme_mod('kg_video_gallery_archive_url');
        }
        if ( empty($archive_url) ) {
            $archive_url = get_post_type_archive_link('kgvideogallery');
        }
    ?>
    <div class="col-md-4">
       <?php 
        $kg_video_gallery = array(
            'post_type'      => 'kgvideogallery',
            'posts_per_page' => 2,
            'order'          => 'DESC',
            'post_status'    => 'publish',
            'no_found_rows'  => true,
        );

        $kg_video_query = new WP_Query($kg_video_gallery);

        if( $kg_video_query->have_posts() ){
            $sl = 0;
            echo '<div class="photo-gallary"><a href="' .esc_url( $archive_url ). '"><h2>ভিডিও গ্যালারি</h2></a></div>';
        ?>
        <div class="jation-rajneti-title">
            <?php while($kg_video_query->have_posts()):                
                $kg_video_query->the_post();
                $sl = $sl+1;
                $url = function_exists('get_field') ? get_field('video_url') : get_post_meta(get_the_ID(), 'video_url', true);
                $id = '';
                if ( ! empty( $url ) ) {
                    $id = preg_replace('/^.*(\?|\&)v\=/', '', $url);
                    $id = preg_replace('/[^\w\-\_].*$/', '', $id);
                }
            ?>

            <?php if($sl==1) { ?>

            <?php if ( ! empty( $id ) ): ?>
            <iframe width="100%" src="https://www.youtube.com/embed/<?php echo esc_attr( $id ); ?>" frameborder="0" allowfullscreen loading="lazy"></iframe> 
            <?php endif; ?>
            <h4 style="font-size:18px;"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h4>
            <?php }
                else{
            ?>

            <div class="tab-content-box">
                <?php if ( ! empty( $id ) ): ?>
                <iframe width="100%" src="https://www.youtube.com/embed/<?php echo esc_attr( $id ); ?>" frameborder="0" allowfullscreen loading="lazy"></iframe>
                <?php endif; ?>
                <h4 style="font-size:18px;"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h4>
            </div>

            <?php } ?>

            <?php endwhile;?>        
        </div>

        <?php 
            wp_reset_postdata();
        }
        ?>
    </div>
    
    <?php }

endif;

add_action('kg_video_gallery_section', 'kg_video_gallery', 5);

if( !function_exists( 'kg_post_author_meta' ) ):
    function kg_post_author_meta() { ?>
        <div class="row">
            <div class="col-md-12">
               <div class="kg-editor-meta-data">
                    <div class="author-photograph">
                        <?php echo get_avatar( get_the_author_meta( 'ID' )); ?>
                    </div>
                    <div class="author-name">
                        <?php the_author_meta('display_name'); ?>
                    </div>
                    
               </div>

            </div>
        </div>
    <?php }

endif;
        
add_action('kg_post_author_meta_section', 'kg_post_author_meta', 5);


// Start Mobile Top Ten News Section

if(!function_exists('khulna_gazettet_top_ten_news_mobile')):
    function khulna_gazettet_top_ten_news_mobile() {
		$options = get_option('cn_framework');
		$cat = ( is_array( $options ) && ! empty( $options['lead_news_category'] ) ) ? $options['lead_news_category'] : '';
		$number_of_post = ( is_array( $options ) && ! empty( $options['number_of_leading_news'] ) ) ? intval( $options['number_of_leading_news'] ) : 15;
        
        $args = array(
			'post_type'         => 'post',
            'posts_per_page'    => $number_of_post,
            'post_status'       => 'publish',
            'no_found_rows'     => true,
        );
		if ( ! empty( $cat ) ) {
			$args['cat'] = $cat;
		}
?>
        
<div class="kg-lead-news-section-mobile">

	<?php	
		$query_two = new WP_Query( $args );
            if( $query_two->have_posts() ){
    ?>

	<div class="row">
 
		<div class="col-md-8">
			<?php  $sl = 0; while($query_two->have_posts()) {
			$query_two->the_post();
			$sl = $sl+1;
						
			$post_id_two = get_the_ID();
            $post_img_two = wp_get_attachment_image_src(get_post_thumbnail_id( $post_id_two ),'khulna_gazette_post_thumb');
			if($sl==1){ 
                $mob_lead_img = function_exists( 'kg_get_the_post_thumbnail_url' ) ? kg_get_the_post_thumbnail_url( $post_id_two, 'khulna_gazette_post_thumb' ) : get_template_directory_uri().'/assets/img/kg-home-image.jpg';
                $default_img = esc_url( get_template_directory_uri().'/assets/img/kg-home-image.jpg' );
            ?>

			<a href="<?php echo esc_url( get_the_permalink() ); ?>">
				<div class="slide-thumb">
					<img src="<?php echo esc_url($mob_lead_img); ?>" onerror="this.onerror=null;this.src='<?php echo $default_img; ?>';" style="width:100%" loading="eager" fetchpriority="high" decoding="async">
					<div class="centered"><?php echo get_the_title(); ?></div>
				</div>
			</a>

			<?php }} ?>
		</div> 

	</div>
	<section class="empty-30"></section>

	<div class="row">
		<?php 
		$query_two->rewind_posts();
		$sl = 0; 
		while($query_two->have_posts()) {
				$query_two->the_post();
				$sl = $sl+1;
				$post_id_one = get_the_ID();
				$mob_grid_img = function_exists( 'kg_get_the_post_thumbnail_url' ) ? kg_get_the_post_thumbnail_url( $post_id_one, 'khulna_gazette_post_thumb' ) : get_template_directory_uri().'/assets/img/kg-home-image.jpg';
				$default_img = esc_url( get_template_directory_uri().'/assets/img/kg-home-image.jpg' );
		
		if($sl>1) { ?>

		<div class="col-md-4">
			<div class="slider-content-box">
				<a href="<?php echo esc_url( get_the_permalink() ); ?>">
					<img src="<?php echo esc_url($mob_grid_img); ?>" onerror="this.onerror=null;this.src='<?php echo $default_img; ?>';" loading="lazy" decoding="async">
					<h5><?php echo get_the_title(); ?></h5>
				</a>

			</div>

		</div>

		<?php }}?>

	</div>
</div>

<?php
            wp_reset_postdata();
        }
    }
endif;

add_action('khulna_gazettet_top_ten_news_section_mobile', 'khulna_gazettet_top_ten_news_mobile', 5);

// End Top Ten Lead News Section
