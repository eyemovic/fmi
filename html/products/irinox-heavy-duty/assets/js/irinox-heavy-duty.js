jQuery(function($){
  $('.irinoxLP-works-list').slick({
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 5000,
    arrows: true
  });
  $('.irinoxLP-trolley-spec').slick({
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 5000,
    arrows: true
  });
  $(function(){
    if ($('[class*=animate]').length) {
      scrollAnimation();
    }
    function scrollAnimation() {
      $(window).scroll(function () {
        $('[class*=animate]').each(function () {
          let position = $(this).offset().top,
          scroll = $(window).scrollTop(),
          windowHeight = $(window).height();
          if (scroll > position - windowHeight + 200) {
            $(this).addClass('--animated');
          }
        });
      });
    }
    $(window).trigger('scroll');
  });
});