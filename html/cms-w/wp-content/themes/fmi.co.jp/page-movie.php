<?php
/*====================================================================================
page-movie.php
====================================================================================*/
  get_header();
  $categories = get_terms('movie_category',array('hide_empty'=>0));
?>
<div class="l-contents">
  <main class="l-main is-xs-noPad">
    <div class="l-main-inner">
      <nav class="l-bredNav">
        <ul class="l-bredNav-ul">
          <li class="l-bredNav-list"><a href="/" class="l-bredNav-link">TOP</a></li>
          <li class="l-bredNav-list">動画一覧ページ</li>
        </ul>
      </nav>
      <h1 class="l-page-ttl l-page-ttl--movie">MOVIE<span>動画</span></h1>
      <nav class="l-anchorNav js-anchorNav u-mb-md-40">
        <div class="l-anchorNav-inner">
          <button class="l-anchorNav-btn js-anchorNavBtn">選択</button>
          <ul class="l-anchorNav-ul u-fixed">
            <?php foreach($categories as $cat): ?>
            <li class="l-anchorNav-list"><a href="#<?php echo $cat->slug; ?>" class="l-anchorNav-link"><?php echo $cat->name; ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </nav>
      <div class="news-index movie-index">
        <?php foreach($categories as $cat):
          $cat_eng = get_field('movie_category_eng','movie_category'.'_'.$cat->term_id);
          $cat_color = get_field('movie_category_class','movie_category'.'_'.$cat->term_id);
        ?>
        <?php
          $args = array( 'post_type' => 'movie', 'order' => 'ASC', 'orderby' => 'menu_order', 'post_status' => 'publish', 'posts_per_page' => -1, 'tax_query' => array( array( 'taxonomy' => 'movie_category', 'field' => 'term_taxonomy_id', 'terms' => $cat->term_id ) ) );
          $mv_query = new WP_Query( $args );
          if ( $mv_query->have_posts() ):
        ?>
        <section id="<?php echo $cat->slug; ?>" class="u-mb-xs-40 u-mb-md-60">
          <div class="l-category <?php echo $cat_color; ?>">
            <span class="l-category-eng"><?php echo $cat_eng; ?></span>
            <h2 class="l-category-ttl"><?php echo $cat->name; ?></h2>
          </div>
          <ul class="movie-list">
          <?php
            while ( $mv_query->have_posts() ) :
              $mv_query->the_post();
              $mv_url = get_field('movie_url', $mv_query->ID);
              $mv_thumb = get_field('movie_thumbnail', $mv_query->ID);
          ?>
            <li class="movie-view" data-url="<?php echo createVideoTag($mv_url); ?>">
              <div class="movie-view__thumb"><img src="<?php echo $mv_thumb; ?>" alt="<?php echo get_the_title(); ?>"><div class="movie-view__btn"></div></div>
              <p class="movie-view__ttl"><?php echo get_the_title(); ?></p>
              <div class="movie-modal">
                <div class="movie-modal__inner">
                  <div class="movie-modal__movie">
                    <iframe width="800" height="450" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen  loading="lazy"></iframe>
                  </div>
                </div>
              </div>
            </li>
          <?php endwhile; ?>
          </ul>
        </section>
        <?php endif; wp_reset_query(); ?>
        <?php endforeach; ?>
      </div>
    </div>
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