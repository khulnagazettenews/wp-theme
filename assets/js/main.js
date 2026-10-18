
jQuery(document).ready(function($){ 
			
    var scrollTicking = false;
    $(window).on('scroll', function(){
        if (!scrollTicking) {
            window.requestAnimationFrame(function() {
                if ($(window).scrollTop() > 150) {
                    $('.scrollup').fadeIn(200);
                } else {
                    $('.scrollup').fadeOut(200);
                }
                scrollTicking = false;
            });
            scrollTicking = true;
        }
    }); 

    $('.scrollup').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 600);
        return false;
    });


    $(".khulna-gazette-search").click(function() {

        $(".search-box").toggle();
       
     });
    
    //Add nav menu required classes
    $("#khulnagazette-nav li").addClass("nav-item");
    $("#khulnagazette-nav li").first().addClass("active");
    $(".navbar-nav li").addClass("nav-item");
    $(".navbar-nav li a").addClass("nav-link");    
    $(".navbar-nav li").has("ul").addClass("dropdown");    
    $(".navbar-nav li ul").addClass("dropdown-menu");
    $("ul.dropdown-menu").parent().addClass("childclassfix");
    $(".childclassfix > a").addClass("dropdown-toggle");
    $(".dropdown-toggle").attr("data-toggle", "dropdown");
    $("ul.dropdown-menu li a").addClass("dropdown-item");
    
    
    $('ul#khulnagazette-nav li.dropdown').hover(function() {
      $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
    }, function() {
      $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
    });
    
    
    //Change title position; show overlay after content has loaded
    if (typeof $.fn.fancybox === 'function') {
        $(".fancybox").fancybox({
            helpers:  {
                title : {
                    type : 'inside'
                },
                overlay : {
                    showEarly : false
                }
            }
        });
    }
    
    // Toggles Search Bar on click
    $("#kg-search").click(function () {
        $(".search-toggle").animate({
            width: 'toggle'
        });
    });

    // Check already loaded images for broken sources
    var defaultImg = (typeof kgData !== 'undefined' && kgData.defaultImage) ? kgData.defaultImage : '';
    if (defaultImg) {
        $('img').each(function() {
            if (this.complete && (this.naturalWidth === 0 || this.naturalHeight === 0)) {
                if (this.src !== defaultImg && !this.dataset.fallbackApplied) {
                    this.dataset.fallbackApplied = 'true';
                    this.onerror = null;
                    this.src = defaultImg;
                }
            }
        });
    }
});

// Global Image Error Handler (Catches 404 / broken images anywhere on site)
(function() {
    var defaultImage = (typeof kgData !== 'undefined' && kgData.defaultImage) ? kgData.defaultImage : '';
    if (!defaultImage) {
        var themeLink = document.querySelector('link[href*="assets/"]');
        if (themeLink) {
            defaultImage = themeLink.href.split('/assets/')[0] + '/assets/img/kg-home-image.jpg';
        }
    }

    window.addEventListener('error', function(e) {
        var target = e.target;
        if (target && target.tagName === 'IMG') {
            if (defaultImage && target.src !== defaultImage && !target.dataset.fallbackApplied) {
                target.dataset.fallbackApplied = 'true';
                target.onerror = null;
                target.src = defaultImage;
            }
        }
    }, true);
})();

// Instant News Navigation Engine (Instant page open on click / hover / touch)
(function() {
    var prefetchedUrls = new Set();
    var homeUrl = (typeof kgData !== 'undefined' && kgData.homeUrl) ? kgData.homeUrl : window.location.origin;

    function shouldPrefetch(url) {
        if (!url || prefetchedUrls.has(url)) return false;
        if (!url.startsWith(homeUrl) && !url.startsWith('/') && !url.startsWith(window.location.origin)) return false;
        if (url.indexOf('/wp-admin') !== -1 || url.indexOf('wp-login') !== -1 || url.indexOf('preview=true') !== -1) return false;
        if (url.indexOf('#') !== -1 && url.split('#')[0] === window.location.href.split('#')[0]) return false;
        if (/\.(jpg|jpeg|png|gif|webp|svg|pdf|zip|mp4|mp3)$/i.test(url)) return false;
        return true;
    }

    function prefetch(url) {
        if (!shouldPrefetch(url)) return;
        prefetchedUrls.add(url);
        var link = document.createElement('link');
        link.rel = 'prefetch';
        link.href = url;
        link.as = 'document';
        document.head.appendChild(link);
    }

    document.addEventListener('pointerover', function(e) {
        var anchor = e.target.closest('a');
        if (anchor && anchor.href) {
            prefetch(anchor.href);
        }
    }, { passive: true });

    document.addEventListener('touchstart', function(e) {
        var anchor = e.target.closest('a');
        if (anchor && anchor.href) {
            prefetch(anchor.href);
        }
    }, { passive: true });

    document.addEventListener('mousedown', function(e) {
        var anchor = e.target.closest('a');
        if (anchor && anchor.href) {
            prefetch(anchor.href);
        }
    }, { passive: true });
})();