<?php
if ( ! defined( 'ABSPATH' ) ) { exit; };

if ( ! function_exists( 'khulnagazette_setup' ) ) :

	function khulnagazette_setup() {
		
		load_theme_textdomain( 'khulnagazette', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'title-tag' );

		add_theme_support( 'post-thumbnails' );
		add_image_size( 'khulna_gazette_post_thumb', 358, 201, true );
		add_image_size( 'khulna_gazette_lead_thumb', 750, 420, true );
		add_image_size( 'khulna_gazette_single_thumb', 1200, 650, true );

		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'khulnagazette' ), 
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);
        


		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
        
        add_theme_support( 'post-formats', array( 'aside', 'chat', 'gallery', 'image', 'video' ) );

        
	}
endif;
add_action( 'after_setup_theme', 'khulnagazette_setup' );

// Fallback for ACF get_field function to avoid fatal errors if ACF is not active
if ( ! function_exists( 'get_field' ) ) {
    function get_field( $selector, $post_id = false, $format_value = true ) {
        if ( ! $post_id ) {
            $post_id = get_the_ID();
        }
        return get_post_meta( $post_id, $selector, true );
    }
}

// Set Post Views (Optimized: skips bots, prevents repeat write locks per visitor)
function setPostViews($postID) {
    if ( is_admin() || empty($postID) ) {
        return;
    }
    // Skip search engine bots and automated scrapers
    if ( ! empty( $_SERVER['HTTP_USER_AGENT'] ) && preg_match( '/(bot|crawler|spider|slurp|facebookexternalhit|whatsapp|preview)/i', $_SERVER['HTTP_USER_AGENT'] ) ) {
        return;
    }
    // Throttle repeat counts from same visitor within 2 hours to prevent database write locks
    if ( isset( $_COOKIE['kg_view_' . $postID] ) ) {
        return;
    }
    if ( ! headers_sent() ) {
        @setcookie( 'kg_view_' . $postID, '1', time() + 7200, COOKIEPATH ? COOKIEPATH : '/', COOKIE_DOMAIN, false, true );
    }
    $countKey = 'post_views_count';
    $count = get_post_meta($postID, $countKey, true);
    if ( $count === '' || $count === false ) {
        $count = 1;
    } else {
        $count = (int) $count + 1;
    }
    update_post_meta($postID, $countKey, $count);
}


/**
* Require theme files
*/
include_once get_template_directory() . '/inc/theme-widgets.php';

/**
* Require theme widgets
*/
include_once get_template_directory() . '/inc/theme-files.php';

/**
* Require theme widgets
*/
include_once get_template_directory() . '/inc/template-functions.php';

/**
* Require theme widgets
*/
include_once get_template_directory() . '/inc/theme-cpts.php';

/**
* Require theme widgets
*/
include_once get_template_directory() . '/inc/theme-hooks-functions.php';

/**
 * Codestar Framework.
 */
require_once get_template_directory() .'/framework/codestar-framework.php';

/**
 * Codestar Framework.
 */
require_once get_template_directory() .'/inc/theme-options.php';

/**
 * All Output and Methods of CS Framework.
 */
require_once get_template_directory() .'/inc/cn-theme-options.php';

/**
* Require theme widgets
*/
include_once get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Added widget function for scholarship
 */
require get_template_directory() . '/inc/widgets/scholarship-widget-functions.php';




/**
 * WordPress Image Optimizer (Optimized & Safe)
 *
 * Automatically resizes very large uploads cleanly without CPU timeout
 */
add_filter( 'wp_handle_upload', 'kg_optimize_uploaded_image' );

function kg_optimize_uploaded_image( $upload ) {
    if ( ! isset( $upload['file'] ) || ! file_exists( $upload['file'] ) ) {
        return $upload;
    }

    // Never touch or crop images uploaded for E-Paper posts (newspaper pages need full resolution/height)
    $post_id = isset( $_REQUEST['post_id'] ) ? (int) $_REQUEST['post_id'] : 0;
    if ( $post_id && get_post_type( $post_id ) === 'epaper' ) {
        return $upload;
    }
    if ( isset( $_REQUEST['post_type'] ) && $_REQUEST['post_type'] === 'epaper' ) {
        return $upload;
    }
    if ( ! empty( $_SERVER['HTTP_REFERER'] ) && stripos( $_SERVER['HTTP_REFERER'], 'epaper' ) !== false ) {
        return $upload;
    }

    $file = $upload['file'];
    $image_info = @getimagesize( $file );

    if ( ! $image_info ) {
        return $upload;
    }

    $mime = isset( $image_info['mime'] ) ? $image_info['mime'] : '';
    $allowed_mimes = array( 'image/jpeg', 'image/png', 'image/webp' );

    if ( ! in_array( $mime, $allowed_mimes, true ) ) {
        return $upload;
    }

    $width  = $image_info[0];
    $height = $image_info[1];

    // Constrain extraordinarily large camera uploads proportionally without hard-cropping
    if ( $width > 1920 || $height > 1200 ) {
        if ( function_exists( 'wp_get_image_editor' ) ) {
            $editor = wp_get_image_editor( $file );
            if ( ! is_wp_error( $editor ) ) {
                $editor->resize( 1920, 1200, false );
                $editor->set_quality( 85 );
                $editor->save( $file );
            }
        }
    }

    return $upload;
}

