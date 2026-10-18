<?php
function khulnagazette_add_attributes_to_post() {
    add_post_type_support('post', 'page-attributes');
}
add_action('init', 'khulnagazette_add_attributes_to_post');

function khulnagazette_excrpt( $length ){
    return 30;
}
add_filter('excerpt_length', 'khulnagazette_excrpt', 999 );

// Get post thumbnail helper with fallback & static memory cache
if ( ! function_exists( 'kg_get_the_post_thumbnail_url' ) ) {
    function kg_get_the_post_thumbnail_url( $post_id = null, $imageSize = 'khulna_gazette_post_thumb' ) {
        static $kg_thumb_cache = array();
        
        if ( empty( $post_id ) ) {
            $post_id = get_the_ID();
        }
        if ( empty( $post_id ) ) {
            return get_template_directory_uri() . '/assets/img/kg-home-image.jpg';
        }

        $cache_key = (int) $post_id . '_' . (string) $imageSize;
        if ( isset( $kg_thumb_cache[$cache_key] ) ) {
            return $kg_thumb_cache[$cache_key];
        }

        $default_image = get_template_directory_uri() . '/assets/img/kg-home-image.jpg';

        $post_type = get_post_type( $post_id );
        if ( empty( $post_type ) && ( is_post_type_archive( 'epaper' ) || ( function_exists( 'get_query_var' ) && get_query_var( 'post_type' ) === 'epaper' ) ) ) {
            $post_type = 'epaper';
        }
        // For E-paper posts, never hard-crop the newspaper scan; always fetch full size
        if ( $post_type === 'epaper' && ( empty( $imageSize ) || $imageSize === 'khulna_gazette_post_thumb' || $imageSize === 'post-thumbnail' ) ) {
            $imageSize = 'full';
        }

        // 1. Featured Image
        if ( has_post_thumbnail( $post_id ) ) {
            $thumb_id = get_post_thumbnail_id( $post_id );
            if ( $thumb_id ) {
                $img = wp_get_attachment_image_src( $thumb_id, $imageSize );
                if ( ! empty( $img[0] ) ) {
                    $kg_thumb_cache[$cache_key] = $img[0];
                    return $img[0];
                }
                $full = wp_get_attachment_image_src( $thumb_id, 'full' );
                if ( ! empty( $full[0] ) ) {
                    $kg_thumb_cache[$cache_key] = $full[0];
                    return $full[0];
                }
            }
        }

        // 1b. Direct _thumbnail_id meta check
        $meta_thumb_id = get_post_meta( $post_id, '_thumbnail_id', true );
        if ( ! empty( $meta_thumb_id ) && is_numeric( $meta_thumb_id ) ) {
            $img = wp_get_attachment_image_src( (int)$meta_thumb_id, $imageSize );
            if ( ! empty( $img[0] ) ) {
                $kg_thumb_cache[$cache_key] = $img[0];
                return $img[0];
            }
            $full = wp_get_attachment_image_src( (int)$meta_thumb_id, 'full' );
            if ( ! empty( $full[0] ) ) {
                $kg_thumb_cache[$cache_key] = $full[0];
                return $full[0];
            }
        }

        // 2. Only for E-Paper posts do deep media/attachment scans (to avoid heavy N+1 queries on normal news)
        if ( $post_type === 'epaper' ) {
            $attachments = get_posts( array(
                'post_parent'    => $post_id,
                'post_type'      => 'attachment',
                'post_mime_type' => 'image',
                'post_status'    => array( 'inherit', 'publish', 'any' ),
                'posts_per_page' => 5,
                'order'          => 'DESC',
                'no_found_rows'  => true,
            ) );
            if ( ! empty( $attachments ) ) {
                foreach ( $attachments as $att_item ) {
                    if ( ! empty( $att_item->ID ) ) {
                        $full = wp_get_attachment_image_src( $att_item->ID, 'full' );
                        if ( ! empty( $full[0] ) ) {
                            $kg_thumb_cache[$cache_key] = $full[0];
                            return $full[0];
                        }
                    }
                }
            }

            if ( function_exists( 'get_attached_media' ) ) {
                $attached_images = get_attached_media( 'image', $post_id );
                if ( ! empty( $attached_images ) ) {
                    foreach ( $attached_images as $first_image ) {
                        if ( ! empty( $first_image->ID ) ) {
                            $full = wp_get_attachment_image_src( $first_image->ID, 'full' );
                            if ( ! empty( $full[0] ) ) {
                                $kg_thumb_cache[$cache_key] = $full[0];
                                return $full[0];
                            }
                        }
                    }
                }
            }

            $all_meta = get_post_custom( $post_id );
            if ( is_array( $all_meta ) ) {
                foreach ( $all_meta as $m_key => $m_vals ) {
                    if ( strpos( $m_key, '_' ) === 0 && $m_key !== '_thumbnail_id' ) {
                        continue;
                    }
                    foreach ( (array) $m_vals as $raw_val ) {
                        $val = maybe_unserialize( $raw_val );
                        if ( is_array( $val ) && ! empty( $val['url'] ) ) {
                            $kg_thumb_cache[$cache_key] = $val['url'];
                            return $val['url'];
                        }
                        if ( is_numeric( $val ) && (int)$val > 0 ) {
                            $att_src = wp_get_attachment_image_src( (int)$val, 'full' );
                            if ( ! empty( $att_src[0] ) ) {
                                $kg_thumb_cache[$cache_key] = $att_src[0];
                                return $att_src[0];
                            }
                        } elseif ( is_string( $val ) && preg_match( '/\.(jpe?g|png|webp|gif)($|\?)/i', $val ) ) {
                            $kg_thumb_cache[$cache_key] = $val;
                            return $val;
                        }
                    }
                }
            }
        }

        // 3. Custom fields & ACF image support
        $custom_keys = array( 'custom_image', 'image', 'upload_image' );
        foreach ( $custom_keys as $key ) {
            $meta_val = get_post_meta( $post_id, $key, true );
            if ( ! empty( $meta_val ) ) {
                if ( is_numeric( $meta_val ) ) {
                    $src_full = wp_get_attachment_image_src( (int)$meta_val, $imageSize );
                    if ( ! empty( $src_full[0] ) ) {
                        $kg_thumb_cache[$cache_key] = $src_full[0];
                        return $src_full[0];
                    }
                } elseif ( is_string( $meta_val ) && filter_var( $meta_val, FILTER_VALIDATE_URL ) ) {
                    $kg_thumb_cache[$cache_key] = $meta_val;
                    return $meta_val;
                }
            }
        }

        $kg_thumb_cache[$cache_key] = $default_image;
        return $default_image;
    }
}

