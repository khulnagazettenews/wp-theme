<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div style="width:100%; height:auto;border-color:#ECEFFF; padding:5px; margin-bottom:10px;">
            <?php if( is_active_sidebar( 'kg_news_page_top_image' ) ){
                dynamic_sidebar( 'kg_news_page_top_image' );    
            } ?>
            </div>
           <?php if( have_posts() ) { ?>
            <div class="kg-single-article">
                <?php while( have_posts() ) {
                    the_post();
                    setPostViews(get_the_ID());
                ?>
                <div class="breadcrumb"><?php get_breadcrumb(); ?></div>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php the_title('<h2>', '</h2>'); ?>
                    </header>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <?php kg_post_meta(); ?>
                        </div>
                        <div class="col-md-4">
                            <h2 class="social-share"><?php echo do_shortcode('[Sassy_Social_Share]'); ?>
                            <div class="kg-print"><?php echo do_shortcode('[print-me]'); ?></div></h2>
                        </div>
                    </div>

                    <?php
                        $thumb_id = get_post_thumbnail_id( get_the_ID() );
                        $epaper_full_img = '';
                        if ( $thumb_id ) {
                            if ( function_exists( 'wp_get_original_image_url' ) ) {
                                $epaper_full_img = wp_get_original_image_url( $thumb_id );
                            }
                            if ( empty( $epaper_full_img ) ) {
                                $epaper_full_img = wp_get_attachment_image_url( $thumb_id, 'full' );
                            }
                        }
                        if ( empty( $epaper_full_img ) ) {
                            $epaper_full_img = function_exists( 'kg_get_the_post_thumbnail_url' ) 
                                ? kg_get_the_post_thumbnail_url( get_the_ID(), 'full' ) 
                                : ( has_post_thumbnail() ? wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' ) : get_template_directory_uri() . '/assets/img/kg-home-image.jpg' );
                        }
                        $default_img = esc_url( get_template_directory_uri() . '/assets/img/kg-home-image.jpg' );
                    ?>

                    <figure class="kg-single-news-figure kg-epaper-figure kg-epaper-single-figure">
                        <a href="<?php echo esc_url( $epaper_full_img ); ?>" id="kg-epaper-main-link" title="<?php esc_attr_e( 'ফুল স্ক্রিনে জুম করে পড়তে ক্লিক করুন', 'khulnagazette' ); ?>">
                            <img src="<?php echo esc_url( $epaper_full_img ); ?>" onerror="this.onerror=null;this.src='<?php echo $default_img; ?>';" loading="eager" fetchpriority="high" decoding="async" alt="<?php the_title_attribute(); ?>" class="kg-epaper-img kg-epaper-single-img" style="width:100% !important; max-width:100% !important; height:auto !important; max-height:none !important; aspect-ratio:auto !important; object-fit:contain !important; display:block !important;">
                        </a>
                    </figure>

                    <div class="kg-epaper-navigation">
                        <div class="kg-epaper-nav-prev">
                            <?php previous_post_link( '%link', '<i class="fa fa-chevron-left"></i> %title' ); ?>
                        </div>
                        <div class="kg-epaper-nav-all">
                            <a href="<?php echo esc_url( get_post_type_archive_link( 'epaper' ) ?: home_url( '/epaper/' ) ); ?>">
                                <i class="fa fa-th-large"></i> সকল পাতা
                            </a>
                        </div>
                        <div class="kg-epaper-nav-next">
                            <?php next_post_link( '%link', '%title <i class="fa fa-chevron-right"></i>' ); ?>
                        </div>
                    </div>

                    <div class="entry-content">
                        <?php the_content(); ?>
                        <?php if(function_exists( 'the_views' )){ ?>
                            <div class="kg-posts-views">
                                 <p><?php the_views(); ?></p>
                            </div>
                        <?php } ?>
                    </div>

                    <?php
                    $other_epapers = new WP_Query( array(
                        'post_type'      => 'epaper',
                        'posts_per_page' => 6,
                        'post__not_in'   => array( get_the_ID() ),
                        'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
                        'post_status'    => array( 'publish', 'private' ),
                    ) );

                    if ( $other_epapers->have_posts() ) :
                    ?>
                    <div class="kg-epaper-other-pages-section">
                        <h3 class="kg-epaper-other-pages-title">
                            <i class="fa fa-newspaper-o"></i> ই-পেপার - অন্যান্য পাতা
                        </h3>
                        <div class="row">
                            <?php
                            while ( $other_epapers->have_posts() ) :
                                $other_epapers->the_post();
                                get_template_part( 'template-parts/content', 'epaper' );
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </article>
                <div style="clear:both"></div>
                 <?php } ?>
            </div>
            <?php }
                else{
                    get_template_part('template-parts/content', 'none');
                }
            ?>
        </div>
        
        <div class="col-md-3">
           <?php do_action( 'kg_tab_section' ); ?>
           
           <div class="empty-20"></div>
            <?php
                if(is_active_sidebar( 'kg_news_page_sidebar' )){
                    dynamic_sidebar( 'kg_news_page_sidebar' );
                }
             ?>
        </div>
        
        <section class="empty-30"></section>
    </div>
</div>

<!-- Full Window E-Paper Interactive Zoom & Pan Viewer Modal -->
<div id="kg-epaper-modal" class="kg-ep-modal" aria-hidden="true">
    <div class="kg-ep-topbar">
        <div class="kg-ep-title-wrap">
            <i class="fa fa-newspaper-o"></i>
            <span class="kg-ep-title"><?php the_title(); ?> - খুলনা গেজেট ই-পেপার</span>
        </div>
        <div class="kg-ep-controls">
            <button type="button" class="kg-ep-ctrl-btn" id="kg-ep-zoom-out" title="<?php esc_attr_e( 'জুম আউট [-]', 'khulnagazette' ); ?>">
                <i class="fa fa-search-minus"></i>
            </button>
            <span class="kg-ep-zoom-badge" id="kg-ep-zoom-val" title="<?php esc_attr_e( 'বর্তমান জুম', 'khulnagazette' ); ?>">100%</span>
            <button type="button" class="kg-ep-ctrl-btn" id="kg-ep-zoom-in" title="<?php esc_attr_e( 'জুম ইন [+]', 'khulnagazette' ); ?>">
                <i class="fa fa-search-plus"></i>
            </button>
            <button type="button" class="kg-ep-ctrl-btn" id="kg-ep-zoom-fit" title="<?php esc_attr_e( 'স্ক্রিনের সাথে ফিট করুন [0]', 'khulnagazette' ); ?>">
                <i class="fa fa-arrows-alt"></i> ফিট স্ক্রিন
            </button>
            <button type="button" class="kg-ep-ctrl-btn" id="kg-ep-zoom-actual" title="<?php esc_attr_e( 'মূল ১০০% সাইজে দেখুন [1]', 'khulnagazette' ); ?>">
                ১:১ সাইজ
            </button>
            <button type="button" class="kg-ep-ctrl-btn" id="kg-ep-fullscreen-btn" title="<?php esc_attr_e( 'ফুল স্ক্রিন [F]', 'khulnagazette' ); ?>">
                <i class="fa fa-expand"></i>
            </button>
            <button type="button" class="kg-ep-ctrl-btn kg-ep-close-btn" id="kg-ep-close-btn" title="<?php esc_attr_e( 'বন্ধ করুন [Esc]', 'khulnagazette' ); ?>">
                <i class="fa fa-times"></i> বন্ধ করুন
            </button>
        </div>
    </div>
    
    <div class="kg-ep-viewport" id="kg-ep-viewport">
        <div class="kg-ep-canvas" id="kg-ep-canvas">
            <img src="<?php echo esc_url( $epaper_full_img ); ?>" 
                 id="kg-ep-modal-img" 
                 alt="<?php the_title_attribute(); ?>" 
                 loading="eager" 
                 decoding="sync"
                 draggable="false">
        </div>
        <div class="kg-ep-help-hint" id="kg-ep-help-hint">
            <span><i class="fa fa-mouse-pointer"></i> মাউস স্ক্রোল করে ইচ্ছামতো জুম ইন/আউট করুন এবং ড্র্যাগ করে টেনে পুরো পেপার পড়ুন</span>
        </div>
    </div>
</div>

<script>
(function() {
    var modal = document.getElementById('kg-epaper-modal');
    var openBtn = document.getElementById('kg-open-epaper-viewer');
    var mainLink = document.getElementById('kg-epaper-main-link');
    var closeBtn = document.getElementById('kg-ep-close-btn');
    var viewport = document.getElementById('kg-ep-viewport');
    var canvas = document.getElementById('kg-ep-canvas');
    var img = document.getElementById('kg-ep-modal-img');
    var zoomInBtn = document.getElementById('kg-ep-zoom-in');
    var zoomOutBtn = document.getElementById('kg-ep-zoom-out');
    var zoomFitBtn = document.getElementById('kg-ep-zoom-fit');
    var zoomActualBtn = document.getElementById('kg-ep-zoom-actual');
    var fsBtn = document.getElementById('kg-ep-fullscreen-btn');
    var zoomBadge = document.getElementById('kg-ep-zoom-val');
    var helpHint = document.getElementById('kg-ep-help-hint');

    if (!modal || !viewport || !canvas || !img) return;

    var scale = 1;
    var fitScale = 1;
    var minScale = 0.2;
    var maxScale = 7.0;
    var posX = 0;
    var posY = 0;
    var isDragging = false;
    var startX = 0;
    var startY = 0;

    function updateTransform() {
        canvas.style.transform = 'translate3d(' + posX + 'px, ' + posY + 'px, 0) scale(' + scale + ')';
        if (zoomBadge) {
            zoomBadge.textContent = Math.round(scale * 100) + '%';
        }
    }

    function calculateFitScale() {
        var vw = viewport.clientWidth || window.innerWidth;
        var vh = viewport.clientHeight || window.innerHeight;
        var nw = img.naturalWidth || img.width || 1200;
        var nh = img.naturalHeight || img.height || 1800;

        var padding = 30;
        var scaleX = (vw - padding) / nw;
        var scaleY = (vh - padding) / nh;
        fitScale = Math.min(scaleX, scaleY);
        if (fitScale > 1.2) fitScale = 1.2;
        if (fitScale < 0.1) fitScale = 0.1;

        scale = fitScale;
        posX = 0;
        posY = 0;
        updateTransform();
    }

    function openModal(e) {
        if (e) e.preventDefault();
        modal.classList.add('kg-ep-active');
        document.body.classList.add('kg-ep-modal-open');

        if (img.complete && img.naturalWidth > 0) {
            calculateFitScale();
        } else {
            img.onload = function() {
                calculateFitScale();
            };
        }

        if (helpHint) {
            helpHint.style.opacity = '1';
            setTimeout(function() {
                helpHint.style.opacity = '0';
            }, 3500);
        }
    }

    function closeModal() {
        modal.classList.remove('kg-ep-active');
        document.body.classList.remove('kg-ep-modal-open');
        if (document.fullscreenElement) {
            if (document.exitFullscreen) document.exitFullscreen().catch(function() {});
        }
    }

    function zoomAtPoint(factor, clientX, clientY) {
        var oldScale = scale;
        var newScale = oldScale * factor;
        if (newScale < minScale) newScale = minScale;
        if (newScale > maxScale) newScale = maxScale;
        if (newScale === oldScale) return;

        var rect = viewport.getBoundingClientRect();
        var originX = clientX !== undefined ? (clientX - rect.left - rect.width / 2) : 0;
        var originY = clientY !== undefined ? (clientY - rect.top - rect.height / 2) : 0;

        posX = originX - (originX - posX) * (newScale / oldScale);
        posY = originY - (originY - posY) * (newScale / oldScale);
        scale = newScale;

        updateTransform();
    }

    if (zoomInBtn) {
        zoomInBtn.addEventListener('click', function() {
            zoomAtPoint(1.3);
        });
    }
    if (zoomOutBtn) {
        zoomOutBtn.addEventListener('click', function() {
            zoomAtPoint(0.77);
        });
    }
    if (zoomFitBtn) {
        zoomFitBtn.addEventListener('click', function() {
            calculateFitScale();
        });
    }
    if (zoomActualBtn) {
        zoomActualBtn.addEventListener('click', function() {
            scale = 1.0;
            posX = 0;
            posY = 0;
            updateTransform();
        });
    }

    if (fsBtn) {
        fsBtn.addEventListener('click', function() {
            if (!document.fullscreenElement) {
                if (modal.requestFullscreen) modal.requestFullscreen();
                else if (modal.webkitRequestFullscreen) modal.webkitRequestFullscreen();
                else if (modal.msRequestFullscreen) modal.msRequestFullscreen();
            } else {
                if (document.exitFullscreen) document.exitFullscreen();
            }
        });
    }

    if (openBtn) openBtn.addEventListener('click', openModal);
    if (mainLink) mainLink.addEventListener('click', openModal);
    if (closeBtn) closeBtn.addEventListener('click', closeModal);

    viewport.addEventListener('wheel', function(e) {
        e.preventDefault();
        var factor = e.deltaY < 0 ? 1.15 : 0.87;
        zoomAtPoint(factor, e.clientX, e.clientY);
    }, { passive: false });

    viewport.addEventListener('mousedown', function(e) {
        if (e.target.closest('.kg-ep-topbar') || e.target.closest('.kg-ep-controls')) return;
        isDragging = true;
        startX = e.clientX - posX;
        startY = e.clientY - posY;
        viewport.classList.add('kg-ep-dragging');
    });

    window.addEventListener('mousemove', function(e) {
        if (!isDragging) return;
        posX = e.clientX - startX;
        posY = e.clientY - startY;
        updateTransform();
    });

    window.addEventListener('mouseup', function() {
        if (isDragging) {
            isDragging = false;
            viewport.classList.remove('kg-ep-dragging');
        }
    });

    viewport.addEventListener('dblclick', function(e) {
        if (e.target.closest('.kg-ep-topbar')) return;
        if (scale <= fitScale * 1.2) {
            zoomAtPoint(2.5, e.clientX, e.clientY);
        } else {
            calculateFitScale();
        }
    });

    var initialDistance = 0;
    var initialScale = 1;
    var touchStartX = 0;
    var touchStartY = 0;

    viewport.addEventListener('touchstart', function(e) {
        if (e.touches.length === 1) {
            isDragging = true;
            touchStartX = e.touches[0].clientX - posX;
            touchStartY = e.touches[0].clientY - posY;
        } else if (e.touches.length === 2) {
            isDragging = false;
            initialDistance = Math.hypot(
                e.touches[0].clientX - e.touches[1].clientX,
                e.touches[0].clientY - e.touches[1].clientY
            );
            initialScale = scale;
        }
    }, { passive: true });

    viewport.addEventListener('touchmove', function(e) {
        if (e.touches.length === 1 && isDragging) {
            posX = e.touches[0].clientX - touchStartX;
            posY = e.touches[0].clientY - touchStartY;
            updateTransform();
        } else if (e.touches.length === 2 && initialDistance > 0) {
            var currentDist = Math.hypot(
                e.touches[0].clientX - e.touches[1].clientX,
                e.touches[0].clientY - e.touches[1].clientY
            );
            var newScale = initialScale * (currentDist / initialDistance);
            if (newScale >= minScale && newScale <= maxScale) {
                scale = newScale;
                updateTransform();
            }
        }
    }, { passive: true });

    viewport.addEventListener('touchend', function(e) {
        if (e.touches.length < 2) {
            initialDistance = 0;
        }
        if (e.touches.length === 0) {
            isDragging = false;
        }
    }, { passive: true });

    window.addEventListener('keydown', function(e) {
        if (!modal.classList.contains('kg-ep-active')) return;

        if (e.key === 'Escape') {
            closeModal();
        } else if (e.key === '+' || e.key === '=') {
            e.preventDefault();
            zoomAtPoint(1.25);
        } else if (e.key === '-' || e.key === '_') {
            e.preventDefault();
            zoomAtPoint(0.8);
        } else if (e.key === '0' || e.key === 'Home') {
            e.preventDefault();
            calculateFitScale();
        } else if (e.key === '1') {
            e.preventDefault();
            scale = 1.0;
            posX = 0;
            posY = 0;
            updateTransform();
        } else if (e.key === 'f' || e.key === 'F') {
            if (fsBtn) fsBtn.click();
        } else if (e.key === 'ArrowUp') {
            posY += 60;
            updateTransform();
        } else if (e.key === 'ArrowDown') {
            posY -= 60;
            updateTransform();
        } else if (e.key === 'ArrowLeft') {
            posX += 60;
            updateTransform();
        } else if (e.key === 'ArrowRight') {
            posX -= 60;
            updateTransform();
        }
    });

    window.addEventListener('resize', function() {
        if (modal.classList.contains('kg-ep-active')) {
            calculateFitScale();
        }
    });
})();
</script>

<?php get_footer(); ?>
