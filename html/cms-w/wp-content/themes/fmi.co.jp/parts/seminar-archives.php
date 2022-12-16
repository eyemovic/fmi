<?php if(have_posts()): ?>
        <div class="seminar_exhibition-post-wrap">
	<?php
    while(have_posts()):
      the_post();
      $post_id = get_the_ID();
      $thumbnail = get_the_post_thumbnail_url( $post_id, 'medium' );
      $category = get_the_terms($post_id, 'seminar-exhibition_category');
      switch($category[0]->slug){
        case 'seminar':
          $cat_name = 'セミナー'; $cat_class="label-seminar";
          break;
        case 'exhibition':
          $cat_name = '展示会'; $cat_class="label-exhibition";
          break;
        case 'stored-seminar':
          $cat_name = 'セミナー'; $cat_class="label-seminar";
          break;
        case 'stored-exhibition':
          $cat_name = '展示会'; $cat_class="label-exhibition";
          break;
      }
      $area = get_the_terms($post_id, 'seminar-exhibition_area');
      $thumbnail = get_the_post_thumbnail_url( $post_id, 'medium' );
  ?>
          <article class="seminar_exhibition-post js-matchHeight">
            <a href="<?php the_permalink(); ?>" class="matchHeight">
              <?php if($thumbnail): ?>
              <div class="seminar_exhibition-thumb"><img src="<?php echo $thumbnail; ?>" alt="<?php echo get_the_title(); ?>"></div>
              <?php endif; ?>
              <div class="seminar_exhibition-post-meta">
                <?php if($category && $category[0]->slug != 'spot'): ?>
                <i class="seminar_exhibition-label <?php echo $cat_class; ?>"><?php echo $cat_name; ?></i>
                <?php endif; ?>
                <i class="seminar_exhibition-area"><?php echo $area[0]->name; ?></i>
              </div>
              <div class="seminar_exhibition-post-desc">
                <div class="seminar_exhibition-post-title"><?php echo get_the_title(); ?></div>
                <div class="seminar_exhibition-post-text"><?php echo wp_trim_words( get_the_content(), 53, '…' ); ?>[続きを読む]</div>
              </div>
            </a>
          </article>
  <?php endwhile;?>
        </div>
        <?php the_posts_pagination(array('mid_size' => 5, 'prev_next' => true, 'prev_text' => __('前へ'), 'next_text' => __('次へ'),'type' => 'array')); ?>
  <?php else: ?>
        <p>まだ投稿がありません</p>
  <?php endif; wp_reset_postdata(); ?>