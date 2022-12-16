<?php
/*====================================================================================
archive-consulting.php
====================================================================================*/
  get_header();
  $categories = get_terms('consulting_category',array('hide_empty'=>0));
?>
<div class="l-contents">
  <main class="l-main is-xs-noPad">
    <div class="l-main-inner l-main-inner--seminar-index">
      <nav class="l-bredNav">
        <ul class="l-bredNav-ul">
          <li class="l-bredNav-list"><a href="/" class="l-bredNav-link">TOP</a></li>
          <li class="l-bredNav-list">コンサルティング</li>
        </ul>
      </nav>
      <h1 class="l-page-ttl">CONSULTING<span>コンサルティング</span></h1>
      <section class="u-mb-xs-10 u-mb-md-35">
        <div class="l-seminar-inner">
          <div class="u-mb-xs-20 u-mb-md-25"><img src="/assets/images/consulting/consulting-main.jpg" alt="FMIアクティブコンサルティング サポートスタッフ"></div>
          <p class="l-txt">経験豊富なシェフ、パティシエ、ジェラティエーレ、バリスタ、管理栄養士から構成されるコンサルティングスタッフがメニュー開発、衛生指導、現場指導など機器の導入による効果向上など機器を通じてお客様の問題解決をサポートします。</p>
        </div>
      </section>
      <nav class="l-anchorNav js-anchorNav u-mb-md-0">
        <div class="l-anchorNav-inner">
          <button class="l-anchorNav-btn js-anchorNavBtn">選択</button>
          <ul class="l-anchorNav-ul">
            <?php $i = 1; foreach($categories as $cat): ?>
            <li class="l-anchorNav-list"><a href="#<?php echo sprintf('%02d', $i); ?>" class="l-anchorNav-link"><?php echo $cat->name; ?></a></li>
            <?php $i++; endforeach; ?>
          </ul>
        </div>
      </nav>
    </div>
    <section class="l-consulting">
      <div class="l-seminar-inner">
<?php $i = 1; foreach($categories as $cat):
  $cat_image = get_field('consulting_category_image','consulting_category'.'_'.$cat->term_id);
  $cat_description = get_field('consulting_category_description','consulting_category'.'_'.$cat->term_id);
?>
        <section class="u-mb-xs-30 u-mb-md-60" id="<?php echo sprintf('%02d', $i); ?>">
          <h3 class="l-mainConts-ttl"><?php echo $cat->name; ?></h3>
          <div class="l-card u-mb-xs-20 u-mb-md-40">
            <div class="l-card-img u-mr-md-30"><img src="<?php echo $cat_image; ?>"></div>
            <div class="l-card-txt">
              <?php echo $cat_description; ?>
            </div>
          </div>
          <div class="l-category u-mb-xs-10 u-mb-md-20">
            <p class="l-category-ttl-2">スタッフ紹介</p>
          </div>
  <?php
    $args = array( 'post_type' => 'consulting', 'order' => 'ASC', 'orderby' => 'menu_order', 'post_status' => 'publish', 'posts_per_page' => -1, 'tax_query' => array( array( 'taxonomy' => 'consulting_category', 'field' => 'term_taxonomy_id', 'terms' => $cat->term_id ) ) );
    $ct_query = new WP_Query( $args );
    if ( $ct_query->have_posts() ):
  ?>
          <ul class="staf-intr">
    <?php
      while ( $ct_query->have_posts() ) :
        $ct_query->the_post();
        $ct_position = get_field('consultant_position', $mv_query->ID);
        $ct_link1 = get_field('consultant_link1', $mv_query->ID);
        $ct_link2 = get_field('consultant_link2', $mv_query->ID);
        $ct_link3 = get_field('consultant_link3', $mv_query->ID);
        $ct_image = get_field('consultant_image', $mv_query->ID);
    ?>
            <li class="staf-conts">
              <div class="l-card u-mb-xs-10 u-mb-md-20">
                <div class="l-card-img"><img src="<?php echo $ct_image; ?>" alt="<?php echo $ct_position . ' ' . get_the_title(); ?>"></div>
                <div class="l-card-txt">
                  <p class="staf_name">
                    <span class="l-txt-sm"><?php echo $ct_position; ?></span><br>
                    <span class="l-txt"><?php echo get_the_title(); ?></span>
                  </p>
                </div>
              </div>
              <?php the_content(); ?>
              <?php if($ct_link1['flag']): ?>
                <a href="<?php echo $ct_link1['url']; ?>" class="l-link-ttl"><?php echo $ct_link1['text']; ?></a>
              <?php endif; ?>
              <?php if($ct_link2['flag']): ?>
                <br><a href="<?php echo $ct_link2['url']; ?>" class="l-link-ttl"><?php echo $ct_link2['text']; ?></a>
              <?php endif; ?>
              <?php if($ct_link3['flag']): ?>
                <br><a href="<?php echo $ct_link3['url']; ?>" class="l-link-ttl"><?php echo $ct_link3['text']; ?></a>
              <?php endif; ?>
            </li>
    <?php endwhile; ?>
          </ul>
  <?php endif; wp_reset_query(); ?>
        </section>
<?php $i++; endforeach; ?>
      </div>
    </section>
  </main>
</div>
<?php get_footer(); ?>
<script>
jQuery(function($){
  let article = $('.movie-view');
  article.on('click', function(){
    let modal = $(this).children('.movie-modal');
    modal.toggleClass('--active');
    let viewer = $(this).find('iframe');
    let src = $(this).data('url');
    viewer.attr('src',src);
  });
});
</script>