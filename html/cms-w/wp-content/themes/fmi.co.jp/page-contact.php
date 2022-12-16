<?php
/*====================================================================================
page-contact.php
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
      <h1 class="l-page-ttl">CONTACT<span>電話でのお問い合わせ</span></h1>
      <div class="l-mainConts">
<?php if(have_posts()): while(have_posts()):the_post(); ?>
<?php the_content(); ?>
<?php endwhile; endif; ?>
      </div>
    </div>
  </main>
</div>
<?php get_footer(); ?>