// Ensure E-Paper archive displays pages in natural order (Page 1, Page 2, etc.) and shows all pages
add_action( 'pre_get_posts', 'khulnagazette_epaper_archive_query' );
function khulnagazette_epaper_archive_query( $query ) {
    if ( ! is_admin() && $query->is_main_query() ) {
        if ( is_post_type_archive( 'epaper' ) || $query->get( 'post_type' ) === 'epaper' ) {
            $query->set( 'orderby', array( 'menu_order' => 'ASC', 'date' => 'ASC' ) );
            $query->set( 'posts_per_page', -1 );
        }
    }
}

// Get post thumbnail
if( !function_exists( 'kg_post_thumbnail' ) ){ 
    function kg_post_thumbnail( $imageSize = 'post-thumbnail' ){ 
        $post_id = get_the_ID();
        $default_image = get_template_directory_uri().'/assets/img/kg-home-image.jpg';
        $imgUrl = kg_get_the_post_thumbnail_url( $post_id, $imageSize );
        echo '<img src="'.esc_url($imgUrl).'" width="1200" height="650" alt="'.esc_attr(get_the_title()).'" loading="lazy" decoding="async" onerror="this.onerror=null;this.src=\''.esc_url($default_image).'\';">';
    } 
}
//End post thumbnail method

// Global fallback filter: if any post has no thumbnail anywhere on site, return default image
add_filter( 'post_thumbnail_html', 'kg_default_post_thumbnail_html', 10, 5 );
function kg_default_post_thumbnail_html( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
    $default_image = esc_url( get_template_directory_uri() . '/assets/img/kg-home-image.jpg' );

    if ( empty( trim( $html ) ) ) {
        $fallback_url = kg_get_the_post_thumbnail_url( $post_id, $size );
        $title = esc_attr( get_the_title( $post_id ) );
        return '<img src="' . esc_url( $fallback_url ) . '" alt="' . $title . '" loading="lazy" decoding="async" onerror="this.onerror=null;this.src=\'' . $default_image . '\';">';
    }

    if ( strpos( $html, 'onerror=' ) === false ) {
        $html = str_replace( '<img ', '<img onerror="this.onerror=null;this.src=\'' . $default_image . '\';" decoding="async" ', $html );
    }

    return $html;
}

// Clean private title prefix (e.g. removes 'Private: ' from 'Private: পঞ্চম পাতা')
add_filter( 'private_title_format', function( $format ) {
    return '%s';
} );
add_filter( 'protected_title_format', function( $format ) {
    return '%s';
} );

if(!function_exists('kg_post_meta')){
    function kg_post_meta(){ ?>
       
        <div class="entry-meta">
            <span class="byline"> 
                 <i class="fa fa-user"></i> 
                 <span><?php the_author_meta('display_name');?></span>
             </span>
             <span class="byline"> 
                 <i class="fa fa-calendar"></i> 
                 <span><?php the_date();?></span>
            </span>
            <span class="byline"> 
                 <i class="fa fa-clock-o"></i> 
                 <span><?php the_time();?></span>
            </span> 
            
        </div>
        
 <?php }
}
//End post meta

