jQuery(function($){
$(window).on('load', function() {
    if($('#lp-bakertop').length) {
        // hero overlayjs
        var overlay = $("#hero-overlay");
        console.log(overlay);
        overlay.animate({
            'left': '-100%',
            'width': '60%'
        }, 1200, function() {

            $('.lp-main-img').addClass('js-fade');
        }
        );
    }
});


$(window).on('load', function() {
    if($('#lp-cafetrone').length) {
        // hero overlayjs
        var overlay = $("#hero-overlay");
        console.log(overlay);
        overlay.animate({
            'left': '-100%',
            'width': '60%'
        }, 1200, function() {

            $('.lp-main-img').addClass('js-fade');
        }
        );
    }
});

$(window).on('load', function () {
    if ($('#lp-smartlifter').length) {
        // hero overlayjs
        var overlay = $("#hero-overlay");
        console.log(overlay);
        overlay.animate({
            'left': '-100%',
            'width': '60%'
        }, 1200, function () {

            $('.lp-main-img').addClass('js-fade');
        }
        );
    }
});



$(window).on('load', function() {
    if($('#lp-carpigiani').length) {
        // hero overlayjs
        var overlay = $("#hero-overlay");
        console.log(overlay);
        overlay.animate({
            'left': '-100%',
            'width': '60%'
        }, 1200, function() {

            $('.lp-main-img').addClass('js-fade');
        }
        );

        // 繰り返しアニメーション
        $(window).on("load touchstart scroll", function () {
            var offsetItem = $('#repeatAnim').offset().top - $(window).height() + 400;
            if (! $('#repeatAnim').hasClass('animate--scrolled')) {
              if ($(window).scrollTop() >= offsetItem) {
                // $('#repeatAnim').addClass('animate--scrolled');
                function repeatAnim() {
                    $('#repeatAnim').removeClass('animate--scrolled');
                    $('#repeatAnim').delay(1000).queue(function(next) {
                        $(this).addClass('animate--scrolled');
                        next();
                    });
                    setTimeout(repeatAnim, 6000);
                }
                repeatAnim();
              }
            }
        });
    }
});


$(window).on('load', function() {
    if($('#lp-cheftop').length) {
        // hero overlayjs
        var overlay = $("#hero-overlay");
        console.log(overlay);
        overlay.animate({
            'left': '-100%',
            'width': '60%'
        }, 1200, function() {

            $('.lp-main-img').addClass('js-fade');
        }
        );

        // gif anim
        $(window).on("load touchstart scroll", function () {
            var offsetGif01 = $('.gif-anim01').offset().top - $(window).height() + 400;
            if (! $('.gif-anim01').hasClass('animate--scrolled')) {
              if ($(window).scrollTop() >= offsetGif01) {
                var timestamp = new Date().getTime();
                function reloadgif() {
                  $('#grafBase').addClass('is-fadeOut');
                  $('#graf').attr('src', '/assets/images/products/lp/cheftop/cheftop-feat2-main.gif' + '?' + timestamp);
                  setTimeout(reloadgif, 5000);
                }
                reloadgif();
                $('.gif-anim01').addClass('animate--scrolled');
              }
            }
        });
    }
});


$(window).on('load', function() {
    if($('#lp-chimbali').length) {
        // hero overlayjs
        var overlay = $("#hero-overlay");
        console.log(overlay);
        overlay.animate({
            'left': '-100%',
            'width': '60%'
        }, 1200, function() {

            $('.lp-main-img').addClass('js-fade');
        }
        );
        // gif anim
        $(window).on("load touchstart scroll", function () {
            var offsetGif01 = $('.gif-anim01').offset().top - $(window).height() + 400;
            if (! $('.gif-anim01').hasClass('animate--scrolled')) {
              if ($(window).scrollTop() >= offsetGif01) {
                var timestamp = new Date().getTime();
                function reloadgif() {
                  $('#grafBase').addClass('is-fadeOut');
                  $('#graf').attr('src', '/assets/images/products/lp/chimbali/anime2.gif' + '?' + timestamp);
                  setTimeout(reloadgif, 5000);
                }
                reloadgif();
                $('.gif-anim01').addClass('animate--scrolled');
              }
            }
        });

        $('#js-chimbali-slider').slick({
             infinite: true,
             autoplay: true,
             autoplaySpeed: 2000,
             speed: 2000,
             fade: true,
             dots:false,
             arrows: false,
             slidesToShow: 1,
             slidesToScroll: 1,
             centerMode: false,
             variableWidth: false,
             asNavFor: '#js-slider-nav',
             pauseOnHover: false,
        });

        $("#js-slider-nav").slick({
          slidesToShow:4,
          variableWidth: true,
          asNavFor: '#js-chimbali-slider',
          focusOnSelect: true,
        });

        $('#js-chimbali-slider').on('beforeChange', function(event, slick, currentSlide, nextSlide){
                // ナビゲーションカレント表示
                var nextItem = nextSlide + 1; // 1~4
                $('.milk-selectorItem').removeClass('is-active');
                $('.milk-selectorItem:nth-child(' + nextItem + ')').addClass('is-active');
        });
    }

});


$(window).on('load', function() {
    if($('#lp-clSeries').length) {

        $slider = $('#js-CLseries-slider');
        $slider.slick({
            infinite: true,
            autoplay: true,
            autoplaySpeed: 2000,
            speed: 2000,
            arrows: false,
            slidesToScroll: 3,
            slidesToShow: 3,
            centerMode: true,
            variableWidth: true,
            dots:true,
            customPaging: function(slider, i) {
              var thumbSrc = $(slider.$slides[i]).find('img').attr('src');
              return '<img src="' + thumbSrc + '">';
            },
            responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    centerMode: true,
                    slidesToScroll: 1,
                    variableWidth: true,
                }
            }]
        });
        var imgInit = $('.slick-dots li').eq(0).find('img');
        $(imgInit).attr("src",$(imgInit).attr("src").replace("-before.", "-after."));
        $slider.on('beforeChange', function(event, slick, currentSlide, nextSlide){
            $('.lp-CLseries-cut-conts').delay(100).queue(function(next) {
                $(this).removeClass('is-active');
                next();
            });
            if (nextSlide == 0) {
                // $('.lp-CLseries-cut-conts.slick-cloned').prev('.lp-CLseries-cut-conts');
                $('.slick-cloned').addClass('slick-active');
            }
            var imgPrev = $('.slick-dots li').eq(currentSlide).find('img');
            var imgNext = $('.slick-dots li').eq(nextSlide).find('img');

            $(imgPrev).attr("src",$(imgPrev).attr("src").replace("-after.", "-before."));
            $(imgNext).attr("src",$(imgNext).attr("src").replace("-before.", "-after."));
        });
        $slider.on('afterChange', function(event, slick, currentSlide, nextSlide){
            $('.slick-center').addClass('is-active');
        });
        // hero overlayjs
        var overlay = $("#hero-overlay");
        console.log(overlay);
        overlay.animate({
            'left': '-100%',
            'width': '60%'
        }, 1200, function() {

            $('.hero-3items').addClass('js-fade');
        }
        );

    }

});


