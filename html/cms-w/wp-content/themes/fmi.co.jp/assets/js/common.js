/**
 * 高さをそろえるクラス名　js-matchHeight
 */
 jQuery(function($){
var sp_flag = false;
// ロード　リサイズ時 window幅取得
$(window).on('load resize', function () {
    sp_flag = (window.matchMedia('(max-width:767px)').matches);
});

$(window).on('load resize', function(){
    // spのときは2カラム、pcのときは3カラムごとに高さ調整
    var columnNum = 3;
    if (sp_flag) {
        columnNum = 2;
    }

    $('.l-item-conts').each(function(){
        $(this).find(".js-matchHeight").autoHeight({column: columnNum});
    });
    $('.mixerNav01-table tr').each(function (){
        $(this).find(".js-matchHeight").autoHeight();
    });

    $(".js-matchHeight-v2").autoHeight({column: columnNum});
    $('.mixerNav01-table tr').each(function (){
        $(this).find(".js-matchHeight-v2").autoHeight();
    });

    $(".js-matchHeight-v3").autoHeight({column: columnNum});
    $('.mixerNav01-table tr').each(function (){
        $(this).find(".js-matchHeight-v3").autoHeight();
    });

    //products lineupページ
    var columnLine = 4;
    if (sp_flag) {
        columnLine = 2;
    }
    $('.brandDetail-item-conts').each(function(){
        $(this).find(".l-item-img").autoHeight({column: columnLine});
        $(this).find(".l-item-ttl").autoHeight({column: columnLine});
    });

    //lp-brandページ
    if (!sp_flag) {
        $('.lp-other').each(function(){
            $(this).find(".js-matchHeight").autoHeight();
        });
    }

    //lp-brandページ carpigiani
    var columnCarpi = 8;
    if (sp_flag) {
        columnCarpi = 2;
    }
    $('.lp-carpigiani-products').each(function(){
        $(this).find(".js-matchHeight").autoHeight({column: columnCarpi});
    });

    //lp-brandページ chimbali
    var columnChimbali = 6;
    if (sp_flag) {
        columnChimbali = 2;
    }
    $('.lp-chimbali-products').each(function(){
        $(this).find(".js-matchHeight").autoHeight({column: columnChimbali});
        $(this).find(".js-matchHeight2, .js-matchHeight3").autoHeight({column: columnChimbali});
        $(this).find(".js-matchHeight4").autoHeight();
    });

    //lp-brandページ cafetorne
    var columnCafetorne = 5;
    var columnCafetorne2 = 7;
    if (sp_flag) {
        columnCafetorne = 2;
        columnCafetorne2 = 2;
    }
    //上段
    if( sp_flag ) {
      $(".lp-cafetrone-products .js-matchHeight:not(:first)").autoHeight({column: columnCafetorne});
    } else {
        $(".lp-cafetrone-products .js-matchHeight").autoHeight({column: columnCafetorne});
    }
    //下段
    $(".lp-cafetrone-products .js-matchHeight2").autoHeight({column: columnCafetorne2});
    $(".lp-cafetrone-products .js-matchHeight3").autoHeight({column: columnCafetorne2});

});


$(function(){
    // cookie popup
    var userVisit = "";
    var userVisit = $.cookie('user_visit');
    var period = 365 * 2;
    var popup = '<div class="index-cookie js-popup"><div class="index-cookie-inner"><p>当社では、本ウェブサイトとサービスを快適にご利用いただくため、また、本ウェブサイトとサービスがどのように活用されているのかを当社で詳しく把握し、最適な広告を表示するために、Cookie を使用しています。詳細を確認して Cookie の設定を行うには、<a href="/privacypolicy/#nav">こちら</a> をクリックしてください。引き続き本サイトをご利用いただいた場合、上記の条件に同意されたものとみなされます。</p><button class="js-close-popup"><img src="/assets/images/common/icon_close.png" alt="閉じる"></button></div></div>';

    if (userVisit !== "visited" ) {
        $('body').prepend(popup);
        $.cookie("user_visit", "visited", { expires: period });
        var closePopup = $('.js-close-popup');
        closePopup.on('click', function() {
            $('.js-popup').remove();
        });
    }
});

/**
 * global nav
 */

var gNavShow = function (){
  $(".js-gNavShow").on('click', function(){
    $(this).toggleClass('is-open');
    if($('.l-gNav').is(':hidden')){
      $('.l-gNav').slideDown(400,'swing');
      $('.l-overlay').fadeIn(400).css({'z-index': '10'});
    } else if($('.l-gNav').is(':visible')){
      $('.l-gNav').slideUp(400,'swing');
      $('.l-overlay').fadeOut(
        400,
        function(){
          $(this).css({'z-index': '30'})
        });
    }
    return false;
  });
}

jQuery.event.add(window,"load",function() {
  gNavShow();
});

$(window).on('load scroll', function () {
  $('.l-contact').toggleClass('showed', $(this).scrollTop() > 89);
});


$('.js-search_trg').on("click", function() {
  $('.l-gNav_search').toggleClass('open');
  $('.l-gNav_lng').toggleClass('open');
  $(this).parent().toggleClass('hidden');
  return false;
});



(function() {
  var sb = document.getElementById('srchBox');
  if (sb && sb.className == 'watermark') {
    var si = document.getElementById('srchInput');
    var f = function() { si.className = 'nomark'; };
    var b = function() {
      if (si.value == '') {
        si.className = '';
      }
    };
    si.onfocus = f;
    si.onblur = b;
    if (!/[&?]p=[^&]/.test(location.search)) {
      b();
    } else {
      f();
    }
  }
  })();
/**
 * modal (/products/brand)
 */
var sp_flag = false;
// ロード　リサイズ時 window幅取得
$(window).on('load resize', function () {
    sp_flag = (window.matchMedia('(max-width:767px)').matches);
});


var $brandModalBtn = $(".js-brand-modal-btn");
var $brandModalConts = $(".js-brand-modal-conts");
var $brandLists = $(".js-brand-lists");
var $brandList = $(".js-brand-lists li");


//modalコンテナ
var modalWrappr ='<div class="js-modal-wrapper"><div class="productsBrand-modal-wrapper"><div class="productsBrand-modal-closeBtn-top-wrapper"><button class="js-modal-closeBtn productsBrand-modal-closeBtn-top"><span class="productsBrand-modal-closeBtn-x"></span></button></div><div class="js-modal-wrapper-inner"></div><button class="js-modal-closeBtn productsBrand-modal-closeBtn-bottom"><span class="productsBrand-modal-closeBtn-x"></span><span class="productsBrand-modal-closeBtn-char">CLOSE</span></button></div></div>';


if($brandModalBtn) {
    $brandModalBtn.each(function (i){
        $(this).on('click', function(e){
            e.preventDefault();

            $(".js-modal-wrapper").remove();
            $brandModalBtn.removeClass('is-active');
            $(this).addClass('is-active');

            var btnTop = $(this).offset().top;
            $("html, body").animate({scrollTop:btnTop}, 500, "swing");

            //クリックした要素の列の最後のli要素のindex取得
            if(sp_flag) {
                var targetNum = (Math.floor(i/2)+1)*2-1;//spのとき
            } else {
                var targetNum = (Math.floor(i/3)+1)*3-1;//pcのとき
            }

            //その列の最後のli要素の次にmodalコンテナを挿入
            $brandList.eq(targetNum).after(modalWrappr);

            //その列の最後のli要素が存在しない場合、リストの最後に挿入
            if(!$brandList.eq(targetNum).length) {
                $brandLists.append(modalWrappr);
            }

            //.js-modal-wrapperの中に、modal中身を追加、表示
            var $thisModalConts = $brandModalConts.eq(i);
            $('.js-modal-wrapper-inner').append($thisModalConts);
            $('.js-modal-wrapper').fadeIn(200, 'swing');

            // spのときは2カラム、pcのときは3カラムごとに高さ調整
            var columnNum = 3;
            if (sp_flag) {
                columnNum = 2;
            }
            $(".js-modal-wrapper .js-matchHeight-modal").autoHeight({column: columnNum});

            //modal　閉じる
            $('.js-modal-closeBtn').on('click', function(){
                $('.js-modal-wrapper').fadeOut(200, 'swing');
                $brandModalBtn.removeClass('is-active');
            });
        });
    });
}


/**
 * アンカーナビ
 */
//スクロールすると固定
var $anchorNav = $('.js-anchorNav');
var $anchorNavBtn = $('.js-anchorNavBtn');

var fps = 60;
var frameTime = 1000/fps;
var setTimeoutId = null;

if($anchorNav.length){
    //ナビの高さ取得
    var navHeight = [];
    $('.js-anchorNav > div').each(function (i, nav){
        navHeight[i] = $(nav).height();
    });

    $(window).on('load, scroll', function () {
        if(setTimeoutId) {
            return false;
        }

        setTimeoutId = setTimeout(function () {

            var windowPos = $(window).scrollTop();
            var anchorNavHeight = [];
            $anchorNav.each(function (i, nav){
                anchorNavHeight[i] = $(nav).offset().top;

                if(windowPos > anchorNavHeight[i]) {
                    //ナビ固定、ナビがあった<nav>に高さを与える（スムーススクロール時のズレ対策）
                    $(nav).addClass('is-fixed');
                    $(nav).height(navHeight[i]);
                } else {
                    $(nav).removeClass('is-fixed');
                    $(nav).height('auto');
                }
            });
            setTimeoutId = null;
        }, frameTime);
    });
}

var sp_flag = false;
// ロード　リサイズ時 window幅取得
$(window).on('load resize', function () {
    sp_flag = (window.matchMedia('(max-width:767px)').matches);
});


//spのとき　ナビ開閉
$anchorNavBtn.on('click', function (){
    if(sp_flag) {
        var $anchorNavMenu = $(this).next();
        var $anchorNavMenuList = $anchorNavMenu.find('a');
        $anchorNavMenu.slideToggle();
        $anchorNavMenuList.on('click', function(){
            $anchorNavMenu.slideUp();
        });
    }
});

/**
 * mdサイズの時は電話機能を無効
 */

var preventCall = function (){
  $('.js-preventCall').on('click', function(e){
    e.preventDefault();
  });
}

$(function(){
  if(winSize.isLg() == true){
    preventCall();
  }
});

/**
 * 指定したIDの位置までスムーススクロールで移動
 */

var smoothScroll = function (){
    //固定ナビがある場合はナビの高さ取得
    if( $('.js-anchorNav').length) {
        var navHeight = [];
        $('.js-anchorNav > div').each(function (i, nav){
            navHeight[i] = $(nav).height();
        });
    }

  $('a[href^="#"]').on('click', function(){
    var speed = 500;
    var href= $(this).attr("href");
    var target = $(href == "#" || href == "" ? 'html' : href);

    if( $(target).length < 1 ) return false;
      var position = target.offset().top;
      
    if (sp_flag) {
        position = position - 50;
        console.log(position);
    } else {
    //固定ナビある場合、固定ナビの高さをスクロール量から減らす
    if( $('.js-anchorNav').length) {
        for (i = 0; i<navHeight.length; i++) {
            position = position - navHeight[i];
        }
    }
    }

    $("html, body").animate({scrollTop:position}, speed, "swing");
    return false;
  });
}

$(function(){
  smoothScroll();
});

/**
 * 汎用トグル
 */

var toggle = function (){
  $('.js-toggle').on('click', function(e){
    e.preventDefault();
    $(this).toggleClass('is-show');
    $(this).next().slideToggle();
    return false;
  });
}

$(function(){
  if(winSizeCurrent == 'sm'){
    toggle();
  }
});

/**
 * sp pcトグル movie用
 */

var toggleSpPc = function (){
    $('.js-toggleSpPc').on('click', function(e){
        e.preventDefault();
        $(this).addClass('is-hide');
        $(this).next().slideToggle();
        return false;
    });
}
toggleSpPc();

/**
 * ウィンドウサイズを取得
 */
var winSize = {
    w : '',
    h : '',
    init : function(){
        this.w = window.innerWidth;
        this.h = window.innerHeight;
    },
    isLg : function(){
        return (this.w >= 768 ) ? true : false;
    },
    isSm : function(){
        return (this.w <= 767 ) ? true : false;
    },
};

winSize.init();

var winSizeCurrent ;//最初のウィンドウサイズを判定
if(winSize.isSm() == true){
  winSizeCurrent = 'sm';
}else{
  winSizeCurrent = 'lg';
}




//ウィンドウサイズが768以上から767以下に切り替わった時、または767以下から768以上に切り替わった時に発生するイベント
var initStyles = function (){
  if(winSize.isSm() == true && winSizeCurrent == 'lg'){//767以下に切り替わったとき

    winSizeCurrent = 'sm';
  } else if(winSize.isLg() == true && winSizeCurrent == 'sm'){//768以上に切り替わったとき
    //グロナビ初期化
    $('.js-gNavShow').removeClass('is-close');
    $('.l-gNav').removeAttr('style');
    $('.l-overlay').removeClass('is-show');
    winSizeCurrent = 'lg';
  }
}


var timer = false;
$(window).resize(function() {
    if (timer !== false) {
        clearTimeout(timer);
    }
    timer = setTimeout(function() {
      winSize.init();
      initStyles();
    }, 200);
});

});