add_filter( 'get_the_archive_title', function ( $title ) {
    if ( is_post_type_archive( 'epaper' ) || ( is_archive() && get_query_var( 'post_type' ) === 'epaper' ) ) {
        return 'ই-পেপার';
    }

    if( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif( is_author() ) {
        $title = get_the_author();
    } elseif( is_post_type_archive( 'kgphotogallery' ) ) {
        $title = 'ফটো গ্যালারি';
    } elseif( is_post_type_archive( 'kgvideogallery' ) ) {
        $title = 'ভিডিও গ্যালারি';
    } elseif( is_post_type_archive( 'toptennews' ) ) {
        $title = 'টপ টেন নিউজ';
    } elseif( is_post_type_archive() ) {
        $pt = post_type_archive_title( '', false );
        if ( strtolower( $pt ) === 'epaper' || strtolower( (string) get_query_var( 'post_type' ) ) === 'epaper' ) {
            return 'ই-পেপার';
        }
        $title = $pt;
    } elseif( is_tax() ) {
        $title = single_term_title( '', false );
    }

    if ( stripos( $title, 'epaper' ) !== false ) {
        return 'ই-পেপার';
    }

    if ( strpos( $title, ': ' ) !== false ) {
        $parts = explode( ': ', $title, 2 );
        if ( ! empty( $parts[1] ) ) {
            $cleaned = trim( $parts[1] );
            if ( strtolower( $cleaned ) === 'epaper' ) {
                return 'ই-পেপার';
            }
            return $cleaned;
        }
    }

    return $title;
}, 99 );


//Count post views

function set_views($postID) {
    $count_key = 'kg_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
 
// Remove issues with prefetching adding extra views
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);


//KG Filters
add_filter('login_errors', 'kg_login_errors');
function kg_login_errors( $error ){
    $error = 'Invalid Login Details';
    return $error;
}

function get_breadcrumb() {
    echo '<a href="'.home_url().'" rel="nofollow"><i class="fa fa-home"></i></a>';
    if (is_category() || is_singular('post')) {
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
        the_category(' ,&nbsp;');
    } elseif (is_page()) {
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
        echo the_title();
    } elseif (is_search()) {
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;Search Results for... ";
        echo '"<em>';
        echo the_search_query();
        echo '</em>"';
    }
    elseif(is_singular('toptennews')){
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
        echo "টপ টেন নিউজ";
    }
    elseif(is_singular('kgphotogallery')){
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
        echo "ফটো গ্যালারি";
    }
    elseif(is_singular('kgvideogallery')){
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
        echo "ভিডিও গ্যালারি";
    }
    elseif(is_singular('epaper')){
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
        $epaper_url = get_post_type_archive_link('epaper');
        if($epaper_url){
            echo '<a href="'.esc_url($epaper_url).'">ই-পেপার</a>';
        } else {
            echo "ই-পেপার";
        }
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
        echo esc_html( get_the_title() );
    }

    
}

//Adding the Open Graph in the Language Attributes
function kg_doctype_opengraph($output) {
    return $output . '
    xmlns:og="http://opengraphprotocol.org/schema/"
    xmlns:fb="http://www.facebook.com/2008/fbml"';
}
add_filter('language_attributes', 'kg_doctype_opengraph');
 
//Lets add Open Graph Meta Info

function kg_insert_fb_in_head() {
global $post;

if ( !is_singular()):
    return;
endif;      
?>
<meta property="og:title" content="<?php echo esc_attr( get_the_title() ); ?>">
<meta property="og:type" content="article"/>
<meta property="og:description" content="<?php echo get_the_excerpt(); ?>">
<meta property="og:url" content="<?php echo esc_url( get_the_permalink() ); ?>">
<meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>">
<?php
if(has_post_thumbnail( $post->ID )):
    $src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
?>
<meta property="og:image" content="<?php echo $src[0]; ?>">
<?php
	else:
    $default_image = get_template_directory_uri().'/assets/img/kg-home-image.jpg';
?>
<meta property="og:image" content="<?php echo $default_image; ?>">
<?php
    endif;
}

add_action( 'wp_head', 'kg_insert_fb_in_head', 5 );
if(!function_exists('kg_post_tags')):
	function kg_post_tags(){ 
		$tags = get_the_tags();
		if( $tags ):

			foreach( $tags as $tag ): ?>
				<li><a href="<?php echo esc_url( get_tag_link( $tag->term_id ) );?>"><?php echo esc_html($tag->name); ?></a></li>
		<?php endforeach; ?>
		<?php endif; ?>	
	<?php }
endif;

/*
* Header Special Events News
*/
if(!function_exists( 'kg_special_news_section' )):
	function kg_special_news_section(){ ?>
	   <section class="khulna-gazette-special-section">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="khulna-gazette-special-section-inner">
							<?php dynamic_sidebar( 'special_news' ); ?>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php }
endif;

add_action('kg_special_news_section_widgets', 'kg_special_news_section');


//Skip category for latest news
if(!function_exists('kg_skip_latest_news_category')){
	function kg_skip_latest_news_category(){

		$options = get_option( 'cn_framework' );
		if ( ! is_array( $options ) || empty( $options['skip_category_for_latest_news'] ) ) {
			return '';
		}

		$cat = $options['skip_category_for_latest_news'];
		if ( is_array( $cat ) ) {
			$clean_cats = array_filter( array_map( 'intval', $cat ) );
			return implode( ',', $clean_cats );
		}
		return is_numeric( $cat ) ? (string) intval( $cat ) : '';
	}
}