$(window).on("load touchstart scroll", function () {
    // スクロールアニメーション
    var thredhold = 150;
    if (window.matchMedia("(min-width:769px)").matches){
      var thredhold = 200;
    }
    $(".animate").each(function () {
        var o = $(this)
            .offset()
            .top - $(window).height() + thredhold;
        $(window).scrollTop() >= o && $(this).addClass("animate--scrolled")
    });
});

$(window).on('load', function() {
    if($('#lp-convotherm').length) {
        // hero overlayjs
        var overlay = $("#hero-overlay");
        console.log(overlay);
        overlay.animate({
            'left': '-100%',
            'width': '60%'
        }, 1200, function() {
            $('.lp-main-img').addClass('js-fade');
        }
        );
        // gif anim
        $(window).on("load touchstart scroll", function () {
            var offsetGif01 = $('.gif-anim01').offset().top - $(window).height() + 400;
            if (! $('.gif-anim01').hasClass('animate--scrolled')) {
              if ($(window).scrollTop() >= offsetGif01) {
                var timestamp = new Date().getTime();
                function reloadgif() {
                  $('#grafBase').addClass('is-fadeOut');
                  $('#graf').attr('src', '/assets/images/products/lp/convotherm/convotherm-feat1-main.gif' + '?' + timestamp);
                }
                reloadgif();
                $('.gif-anim01').addClass('animate--scrolled');
              }
            }
        });
    }
});


