/*
* hero slider
*/

// $(function () {
//   $slider = $('.hero-slider');
//   if (window.matchMedia('(max-width: 767px)').matches) {
//     var video = $(".slide-video--sp").get(0);
//   }else{
//     var video = $(".slide-video--pc").get(0);
//   }
//   $slider.slick({
//     infinite: true,
//     autoplay: true,
//     autoplaySpeed: 5000,
//     speed: 2000,
//     fade: true,
//     dots: true,
//     appendArrows: '.hero-slider-arrows',
//     arrows: true,
//     slidesToShow: 1,
//     slidesToScroll: 1,
//     centerMode: false,
//     variableWidth: false,
//     responsive: [{
//       breakpoint: 768,
//       settings: {
//         dots: false,
//       }
//     }]
//   });
//   $slider.slick('slickPause');
//   video.currentTime = 0;
//   video.play();
//   $(video).on('ended',function() {
//     $slider.slick('slickPlay');
//     $slider.slick('slickNext');
//   });
//   $slider.on("beforeChange", function (event, slick, currentSlide, nextSlide) {
//     console.log(nextSlide);
//     var next = $('.hero-slider [data-slick-index=' + nextSlide + ']');
//     if(next.hasClass('video')){
//       if (window.matchMedia('(max-width: 767px)').matches) {
//         video = next.find(".slide-video--sp").get(0);
//         console.log(video);
//       }else{
//         video = next.find(".slide-video--pc").get(0);
//         console.log(video);
//       }
//       $slider.slick('slickPause');
//       video.currentTime = 0;
//       video.play();
//       $(video).on('ended',function() {
//         $slider.slick('slickPlay');
//         $slider.slick('slickNext');
//       });
//     }
//   });



$(function(){
  $slider = $('.hero-slider');
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


  //  // セミナー・展示会
  $('.seminar_exhibition-slider-selected').slick({
    infinite: true,
    autoplay: true,
    autoplaySpeed: 4000,
    speed: 2000,
    // fade: true,
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
    // onSlideAfter: function($slideElement, oldIndex, newIndex) {
    //    var targetElm = $slideElement;
    // }
  });
  
  // セミナー・展示会
  $('.seminar_exhibition-slider').slick({
    infinite: true,
    autoplay: true,
    autoplaySpeed: 4000,
    speed: 2000,
    // fade: true,
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
    // onSlideAfter: function($slideElement, oldIndex, newIndex) {
    //    var targetElm = $slideElement;
    // }
  });

   // 製品情報
   $('.products-slider').slick({
     infinite: true,
     autoplay: true,
     autoplaySpeed: 4000,
     speed: 2000,
     // fade: true,
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
     // onSlideAfter: function($slideElement, oldIndex, newIndex) {
     //    var targetElm = $slideElement;
     // }
   });

   $('.matchHeight').matchHeight();

});