/**
 * Database & Backend Optimization (100% backend-only: zero design/font/image changes)
 * 1. Resolves "Commands out of sync; you can't run this command now" in MySQL/MariaDB
 * 2. Cleans expired transients automatically to prevent kg_options bloat
 */

// Flush any pending/unbuffered MySQLi result sets before WordPress shutdown hooks run
add_action( 'shutdown', 'kg_fix_commands_out_of_sync', -9999 );
function kg_fix_commands_out_of_sync() {
    global $wpdb;
    if ( isset( $wpdb->dbh ) && $wpdb->dbh instanceof mysqli ) {
        while ( mysqli_more_results( $wpdb->dbh ) ) {
            if ( mysqli_next_result( $wpdb->dbh ) ) {
                $extra_res = mysqli_use_result( $wpdb->dbh );
                if ( $extra_res instanceof mysqli_result ) {
                    mysqli_free_result( $extra_res );
                }
            } else {
                break;
            }
        }
    }
}

// Scheduled maintenance to clear expired transients from kg_options
if ( ! wp_next_scheduled( 'kg_clean_expired_transients_cron' ) ) {
    wp_schedule_event( time(), 'twicedaily', 'kg_clean_expired_transients_cron' );
}
add_action( 'kg_clean_expired_transients_cron', 'kg_purge_expired_transients' );
function kg_purge_expired_transients() {
    global $wpdb;
    $time = time();
    $wpdb->query( $wpdb->prepare(
        "DELETE a, b FROM {$wpdb->options} a
         JOIN {$wpdb->options} b ON b.option_name = CONCAT('_transient_timeout_', SUBSTRING(a.option_name, 12))
         WHERE a.option_name LIKE '_transient_%'
         AND b.option_value < %d",
        $time
    ) );
}

/**
 * Super Fast News Performance Engine
 * 1. Speculation Rules API: Native Chromium instant prerender/prefetch on click/hover
 * 2. Resource Hints: DNS prefetch and preconnect
 * 3. Removes blocking WP emoji & head bloat
 * 4. Browser caching headers for instant repeat/back visits
 * 5. Script deferral for instant initial news render
 */

// Native Speculation Rules API for instant article opening on click
add_action( 'wp_head', 'kg_speculation_rules_instant_click', 2 );
function kg_speculation_rules_instant_click() {
    if ( is_admin() ) {
        return;
    }
    ?>
    <script type="speculationrules">
    {
      "prefetch": [
        {
          "source": "document",
          "where": {
            "and": [
              { "href_matches": "/*" },
              { "not": { "href_matches": "/wp-admin/*" } },
              { "not": { "href_matches": "/*wp-login*" } },
              { "not": { "href_matches": "/*preview=true*" } },
              { "not": { "href_matches": "/*.jpg" } },
              { "not": { "href_matches": "/*.png" } },
              { "not": { "href_matches": "/*.pdf" } }
            ]
          },
          "eagerness": "moderate"
        }
      ]
    }
    </script>
    <?php
}

// Preconnect and DNS prefetch
add_action( 'wp_head', 'kg_speed_resource_hints', 1 );
function kg_speed_resource_hints() {
    echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">' . "\n";
    echo '<link rel="dns-prefetch" href="//fonts.gstatic.com">' . "\n";
    echo '<link rel="preconnect" href="' . esc_url( home_url() ) . '">' . "\n";
}

// Disable WordPress emoji scripts and styles to eliminate render-blocking assets
add_action( 'init', 'kg_disable_emojis' );
function kg_disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}

// Remove unnecessary header bloat
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

// Send browser caching headers for non-logged-in visitors
add_action( 'send_headers', 'kg_send_browser_cache_headers' );
function kg_send_browser_cache_headers() {
    if ( ! is_user_logged_in() && ! is_admin() && ! headers_sent() ) {
        header( 'Cache-Control: public, max-age=300, stale-while-revalidate=600' );
    }
}

