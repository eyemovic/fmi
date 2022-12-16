<?php
/*====================================================================================
mec_label.php
====================================================================================*/
  get_header();
  global $wp_query;
  $page = get_query_var( 'paged' );
  $seminar_category = get_terms('mec_label',array('hide_empty' => false));
  $term = get_queried_object();
?>
<div class="l-contents">
  <main class="l-main is-xs-noPad">
    <div class="l-main-inner l-main-inner--seminar-index">
      <nav class="l-bredNav">
        <ul class="l-bredNav-ul">
          <li class="l-bredNav-list"><a href="/" class="l-bredNav-link">TOP</a></li>
          <li class="l-bredNav-list">セミナー / 展示会情報</li>
        </ul>
      </nav>
      <h1 class="l-page-ttl l-page-ttl--seminar-exhibition">SEMINAR / EXHIBITION<span>セミナー / 展示会情報【MECカレンダー版】</span></h1>
      <div class="l-anchorNav-wrap">
        <nav class="l-anchorNav js-anchorNav">
          <div class="l-anchorNav-inner">
            <button class="l-anchorNav-btn js-anchorNavBtn">選択</button>
            <ul class="l-anchorNav-ul">
              <li class="l-anchorNav-list"><a href="#01" class="l-anchorNav-link">セミナー / 展示会情報一覧</a></li>
              <li class="l-anchorNav-list"><a href="#02" class="l-anchorNav-link">FMIのセミナーについて</a></li>
              <li class="l-anchorNav-list"><a href="#03" class="l-anchorNav-link">展示会について</a></li>
              <li class="l-anchorNav-list"><a href="#04" class="l-anchorNav-link">バーチャルショールーム</a></li>
            </ul>
          </div>
        </nav>
      </div>
    </div>
    <section class="l-seminar-gr-section" id="01">
      <div class="l-seminar-inner">
        <h2 class="l-ttl-sm">セミナー / 展示会情報一覧</h2>
        <nav class="l-pageNav l-pageNav-v2">
          <ul class="l-pageNav-ul">
            <li class="l-pageNav-list"><a href="/events/" class="l-pageNav-link"><span>ALL</span></a></li>
            <?php if($seminar_category): foreach($seminar_category as $sem_cat): if($sem_cat->slug != 'spot'): ?>
            <li class="l-pageNav-list"><a href="/events/<?php echo $sem_cat->slug; ?>/" class="l-pageNav-link<?php if($term->slug == $sem_cat->slug) echo " is-current"; ?>"><span><?php echo $sem_cat->name; ?></span></a></li>
            <?php endif; endforeach; endif; ?>
          </ul>
        </nav>
<?php include('parts/seminar-archives-mec.php'); ?>
      </div>
    </section>
    <div class="index-calenderarea-wrap" id="02">
      <div class="index-calenderarea">
        <?php echo do_shortcode('[MEC id="8456"]'); ?>
      </div>
    </div>
    <section class="l-seminar-section" id="03">
      <div class="l-seminar-inner">
        <h2 class="l-ttl-sm">展示会について</h2>
        <div class="about-exhibitor-hero"><img src="/assets/images/seminar-exhibition/index/about_exhibition.jpg" alt=""></div>
        <div class="l-txt">製品の魅力をお伝えする場として、展示会に多数出展しています。<br>
          製品説明はもちろん、効果的な活用方法を実演とともにご提案します。<br>
        出展情報は随時更新しますので、ご興味をお持ちの方は、是非展示会にお越しください。</div>
      </div>
    </section>
    <div class="consulting-banner l-seminar-inner">
      <a href="/consulting/">
        <img src="/assets/images/seminar-exhibition/index/bnr_consulting.jpg" alt="FMIアクティブコンサルサポートスタッフ">
      </a>
    </div>
    <div class="consulting-banner l-seminar-inner" id="04">
        <h2 class="l-ttl-sm">バーチャルショールーム</h2>
      <a href="/virtual/index.html">
        <img src="/assets/images/virtual/banner_virtualshowroom.jpg" alt="FMI バーチャルショールーム">
      </a>
    </div>
  </main>
</div>
<?php get_footer(); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js" type="text/javascript"></script>