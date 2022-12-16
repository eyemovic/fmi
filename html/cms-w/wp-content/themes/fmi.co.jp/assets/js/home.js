jQuery(function($){

/*===== slick mv ===== */
  $(function () {
    $slider = $('.hero-slider');
    if($slider.find('.slide-video').length){
      mvSliderVideos($slider);
    }else{
      mvSliderImages($slider);
    }
  });

  function mvSliderImages($slider){
    $slider.slick({
      infinite: true,
      autoplay: true,
      autoplaySpeed: 5000,
      speed: 2000,
      fade: true,
      dots: true,
      appendArrows: '.hero-slider-arrows',
      arrows: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      centerMode: false,
      variableWidth: false,
      responsive: [{
        breakpoint: 768,
        settings: {
          dots: false,
        }
      }]
    });
  }

  function mvSliderVideos($slider){
    let $videoElm = $('.slide-video');
    getVideoSrc($videoElm);
    let video = $videoElm.get(0);
    $slider.slick({
      infinite: true,
      autoplay: true,
      autoplaySpeed: 5000,
      speed: 2000,
      fade: true,
      dots: true,
      appendArrows: '.hero-slider-arrows',
      arrows: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      centerMode: false,
      variableWidth: false,
      responsive: [{
        breakpoint: 768,
        settings: {
          dots: false,
        }
      }]
    });
    $slider.slick('slickPause');
    video.currentTime = 0;
    video.play();
    $(video).on('ended',function() {
      $slider.slick('slickPlay');
      $slider.slick('slickNext');
    });
    $slider.on("beforeChange", function (event, slick, currentSlide, nextSlide) {
      var next = $('.hero-slider [data-slick-index=' + nextSlide + ']');
      if(next.hasClass('hero-slider-item--video')){
        $videoElm = next.find('.slide-video');
        getVideoSrc($videoElm);
        video = $videoElm.get(0);
        $slider.slick('slickPause');
        video.currentTime = 0;
        video.play();
        $(video).on('ended',function() {
          $slider.slick('slickPlay');
          $slider.slick('slickNext');
        });
      }
    });
  }

  function getVideoSrc(elm){
    let $videoSrc;
    if (window.matchMedia('(max-width: 767px)').matches) {
      $videoSrc = elm.find(".slide-video__sp").data('src');
    }else{
      $videoSrc = elm.find(".slide-video__pc").data('src');
    }
    elm.attr('src',$videoSrc);
  }


/*===== slick pickup ===== */

  $('.seminar_exhibition-slider-selected').slick({
    infinite: true,
    autoplay: true,
    autoplaySpeed: 4000,
    speed: 2000,
    dots: false,
    appendArrows: '.seminar_exhibition-slider-selected-arrows',
    arrows: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    centerMode: true,
    variableWidth: true,
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

/*===== slick seminar-exhibition ===== */
  $('.seminar_exhibition-slider').slick({
    infinite: true,
    autoplay: true,
    autoplaySpeed: 4000,
    speed: 2000,
    dots: false,
    appendArrows: '.seminar_exhibition-slider-arrows',
    arrows: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    centerMode: true,
    variableWidth: true,
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

/*===== slick products ===== */
   $('.products-slider').slick({
     infinite: true,
     autoplay: true,
     autoplaySpeed: 4000,
     speed: 2000,
     dots:false,
     appendArrows: '.products-slide-arrows',
     arrows: true,
     slidesToShow: 6,
     slidesToScroll: 6,
     centerMode: false,
     variableWidth: true,
      responsive: [{
      breakpoint: 768,
        settings: {
          slidesToShow: 2,
          centerMode: false,
          slidesToScroll: 2,
          variableWidth: true,
      }
    }]
   });

/*===== matchHeight ===== */
  $('.matchHeight').matchHeight();

});