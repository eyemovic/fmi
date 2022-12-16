<?php
/*====================================================================================
index.php
====================================================================================*/
global $template;
if(!is_home() || !is_front_page()){
  echo basename($template);
}
?>
<?php get_header(); ?>
<div class="l-contents">
  <main class="l-main is-xs-noPad">
    <div class="hero">
      <div class="hero-slider-arrows-area">
        <div class="hero-slider-arrows"></div>
      </div>
      <ul class="hero-slider">
<?php
  $arg = array('posts_per_page' => -1, 'post_type' => 'slider', 'order' => 'ASC', 'post_status' => 'publish');
  $slider_items = new WP_Query($arg);
  if($slider_items->have_posts()):
    while($slider_items->have_posts()):
      $slider_item = $slider_items->the_post();
      $metas = array('slider_image_pc','slider_image_sp','slider_url','slider_movie_pc','slider_movie_sp','slider_url_blank');
      $meta = array();
      foreach($metas as $key){
        $meta[$key] = get_field($key, $slider_item->ID);
      }
?>
  <?php if($meta['slider_movie_pc'] && $meta['slider_movie_sp']):
    $ext_pc = substr($meta['slider_movie_pc'], strrpos($meta['slider_movie_pc'], '.') + 1);
    $ext_sp = substr($meta['slider_movie_sp'], strrpos($meta['slider_movie_sp'], '.') + 1);
  ?>
        <li class="hero-slider-item hero-slider-item--video">
          <div class="hero-contents">
            <?php if($meta['slider_url']): ?><a href="<?php echo $meta['slider_url']; ?>"<?php if($meta['slider_url_blank']) echo ' target="_blank"';?> class="slider_link" id="slider_<?php echo $post->post_name; ?>" data-slider-name="<?php echo $post->post_title; ?>"><?php endif; ?>
              <video class="slide-video" autoplay muted playsinline preload="metadata">
                <source type="video/<?php echo $ext_pc; ?>" data-src="<?php echo $meta['slider_movie_pc']; ?>" class="slide-video__pc">
                <source type="video/<?php echo $ext_sp; ?>" data-src="<?php echo $meta['slider_movie_sp']; ?>" class="slide-video__sp">
              </video>
            <?php if($meta['slider_url']): ?></a><?php endif; ?>
          </div>
        </li>
  <?php else: ?>
        <li class="hero-slider-item">
          <div class="hero-contents">
            <?php if($meta['slider_url']): ?><a href="<?php echo $meta['slider_url']; ?>"<?php if($meta['slider_url_blank']) echo ' target="_blank"';?> class="slider_link" id="slider_<?php echo $post->post_name; ?>" data-slider-name="<?php echo $post->post_title; ?>"><?php endif; ?>
              <picture>
                <source media="(min-width: 768px)" srcset="<?php echo $meta['slider_image_pc']; ?>">
                <img src="<?php echo $meta['slider_image_sp']; ?>" alt="<?php echo get_the_title(); ?>">
              </picture>
            <?php if($meta['slider_url']): ?></a><?php endif; ?>
          </div>
        </li>
  <?php endif; ?>
<?php endwhile; endif; wp_reset_postdata(); ?>
      </ul>
    </div>
    <section class="index-gr-section">
      <div class="l-index-inner">
        <h2 class="l-page-ttl l-page-ttl--index">PICKUP<span>ピックアップ / おすすめ</span></h2>
      </div>
      <div class="index-section-small">
        <div class="content-slider-wrap">
          <div class="seminar_exhibition-slider-arrows-area">
            <div class="seminar_exhibition-slider-selected-arrows"></div>
          </div>
          <ul class="seminar_exhibition-slider-selected">
