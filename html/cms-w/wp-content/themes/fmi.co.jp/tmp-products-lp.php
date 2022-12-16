<?php
/*
Template Name: 製品ページ（LP）
Template Post Type: products
*/
  get_header();
  $post_id = get_the_ID();
  $lp_class = get_field('product_lp_class', $post_id);
?>
<div class="l-contents" id="lp-<?php echo $lp_class; ?>">
  <main class="l-main is-xs-noPad">
    <div class="lp-header">
      <nav class="l-bredNav">
        <ul class="l-bredNav-ul">
          <li class="l-bredNav-list"><a href="/" class="l-bredNav-link">TOP</a></li>
          <li class="l-bredNav-list"><a href="/products/" class="l-bredNav-link"> 製品情報</a></li>
          <li class="l-bredNav-list"> <?php echo get_the_title(); ?></li>
        </ul>
      </nav>
    </div>
    <?php the_content(); ?>
  </main>
</div>
<?php get_footer(); ?>
