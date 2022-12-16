<?php
/*====================================================================================
single-casestudy.php
====================================================================================*/
  get_header();
  global $post;
  $post_id = $post->ID;
  $keyvisual = get_field('case_keyvisual', $post_id);
?>
<div class="l-contents">
  <main class="l-main is-xs-noPad">
    <div class="l-main-inner">
      <nav class="l-bredNav">
        <ul class="l-bredNav-ul">
          <li class="l-bredNav-list"><a href="/" class="l-bredNav-link">TOP</a></li>
          <li class="l-bredNav-list"><a href="/casestudy" class="l-bredNav-link">導入事例</a></li>
          <li class="l-bredNav-list"><?php echo get_the_title(); ?></li>
        </ul>
      </nav>
      <h1 class="l-page-ttl">CASE STUDY<span>導入事例</span></h1>
      <?php if($keyvisual): ?>
      <div class="casestudy-hero">
        <p style="background-image: url(<?php echo $keyvisual['url']; ?>);" class="casestudy-hero_img"></p>
      </div>
      <?php endif; ?>
      <section>
<?php if(have_posts()): the_post(); the_content(); endif; ?>
      </section>
    </div>
  </main>
</div>
<?php get_footer(); ?>