<?php
/*====================================================================================
archive-products.php
====================================================================================*/
  get_header();
?>
<div class="l-contents">
  <main class="l-main is-xs-noPad">
    <div class="l-main-inner-section products-main-inner-section">
      <nav class="l-bredNav">
        <ul class="l-bredNav-ul">
          <li class="l-bredNav-list"><a href="/" class="l-bredNav-link">TOP</a></li>
          <li class="l-bredNav-list">製品情報</li>
        </ul>
      </nav>
      <h1 class="l-page-ttl">PRODUCTS<span>製品情報</span></h1>
    </div>
    <nav class="products-nav">
      <ul class="products-nav-ul l-main-sectionWide">
        <li class="products-nav-list">
          <div class="products-nav-list-inner"></div>
          <a href="/products/brand/" class="products-nav-link"><img src="/assets/images/products/home/link-brand.png" alt="ブランドから選ぶ"></a>
        </li>
        <li class="products-nav-list">
          <div class="products-nav-list-inner"></div>
          <a href="/products/category/" class="products-nav-link"><img src="/assets/images/products/home/link-category.png" alt="業種から選ぶ"></a>
        </li>
        <li class="products-nav-list">
          <div class="products-nav-list-inner"></div>
          <a href="/products/list/" class="products-nav-link"><img src="/assets/images/products/home/link-list.png" alt="製品一覧から選ぶ"></a>
        </li>
      </ul>
    </nav>
    <div class="l-main-inner products-main-inner">
      <section class="products-main-virtual">
        <h2 class="l-ttl-sm">バーチャルショールームから製品を見る</h2>
        <a href="/virtual/index.html"><img src="/assets/images/virtual/banner_virtualshowroom.jpg" alt="FMI バーチャルショールーム"></a>
      </section>
      <section>
        <h2 class="l-ttl-sm">おすすめ製品</h2>
  <?php
    $recommend_post = get_page_by_path('_recommend', OBJECT, 'products');
    $recommend_item = get_field('product_recommend_item', $recommend_post->ID);
  ?>
        <ul class="l-item-conts">
    <?php
    if($recommend_item): foreach($recommend_item as $rec_post):
        $pr_image = get_the_post_thumbnail_url( $rec_post->ID, 'medium' );
        $pr_ttl = get_field('product_recommend_ttl', $rec_post->ID);
        if($pr_ttl == "") $pr_ttl = $rec_post->post_title;
        $pr_txt = get_field('product_recommend_description', $rec_post->ID);
    ?>
          <li class="l-item">
            <a href="<?php echo the_permalink($rec_post->ID); ?>">
              <p class="l-item-img js-matchHeight-modal"><img src="<?php echo $pr_image; ?>" alt="<?php echo $pr_ttl; ?>"></p>
              <p class="l-item-ttl"><?php echo $pr_ttl; ?></p>
              <p class="l-item-cap"><?php echo $pr_txt; ?></p>
            </a>
          </li>
    <?php endforeach; endif; ?>
        </ul>
      </section>
      <section class="products-recipe">
        <a href="/recipe" class="index-banner"><img src="/assets/images/recipe/recipe_banner.jpg" alt="FMIレシピページ 豊富なレシピでお客様をサポートいたします。"></a>
      </section>
    </div>
  </main>
</div>
<?php get_footer(); ?>