<?php
  $current_date = wp_date('Ymd');
  $arg = array(
    'posts_per_page' => 3,
    'post_type' => 'seminar-exhibition',
    'post_status' => 'publish',
    'orderby' => 'meta_value',
    'order' => 'ASC',
    'meta_key' => 'seminar_date_start',
    'type' => 'DATEVALUE',
    'meta_query' => array(
      'relation' => 'AND',
      array(
        'key' => 'seminar_date_start',
        'value' => $current_date,
        'compare' => '>=',
        'type' => 'DATE'
      ),
      array(
        'key' => 'seminar_flag_pickup',
        'value' => 1,
        'compare' => '='
      )
    ),
    'tax_query' => array(
      'relation' => 'AND',
      array(
        'taxonomy' => 'seminar-exhibition_category',
        'field' => 'slug',
        'terms' => array('stored-seminar','stored-exhibition'),
        'operator' => 'NOT IN'
      ),
      array(
        'taxonomy' => 'seminar-exhibition_status',
        'field' => 'slug',
        'terms' => array('finished','full'),
        'operator' => 'NOT IN'
      )
    )
  );
  $pickupseminar_items = new WP_Query($arg);
  if($pickupseminar_items->have_posts()):
    while($pickupseminar_items->have_posts()):
      $pickupseminar_item = $pickupseminar_items->the_post();
      $post_id = $pickupseminar_item->ID;
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
?>
            <li class="seminar_exhibition-slider__item">
              <article class="seminar_exhibition-post">
                <a href="<?php the_permalink(); ?>" class="matchHeight">
                  <div class="seminar_exhibition-thumb"><img src="<?php echo $thumbnail; ?>" alt="<?php echo get_the_title(); ?>"></div>
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
            </li>
<?php endwhile; endif; wp_reset_postdata(); ?>
          </ul>
        </div>
      </div>

      <div class="l-index-inner">
        <h2 class="l-page-ttl l-page-ttl--index">SEMINAR / EXHIBITION<span>セミナー / 展示会情報</span></h2>
      </div>
      <div class="index-section-small">
        <div class="content-slider-wrap">
          <div class="seminar_exhibition-slider-arrows-area">
            <div class="seminar_exhibition-slider-arrows"></div>
          </div>
          <ul class="seminar_exhibition-slider">
<?php
  $arg = array(
    'posts_per_page' => 7,
    'post_type' => 'seminar-exhibition',
    'post_status' => 'publish',
    'orderby' => 'meta_value',
    'order' => 'ASC',
    'meta_key' => 'seminar_date_start',
    'type' => 'DATEVALUE',
    'meta_query' => array(
      'relation' => 'AND',
      array(
        'key' => 'seminar_date_start',
        'value' => $current_date,
        'compare' => '>=',
        'type' => 'DATE'
      )
    ),
    'tax_query' => array(
      'relation' => 'AND',
      array(
        'taxonomy' => 'seminar-exhibition_category',
        'field' => 'slug',
        'terms' => array('stored-seminar','stored-exhibition'),
        'operator' => 'NOT IN'
      ),
      array(
        'taxonomy' => 'seminar-exhibition_status',
        'field' => 'slug',
        'terms' => array('finished','full'),
        'operator' => 'NOT IN'
      )
    )
  );
  $seminar_items = new WP_Query($arg);
  if($seminar_items->have_posts()):
    while($seminar_items->have_posts()):
      $seminar_item = $seminar_items->the_post();
      $post_id = $seminar_item->ID;
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
?>
            <li class="seminar_exhibition-slider__item">
              <article class="seminar_exhibition-post">
                <a href="<?php the_permalink(); ?>" class="matchHeight">
                  <div class="seminar_exhibition-thumb"><img src="<?php echo $thumbnail; ?>" alt="<?php echo get_the_title(); ?>"></div>
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
            </li>
<?php endwhile; endif; wp_reset_postdata(); ?>
          </ul>
        </div>
        <a href="/seminar-exhibition/" class="l-button">セミナー／展示会情報一覧へ</a>
      </div>
      <div class="index-virtual">
        <a href="/virtual/"><img src="/assets/images/virtual/banner_virtualshowroom.jpg" alt="FMI バーチャルショールーム"></a>
      </div>
    </section>

    <section class="index-section index-section--products">
      <div class="l-index-inner">
        <h2 class="l-page-ttl l-page-ttl--index">PRODUCTS<span>製品情報</span></h2>
      </div>
      <section class="index-section-small">
        <h3 class="index-heading03">おすすめ製品</h3>
        <div class="content-slider-wrap products-slider-wrap">
          <div class="products-slide-arrows"></div>
<?php
    $recommend_post = get_page_by_path('_recommend', OBJECT, 'products');
    $recommend_item = get_field('product_recommend_item', $recommend_post->ID); ?>
<?php if($recommend_item): ?>
          <ul class="products-slider">
<?php foreach($recommend_item as $rec_post):
        $pr_image = get_field('product_top_recommend_image', $rec_post->ID);
        if(!$pr_image) $pr_image = get_the_post_thumbnail_url($rec_post->ID, 'medium');
        $pr_ttl = get_field('product_top_recommend_ttl', $rec_post->ID);
        if(!$pr_ttl) $pr_ttl = get_field('product_recommend_ttl', $rec_post->ID);
        if(!$pr_ttl) $pr_ttl = $rec_post->post_title;
