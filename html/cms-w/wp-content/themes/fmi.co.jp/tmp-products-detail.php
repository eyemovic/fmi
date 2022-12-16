<?php
/*
Template Name: 製品ページ（型番）
Template Post Type: products
*/
  get_header();
  $post_id = get_the_ID();
  $parent_id = $post->post_parent;
  $post_parent_slug = get_post($parent_id)->post_name;
  if($post_parent_slug == 'cat387'){
    $parent_id = get_posts(array('post_type' => 'products','name'=> 'pasteurizer','posts_per_page' => 1))[0]->ID;
    $post_parent_slug = get_post($parent_id)->post_name;
  }
  $meta_key = array('model_tag1','model_tag2','model_number','model_description','model_btn_contact','model_btn_contact_url','model_btn_catalog','model_btn_catalog_pdf','model_btn_manual','model_btn_manual_pdf','model_btn_scale','model_btn_scale_pdf','model_btn_cad','model_btn_cad_url','model_btn_demo','model_btn_demo_url','model_new','model_caption','model_image_position_top');
  $meta = array();
  foreach($meta_key as $key){
    $meta[$key] = get_field($key,$post_id);
  }
  $option_01 = get_field('model_option1');
  $option_02 = get_field('model_option2');
  $option_03 = get_field('model_option3');
  $thumbnail = get_the_post_thumbnail_url($post_id,'full');
  $tag_01 = explode(',', get_field('model_tag1'));
  $tag_02 = explode(',', get_field('model_tag2'));
  $description_01 = get_field('model_description_group1');
  $description_02 = get_field('model_description_group2');
  $number = get_field('model_number');
  if(!$number) $number = str_replace('非公開: ', '', get_the_title());
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
          <li class="l-bredNav-list"> <?php echo str_replace('非公開: ', '', get_the_title()); ?></li>
        </ul>
      </nav>
      <ul class="brandDetail-tag-conts brandDetail-tag-conts--top u-mb-xs-10 u-mb-md-20">
        <?php if(!empty(array_filter($tag_01))): foreach($tag_01 as $tag): ?>
        <li class="brandDetail-tag brandDetail-tag--blue"><?php echo $tag; ?></li>
        <?php endforeach; endif; ?>
      </ul>
      <section>
        <div class="l-mainConts">
          <h1 class="l-page-ttl-v3 brandDetail-page-ttl-v3"><?php if($post_parent_slug != 'gelato'): ?>型 式｜<?php endif; ?><?php echo str_replace('非公開: ', '', get_the_title()); ?></h1>
          <section>
            <div class="brandDetail-card u-mb-xs-40">
              <div class="brandDetail-card-inner">
                <h2 class="l-ttl-md u-mb-xs-0 u-mb-md-10"><?php echo $number; ?></h2>
                <?php if($meta['model_description']): ?>
                <p class="l-txt-sm u-fw-b u-mb-xs-15"><?php the_field('model_description'); ?></p>
                <?php endif; ?>
                <p class="l-card-img<?php if($meta['model_image_position_top']) echo ' is-position-top'; ?>">
                  <?php if($meta['model_new']): ?>
                  <span class="brandDetail-new"><img src="/assets/images/products/lineup/icon-new.png" alt="NEW"></span>
                  <?php endif; ?>
                  <img src="<?php echo $thumbnail; ?>" alt="型 式｜<?php echo str_replace('非公開: ', '', get_the_title()); ?>">
                </p>
                <?php if($meta['model_btn_demo'] && $meta['model_btn_demo_url']): ?>
                <p class="brandContact-btn"><a href="<?php echo $meta['model_btn_demo_url']; ?>" target="_blank"><span>無料デモ機・貸出希望<br class="u-hidden-o-md">問い合わせページ</span></a></p>
                <?php endif; ?>
                <div class="l-card-txt">
                  <ul class="brandDetail-tag-conts u-mb-xs-20 u-mb-md-25">
                    <?php if(!empty(array_filter($tag_02))): foreach($tag_02 as $tag): ?>
                    <li class="brandDetail-tag brandDetail-tag--gray"><?php echo $tag; ?></li>
                    <?php endforeach; endif; ?>
                  </ul>
                  <?php if($meta['model_btn_contact'] && $meta['model_btn_contact_url']): ?>
                  <p class="brandDetail-btn u-mb-xs-10"><a href="<?php echo $meta['model_btn_contact_url']; ?>" target="_blank">お問い合わせはこちら</a></p>
                  <?php endif; ?>
                  <?php if($meta['model_btn_catalog'] && $meta['model_btn_catalog_pdf']): ?>
                  <p class="brandDetail-btn u-mb-xs-10"><a href="<?php echo $meta['model_btn_catalog_pdf']; ?>" target="_blank">カタログPDFはこちら</a></p>
                  <?php endif; ?>
                  <?php if($meta['model_btn_manual'] && $meta['model_btn_manual_pdf']): ?>
                  <p class="brandDetail-btn u-mb-xs-10"><a href="<?php echo $meta['model_btn_manual_pdf']; ?>" target="_blank">取扱説明書PDFはこちら</a></p>
                  <?php endif; ?>
                  <?php if($meta['model_btn_scale'] && $meta['model_btn_scale_pdf']): ?>
                  <p class="brandDetail-btn u-mb-xs-10"><a href="<?php echo $meta['model_btn_scale_pdf']; ?>" target="_blank">外形寸法／承認図</a></p>
                  <?php endif; ?>
                  <?php if($meta['model_btn_cad'] && $meta['model_btn_cad_url']): ?>
                  <p class="brandDetail-btn"><a href="<?php echo $meta['model_btn_cad_url']; ?>" target="_blank">CADデータ／DXF</a></p>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <?php the_content(); ?>
            <div class="brandDetail-caption l-txt-sm u-mb-xs-30 u-mb-md-70">
              <?php if($meta['model_caption']) the_field('model_caption'); ?>
            </div>
            <?php if($option_01 && !empty(array_filter($option_01))): ?>
            <section>
              <?php if($option_01['option_heading']): ?><h3 class="l-mainConts-ttl"><?php echo $option_01['option_heading']; ?></h3><?php endif; ?>
              <ul class="l-item-conts brandDetail-item-conts u-mb-xs-15  u-mb-xs-20">
                <?php
                  foreach($option_01['option_item'] as $op):
                    $op_image = get_field('product_option_image','products_option'.'_'.$op->term_id);
                    $op_name = get_field('product_option_txt','products_option'.'_'.$op->term_id);
                    if(!$op_name) $op_name = $op->name;
                ?>
                <li class="l-item">
                  <div>
                    <p class="l-item-img"><img src="<?php echo $op_image['url']; ?>" alt="<?php echo $op_name; ?>"></p>
                    <p class="l-item-ttl"><?php echo $op_name; ?></p>
                  </div>
                  <p class="l-item-caption"><?php echo $op->description; ?></p>
                </li>
                <?php endforeach; ?>
              </ul>
              <?php if($option_01['option_txt']): ?>
              <div class="brandDetail-caption l-txt-sm">
                <?php echo $option_01['option_txt']; ?>
              </div>
              <?php endif; ?>
            </section>
            <?php endif; ?>
            <?php if($option_02 && !empty(array_filter($option_02))): ?>
            <section>
              <?php if($option_02['option_heading']): ?><h3 class="l-mainConts-ttl"><?php echo $option_02['option_heading']; ?></h3><?php endif; ?>
              <ul class="l-item-conts brandDetail-item-conts u-mb-xs-15  u-mb-xs-20">
                <?php
                  foreach($option_02['option_item'] as $op):
                    $op_image = get_field('product_option_image','products_option'.'_'.$op->term_id);
                    $op_name = get_field('product_option_txt','products_option'.'_'.$op->term_id);
                    if(!$op_name) $op_name = $op->name;
                ?>
                <li class="l-item">
                  <div>
                    <p class="l-item-img"><img src="<?php echo $op_image['url']; ?>" alt="<?php echo $op_name; ?>"></p>
                    <p class="l-item-ttl"><?php echo $op_name; ?></p>
                  </div>
                  <p class="l-item-caption"><?php echo $op->description; ?></p>
                </li>
                <?php endforeach; ?>
              </ul>
              <?php if($option_02['option_txt']): ?>
              <div class="brandDetail-caption l-txt-sm">
                <?php echo $option_02['option_txt']; ?>
              </div>
              <?php endif; ?>
            </section>
            <?php endif; ?>
            <?php if($option_03 && !empty(array_filter($option_03))): ?>
            <section>
              <?php if($option_03['option_heading']): ?><h3 class="l-mainConts-ttl"><?php echo $option_03['option_heading']; ?></h3><?php endif; ?>
              <ul class="l-item-conts brandDetail-item-conts u-mb-xs-15  u-mb-xs-20">
                <?php
                  foreach($option_03['option_item'] as $op):
                    $op_image = get_field('product_option_image','products_option'.'_'.$op->term_id);
                    $op_name = get_field('product_option_txt','products_option'.'_'.$op->term_id);
                    if(!$op_name) $op_name = $op->name;
                ?>
                <li class="l-item">
                  <div>
                    <p class="l-item-img"><img src="<?php echo $op_image['url']; ?>" alt="<?php echo $op_name; ?>"></p>
                    <p class="l-item-ttl"><?php echo $op_name; ?></p>
                  </div>
                  <p class="l-item-caption"><?php echo $op->description; ?></p>
                </li>
                <?php endforeach; ?>
              </ul>
              <?php if($option_03['option_txt']): ?>
              <div class="brandDetail-caption l-txt-sm">
                <?php echo $option_03['option_txt']; ?>
              </div>
              <?php endif; ?>
            </section>
            <?php endif; ?>
            <?php if($description_01['flg']): ?>
            <section>
              <?php if($description_01['ttl']): ?><h3 class="l-mainConts-ttl"><?php echo $description_01['ttl']; ?></h3><?php endif; ?>
              <div class="u-mb-xs-15  u-mb-xs-20">
                <?php echo $description_01['content']; ?>
              </div>
            </section>
            <?php endif; ?>
            <?php if($description_02['flg']): ?>
            <section>
              <?php if($description_02['ttl']): ?><h3 class="l-mainConts-ttl"><?php echo $description_02['ttl']; ?></h3><?php endif; ?>
              <div class="u-mb-xs-15  u-mb-xs-20">
                <?php echo $description_02['content']; ?>
              </div>
            </section>
            <?php endif; ?>
          </section>
        </div>
      </section>
    </div>
  </main>
</div>
<?php get_footer(); ?>