<?php
/*====================================================================================
404.php
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
          <li class="l-bredNav-list">お探しのページは見つかりませんでした</li>
        </ul>
      </nav>
      <h1 class="l-page-ttl">404 NOT FOUND</h1>
      <p class="l-ttl-md l-ttl-md--404">お探しのページは見つかりませんでした</p>
      <p class="l-txt u-ta-center u-mb-xs-20 u-mb-md-30">お探しのページが見つかりませんでした。<br>URLが間違っているか、ページが存在しません。<br>下のリンクや検索からお探しください。</p>
      <div class="error404-search u-mb-xs-40 u-mb-md-60">
        <div id="srchBox" class=" watermark">
          <script async src="https://cse.google.com/cse.js?cx=016533161740608887884:ny0d83hgxye"></script>
          <div class="gcse-search" style="margin: 0 auto;"></div>
          </div>
      </div>
      <p class="u-ta-center">
        <a href="/" class="l-link-ttl">トップ</a>
      </p>
    </div>
  </main>
</div>
<?php get_footer(); ?>