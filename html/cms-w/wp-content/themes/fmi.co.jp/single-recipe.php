<?php
/*====================================================================================
single-recipe.php
====================================================================================*/
?>
<?php
  get_header();
  global $post;
  $post_id = get_the_ID();
  $recipe_01 = get_field('recipe_group1');
  $recipe_02 = get_field('recipe_group2');
  $recipe_03 = get_field('recipe_group3');
  $recipe_04 = get_field('recipe_group3');
  $category = get_field('recipe_category');
  $brands = get_field('recipe_brand');
  $related = get_field('recipe_related');
  $ingredient_flag = get_field('recipe_ingredient_flag');
  $ingredient = get_field('recipe_ingredient');
  $ingredient_gelato = get_field('recipe_ingredient_gelato');
  $setting_unox = get_field('recipe_unox');
  $setting_metos = get_field('recipe_metos');
  $thumbnail = get_the_post_thumbnail_url($post->ID,'full');
?>
<div class="l-contents">
  <main class="l-main is-xs-noPad">
    <div class="l-main-inner">
      <nav class="l-bredNav">
        <ul class="l-bredNav-ul">
          <li class="l-bredNav-list"><a href="/" class="l-bredNav-link">TOP</a></li>
          <li class="l-bredNav-list"><a href="/recipe/" class="l-bredNav-link">レシピ</a></li>
          <li class="l-bredNav-list"><?php echo get_the_title(); ?></li>
        </ul>
      </nav>
    </div>
    <section class="recipe-post">
      <div class="l-main-inner recipe-post__inner">
        <article class="recipe-article">
          <h1 class="recipe-article__ttl"><?php echo get_the_title(); ?></h1>
          <?php if($category): ?>
          <div class="recipe-article__tag">
            <a href="/recipe/category/<?php echo $category[0]->slug; ?>/"><?php echo $category[0]->name; ?></a>
          </div>
          <?php endif; ?>
          <div class="recipe-article__thumbnail">
            <img src="<?php echo $thumbnail; ?>" alt="<?php echo get_the_title(); ?>">
          </div>
          <?php if($brands): ?>
          <div class="recipe-article__logo">
            <?php foreach($brands as $brand): $brand_logo = get_field('recipe_brand_logo','recipe_brand'.'_'.$brand->term_id); ?>
            <div class="recipe-article__logo-item">
              <img src="<?php echo $brand_logo['url']; ?>" alt="<?php echo $brand->name; ?>">
            </div>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
          <div class="recipe-article-ingredient<?php if($ingredient_flag == 'gelato') echo ' recipe-article-ingredient--gelato'; ?>">
            <h2 class="recipe-article-ingredient__ttl"><img src="/assets/images/recipe/icon-ingredient.svg">材料</h2>
            <div class="recipe-article-ingredient__inner">
              <?php
              if($ingredient_flag == 'normal'){
                if($ingredient) echo $ingredient;
              }elseif($ingredient_flag == 'gelato'){
                if($ingredient_gelato) echo $ingredient_gelato;
              }
              ?>
            </div>
          </div>
          <?php if(($recipe_01['recipe'] || $recipe_01['description']) && !strpos($recipe_01['recipe'], 'ダミーテキスト')): ?>
          <div class="recipe-article-recipe">
            <h2 class="recipe-article-recipe__ttl"><img src="/assets/images/recipe/icon-recipe.svg">レシピ</h2>
            <div class="recipe-article-recipe__inner">
              <div class="recipe-article-recipe-step">
                <?php if($recipe_01['ttl']): ?>
                <h3 class="recipe-article-recipe-step__ttl"><?php echo $recipe_01['ttl']; ?></h3>
                <?php endif; ?>
                <?php if($recipe_01['recipe'] && !strpos($recipe_01['recipe'], 'ダミーテキスト')) echo $recipe_01['recipe']; ?>
                <?php if($recipe_01['description']): ?>
                <div class="recipe-article-recipe-step__txt">
                  <?php echo $recipe_01['description']; ?>
                </div>
                <?php endif; ?>
              </div>
              <?php if($recipe_02['flg']): ?>
              <div class="recipe-article-recipe-step">
                <?php if($recipe_02['ttl']): ?>
                <h3 class="recipe-article-recipe-step__ttl"><?php echo $recipe_02['ttl']; ?></h3>
                <?php endif; ?>
                <?php if($recipe_02['recipe'] && !strpos($recipe_02['recipe'], 'ダミーテキスト')) echo $recipe_02['recipe']; ?>
                <?php if($recipe_02['description']): ?>
                <div class="recipe-article-recipe-step__txt">
                  <?php echo $recipe_02['description']; ?>
                </div>
                <?php endif; ?>
              </div>
              <?php endif; ?>
              <?php if($recipe_03['flg']): ?>
              <div class="recipe-article-recipe-step">
                <?php if($recipe_03['ttl']): ?>
                <h3 class="recipe-article-recipe-step__ttl"><?php echo $recipe_03['ttl']; ?></h3>
                <?php endif; ?>
                <?php if($recipe_03['recipe'] && !strpos($recipe_03['recipe'], 'ダミーテキスト')) echo $recipe_03['recipe']; ?>
                <?php if($recipe_03['description']): ?>
                <div class="recipe-article-recipe-step__txt">
                  <?php echo $recipe_03['description']; ?>
                </div>
                <?php endif; ?>
              </div>
              <?php endif; ?>
              <?php if($recipe_04['flg']): ?>
              <div class="recipe-article-recipe-step">
                <?php if($recipe_04['ttl']): ?>
                <h3 class="recipe-article-recipe-step__ttl"><?php echo $recipe_04['ttl']; ?></h3>
                <?php endif; ?>
                <?php if($recipe_04['recipe'] && !strpos($recipe_04['recipe'], 'ダミーテキスト')) echo $recipe_04['recipe']; ?>
                <?php if($recipe_04['description']): ?>
                <div class="recipe-article-recipe-step__txt">
                  <?php echo $recipe_04['description']; ?>
                </div>
                <?php endif; ?>
              </div>
              <?php endif; ?>
            </div>
          </div>
          <?php endif; ?>
          <?php if($setting_unox): ?>
          <div class="recipe-article-setting">
            <h2 class="recipe-article-setting__ttl"><img src="/assets/images/recipe/icon-oven.svg">UNOX設定</h2>
            <div class="recipe-article-setting__inner">
              <?php echo $setting_unox; ?>
            </div>
          </div>
          <?php endif; ?>
          <?php if($setting_metos): ?>
          <div class="recipe-article-setting">
            <h2 class="recipe-article-setting__ttl"><img src="/assets/images/recipe/icon-metos.svg">メトス設定</h2>
            <div class="recipe-article-setting__inner">
              <?php echo $setting_metos; ?>
            </div>
          </div>
          <?php endif; ?>
      </article>
      <aside class="recipe-related">
        <h2 class="recipe-related__ttl">関連製品</h2>
        <?php
          if($related): foreach($related as $related_item):
            $related_image = get_field('recipe_related_image','recipe_option'.'_'.$related_item->term_id);
            $related_url = get_field('recipe_related_url','recipe_option'.'_'.$related_item->term_id);
        ?>
        <div class="recipe-related-item">
          <a href="<?php echo $related_url; ?>">
            <div class="recipe-related-item__image">
              <img src="<?php echo $related_image['url']; ?>" alt="<?php echo $related_item->name; ?>">
            </div>
            <p class="recipe-related-item__ttl"><?php echo $related_item->name; ?></p>
          </a>
        </div>
        <?php endforeach; endif; ?>
      </aside>
    </div>
    <section class="recipe-archive" id="01">
      <div class="recipe-archive__inner">
        <h2 class="l-ttl-sm">他のレシピを見る</h2>
  <?php
    $args = array(
      'posts_per_page' => '3',
      'post_type' => 'recipe',
      'order' => 'DESC',
      'taxonomy' => 'recipe_category',
      'term' => $category[0]->slug,
      'post_status' => 'publish',
      'post__not_in' => array($post->ID)
    );
    $related_query = new WP_Query( $args );
    if ( $related_query->have_posts() ):
  ?>
        <div class="recipe-archive-list">
    <?php
      while ( $related_query->have_posts() ) :
        $related_query->the_post();
        $related_thumbnail = get_the_post_thumbnail_url($related_query->ID, 'medium' );
        $related_category = get_the_terms($related_query->ID, 'recipe_category');
        $related_brand = get_the_terms($related_query->ID, 'recipe_brand');
    ?>
          <article class="recipe-archive-list__item">
            <a href="<?php the_permalink(); ?>">
              <div class="recipe-archive-list__image">
                <img src="<?php echo $related_thumbnail; ?>" alt="<?php echo get_the_title(); ?>">
              </div>
              <div class="recipe-archive-list__body">
                <h3 class="recipe-archive-list__ttl"><?php echo get_the_title(); ?></h3>
                <div class="recipe-archive-list__tag">
                  <?php if($related_brand): foreach($related_brand as $r_brand): if($r_brand->name != $related_category[0]->name): ?>
                  <span><?php echo $r_brand->name; ?></span>
                  <?php endif; endforeach; endif; ?>
                  <?php if($related_category): ?>
                  <span><?php echo $related_category[0]->name; ?></span>
                  <?php endif; ?>
                </div>
              </div>
            </a>
          </article>
    <?php endwhile; ?>
        </div>
  <?php else: ?>
        <p>関連するレシピはありません。</p>
  <?php endif; wp_reset_postdata(); ?>
        <div class="recipe-archive__btn">
          <a href="/recipe/" class="l-button">レシピ一覧に戻る</a>
          <a href="/" class="l-button">トップページに戻る</a>
        </div>
      </div>
    </section>
  </main>
</div>
<?php get_footer(); ?>
<script>
jQuery(function($){
  let metos = $('.recipe-article-setting__table--metos');
  let metos_column = metos.find('tbody > tr');
  metos_column.each(function(){
    let metos_autoreverse = $(this).children('td').eq(5);
    metos_autoreverse.addClass('recipe-article-setting__checkbox');
    let metos_autoreverse_text = metos_autoreverse.text();
    if(metos_autoreverse_text == ''){
      metos_autoreverse.html('<img src="/assets/images/recipe/icon-checkbox.svg">');
    }else{
      metos_autoreverse.html('<img src="/assets/images/recipe/icon-checkbox-checked.svg">');
    }
  })
});
</script>