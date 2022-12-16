<?php
/*
Template Name: ミキサーブレンダーナビ
Template Post Type: products
*/
  get_header();
  $post_id = get_the_ID();
?>
<div class="l-contents">
  <main class="l-main is-xs-noPad">
    <div class="l-main-inner">
      <nav class="l-bredNav">
        <ul class="l-bredNav-ul">
          <li class="l-bredNav-list"><a href="/" class="l-bredNav-link">TOP</a></li>
          <li class="l-bredNav-list"> <?php echo get_the_title(); ?></li>
        </ul>
      </nav>
      <?php the_content(); ?>
    </div>
  </main>
</div>
<?php get_footer(); ?>
