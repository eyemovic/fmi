<?php
/*
Template Name: 製品ページ（業種から選ぶ）
Template Post Type: products
*/
  get_header();
  $categories = get_terms('products_category',array('hide_empty'=>0));
  $categories_parents = get_terms('products_category',array('hide_empty'=>0, 'parent' => 0));
?>
<div class="l-contents">

  <main class="l-main is-xs-noPad">
    <div class="l-main-inner">
      <nav class="l-bredNav">
        <ul class="l-bredNav-ul">
          <li class="l-bredNav-list"><a href="/" class="l-bredNav-link">TOP</a></li>
          <li class="l-bredNav-list"><a href="/products/" class="l-bredNav-link">製品情報</a></li>
          <li class="l-bredNav-list">業種一覧から選ぶ</li>
        </ul>
      </nav>
      <div class="products-header--search">
        <h1 class="l-page-ttl-v2 u-mb-xs-15 u-mb-md-30">PRODUCTS<span>業種から選ぶ</span></h1>
        <div class="products-search u-mb-xs-40 u-mb-md-0">
          <div id="srchBox" class="watermark">
            <script async src="https://cse.google.com/cse.js?cx=016533161740608887884:ny0d83hgxye"></script>
            <div class="gcse-search"></div>
          </div>
        </div>
      </div>
      <nav class="l-anchorNav js-anchorNav u-mb-xs-40 u-mb-md-60">
        <div class="l-anchorNav-inner">
          <button class="l-anchorNav-btn js-anchorNavBtn">種類</button>
          <ul class="l-anchorNav-ul">
            <?php foreach($categories_parents as $categories_parent): ?>
            <li class="l-anchorNav-list"><a href="#<?php echo $categories_parent->slug; ?>" class="l-anchorNav-link"><?php echo $categories_parent->name; ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </nav>
      <?php foreach($categories_parents as $categories_parent):
        $categories_children = get_terms('products_category', array('child_of' => $categories_parent->term_id, 'hide_empty' => '0'));
      ?>
      <section id="<?php echo $categories_parent->slug; ?>" class="u-mb-xs-60 u-mb-md-120">
        <div class="l-category">
          <h2 class="l-category-ttl"><?php echo $categories_parent->name; ?></h2>
        </div>
        <?php foreach($categories_children as $category):
          $category_color = get_field('product_category_color','products_option'.'_'.$category->term_id);
          $category_item = get_field('product_category_item','products_option'.'_'.$category->term_id);
        ?>
        <section class="u-mb-xs-40 u-mb-md-60 <?php echo $category_color; ?>">
          <h3 class="l-ttl-sm"><?php echo $category->name; ?></h3>
          <ul class="l-item-conts">
<?php
  if($category_item): foreach($category_item as $cat_post):
      $pr_image = get_the_post_thumbnail_url( $cat_post->ID, 'medium' );
      $pr_ttl = get_field('product_recommend_ttl', $cat_post->ID);
      if($pr_ttl == "") $pr_ttl = $cat_post->post_title;
      $pr_txt = get_field('product_recommend_description', $cat_post->ID);
?>
            <li class="l-item">
              <a href="<?php echo get_the_permalink($cat_post->ID); ?>">
                <p class="l-item-img js-matchHeight"><img src="<?php echo $pr_image; ?>" alt="<?php echo $pr_ttl; ?>"></p>
                <p class="l-item-ttl"><?php echo $pr_ttl; ?></p>
                <p class="l-item-cap"><?php echo $pr_txt; ?></p>
              </a>
            </li>
<?php endforeach; endif; ?>
          </ul>
        </section>
        <?php endforeach; ?>
      </section>
      <?php endforeach; ?>
      <section class="products-recipe">
        <a href="/recipe" class="index-banner"><img src="/assets/images/recipe/recipe_banner.jpg" alt="FMIレシピページ 豊富なレシピでお客様をサポートいたします。"></a>
      </section>
    </div>
  </main>
</div>
<?php get_footer(); ?>