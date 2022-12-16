<?php
/*====================================================================================
search-recipe.php
====================================================================================*/
  get_header();
  global $wp_query;
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>
<div class="l-contents">
  <main class="l-main is-xs-noPad">
    <div class="l-main-inner">
      <nav class="l-bredNav">
        <ul class="l-bredNav-ul">
          <li class="l-bredNav-list"><a href="/" class="l-bredNav-link">TOP</a></li>
          <li class="l-bredNav-list">レシピ</li>
        </ul>
      </nav>
      <h1 class="l-page-ttl">RECIPE<span>レシピ</span></h1>
      <?php get_template_part('searchform-recipe'); ?>
    </div>
    <section class="recipe-archive">
      <div class="recipe-archive__inner">
	<?php if(have_posts()): ?>
        <h2 class="l-ttl-sm">レシピ検索結果<span class="recipe-archive__postsnum">（全<?php echo $wp_query->found_posts; ?>件　<strong><?php echo $paged; ?></strong>ページ目 / <?php echo $wp_query->max_num_pages; ?>ページ中表示）</span></h2>
        <div class="recipe-archive-list">
	<?php
    while(have_posts()):
      the_post();
      $post_id = get_the_ID();
      $thumbnail = get_the_post_thumbnail_url( $post_id, 'medium' );
      $category = get_the_terms($post_id, 'recipe_category');
      $brands = get_the_terms($post_id, 'recipe_brand');
  ?>
          <article class="recipe-archive-list__item">
            <a href="<?php the_permalink(); ?>">
              <div class="recipe-archive-list__image">
                <img src="<?php echo $thumbnail; ?>" alt="<?php echo get_the_title(); ?>">
              </div>
              <div class="recipe-archive-list__body">
                <h3 class="recipe-archive-list__ttl"><?php echo get_the_title(); ?></h3>
                <div class="recipe-archive-list__tag">
                  <?php if($brands): foreach($brands as $brand): if($brand->name != $category[0]->name): ?>
                  <span><?php echo $brand->name; ?></span>
                  <?php endif; endforeach; endif; ?>
                  <?php if($category): ?>
                  <span><?php echo $category[0]->name; ?></span>
                  <?php endif; ?>
                </div>
              </div>
            </a>
          </article>
  <?php endwhile;?>
        </div>
  <?php the_posts_pagination(array('show_all' => true, 'prev_next' => true, 'prev_text' => __('前へ'), 'next_text' => __('次へ'),'type' => 'array')); ?>
  <?php else: ?>
        <p>まだ投稿がありません</p>
  <?php endif; ?>
      </div>
    </section>
  </main>
</div>
<?php get_footer(); ?>