?>
            <li class="products-slider-item">
              <a href="<?php echo get_the_permalink($rec_post->ID); ?>" class="index-recomm-product">
                <div class="products-slider-img matchHeight">
                  <img src="<?php echo $pr_image; ?>" alt="<?php echo $pr_ttl; ?>">
                </div>
                <span class="index-recomm-product-text"><?php echo $pr_ttl; ?></span>
              </a>
            </li>
<?php endforeach; ?>
          </ul>
<?php endif; ?>
          <a href="/products/" class="l-button">おすすめ製品一覧へ</a>
        </div>
      </section>

      <nav class="products-nav">
        <ul class="products-nav-ul l-main-sectionWide">
          <li class="products-nav-list">
            <div class="products-nav-list-inner"></div>
            <a href="/products/brand" class="products-nav-link"><img src="/assets/images/products/home/link-brand.png" alt="ブランドから選ぶ"></a>
          </li>
          <li class="products-nav-list">
            <div class="products-nav-list-inner"></div>
            <a href="/products/category" class="products-nav-link"><img src="/assets/images/products/home/link-category.png" alt="業種から選ぶ"></a>
          </li>
          <li class="products-nav-list">
            <div class="products-nav-list-inner"></div>
            <a href="/products/list" class="products-nav-link"><img src="/assets/images/products/home/link-list.png" alt="製品一覧から選ぶ"></a>
          </li>
        </ul>
      </nav>

      <section class="index-product-brands-section l-index-inner index-section-middle">
        <h3 class="index-heading03">主な取扱いブランド</h3>
        <ul class="index-product-brands">
<?php
  $arg = array('posts_per_page' => -1, 'post_type' => 'mainbrand', 'order' => 'ASC', 'post_status' => 'publish');
  $brand_items = new WP_Query($arg);
  if($brand_items->have_posts()):
    while($brand_items->have_posts()):
      $brand_items->the_post();
      $post_id = get_the_ID();
      $brand_logo = get_field('mainbrand_logo', $post_id);
      $brand_link = get_field('mainbrand_link', $post_id);
?>
          <li><a href="<?php echo $brand_link; ?>"><img src="<?php echo $brand_logo; ?>" alt="<?php echo get_the_title(); ?>"></a></li>
<?php endwhile; endif; wp_reset_postdata(); ?>
        </ul>
      </section>
    </section>

    <section class="index-section index-section--news">
      <div class="l-index-inner index-section-middle">
        <h2 class="l-page-ttl l-page-ttl--index">NEWS<span>最新情報</span></h2>
        <div class="news-contents">
<?php
  $arg = array('posts_per_page' => -1,'post_type' => 'news', 'order' => 'DESC', 'post_status' => 'publish');
  $news_items = new WP_Query($arg);
  if($news_items->have_posts()):
    $nom = 0;
    while($news_items->have_posts()&&$nom < 5):
      $news_items->the_post();
      $post_id = get_the_ID();
      $category = get_the_terms($post_id, 'news_category');
        if(get_field('news_flag_index')):
          $nom++;
?>
          <article class="index-post">
            <a href="<?php the_permalink(); ?>">
              <div class="index-post-meta">
                <?php if($category): ?>
                <i class="index-post-label label-<?php echo $category[0]->slug; ?>"><?php echo $category[0]->name; ?></i>
                <?php endif; ?>
                <div class="index-post-time-wrap">
                  <time class="index-post-time"><?php echo get_the_date('Y.m.d'); ?></time>
                </div>
              </div>
              <div class="index-post-title"><?php echo get_the_title(); ?></div>
            </a>
          </article>
<?php endif; endwhile; endif; wp_reset_postdata(); ?>
        </div>
        <a href="/news/" class="l-button">ニュース一覧へ</a>
      </div>
    </section>

    <div class="index-banner-area l-main-inner-section">
      <a href="/products/mixer/" class="index-banner"><img src="./assets/images/index/banner_mixerblender.png" alt="ミキサー/ブレンダー選びナビ お客様の用途や処理量に応じた、適切な機種選びをお手伝いいたします。"></a>
    </div>

    <div class="index-banner-area l-main-inner-section">
      <a href="/recipe" class="index-banner"><img src="./assets/images/recipe/recipe_banner.jpg" alt="FMIレシピページ 豊富なレシピでお客様をサポートいたします。"></a>
    </div>

  </main>
</div>
<?php get_footer(); ?>