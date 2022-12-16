<?php
/*====================================================================================
共通ヘッダー
====================================================================================*/
if(is_search()){
  $search_query = get_search_query();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<script type="text/javascript">
var ua = navigator.userAgent.toLowerCase();
if ((ua.indexOf('iphone') > 0 && ua.indexOf('ipad') == -1) || ua.indexOf('ipod') > 0 || (ua.indexOf('android') > 0 && ua.indexOf('mobile') > 0)) {
    document.write('<meta name="viewport" content="width=device-width, initial-scale=1.0">');
} else {
    document.write('<meta name="viewport" content="width=1080">');
}
</script>
<link rel="shortcut icon" href="/assets/images/favicon.ico" type="image/vnd.microsoft.icon">
<link rel="icon" href="/assets/images/favicon.ico" type="image/vnd.microsoft.icon">
<link rel="apple-touch-icon" href="/assets/images/home-icon.png">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css<?php echo '?' . filemtime( get_template_directory() . '/style.css'); ?>">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700">
<?php if(is_single('irinox-heavy-duty')): ?>
<link rel="preload" href="/products/irinox-heavy-duty/assets/images/mv-image.webp" as="image" media="(min-width: 768px)">
<link rel="preload" href="/products/irinox-heavy-duty/assets/images/mv-image-sp.webp" as="image" media="(max-width: 767px)">
<link rel="preload" href="/products/irinox-heavy-duty/assets/images/mv-bg.webp" as="image">
<link rel="stylesheet" href="/products/irinox-heavy-duty/assets/css/irinox-lp.min.css">
<?php endif; ?>
<?php wp_head(); ?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/styles.css<?php echo '?' . filemtime( get_template_directory() . '/assets/css/styles.css'); ?>">
<!-- SMP Tracking Tag Ver 3 -->
<script type="text/javascript">
<!--
if(typeof _cam !== 'function') {
(function(n){
var w = window, d = document;
w['ShanonCAMObject'] = n, w[n] = w[n] || function(){(w[n].q=w[n].q||[]).push(arguments)};
w[n].date = 1*new Date();
var e = d.createElement('script'), t = d.getElementsByTagName('script')[0];
e.async = 1, e.type='text/javascript', e.charset='utf-8', e.src = 'https://tracker.shanon-services.com/static/js/cam3.js' + "?_=" + w[n].date;
t.parentNode.insertBefore(e,t);
})('_cam');

_cam('create', 'jWFZQUEpsl-635');
}

_cam('send');
//-->
</script>
<!-- Google Tag Manager -->
<script>(function (w, d, s, l, i) {
    w[l] = w[l] || []; w[l].push({
        'gtm.start':
            new Date().getTime(), event: 'gtm.js'
    }); var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-NQN7CNK');</script>
<!-- End Google Tag Manager -->
</head>
<?php if(is_home() || is_front_page()): ?>
<body id="pagetop" class="is-home">
<?php elseif(is_post_type_archive('movie')): ?>
<body id="pagetop" class="is-movie">
<?php elseif(is_post_type_archive('products') || is_single(array('category','brand','list'))): ?>
<body id="pagetop" class="is-products">
<?php elseif(is_singular('casestudy')): ?>
<body id="pagetop" class="is-casestudy">
<?php elseif(is_page_template('tmp-products-lp.php')): $lp_class = get_field('product_lp_class', $post_id); ?>
<body id="pagetop" class="is-lp-<?php echo $lp_class; ?> is-lp-brand">
<?php else: ?>
<body id="pagetop">
<?php endif; ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NQN7CNK" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v13.0" nonce="YGzFA4xm"></script>
<div id="wrapper" class="l-wrapper">
  <div class="l-header-wrap">
    <header class="l-header">
      <div class="l-gNav_subItem search_trg search_trg2">
        <a class="js-search_trg" href="#"></a>
      </div>
      <p class="l-header_logo"><a href="/"><img src="/assets/images/common/logo.svg" alt="FMI" width="70"></a></p>
      <p class="l-header_nav">
        <a class="l-header_navTrg js-gNavShow" href="javascript:void(0);"><span></span></a>
      </p>
    </header>
    <nav class="l-gNav">
      <div class="l-gNav_inner">
<?php
  $gnav = wp_get_nav_menu_object('header_gnav');
  if($gnav):
    $gnav_items = wp_get_nav_menu_items($gnav->term_id);
?>
        <ul class="l-gNav_main">
<?php foreach($gnav_items as $gnav_item): ?>
          <li class="l-gNav_mainItem"><a href="<?php echo $gnav_item->url; ?>"><?php echo $gnav_item->title; ?></a></li>
<?php endforeach; ?>
        </ul>
<?php endif; ?>
        <div class="l-gNav_sub l-gNav_sub2">
          <ul class="l-gNav_lng l-gNav_lng2">
            <li><a class="l-gNav_lngItem current" href="/">JA</a></li>
            <li><a class="l-gNav_lngItem" href="/corporate_en/">EN</a></li>
          </ul>
          <div id="srchBox" class="l-gNav_subItem l-gNav_search l-gNav_search2 watermark">
            <!-- <script async src="https://cse.google.com/cse.js?cx=016533161740608887884:ny0d83hgxye"></script>
            <div class="gcse-search"></div> -->
            <form method="GET" action="<?php echo home_url('/'); ?>" class="global-search">
              <input name="s" type="text" class="global-search__input" placeholder="検索キーワードを入力" value="<?php echo esc_attr($search_query); ?>">
              <input type='hidden' value='8501' name='wpessid' />
              <button type="submit" class="global-search__btn"></button>
            </form>
          </div>
          <!-- /#srchBox -->
          <div class="l-gNav_subItem l-gNav_btn l-gNav_btn2 phone u-hidden-u-md">
            <a href="/contact/"><i class="icn_mail"></i>お電話での問い合わせ</a>
          </div>
          <div class="l-gNav_subItem l-gNav_btn l-gNav_btn2 ">
            <a class="btn btn-search" href="https://fmi.smktg.jp/public/application/add/365"><i class="icn_mail"></i>メールでのお問い合わせ</a>
          </div>
          <div class="l-gNav_subItem l-gNav_btn l-gNav_btn2 phone u-hidden-o-md">
            <a href="/contact/"><span class="phoneico">お電話での問い合わせ</span></a>
          </div>
        </div>
      </div>
    </nav>
  </div>