// Defer non-critical scripts so page renders immediately
add_filter( 'script_loader_tag', 'kg_defer_scripts', 10, 2 );
function kg_defer_scripts( $tag, $handle ) {
    if ( is_admin() ) {
        return $tag;
    }
    if ( in_array( $handle, array( 'khulnagazette-main-js', 'bootstrap-min-js' ), true ) ) {
        if ( strpos( $tag, 'defer' ) === false ) {
            $tag = str_replace( ' src', ' defer src', $tag );
        }
    }
    return $tag;
}

// Remove unused core Gutenberg Block Library CSS on frontend unless the post explicitly uses blocks
add_action( 'wp_enqueue_scripts', 'kg_remove_block_css', 100 );
function kg_remove_block_css() {
    if ( ! is_admin() ) {
        if ( is_singular() && function_exists( 'has_blocks' ) ) {
            global $post;
            if ( $post && has_blocks( $post ) ) {
                return;
            }
        }
        wp_dequeue_style( 'wp-block-library' );
        wp_dequeue_style( 'wp-block-library-theme' );
        wp_dequeue_style( 'wc-blocks-style' );
        wp_dequeue_style( 'classic-theme-styles' );
        wp_dequeue_style( 'global-styles' );
    }
}

/**
 * Security & External Code Injection Protection
 * 1. Blocks external malicious payloads (XSS, SQLi, RCE, Path Traversal) before execution
 * 2. Hardens HTTP security headers (X-Frame-Options, X-XSS-Protection, Nosniff)
 * 3. Disables XML-RPC & pingbacks to stop automated brute force & CPU drain
 * 4. Disallows file editing from dashboard
 * 5. Disables frontend heartbeat to stop server AJAX spam
 */

// Block malicious external code injection from URLs and queries
add_action( 'init', 'kg_firewall_block_external_code_injection', 1 );
function kg_firewall_block_external_code_injection() {
    if ( is_admin() ) {
        return;
    }
    $req_uri   = isset( $_SERVER['REQUEST_URI'] ) ? rawurldecode( $_SERVER['REQUEST_URI'] ) : '';
    $query_str = isset( $_SERVER['QUERY_STRING'] ) ? rawurldecode( $_SERVER['QUERY_STRING'] ) : '';
    $payload   = strtolower( $req_uri . ' ' . $query_str );

    $dangerous_patterns = array(
        '<script', '</script>', 'javascript:', 'vbscript:',
        'eval(', 'base64_decode', 'gzinflate', 'shell_exec',
        'union select', 'union+select', 'select 1 from',
        '../', '..\\', '/etc/passwd', 'wp-config.php',
        'concat(', 'group_concat', 'order by 9999'
    );

    foreach ( $dangerous_patterns as $pattern ) {
        if ( strpos( $payload, $pattern ) !== false ) {
            status_header( 403 );
            wp_die( 'Access Denied: Malicious external code injection attempt blocked.', 'Security Alert', array( 'response' => 403 ) );
        }
    }
}

// HTTP Security Headers to prevent browser script injection & clickjacking
add_action( 'send_headers', 'kg_security_headers' );
function kg_security_headers() {
    if ( ! headers_sent() ) {
        header( 'X-Content-Type-Options: nosniff' );
        header( 'X-Frame-Options: SAMEORIGIN' );
        header( 'X-XSS-Protection: 1; mode=block' );
        header( 'Referrer-Policy: strict-origin-when-cross-origin' );
    }
}

// Disable XML-RPC to eliminate DDoS and brute force attacks that slow down the server
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'wp_headers', 'kg_remove_pingback_header' );
function kg_remove_pingback_header( $headers ) {
    unset( $headers['X-Pingback'] );
    return $headers;
}

// Disable Dashicons stylesheet on frontend for visitors
add_action( 'wp_enqueue_scripts', 'kg_dequeue_dashicons_frontend' );
function kg_dequeue_dashicons_frontend() {
    if ( ! is_user_logged_in() ) {
        wp_deregister_style( 'dashicons' );
    }
}

// Disable Heartbeat on frontend to save server CPU cycles
add_action( 'init', 'kg_stop_heartbeat_frontend', 1 );
function kg_stop_heartbeat_frontend() {
    if ( ! is_admin() ) {
        wp_deregister_script( 'heartbeat' );
    }
}

// Disallow file editing in WP dashboard to prevent external malicious file tampering
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
    define( 'DISALLOW_FILE_EDIT', true );
}