$(window).on('load', function() {
    if($('#lp-irinoxB').length) {
        console.log("irinox2");
        // hero overlayjs
        var overlay = $("#hero-overlay");
        // console.log(overlay);
        overlay.animate({
            'left': '-100%',
            'width': '60%'
        }, 1200, function() {

            $('.lp-main-img').addClass('js-fade');
        }
        );
        if(window.matchMedia("(max-width:769px)").matches){
            var scrollAreaH = $('.lp-irinox-feat1').outerHeight();
            var section01AreaH = $('.lp-irinox-feat1-inner--1').outerHeight();
            var section02AreaH = $('.lp-irinox-feat1-inner--2').outerHeight();
            var section03AreaH = $('.lp-irinox-feat1-inner--3').outerHeight();
            var setDuration = scrollAreaH - section03AreaH;
            // count
            var controller = new ScrollMagic();
            var scene = new ScrollScene({triggerElement: ".lp-irinox-feat1-thermo-inner", duration: setDuration , triggerHook : "onLeave"})
                     .setPin("#js-meter")
                     .addTo(controller);

            // progress
            var countObj = $("#js-meter span");
            var scene2 = new ScrollScene({
                triggerElement: ".lp-irinox-feat1-thermo-inner",
                triggerHook: 'onLeave',
                duration: section01AreaH
            })
            .on("progress", function (prog) {
                var p = prog.progress;
                parogressNum = -40 + 75 * p;
                calcNum = Math.floor(parogressNum);
                countObj.text(calcNum);
            })
            .addTo(controller);

            var scene3 = new ScrollScene({
                triggerElement: ".lp-irinox-feat1-inner--2",
                triggerHook: 'onLeave',
                duration: section02AreaH
            })
            .on("progress", function (prog) {
                var p = prog.progress;
                parogressNum = 35 + 50 * p;
                calcNum = Math.floor(parogressNum);
                countObj.text(calcNum);
            })
            .addTo(controller);

            // 芯温表示
            var scene4 = new ScrollScene({
                triggerElement: '.lp-irinox-feat1-inner--1',
                triggerHook: 'onLeave',
                offset: 200
            }).setClassToggle('.lp-irinox-feat1-meter', 'js-fadeOut').addTo(controller);
        }

        if(window.matchMedia("(min-width:769px)").matches){
            var scrollAreaH = $('.lp-irinox-feat1').outerHeight();
            var section01AreaH = $('.lp-irinox-feat1-inner--1').outerHeight();
            var section02AreaH = $('.lp-irinox-feat1-inner--2').outerHeight();
            var section03AreaH = $('.lp-irinox-feat1-inner--3').outerHeight();
            var setDuration = scrollAreaH - section03AreaH;
            // count
            var controller = new ScrollMagic();
            var scene = new ScrollScene({triggerElement: ".lp-irinox-feat1-thermo-inner", duration: setDuration , triggerHook : "onLeave"})
                     .setPin("#js-meter")
                     .addTo(controller);

            // progress
            var countObj = $("#js-meter span");
            var scene2 = new ScrollScene({
                triggerElement: ".lp-irinox-feat1-thermo-inner",
                triggerHook: 'onLeave',
                duration: section01AreaH
            })
            .on("progress", function (prog) {
                var p = prog.progress;
                parogressNum = -40 + 75 * p;
                calcNum = Math.floor(parogressNum);
                countObj.text(calcNum);
            })
            .addTo(controller);

            var scene3 = new ScrollScene({
                triggerElement: ".lp-irinox-feat1-inner--2",
                triggerHook: 'onLeave',
                duration: section02AreaH
            })
            .on("progress", function (prog) {
                var p = prog.progress;
                parogressNum = 35 + 50 * p;
                calcNum = Math.floor(parogressNum);
                countObj.text(calcNum);
            })
            .addTo(controller);

            // 芯温表示
            var scene4 = new ScrollScene({
                triggerElement: '.lp-irinox-feat1-inner--1',
                triggerHook: 'onLeave',
                offset: 200
            }).setClassToggle('.lp-irinox-feat1-meter', 'js-fadeOut').addTo(controller);
        }

    }
});


