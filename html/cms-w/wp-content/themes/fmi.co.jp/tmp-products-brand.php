<?php
/*
Template Name: 製品ページ（ブランドから選ぶ）
Template Post Type: products
*/
  get_header();
  $brands = get_terms('products_brand',array('hide_empty'=>0));
?>
<div class="l-contents">

  <main class="l-main is-xs-noPad">
    <div class="l-main-inner">
      <nav class="l-bredNav">
        <ul class="l-bredNav-ul">
          <li class="l-bredNav-list"><a href="/" class="l-bredNav-link">TOP</a></li>
          <li class="l-bredNav-list"><a href="/products/" class="l-bredNav-link">製品情報</a></li>
          <li class="l-bredNav-list">ブランドから選ぶ</li>
        </ul>
      </nav>
      <div class="products-header--search">
        <h1 class="l-page-ttl-v2">PRODUCTS<span>ブランドから選ぶ</span></h1>
        <ul class="l-item-conts js-brand-lists">
          <?php foreach($brands as $brand):
            $brand_logo = get_field('product_brand_logo','products_option'.'_'.$brand->term_id);
          ?>
          <li class="l-item js-brand-modal-btn">
            <a href="" class="productsBrand-name-inner">
              <p class="l-item-img js-matchHeight"><img src="<?php echo $brand_logo['url']; ?>" alt="<?php echo $brand->name; ?>"></p>
              <p class="l-item-ttl u-ta-center"><?php echo $brand->name; ?></p>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <section class="products-recipe">
        <a href="/recipe" class="index-banner"><img src="/assets/images/recipe/recipe_banner.jpg" alt="FMIレシピページ 豊富なレシピでお客様をサポートいたします。"></a>
      </section>
    </div>
  </main>
</div>

<section class="js-brand-modal-conts-wrapper">
  <?php foreach($brands as $brand): ?>
  <div class="js-brand-modal-conts">
    <ul class="l-item-conts">
<?php
  $args = array(
    'post_type' => 'products',
    'order' => 'ASC',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'tax_query' => array(
      array(
        'taxonomy' => 'products_brand',
        'field' => 'term_taxonomy_id',
        'terms' => $brand->term_id
      )
    )
  );
  $pr_query = new WP_Query( $args );
  if ( $pr_query->have_posts() ):
    while ( $pr_query->have_posts() ) :
      $pr_query->the_post();
      $pr_image = get_the_post_thumbnail_url( $post->ID, 'medium' );
      $pr_ttl = get_field('product_recommend_ttl', $post->ID);
      if($pr_ttl == "") $pr_ttl = get_the_title();
      $pr_txt = get_field('product_recommend_description', $post->ID);
      if($brand->slug == 'comprital'){
        $pr_image = '/assets/products/comprital2_thumb.jpg';
        $pr_ttl = 'ジェラート食材（コンプリタール社）';
        $pr_txt = '安定剤';
      }elseif($brand->slug == 'torronalba'){
        $pr_image = '/assets/products/torronalba2_thumb.jpg';
        $pr_ttl = 'ジェラート食材（トロナルバ社）';
        $pr_txt = 'フレーバー各種';
      }
?>
      <li class="l-item">
        <a href="<?php echo get_the_permalink(); ?>">
          <p class="l-item-img js-matchHeight-modal"><img src="<?php echo $pr_image; ?>" alt="<?php echo $pr_ttl; ?>"></p>
          <p class="l-item-ttl"><?php echo $pr_ttl; ?></p>
          <p class="l-item-cap"><?php echo $pr_txt; ?></p>
        </a>
      </li>
<?php endwhile; endif; wp_reset_query(); ?>
    </ul>
  </div>
  <?php endforeach; ?>
</section>
<?php get_footer(); ?>