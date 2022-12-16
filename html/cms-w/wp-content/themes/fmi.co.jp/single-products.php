<?php
/*====================================================================================
single-products.php
====================================================================================*/
  global $post;
  if ($post->post_parent) {
    $parent = get_post($post->post_parent);
  }
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
<?php if(have_posts()): the_post(); ?>
<?php the_content(); ?>
<?php endif; ?>
    </div>
  </main>
</div>
<?php get_footer(); ?>