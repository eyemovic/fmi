<?php
/*====================================================================================
archive-news.php
====================================================================================*/
?>
<?php
  get_header();
?>
<div class="l-contents">
  <main class="l-main is-xs-noPad">
    <div class="l-main-inner">
      <nav class="l-bredNav">
        <ul class="l-bredNav-ul">
          <li class="l-bredNav-list"><a href="/" class="l-bredNav-link">TOP</a></li>
          <li class="l-bredNav-list">ニュース</li>
        </ul>
      </nav>
      <h1 class="l-page-ttl">NEWS<span>ニュース</span></h1>
      <section>
        <h2 class="l-ttl-sm">最新情報一覧</h2>
        <nav class="l-pageNav l-pageNav-v2 u-mb-md-40">
          <ul class="l-pageNav-ul">
            <li class="l-pageNav-list"><a href="/news/" class="l-pageNav-link is-current"><span>ALL</span></a></li>
            <li class="l-pageNav-list"><a href="/news/exhibition/" class="l-pageNav-link"><span>展示会</span></a></li>
            <li class="l-pageNav-list"><a href="/news/seminar/" class="l-pageNav-link"><span>セミナー</span></a></li>
            <li class="l-pageNav-list"><a href="/news/products/" class="l-pageNav-link"><span>製品情報</span></a></li>
            <li class="l-pageNav-list"><a href="/news/information/" class="l-pageNav-link"><span>インフォメーション</span></a></li>
          </ul>
        </nav>
<?php include('parts/news-archives.php'); ?>
      </section>
    </div>
  </main>

</div>
<?php get_footer(); ?>