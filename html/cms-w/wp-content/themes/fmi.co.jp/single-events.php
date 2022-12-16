<?php
/*====================================================================================
single-recipe.php
====================================================================================*/
?>
<?php
  get_header();
  global $post;
?>
<div class="l-contents">
  <main class="l-main is-xs-noPad">
    <div class="l-main-inner">
      <nav class="l-bredNav">
        <ul class="l-bredNav-ul">
          <li class="l-bredNav-list"><a href="/" class="l-bredNav-link">TOP</a></li>
          <li class="l-bredNav-list"><a href="/recipe/" class="l-bredNav-link">イベント</a></li>
          <li class="l-bredNav-list"><?php echo get_the_title(); ?></li>
        </ul>
      </nav>
    </div>
  </main>
</div>
<?php get_footer(); ?>