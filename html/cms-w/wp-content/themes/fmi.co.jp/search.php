<?php
/*====================================================================================
search.php
====================================================================================*/

  //親子ページテンプレートを探す
  global $wp_query;
  $search_query = get_search_query();
  get_header();
  $results_total = $wp_query->found_posts;
  $results = $wp_query->posts;
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>
<div class="l-contents">
  <main class="l-main is-xs-noPad">
    <div class="l-main-inner">
      <h1 class="l-page-ttl">Search<span>検索結果</span></h1>
      <section class="search-result">
<?php if($search_query): ?>
        <h2 class="l-ttl-sm">「<?php echo esc_attr($search_query); ?>」の検索結果<span class="recipe-archive__postsnum">（全<?php echo $wp_query->found_posts; ?>件　<strong><?php echo $paged; ?></strong>ページ目 / <?php echo $wp_query->max_num_pages; ?>ページ中表示）</span></h2>
  <?php if(have_posts()): ?>
        <ul class="search-result-list">
    <?php while(have_posts()): the_post();
      $parent_id = $post->post_parent;
      $posttype = get_post_type_object($post->post_type)->label;
      $thumbnail = get_the_post_thumbnail_url( $post->ID, 'thumbnail' );
    ?>
        <li class="search-result-list__item">
          <a href="<?php the_permalink(); ?>">
            <?php if($thumbnail): ?><div class="search-result-list__thumbnail"><img src="<?php echo $thumbnail; ?>"></div><?php endif; ?>
            <div class="search-result-list__body">
              <?php if($posttype != '固定ページ' && $parent_id): ?>
                <div class="search-result-list__posttype"><span><?php echo esc_html($posttype); ?></span><span><?php echo esc_html(get_post($parent_id)->post_title); ?></span></div>
              <?php elseif($posttype != '固定ページ'): ?>
                <div class="search-result-list__posttype"><span><?php echo esc_html($posttype); ?></span></div>
              <?php elseif($posttype == '固定ページ' && $parent_id): ?>
                <div class="search-result-list__posttype"><span><?php echo esc_html(get_post($parent_id)->post_title); ?></span></div>
              <?php elseif($posttype == '固定ページ' && !$parent_id): ?>
                <div class="search-result-list__posttype"><span><?php echo get_the_title(); ?></span></div>
              <?php endif; ?>
              <p class="search-result-list__ttl"><?php echo get_the_title(); ?></p>
              <p class="search-result-list__url"><?php echo get_the_permalink(); ?></p>
            </div>
          </a>
        </li>
    <?php endwhile; ?>
        </ul>
        <?php the_posts_pagination(array('show_all' => true, 'prev_next' => true, 'prev_text' => __('前へ'), 'next_text' => __('次へ'),'type' => 'array')); ?>
  <?php else: ?>
        <p>検索結果が見つかりませんでした。</p>
  <?php endif; ?>
<?php else: ?>
        <p>検索キーワードを指定して、再検索してください。</p>
<?php endif; ?>
      </section>
    </div>
  </main>
</div>
<?php get_footer(); ?>