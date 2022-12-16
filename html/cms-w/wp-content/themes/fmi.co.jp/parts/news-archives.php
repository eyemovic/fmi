        <div class="news-index">
	<?php if(have_posts()): ?>
          <ul class="l-item-conts u-mb-xs-20 u-mb-md-40">
	<?php
    while(have_posts()):
      the_post();
      $post_id = get_the_ID();
      $thumbnail = get_the_post_thumbnail_url( $post_id, 'medium' );
      $cateogries = get_the_terms($post_id, 'news_category');
  ?>
            <li class="l-item">
              <a href="<?php echo get_the_permalink(); ?>">
                <p class="l-item-img"><img src="<?php echo $thumbnail; ?>" alt="<?php echo get_the_title(); ?>"></p>
                <div class=" index-post-meta news-index-post-meta u-mb-xs-15">
                  <?php if($cateogries): foreach($cateogries as $category): ?>
                  <i class="index-post-label label-<?php echo $category->slug; ?>"><?php echo $category->name; ?></i>
                  <?php endforeach; endif; ?>
                  <div class="index-post-time-wrap">
                    <time class="index-post-time"><?php echo get_the_date('Y.m.d'); ?></time>
                  </div>
                </div>
                <p class="l-item-ttl"><?php echo get_the_title(); ?></p>
              </a>
            </li>
  <?php endwhile;?>
          </ul>
          <?php the_posts_pagination(array('show_all' => true, 'prev_next' => true, 'prev_text' => __('前へ'), 'next_text' => __('次へ'),'type' => 'array')); ?>
  <?php else: ?>
        <p>まだ投稿がありません</p>
  <?php endif; ?>
        </div>