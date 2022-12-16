<?php
/*
Template Name: 製品ページ（汎用）
Template Post Type: products
*/
  get_header();
  $post_id = get_the_ID();
  $post_slug = $post->post_name;
  $parent_id = $post->post_parent;
  $meta_key = array('products_base_header_image','products_base_header_ttl','products_base_header_text','products_base_flag_recipe','products_base_flag_recipe_url','products_base_flag_blender','products_base_flag_robotcoupe_demo','products_base_related_under_text');
  $meta = array();
  foreach($meta_key as $key){
    $meta[$key] = get_field($key,$post_id);
  }
  $group_count = 0;
  $group_01 = get_field('products_base_group1');
  $group_02 = get_field('products_base_group2');
  $group_03 = get_field('products_base_group3');
  $group_04 = get_field('products_base_group4');
  $group_05 = get_field('products_base_group5');
  if($group_01 && !empty(array_filter($group_01))) $group_count++;
  if($group_02 && !empty(array_filter($group_02))) $group_count++;
  if($group_03 && !empty(array_filter($group_03))) $group_count++;
  if($group_04 && !empty(array_filter($group_04))) $group_count++;
  if($group_05 && !empty(array_filter($group_05))) $group_count++;
  $related_01 = get_field('products_base_related1');
  $related_02 = get_field('products_base_related2');
  $related_03 = get_field('products_base_related3');
  $related_04 = get_field('products_base_related4');
  $related_05 = get_field('products_base_related5');
