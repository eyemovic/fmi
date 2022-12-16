<?php
/*====================================================================================
archive-news.php
====================================================================================*/
?>
<?php
  get_header();
?>
<div class="l-contents">
  <main class="l-main is-xs-noPad">
    <div class="l-main-inner l-main-inner--seminar-index">
      <nav class="l-bredNav">
        <ul class="l-bredNav-ul">
          <li class="l-bredNav-list"><a href="/" class="l-bredNav-link">TOP</a></li>
          <li class="l-bredNav-list">導入事例</li>
        </ul>
      </nav>
      <h1 class="l-page-ttl">CASE STUDY<span>導入事例</span></h1>
    </div>
    <section class="l-seminar-gr-section">
      <div class="l-seminar-inner">
<?php if(have_posts()): ?>
        <div class="seminar_exhibition-post-wrap">
	<?php
    while(have_posts()):
      the_post();
      $post_id = get_the_ID();
      $thumbnail = get_the_post_thumbnail_url( $post_id, 'thumbnail' );
      $categories = get_the_terms($post_id, 'casestudy_category');
      $category_count = count($categories);
      if($category_count > 1){
        $category_class = 'label-coorperate';
      }else{
        switch($categories[0]->slug){
          case 'irinox':
            $category_class = 'label-irinox'; break;
          case 'carpigiani':
            $category_class = 'label-carpigiani'; break;
          case 'robotcoupe':
            $category_class = 'label-robotcoupe'; break;
          case 'cimbali':
            $category_class = 'label-cimbali'; break;
          default:
            $category_class = 'label-coorperate';
        }
      }
      $cats = array();
      foreach($categories as $cat){
        array_push($cats, $cat->name);
      }
      $excerpt = get_field('case_excerpt', $post_id);
  ?>
          <article class="seminar_exhibition-post">
            <a href="<?php the_permalink(); ?>">
              <div class="seminar_exhibition-thumb"><img src="<?php echo $thumbnail; ?>" alt="<?php echo get_the_title(); ?>"></div>
              <?php if($categories): ?>
              <div class="seminar_exhibition-post-meta">
                <i class="seminar_exhibition-label <?php echo $category_class; ?>"><?php echo implode('/',$cats); ?></i>
              </div>
              <?php endif; ?>
              <div class="seminar_exhibition-post-desc">
                <div class="seminar_exhibition-post-title"><?php echo get_the_title(); ?></div>
                <div class="seminar_exhibition-post-text">
                <?php echo $excerpt; ?>…[続きを読む]
                </div>
                <div class="seminar_exhibition-post-date">
                  <time><?php the_time('Y.m.d'); ?></time>
                </div>
              </div>
            </a>
          </article>
  <?php endwhile;?>
        </div>
  <?php endif; ?>
      </div>
    </section>
    <section class="casestudy-cta">
      <div class="casestudy-cta__inner">
        <div class="casestudy-cta__body">
          <h2 class="casestudy-cta__ttl">食品製造に関する事例をもっと詳しく知りたい方へ</h2>
          <div class="casestudy-cta__txt">食品製造に関する事例は、「問題解決！食品製造サポートナビ」でもご紹介しております。大人数向けの食事提供やセントラルキッチンの運営に従事されている方も是非ご覧ください。</div>
        </div>
        <div class="casestudy-cta__banner">
          <a href="https://foodmachine-support.com/" target="_blank"><img src="/assets/images/common/foodmachine-support_banner.jpg"></a>
        </div>
      </div>
    </section>
  </main>
</div>
<?php get_footer(); ?>