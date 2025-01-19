(function ($) {
    "use strict";

    // loader
    $('.loader-wrapper').fadeOut('slow', function () {
        $(this).remove();
    });
    // tap top
    $('.tap-top').on('click', function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });

    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 600) {
            $('.tap-top').fadeIn();
        } else {
            $('.tap-top').fadeOut();
        }
    });
    $(document).on('click', function (e) {
        var outside_space = $(".outside");
        if (!outside_space.is(e.target) &&
            outside_space.has(e.target).length === 0) {
            $(".menu-to-be-close").removeClass("d-block");
            $('.menu-to-be-close').css('display', 'none');
        }
    })

   

    if ($(".page-wrapper").hasClass("horizontal-wrapper")) {
        $(".sidebar-list").hover(
          function () {
            $(this).addClass("hoverd");
          },
          function () {
            $(this).removeClass("hoverd");
          }
        );
        $(window).on("scroll", function () {
          if ($(this).scrollTop() < 600) {
            $(".sidebar-list").removeClass("hoverd");
          }
        });
      }

   
    

    /*=====================
      02. Background Image js
      ==========================*/
    $(".bg-center").parent().addClass('b-center');
    $(".bg-img-cover").parent().addClass('bg-size');
    $('.bg-img-cover').each(function () {
        var el = $(this),
            src = el.attr('src'),
            parent = el.parent();
        parent.css({
            'background-image': 'url(' + src + ')',
            'background-size': 'cover',
            'background-position': 'center',
            'display': 'block'
        });
        el.hide();
    });

    $(".mega-menu-container").css("display", "none");
    $(".header-search").on('click', function () {
        $(".search-full").addClass("open");
    });
    $(".close-search").on('click', function () {
        $(".search-full").removeClass("open");
        $("body").removeClass("offcanvas");
    });
    $(".mobile-toggle").on('click', function () {
        $(".nav-menus").toggleClass("open");
    });
    $(".mobile-toggle-left").on('click', function () {
        $(".left-header").toggleClass("open");
    });
    $(".bookmark-search").on('click', function () {
        $(".form-control-search").toggleClass("open");
    })
    $(".filter-toggle").on('click', function () {
        $(".product-sidebar").toggleClass("open");
    });
    $(".toggle-data").on('click', function () {
        $(".product-wrapper").toggleClass("sidebaron");
    });

    $(".mobile-search").on('click', function () {
        $(".form-control").toggleClass("open");
    });

    $(".form-control-search input").keyup(function (e) {
        if (e.target.value) {
            $(".page-wrapper").addClass("offcanvas-bookmark");
        } else {
            $(".page-wrapper").removeClass("offcanvas-bookmark");
        }
    });
    $(".search-full input").keyup(function (e) {
        if (e.target.value) {
            $("body").addClass("offcanvas");
        } else {
            $("body").removeClass("offcanvas");
        }
    });

    $('body').keydown(function (e) {
        if (e.keyCode == 27) {
            $('.search-full input').val('');
            $('.form-control-search input').val('');
            $('.page-wrapper').removeClass('offcanvas-bookmark');
            $('.search-full').removeClass('open');
            $('.search-form .form-control-search').removeClass('open');
            $("body").removeClass("offcanvas");
        }
    });
    $(".mode").on("click", function () {
        $('.mode i').toggleClass("fa-moon-o").toggleClass("fa-lightbulb-o");
        $('body').toggleClass("dark-only");
        var color = $(this).attr("data-attr");
        localStorage.setItem('body', 'dark-only');
    });

    // active link

  

   
    
    $(".onhover-dropdown").on("click", function () {
        $(this).children('.onhover-show-div').toggleClass("active");
    });
    // search input 
   
    
    //landing header //
    $(".toggle-menu").on('click', function (){
        $('.landing-menu').toggleClass('open');
    });   
    $(".menu-back").on('click', function (){
        $('.landing-menu').toggleClass('open');
    });  
    
    $(".md-sidebar-toggle").on('click', function (){
        $('.md-sidebar-aside').toggleClass('open');
    });
    
    // color selector 
      $('.color-selector ul li ').on('click', function(e) {
        $(".color-selector ul li").removeClass("active");
        $(this).addClass("active");
      });
    
    //extra
   
    
    


$(document).ready(function () {

    if (localStorage.getItem("primary") != null) {
        var primary_val = localStorage.getItem("primary");
        $("#ColorPicker1").val(primary_val);
        var secondary_val = localStorage.getItem("secondary");
        $("#ColorPicker2").val(secondary_val);
    }


});  


    /*TRANSLATE*/
    



})(jQuery);

function toggleFullScreen() {
    if ((document.fullScreenElement && document.fullScreenElement !== null) ||
        (!document.mozFullScreen && !document.webkitIsFullScreen)) {
        if (document.documentElement.requestFullScreen) {
            document.documentElement.requestFullScreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullScreen) {
            document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }
}