?>
<div class="l-contents">
  <main class="l-main is-xs-noPad">
    <div class="l-main-inner">
      <nav class="l-bredNav">
        <ul class="l-bredNav-ul">
          <li class="l-bredNav-list"><a href="/" class="l-bredNav-link">TOP</a></li>
          <li class="l-bredNav-list"><a href="/products/" class="l-bredNav-link"> 製品情報</a></li>
          <?php if($parent_id): ?>
          <li class="l-bredNav-list"><a href="<?php echo get_permalink($parent_id); ?>" class="l-bredNav-link"> <?php echo str_replace('非公開: ', '', get_the_title($parent_id)); ?></a></li>
          <?php endif; ?>
          <li class="l-bredNav-list"> <?php echo get_the_title(); ?></li>
        </ul>
      </nav>
      <h1 class="l-page-ttl-v3"><?php echo get_the_title(); ?></h1>
      <div class="products-header u-mb-xs-35">
        <p class="u-mb-xs-20 u-mb-md-0"><img src="<?php echo $meta['products_base_header_image']['url']; ?>" alt="<?php echo get_the_title(); ?> イメージ画像"></p>
      </div>
      <section class="u-mb-xs-60 u-mb-md-120">
        <?php if($meta['products_base_header_ttl']): ?>
        <h2 class="l-ttl-md"><?php echo $meta['products_base_header_ttl']; ?></h2>
        <?php endif; ?>
        <p class="l-txt-xs u-mb-xs-20 u-mb-md-35"><?php the_field('products_base_header_text'); ?></p>
        <?php if($group_count > 1): ?>
        <nav class="l-pageNav productsArticle-pageNav u-mb-xs-40 u-mb-md-60">
          <ul class="l-pageNav-ul">
          </ul>
        </nav>
        <?php if($group_01['tab_name']): ?>
        <input type="radio" name="products-tab" id="tab-menu-1" class="l-tabRadio-btn" checked="checked">
        <?php endif; ?>
        <?php if($group_02['tab_name']): ?>
        <input type="radio" name="products-tab" id="tab-menu-2" class="l-tabRadio-btn">
        <?php endif; ?>
        <?php if($group_03['tab_name']): ?>
        <input type="radio" name="products-tab" id="tab-menu-3" class="l-tabRadio-btn">
        <?php endif; ?>
        <?php if($group_04['tab_name']): ?>
        <input type="radio" name="products-tab" id="tab-menu-4" class="l-tabRadio-btn">
        <?php endif; ?>
        <?php if($group_05['tab_name']): ?>
        <input type="radio" name="products-tab" id="tab-menu-5" class="l-tabRadio-btn">
        <?php endif; ?>
        <ul class="l-tabMenu-ul">
          <?php if($group_01['tab_name']): ?>
          <li class="l-tabMenu-list"><label class="l-tabMenu-label" for="tab-menu-1"><?php echo $group_01['tab_name']; ?></label></li>
          <?php endif; ?>
          <?php if($group_02['tab_name']): ?>
          <li class="l-tabMenu-list"><label class="l-tabMenu-label" for="tab-menu-2"><?php echo $group_02['tab_name']; ?></label></li>
          <?php endif; ?>
          <?php if($group_03['tab_name']): ?>
          <li class="l-tabMenu-list"><label class="l-tabMenu-label" for="tab-menu-3"><?php echo $group_03['tab_name']; ?></label></li>
          <?php endif; ?>
          <?php if($group_04['tab_name']): ?>
          <li class="l-tabMenu-list"><label class="l-tabMenu-label" for="tab-menu-4"><?php echo $group_04['tab_name']; ?></label></li>
          <?php endif; ?>
          <?php if($group_05['tab_name']): ?>
          <li class="l-tabMenu-list"><label class="l-tabMenu-label" for="tab-menu-5"><?php echo $group_05['tab_name']; ?></label></li>
          <?php endif; ?>
        </ul>
        <ul class="l-tabConts-ul">
          <?php if($group_01['tab_name']): ?>
          <li class="l-mainConts l-tabConts u-mb-xs-40 u-mb-md-80">
            <?php echo $group_01['tab_description']; ?>
          </li>
          <?php endif; ?>
          <?php if($group_02['tab_name']): ?>
          <li class="l-mainConts l-tabConts u-mb-xs-40 u-mb-md-80">
            <?php echo $group_02['tab_description']; ?>
          </li>
          <?php endif; ?>
          <?php if($group_03['tab_name']): ?>
          <li class="l-mainConts l-tabConts u-mb-xs-40 u-mb-md-80">
            <?php echo $group_03['tab_description']; ?>
          </li>
          <?php endif; ?>
          <?php if($group_04['tab_name']): ?>
          <li class="l-mainConts l-tabConts u-mb-xs-40 u-mb-md-80">
            <?php echo $group_04['tab_description']; ?>
          </li>
          <?php endif; ?>
          <?php if($group_05['tab_name']): ?>
          <li class="l-mainConts l-tabConts u-mb-xs-40 u-mb-md-80">
            <?php echo $group_05['tab_description']; ?>
          </li>
          <?php endif; ?>
        </ul>
        <?php else: ?>
        <div class="l-mainConts u-mb-xs-40 u-mb-md-80">
          <?php echo $group_01['tab_description']; ?>
        </div>
        <?php endif; ?>
        <?php if($post_slug == 'kitchenaid'): ?>
        <section class="u-mb-xs-40 u-mb-md-80">
          <div class="l-mainConts">
            <section>
              <div class="brandDetail-card">
                <div class="brandDetail-card-inner brandDetail-card-inner2">
                  <p class="u-fz-xs-12rem"><a class="u-c-blue u-fw-b" href="/products/kitchenaid_metalfoodgrinder/">オプション</a></p>
                  <h2 class="l-category-ttl u-mb-xs-20 u-mb-md-30">メタルフードグラインダー<span>（アルミ金属製）</span></h2>
                  <p class="u-mb-xs-15  u-mb-xs-20 u-mb-md-40">キッチンエイド社としてプロユース向けの<br>フードグラインダーアタッチメントは初めてのラインナップ。 <br>耐久性のある丈夫なアルミ金属製。 <br>製菓用だけではなく様々な料理にもご使用いただけます。</p>
                  <p class="l-card-img l-card-img2">
                    <img src="/assets/images/products/lp/kitchenaid_metalfoodgrinder/kitchenaid_mfg_img01.png" alt="メタルフードグラインダー（アルミ金属製）">
                  </p>
                  <p class="l-link-back-btn casestudy-link-btn pcLeft"><a href="/products/kitchenaid_metalfoodgrinder/">詳細はこちら</a></p>
                </div>
              </div>
            </section>
          </div>
        </section>
        <?php endif; ?>
        <?php if($post_slug == 'merrychef'): ?>
        <section class="u-mb-xs-60 u-mb-md-120">
          <div class="merrychef__linkbanner">
            <a href="/merrychef_lp/">
              <picture>
                <source media="(min-width: 768px)" srcset="/assets/top/items/slide15_pc.jpg">
                <img src="/assets/top/items/slide15_sp.jpg" alt="MERRYCHEF">
              </picture>
            </a>
          </div>
        </section>
        <?php endif; ?>
        <?php if($related_01 && !empty(array_filter($related_01)) && (!empty(array_filter($related_01['group1'])) || !empty(array_filter($related_01['group2'])) || !empty(array_filter($related_01['group3'])))): ?>
        <section class="u-mb-xs-60 u-mb-md-120">
          <?php if($related_01['subttl'] || $related_01['ttl']): ?>
          <div class="l-category">
            <?php if($related_01['subttl']): ?><span class="l-category-eng"><?php echo $related_01['subttl']; ?></span><?php endif; ?>
            <?php if($related_01['ttl']): ?><h3 class="l-category-ttl"><?php echo $related_01['ttl']; ?></h3><?php endif; ?>
          </div>
          <?php endif; ?>
          <?php if(!empty(array_filter($related_01['group1']))): ?>
          <section class="u-mb-xs-40 u-mb-md-60" id="cat">
            <?php if($related_01['group1']['middlettl']): ?>
            <h4 class="l-ttl-sm"><?php echo $related_01['group1']['middlettl']; ?></h4>
            <?php endif; ?>
            <ul class="l-item-conts productsArticle-item-conts">
              <?php
                foreach($related_01['group1']['products'] as $pro):
                  $post_id = $pro->ID;
                  $thumbnail = get_the_post_thumbnail_url($post_id,'full');
                  if(!$thumbnail) $thumbnail = 'noimage';
                  $new_flg = get_field('model_new',$post_id);
                  $description = get_field('product_recommend_description', $post_id);
              ?>
              <li class="l-item l-item-bd0">
                <a href="<?php the_permalink($post_id); ?>">
                  <p class="l-item-img js-matchHeight">
                    <?php if($new_flg): ?>
                    <span class="productsArticle-item-new"><img src="/assets/images/products/lineup/icon-new.png" alt="NEW"></span>
                    <?php endif; ?>
                    <img src="<?php echo $thumbnail; ?>" alt="<?php echo get_the_title($post_id); ?> 製品イメージ">
                  </p>
                  <p class="l-item-ttl"><?php if($post_slug != 'gelato'): ?>型 式｜<?php endif; ?><?php echo get_the_title($post_id); ?></p>
                  <?php if($description): ?><p class="l-item-txt-note"><?php echo $description; ?></p><?php endif; ?>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </section>
          <?php endif; ?>
          <?php if(!empty(array_filter($related_01['group2']))): ?>
          <section class="u-mb-xs-40 u-mb-md-60" id="cat">
            <?php if($related_01['group2']['middlettl']): ?>
            <h4 class="l-ttl-sm"><?php echo $related_01['group2']['middlettl']; ?></h4>
            <?php endif; ?>
            <ul class="l-item-conts productsArticle-item-conts">
              <?php
                foreach($related_01['group2']['products'] as $pro):
                  $post_id = $pro->ID;
                  $thumbnail = get_the_post_thumbnail_url($post_id,'full');
                  if(!$thumbnail) $thumbnail = 'noimage';
                  $new_flg = get_field('model_new',$post_id);
                  $description = get_field('product_recommend_description', $post_id);
              ?>
              <li class="l-item l-item-bd0">
                <a href="<?php the_permalink($post_id); ?>">
                  <p class="l-item-img js-matchHeight">
                    <?php if($new_flg): ?>
                    <span class="productsArticle-item-new"><img src="/assets/images/products/lineup/icon-new.png" alt="NEW"></span>
                    <?php endif; ?>
                    <img src="<?php echo $thumbnail; ?>" alt="<?php echo get_the_title($post_id); ?> 製品イメージ">
                  </p>
                  <p class="l-item-ttl"><?php if($post_slug != 'gelato'): ?>型 式｜<?php endif; ?><?php echo get_the_title($post_id); ?></p>
                  <?php if($description): ?><p class="l-item-txt-note"><?php echo $description; ?></p><?php endif; ?>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </section>
          <?php endif; ?>
          <?php if(!empty(array_filter($related_01['group3']))): ?>
          <section class="u-mb-xs-40 u-mb-md-60" id="cat">
            <?php if($related_01['group3']['middlettl']): ?>
            <h4 class="l-ttl-sm"><?php echo $related_01['group3']['middlettl']; ?></h4>
            <?php endif; ?>
            <ul class="l-item-conts productsArticle-item-conts">
              <?php
                foreach($related_01['group3']['products'] as $pro):
                  $post_id = $pro->ID;
                  $thumbnail = get_the_post_thumbnail_url($post_id,'full');
                  if(!$thumbnail) $thumbnail = 'noimage';
                  $new_flg = get_field('model_new',$post_id);
                  $description = get_field('product_recommend_description', $post_id);
              ?>
              <li class="l-item l-item-bd0">
                <a href="<?php the_permalink($post_id); ?>">
                  <p class="l-item-img js-matchHeight">
                    <?php if($new_flg): ?>
                    <span class="productsArticle-item-new"><img src="/assets/images/products/lineup/icon-new.png" alt="NEW"></span>
                    <?php endif; ?>
                    <img src="<?php echo $thumbnail; ?>" alt="<?php echo get_the_title($post_id); ?> 製品イメージ">
                  </p>
                  <p class="l-item-ttl"><?php if($post_slug != 'gelato'): ?>型 式｜<?php endif; ?><?php echo get_the_title($post_id); ?></p>
                  <?php if($description): ?><p class="l-item-txt-note"><?php echo $description; ?></p><?php endif; ?>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </section>
          <?php endif; ?>
        </section>
        <?php endif; ?>
        <?php if($related_02 && !empty(array_filter($related_02)) && (!empty(array_filter($related_02['group1'])) || !empty(array_filter($related_02['group2'])) || !empty(array_filter($related_02['group3'])))): ?>
        <section class="u-mb-xs-60 u-mb-md-120">
          <?php if($related_02['subttl'] || $related_02['ttl']): ?>
          <div class="l-category">
            <?php if($related_02['subttl']): ?><span class="l-category-eng"><?php echo $related_02['subttl']; ?></span><?php endif; ?>
            <?php if($related_02['ttl']): ?><h3 class="l-category-ttl"><?php echo $related_02['ttl']; ?></h3><?php endif; ?>
          </div>
          <?php endif; ?>
          <?php if(!empty(array_filter($related_02['group1']))): ?>
          <section class="u-mb-xs-40 u-mb-md-60" id="cat">
            <?php if($related_02['group1']['middlettl']): ?>
            <h4 class="l-ttl-sm"><?php echo $related_02['group1']['middlettl']; ?></h4>
            <?php endif; ?>
            <ul class="l-item-conts productsArticle-item-conts">
              <?php
                foreach($related_02['group1']['products'] as $pro):
                  $post_id = $pro->ID;
                  $thumbnail = get_the_post_thumbnail_url($post_id,'full');
                  if(!$thumbnail) $thumbnail = 'noimage';
                  $new_flg = get_field('model_new',$post_id);
                  $description = get_field('product_recommend_description', $post_id);
              ?>
              <li class="l-item l-item-bd0">
                <a href="<?php the_permalink($post_id); ?>">
                  <p class="l-item-img js-matchHeight">
                    <?php if($new_flg): ?>
                    <span class="productsArticle-item-new"><img src="/assets/images/products/lineup/icon-new.png" alt="NEW"></span>
                    <?php endif; ?>
                    <img src="<?php echo $thumbnail; ?>" alt="<?php echo get_the_title($post_id); ?> 製品イメージ">
                  </p>
                  <p class="l-item-ttl"><?php if($post_slug != 'gelato'): ?>型 式｜<?php endif; ?><?php echo get_the_title($post_id); ?></p>
                  <?php if($description): ?><p class="l-item-txt-note"><?php echo $description; ?></p><?php endif; ?>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </section>
          <?php endif; ?>
          <?php if(!empty(array_filter($related_02['group2']))): ?>
          <section class="u-mb-xs-40 u-mb-md-60" id="cat">
            <?php if($related_02['group2']['middlettl']): ?>
            <h4 class="l-ttl-sm"><?php echo $related_02['group2']['middlettl']; ?></h4>
            <?php endif; ?>
            <ul class="l-item-conts productsArticle-item-conts">
              <?php
                foreach($related_02['group2']['products'] as $pro):
                  $post_id = $pro->ID;
                  $thumbnail = get_the_post_thumbnail_url($post_id,'full');
                  if(!$thumbnail) $thumbnail = 'noimage';
                  $new_flg = get_field('model_new',$post_id);
                  $description = get_field('product_recommend_description', $post_id);
              ?>
              <li class="l-item l-item-bd0">
                <a href="<?php the_permalink($post_id); ?>">
                  <p class="l-item-img js-matchHeight">
                    <?php if($new_flg): ?>
                    <span class="productsArticle-item-new"><img src="/assets/images/products/lineup/icon-new.png" alt="NEW"></span>
                    <?php endif; ?>
                    <img src="<?php echo $thumbnail; ?>" alt="<?php echo get_the_title($post_id); ?> 製品イメージ">
                  </p>
                  <p class="l-item-ttl"><?php if($post_slug != 'gelato'): ?>型 式｜<?php endif; ?><?php echo get_the_title($post_id); ?></p>
                  <?php if($description): ?><p class="l-item-txt-note"><?php echo $description; ?></p><?php endif; ?>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </section>
          <?php endif; ?>
          <?php if(!empty(array_filter($related_02['group3']))): ?>
          <section class="u-mb-xs-40 u-mb-md-60" id="cat">
            <?php if($related_02['group3']['middlettl']): ?>
            <h4 class="l-ttl-sm"><?php echo $related_02['group3']['middlettl']; ?></h4>
            <?php endif; ?>
            <ul class="l-item-conts productsArticle-item-conts">
              <?php
                foreach($related_02['group3']['products'] as $pro):
                  $post_id = $pro->ID;
                  $thumbnail = get_the_post_thumbnail_url($post_id,'full');
                  if(!$thumbnail) $thumbnail = 'noimage';
                  $new_flg = get_field('model_new',$post_id);
                  $description = get_field('product_recommend_description', $post_id);
              ?>
              <li class="l-item l-item-bd0">
                <a href="<?php the_permalink($post_id); ?>">
                  <p class="l-item-img js-matchHeight">
                    <?php if($new_flg): ?>
                    <span class="productsArticle-item-new"><img src="/assets/images/products/lineup/icon-new.png" alt="NEW"></span>
                    <?php endif; ?>
                    <img src="<?php echo $thumbnail; ?>" alt="<?php echo get_the_title($post_id); ?> 製品イメージ">
                  </p>
                  <p class="l-item-ttl"><?php if($post_slug != 'gelato'): ?>型 式｜<?php endif; ?><?php echo get_the_title($post_id); ?></p>
                  <?php if($description): ?><p class="l-item-txt-note"><?php echo $description; ?></p><?php endif; ?>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </section>
          <?php endif; ?>
        </section>
        <?php endif; ?>
        <?php if($related_03 && !empty(array_filter($related_03)) && (!empty(array_filter($related_03['group1'])) || !empty(array_filter($related_03['group2'])) || !empty(array_filter($related_03['group3'])))): ?>
        <section class="u-mb-xs-60 u-mb-md-120">
          <?php if($related_03['subttl'] || $related_03['ttl']): ?>
          <div class="l-category">
            <?php if($related_03['subttl']): ?><span class="l-category-eng"><?php echo $related_03['subttl']; ?></span><?php endif; ?>
            <?php if($related_03['ttl']): ?><h3 class="l-category-ttl"><?php echo $related_03['ttl']; ?></h3><?php endif; ?>
          </div>
          <?php endif; ?>
          <?php if(!empty(array_filter($related_03['group1']))): ?>
          <section class="u-mb-xs-40 u-mb-md-60" id="cat">
            <?php if($related_03['group1']['middlettl']): ?>
            <h4 class="l-ttl-sm"><?php echo $related_03['group1']['middlettl']; ?></h4>
            <?php endif; ?>
            <ul class="l-item-conts productsArticle-item-conts">
              <?php
                foreach($related_03['group1']['products'] as $pro):
                  $post_id = $pro->ID;
                  $thumbnail = get_the_post_thumbnail_url($post_id,'full');
                  if(!$thumbnail) $thumbnail = 'noimage';
                  $new_flg = get_field('model_new',$post_id);
                  $description = get_field('product_recommend_description', $post_id);
              ?>
              <li class="l-item l-item-bd0">
                <a href="<?php the_permalink($post_id); ?>">
                  <p class="l-item-img js-matchHeight">
                    <?php if($new_flg): ?>
                    <span class="productsArticle-item-new"><img src="/assets/images/products/lineup/icon-new.png" alt="NEW"></span>
                    <?php endif; ?>
                    <img src="<?php echo $thumbnail; ?>" alt="<?php echo get_the_title($post_id); ?> 製品イメージ">
                  </p>
                  <p class="l-item-ttl"><?php if($post_slug != 'gelato'): ?>型 式｜<?php endif; ?><?php echo get_the_title($post_id); ?></p>
                  <?php if($description): ?><p class="l-item-txt-note"><?php echo $description; ?></p><?php endif; ?>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </section>
          <?php endif; ?>
          <?php if(!empty(array_filter($related_03['group2']))): ?>
          <section class="u-mb-xs-40 u-mb-md-60" id="cat">
            <?php if($related_03['group2']['middlettl']): ?>
            <h4 class="l-ttl-sm"><?php echo $related_03['group2']['middlettl']; ?></h4>
            <?php endif; ?>
            <ul class="l-item-conts productsArticle-item-conts">
              <?php
                foreach($related_03['group2']['products'] as $pro):
                  $post_id = $pro->ID;
                  $thumbnail = get_the_post_thumbnail_url($post_id,'full');
                  if(!$thumbnail) $thumbnail = 'noimage';
                  $new_flg = get_field('model_new',$post_id);
                  $description = get_field('product_recommend_description', $post_id);
              ?>
              <li class="l-item l-item-bd0">
                <a href="<?php the_permalink($post_id); ?>">
                  <p class="l-item-img js-matchHeight">
                    <?php if($new_flg): ?>
                    <span class="productsArticle-item-new"><img src="/assets/images/products/lineup/icon-new.png" alt="NEW"></span>
                    <?php endif; ?>
                    <img src="<?php echo $thumbnail; ?>" alt="<?php echo get_the_title($post_id); ?> 製品イメージ">
                  </p>
                  <p class="l-item-ttl"><?php if($post_slug != 'gelato'): ?>型 式｜<?php endif; ?><?php echo get_the_title($post_id); ?></p>
                  <?php if($description): ?><p class="l-item-txt-note"><?php echo $description; ?></p><?php endif; ?>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </section>
          <?php endif; ?>
          <?php if(!empty(array_filter($related_03['group3']))): ?>
          <section class="u-mb-xs-40 u-mb-md-60" id="cat">
            <?php if($related_03['group3']['middlettl']): ?>
            <h4 class="l-ttl-sm"><?php echo $related_03['group3']['middlettl']; ?></h4>
            <?php endif; ?>
            <ul class="l-item-conts productsArticle-item-conts">
              <?php
                foreach($related_03['group3']['products'] as $pro):
                  $post_id = $pro->ID;
                  $thumbnail = get_the_post_thumbnail_url($post_id,'full');
                  if(!$thumbnail) $thumbnail = 'noimage';
                  $new_flg = get_field('model_new',$post_id);
                  $description = get_field('product_recommend_description', $post_id);
              ?>
              <li class="l-item l-item-bd0">
                <a href="<?php the_permalink($post_id); ?>">
                  <p class="l-item-img js-matchHeight">
                    <?php if($new_flg): ?>
                    <span class="productsArticle-item-new"><img src="/assets/images/products/lineup/icon-new.png" alt="NEW"></span>
                    <?php endif; ?>
                    <img src="<?php echo $thumbnail; ?>" alt="<?php echo get_the_title($post_id); ?> 製品イメージ">
                  </p>
                  <p class="l-item-ttl"><?php if($post_slug != 'gelato'): ?>型 式｜<?php endif; ?><?php echo get_the_title($post_id); ?></p>
                  <?php if($description): ?><p class="l-item-txt-note"><?php echo $description; ?></p><?php endif; ?>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </section>
          <?php endif; ?>
        </section>
        <?php endif; ?>
        <?php if($related_04 && !empty(array_filter($related_04)) && (!empty(array_filter($related_04['group1'])) || !empty(array_filter($related_04['group2'])) || !empty(array_filter($related_04['group3'])))): ?>
        <section class="u-mb-xs-60 u-mb-md-120">
          <?php if($related_04['subttl'] || $related_04['ttl']): ?>
          <div class="l-category">
            <?php if($related_04['subttl']): ?><span class="l-category-eng"><?php echo $related_04['subttl']; ?></span><?php endif; ?>
            <?php if($related_04['ttl']): ?><h3 class="l-category-ttl"><?php echo $related_04['ttl']; ?></h3><?php endif; ?>
          </div>
          <?php endif; ?>
          <?php if(!empty(array_filter($related_04['group1']))): ?>
          <section class="u-mb-xs-40 u-mb-md-60" id="cat">
            <?php if($related_04['group1']['middlettl']): ?>
            <h4 class="l-ttl-sm"><?php echo $related_04['group1']['middlettl']; ?></h4>
            <?php endif; ?>
            <ul class="l-item-conts productsArticle-item-conts">
              <?php
                foreach($related_04['group1']['products'] as $pro):
                  $post_id = $pro->ID;
                  $thumbnail = get_the_post_thumbnail_url($post_id,'full');
                  if(!$thumbnail) $thumbnail = 'noimage';
                  $new_flg = get_field('model_new',$post_id);
                  $description = get_field('product_recommend_description', $post_id);
              ?>
              <li class="l-item l-item-bd0">
                <a href="<?php the_permalink($post_id); ?>">
                  <p class="l-item-img js-matchHeight">
                    <?php if($new_flg): ?>
                    <span class="productsArticle-item-new"><img src="/assets/images/products/lineup/icon-new.png" alt="NEW"></span>
                    <?php endif; ?>
                    <img src="<?php echo $thumbnail; ?>" alt="<?php echo get_the_title($post_id); ?> 製品イメージ">
                  </p>
                  <p class="l-item-ttl"><?php if($post_slug != 'gelato'): ?>型 式｜<?php endif; ?><?php echo get_the_title($post_id); ?></p>
                  <?php if($description): ?><p class="l-item-txt-note"><?php echo $description; ?></p><?php endif; ?>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </section>
          <?php endif; ?>
          <?php if(!empty(array_filter($related_04['group2']))): ?>
          <section class="u-mb-xs-40 u-mb-md-60" id="cat">
            <?php if($related_04['group2']['middlettl']): ?>
            <h4 class="l-ttl-sm"><?php echo $related_04['group2']['middlettl']; ?></h4>
            <?php endif; ?>
            <ul class="l-item-conts productsArticle-item-conts">
              <?php
                foreach($related_04['group2']['products'] as $pro):
                  $post_id = $pro->ID;
                  $thumbnail = get_the_post_thumbnail_url($post_id,'full');
                  if(!$thumbnail) $thumbnail = 'noimage';
                  $new_flg = get_field('model_new',$post_id);
                  $description = get_field('product_recommend_description', $post_id);
              ?>
              <li class="l-item l-item-bd0">
                <a href="<?php the_permalink($post_id); ?>">
                  <p class="l-item-img js-matchHeight">
                    <?php if($new_flg): ?>
                    <span class="productsArticle-item-new"><img src="/assets/images/products/lineup/icon-new.png" alt="NEW"></span>
                    <?php endif; ?>
                    <img src="<?php echo $thumbnail; ?>" alt="<?php echo get_the_title($post_id); ?> 製品イメージ">
                  </p>
                  <p class="l-item-ttl"><?php if($post_slug != 'gelato'): ?>型 式｜<?php endif; ?><?php echo get_the_title($post_id); ?></p>
                  <?php if($description): ?><p class="l-item-txt-note"><?php echo $description; ?></p><?php endif; ?>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </section>
          <?php endif; ?>
          <?php if(!empty(array_filter($related_04['group3']))): ?>
          <section class="u-mb-xs-40 u-mb-md-60" id="cat">
            <?php if($related_04['group3']['middlettl']): ?>
            <h4 class="l-ttl-sm"><?php echo $related_04['group3']['middlettl']; ?></h4>
            <?php endif; ?>
            <ul class="l-item-conts productsArticle-item-conts">
              <?php
                foreach($related_04['group3']['products'] as $pro):
                  $post_id = $pro->ID;
                  $thumbnail = get_the_post_thumbnail_url($post_id,'full');
                  if(!$thumbnail) $thumbnail = 'noimage';
                  $new_flg = get_field('model_new',$post_id);
                  $description = get_field('product_recommend_description', $post_id);
              ?>
              <li class="l-item l-item-bd0">
                <a href="<?php the_permalink($post_id); ?>">
                  <p class="l-item-img js-matchHeight">
                    <?php if($new_flg): ?>
                    <span class="productsArticle-item-new"><img src="/assets/images/products/lineup/icon-new.png" alt="NEW"></span>
                    <?php endif; ?>
                    <img src="<?php echo $thumbnail; ?>" alt="<?php echo get_the_title($post_id); ?> 製品イメージ">
                  </p>
                  <p class="l-item-ttl"><?php if($post_slug != 'gelato'): ?>型 式｜<?php endif; ?><?php echo get_the_title($post_id); ?></p>
                  <?php if($description): ?><p class="l-item-txt-note"><?php echo $description; ?></p><?php endif; ?>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </section>
          <?php endif; ?>
        </section>
        <?php endif; ?>
        <?php if($related_05 && !empty(array_filter($related_05)) && (!empty(array_filter($related_05['group1'])) || !empty(array_filter($related_05['group2'])) || !empty(array_filter($related_05['group3'])))): ?>
        <section class="u-mb-xs-60 u-mb-md-120">
          <?php if($related_05['subttl'] || $related_05['ttl']): ?>
          <div class="l-category">
            <?php if($related_05['subttl']): ?><span class="l-category-eng"><?php echo $related_05['subttl']; ?></span><?php endif; ?>
            <?php if($related_05['ttl']): ?><h3 class="l-category-ttl"><?php echo $related_05['ttl']; ?></h3><?php endif; ?>
          </div>
          <?php endif; ?>
          <?php if(!empty(array_filter($related_05['group1']))): ?>
          <section class="u-mb-xs-40 u-mb-md-60" id="cat">
            <?php if($related_05['group1']['middlettl']): ?>
            <h4 class="l-ttl-sm"><?php echo $related_05['group1']['middlettl']; ?></h4>
            <?php endif; ?>
            <ul class="l-item-conts productsArticle-item-conts">
              <?php
                foreach($related_05['group1']['products'] as $pro):
                  $post_id = $pro->ID;
                  $thumbnail = get_the_post_thumbnail_url($post_id,'full');
                  if(!$thumbnail) $thumbnail = 'noimage';
                  $new_flg = get_field('model_new',$post_id);
                  $description = get_field('product_recommend_description', $post_id);
              ?>
              <li class="l-item l-item-bd0">
                <a href="<?php the_permalink($post_id); ?>">
                  <p class="l-item-img js-matchHeight">
                    <?php if($new_flg): ?>
                    <span class="productsArticle-item-new"><img src="/assets/images/products/lineup/icon-new.png" alt="NEW"></span>
                    <?php endif; ?>
                    <img src="<?php echo $thumbnail; ?>" alt="<?php echo get_the_title($post_id); ?> 製品イメージ">
                  </p>
                  <p class="l-item-ttl"><?php if($post_slug != 'gelato'): ?>型 式｜<?php endif; ?><?php echo get_the_title($post_id); ?></p>
                  <?php if($description): ?><p class="l-item-txt-note"><?php echo $description; ?></p><?php endif; ?>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </section>
          <?php endif; ?>
          <?php if(!empty(array_filter($related_05['group2']))): ?>
          <section class="u-mb-xs-40 u-mb-md-60" id="cat">
            <?php if($related_05['group2']['middlettl']): ?>
            <h4 class="l-ttl-sm"><?php echo $related_05['group2']['middlettl']; ?></h4>
            <?php endif; ?>
            <ul class="l-item-conts productsArticle-item-conts">
              <?php
                foreach($related_05['group2']['products'] as $pro):
                  $post_id = $pro->ID;
                  $thumbnail = get_the_post_thumbnail_url($post_id,'full');
                  if(!$thumbnail) $thumbnail = 'noimage';
                  $new_flg = get_field('model_new',$post_id);
                  $description = get_field('product_recommend_description', $post_id);
              ?>
              <li class="l-item l-item-bd0">
                <a href="<?php the_permalink($post_id); ?>">
                  <p class="l-item-img js-matchHeight">
                    <?php if($new_flg): ?>
                    <span class="productsArticle-item-new"><img src="/assets/images/products/lineup/icon-new.png" alt="NEW"></span>
                    <?php endif; ?>
                    <img src="<?php echo $thumbnail; ?>" alt="<?php echo get_the_title($post_id); ?> 製品イメージ">
                  </p>
                  <p class="l-item-ttl"><?php if($post_slug != 'gelato'): ?>型 式｜<?php endif; ?><?php echo get_the_title($post_id); ?></p>
                  <?php if($description): ?><p class="l-item-txt-note"><?php echo $description; ?></p><?php endif; ?>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </section>
          <?php endif; ?>
          <?php if(!empty(array_filter($related_05['group3']))): ?>
          <section class="u-mb-xs-40 u-mb-md-60" id="cat">
            <?php if($related_05['group3']['middlettl']): ?>
            <h4 class="l-ttl-sm"><?php echo $related_05['group3']['middlettl']; ?></h4>
            <?php endif; ?>
            <ul class="l-item-conts productsArticle-item-conts">
              <?php
                foreach($related_05['group3']['products'] as $pro):
                  $post_id = $pro->ID;
                  $thumbnail = get_the_post_thumbnail_url($post_id,'full');
                  if(!$thumbnail) $thumbnail = 'noimage';
                  $new_flg = get_field('model_new',$post_id);
                  $description = get_field('product_recommend_description', $post_id);
              ?>
              <li class="l-item l-item-bd0">
                <a href="<?php the_permalink($post_id); ?>">
                  <p class="l-item-img js-matchHeight">
                    <?php if($new_flg): ?>
                    <span class="productsArticle-item-new"><img src="/assets/images/products/lineup/icon-new.png" alt="NEW"></span>
                    <?php endif; ?>
                    <img src="<?php echo $thumbnail; ?>" alt="<?php echo get_the_title($post_id); ?> 製品イメージ">
                  </p>
                  <p class="l-item-ttl"><?php if($post_slug != 'gelato'): ?>型 式｜<?php endif; ?><?php echo get_the_title($post_id); ?></p>
                  <?php if($description): ?><p class="l-item-txt-note"><?php echo $description; ?></p><?php endif; ?>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </section>
          <?php endif; ?>
        </section>
        <?php endif; ?>
        <?php if($meta['products_base_related_under_text']): ?>
        <p class="l-item-ttl"><?php echo $meta['products_base_related_under_text']; ?></p>
        <?php endif; ?>
      </section>
      <?php if($meta['products_base_flag_blender']): ?>
      <div class="index-banner-area l-main-inner-section">
        <a href="/products/mixer/" class="index-banner"><img src="/assets/images/index/banner_mixerblender.png" alt="ミキサー/ブレンダー選びナビ お客様の用途や処理量に応じた、適切な機種選びをお手伝いいたします。"></a>
      </div>
      <?php endif; ?>
      <?php if($meta['products_base_flag_robotcoupe_demo']): ?>
      <div class="index-banner-area l-main-inner-section">
        <a href="https://fmi.smktg.jp/public/application/add/365" class="index-banner" target="_blank"><img src="/assets/top/items/slide08_pc_bnr.png" alt="ロボクープ　デモ機一週間無料貸出実施中"></a>
      </div>
      <?php endif; ?>
      <?php if($meta['products_base_flag_recipe']): ?>
      <section class="products-recipe">
        <div class="products-recipe__inner">
          <a href="<?php echo $meta['products_base_flag_recipe_url']; ?>"><img src="/assets/images/recipe/recipe_banner.jpg" alt="FMIレシピページ 豊富なレシピでお客様をサポートいたします。"></a>
        </div>
      </section>
      <?php endif; ?>
    </div>
  </main>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>window.jQuery || document.write( '<script src="/assets/js/lib/jquery-3.2.1.min.js"><\/script>' );</script>
<script src="/assets/js/lib/jquery.cookie.js"></script>
<script src="/assets/js/lib/css_browser_selector.js"></script>
<script src="/assets/js/lib/jQueryAutoHeight.js"></script>
<script src="/assets/js/lib/picturefill.min.js"></script>
<script src="/assets/js/common.js?2021"></script>
<?php get_footer(); ?>