$(window).on('load', function() {
    if($('#lp-irinoxC').length) {
        // hero overlayjs
        var overlay = $("#hero-overlay");
        console.log(overlay);
        overlay.animate({
            'left': '-100%',
            'width': '60%'
        }, 1200, function() {

            $('.lp-main-img').addClass('js-fade');
        }
        );

        if(window.matchMedia("(max-width:769px)").matches){
            var scrollAreaH = $('.lp-irinox-feat1').outerHeight();
            var section01AreaH = $('.lp-irinox-feat1-inner--1').outerHeight();
            var section02AreaH = $('.lp-irinox-feat1-inner--2').outerHeight();
            var section03AreaH = $('.lp-irinox-feat1-inner--3').outerHeight();
            var setDuration = scrollAreaH - section03AreaH;
            // count
            var controller = new ScrollMagic();
            var scene = new ScrollScene({triggerElement: ".lp-irinox-feat1-thermo-inner", duration: setDuration , triggerHook : "onLeave"})
                     .setPin("#js-meter")
                     .addTo(controller);

            // progress
            var countObj = $("#js-meter span");
            var scene2 = new ScrollScene({
                triggerElement: ".lp-irinox-feat1-thermo-inner",
                triggerHook: 'onLeave',
                duration: section01AreaH
            })
            .on("progress", function (prog) {
                var p = prog.progress;
                parogressNum = 85 - 50 * p;
                calcNum = Math.floor(parogressNum);
                countObj.text(calcNum);
            })
            .addTo(controller);

            var scene3 = new ScrollScene({
                triggerElement: ".lp-irinox-feat1-inner--2",
                triggerHook: 'onLeave',
                duration: section02AreaH
            })
            .on("progress", function (prog) {
                var p = prog.progress;
                parogressNum = 35 - 75 * p;
                calcNum = Math.floor(parogressNum);
                countObj.text(calcNum);
            })
            .addTo(controller);

            // 芯温表示
            var scene4 = new ScrollScene({
                triggerElement: '.lp-irinox-feat1-inner--3',
                triggerHook: 'onLeave',
                offset: -100
            }).setClassToggle('.lp-irinox-feat1-meter', 'js-fadeIn').addTo(controller);

        }

        if(window.matchMedia("(min-width:769px)").matches){
            var scrollAreaH = $('.lp-irinox-feat1').outerHeight();
            var section01AreaH = $('.lp-irinox-feat1-inner--1').outerHeight();
            var section02AreaH = $('.lp-irinox-feat1-inner--2').outerHeight();
            var section03AreaH = $('.lp-irinox-feat1-inner--3').outerHeight();
            var setDuration = scrollAreaH - section03AreaH;
            // count
            var controller = new ScrollMagic();
            var scene = new ScrollScene({triggerElement: ".lp-irinox-feat1", duration: setDuration , triggerHook : "onLeave"})
                     .setPin("#js-meter")
                     .addTo(controller);

            // progress
            var countObj = $("#js-meter span");
            var scene2 = new ScrollScene({
                triggerElement: ".lp-irinox-feat1-thermo-inner",
                triggerHook: 'onLeave',
                duration: section01AreaH
            })
            .on("progress", function (prog) {
                var p = prog.progress;
                parogressNum = 85 - 50 * p;
                calcNum = Math.floor(parogressNum);
                countObj.text(calcNum);
            })
            .addTo(controller);

            var scene3 = new ScrollScene({
                triggerElement: ".lp-irinox-feat1-inner--2",
                triggerHook: 'onLeave',
                duration: section02AreaH
            })
            .on("progress", function (prog) {
                var p = prog.progress;
                parogressNum = 35 - 75 * p;
                calcNum = Math.floor(parogressNum);
                countObj.text(calcNum);
            })
            .addTo(controller);

            // 芯温表示
            var scene4 = new ScrollScene({
                triggerElement: '.lp-irinox-feat1-inner--3',
                triggerHook: 'onLeave',
                offset: -100
            }).setClassToggle('.lp-irinox-feat1-meter', 'js-fadeIn').addTo(controller);
        }
    }
});


