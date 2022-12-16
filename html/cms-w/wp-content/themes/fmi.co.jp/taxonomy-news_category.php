<?php
/*====================================================================================
taxonomy-news_category.php
====================================================================================*/
?>
<?php
  get_header();
  $news_categories = get_terms('news_category',array('hide_empty'=>0));
  $term = get_queried_object();
?>
<div class="l-contents">
  <main class="l-main is-xs-noPad">
    <div class="l-main-inner">
      <nav class="l-bredNav">
        <ul class="l-bredNav-ul">
          <li class="l-bredNav-list"><a href="/" class="l-bredNav-link">TOP</a></li>
          <li class="l-bredNav-list"><a href="/news" class="l-bredNav-link">ニュース</a></li>
          <li class="l-bredNav-list"><?php echo $term->name; ?></li>
        </ul>
      </nav>
      <h1 class="l-page-ttl">NEWS<span>ニュース</span></h1>
      <section>
        <h2 class="l-ttl-sm">最新情報一覧</h2>
        <nav class="l-pageNav l-pageNav-v2 u-mb-md-40">
          <ul class="l-pageNav-ul">
            <li class="l-pageNav-list"><a href="/news/" class="l-pageNav-link"><span>ALL</span></a></li>
            <?php foreach($news_categories as $news_cat): ?>
            <li class="l-pageNav-list"><a href="/news/<?php echo $news_cat->slug; ?>/" class="l-pageNav-link<?php if($term->slug == $news_cat->slug) echo " is-current"; ?>"><span><?php echo $news_cat->name; ?></span></a></li>
            <?php endforeach; ?>
          </ul>
        </nav>
<?php include('parts/news-archives.php'); ?>
      </section>
    </div>
  </main>
</div>
<?php get_footer(); ?>