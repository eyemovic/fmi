<?php
/*====================================================================================
共通ヘッダー（英）
====================================================================================*/
?>
<!DOCTYPE html>
<html lang="en">
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
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/lib/jquery-3.2.1.min.js"></script>
<?php wp_head(); ?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/styles.css<?php echo '?' . filemtime( get_template_directory() . '/assets/css/styles.css'); ?>">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/overview_en.css<?php echo '?' . filemtime( get_template_directory() . '/assets/css/overview_en.css'); ?>">
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
<body id="pagetop" class="is-home">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NQN7CNK" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v13.0" nonce="YGzFA4xm"></script>
<div id="wrapper" class="l-wrapper">
  <header class="l-header">
    <!-- <p class="l-header_tel">0120-080-478</p> -->
    <p class="l-header_logo"><a href="/"><img src="/assets/images/common/logo.svg" alt="FMI" width="70"></a></p>
    <p class="l-header_nav">
      <a class="l-header_navTrg js-gNavShow" href="javascript:void(0);"><span></span></a>
    </p>
  </header>
  <nav class="l-gNav">
    <div class="l-gNav_inner">
      <ul class="l-gNav_main">
        <li class="l-gNav_mainItem"><a href="/corporate_en/">Overview</a></li>
        <li class="l-gNav_mainItem"><a href="/corporate_en/history/">History</a></li>
        <li class="l-gNav_mainItem"><a href="/corporate_en/location/">Location</a></li>
      </ul>
      <div class="l-gNav_sub">
        <ul class="l-gNav_lng">
          <li><a class="l-gNav_lngItem" href="/">JA</a></li>
          <li><a class="l-gNav_lngItem current" href="/corporate_en/">EN</a></li>
        </ul>
      </div>
    </div>
  </nav>