$(window).on('load',function(){
    //モーダル
    var $modalBtn = $('.js-lp-modal-btn');
    var $modal =$('.js-lp-modal');

    if($modalBtn.length>0) {
        $modalBtn.on('click', function(event) {
            event.preventDefault();

            var indexNum = $(this).index('.js-lp-modal-btn');
            var $targetModal = $modal.eq(indexNum);
            var $modalCloseBtn = $targetModal.find('.js-lp-modal-close-btn');
            var $modalOverlay = $targetModal.find('.js-lp-modal-overlay');

            //モーダル表示
            $targetModal.appendTo('body').fadeIn(100, 'swing');

            //モーダル非表示
            $modalOverlay.off('click');
            $modalOverlay.on('click', function(){
                modalClose();
            });

            $modalCloseBtn.off('click');
            $modalCloseBtn.on('click', function(){
                modalClose();
            });
            //背景固定
            var current_scrollY = $(window).scrollTop();

            $('#wrapper').css({
              position: 'fixed',
              width: '100%',
              top: -1 * (current_scrollY)
            });

            // モーダル閉じる
            function modalClose(){
              //背景元の位置に
              $targetModal.fadeOut(200, 'swing');
              $('#wrapper').attr({style:''});
              $('html, body').animate({scrollTop: current_scrollY}, 0);
            }
        });
    }
});

$(window).on('load', function() {
    if($('#lp-pacojet').length) {
        // hero overlayjs
        var overlay = $("#hero-overlay");
        console.log(overlay);
        overlay.animate({
            'left': '-100%',
            'width': '60%'
        }, 1200, function() {

            $('.lp-main-img').addClass('js-fade');
        }
        );
    }
});


$(window).on('load', function() {
    if($('#lp-rseries').length) {
        // hero overlayjs
        var overlay = $("#hero-overlay");
        console.log(overlay);
        overlay.animate({
            'left': '-100%',
            'width': '60%'
        }, 1200, function() {
            $('.hero-3items').addClass('js-fade');
        }
        );
        // tab click
        var $lpProductsTabNavList = $('.lp-productsTab-nav-label');
        $lpProductsTabNavList.on('touchend click', function () {
            var index = $lpProductsTabNavList.index(this);
            $('.lp-card-txt').removeClass('animate--scrolled');
            if( index <= 5 && 3 <= index ) {
                var indexItem = index - 3;
                 $('.lp-productsTab-conts').eq(indexItem).find('.lp-card-txt').addClass('animate--scrolled');
            }
            $('.lp-rseries-func-ul').removeClass('animate--scrolled');
            jQuery('html,body').animate({
              scrollTop : jQuery('#tabContents').offset().top
            }, 'normal');
        });
    }
});


//lp-brandページ タブ
var sp_flag = false;
// ロード　リサイズ時 window幅取得
$(window).on('load resize', function () {
    sp_flag = (window.matchMedia('(max-width:767px)').matches);
});

var $lpProductsTabavBtn = $('.js-lp-productsTab-nav-btn');

$(window).on('load resize', function () {
    if ($lpProductsTabavBtn.length && sp_flag ) {
        //ボタン押したらメニュー表示
        $lpProductsTabavBtn.on('click', function () {
            $lpProductsTabavBtn = $(this);
            var $lpProductsTabNavUl = $lpProductsTabavBtn.next();
            var $lpProductsTabNavLabel = $lpProductsTabNavUl.find('.js-lp-productsTab-nav-list label');

            $lpProductsTabNavUl.slideDown(200, 'swing');

            //リストをクリック ボタンテキスト変更 モーダル閉じる
            $lpProductsTabNavLabel.off('click');
            $lpProductsTabNavLabel.on('click', function() {
                var listValue = $(this).text();
                $lpProductsTabavBtn.text(listValue);
                $lpProductsTabNavUl.slideUp(200, 'swing');
            })
        });
    }
});

});