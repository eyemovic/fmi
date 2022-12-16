<?php
/*====================================================================================
page-aftermaintenance.php
====================================================================================*/
  global $post;
  get_header();
?>
<div class="l-contents">
  <main class="l-main is-xs-noPad">
    <div class="l-main-inner">
      <nav class="l-bredNav">
        <ul class="l-bredNav-ul">
          <li class="l-bredNav-list"><a href="/" class="l-bredNav-link">TOP</a></li>
          <?php if($parent): ?>
          <li class="l-bredNav-list"><a href="/<?php echo $parent->post_name; ?>" class="l-bredNav-link"><?php echo $parent->post_title; ?></a></li>
          <?php endif; ?>
          <li class="l-bredNav-list"><?php the_title(); ?></li>
        </ul>
      </nav>
      <h1 class="l-page-ttl">Support<span>お客様サポート</span></h1>
      <p class="l-ttl-md">FMIのアフターサービスネットワーク</p>
      <p class="l-txt-sm u-mb-xs-20 u-mb-md-30">全国にサービスマンが常駐し、メンテナンスや保守点検に至るまで、万全の体制でお客様をバックアップします。</p>
      <div class="l-mainConts">
<?php if(have_posts()): the_post(); ?>
<?php the_content(); ?>
<?php endif; ?>
      </div>
    </div>
  </main>
</div>
<?php get_footer(); ?>