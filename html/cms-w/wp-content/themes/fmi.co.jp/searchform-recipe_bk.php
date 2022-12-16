<?php
  $recipe_categories =  get_terms('recipe_category',array('hide_empty' => false));
  $recipe_tags =  get_terms('recipe_tag',array('hide_empty' => false, 'parent' => 0));
  if(is_search()){
    $search_query = get_search_query();
  }
  $search_category = get_query_var('recipe_category');
  $search_tag = get_query_var('recipe_tag');
  if(!is_array($search_tag)) $search_tag = array($search_tag);
?>
<section class="recipe-search">
  <form method="GET" action="<?php echo home_url('/recipe'); ?>">
    <div class="recipe-search__parts">
      <div class="recipe-search__ttl">カテゴリー</div>
      <div class="recipe-search__body">
        <div class="recipe-search__selectbox">
          <select name="recipe_category" id="select_category">
            <option value="">カテゴリを絞り込む</option>
            <?php foreach($recipe_categories as $recipe_cat): ?>
              <option value="<?php echo $recipe_cat->slug; ?>"<?php if($search_category && $search_category == $recipe_cat->slug) echo ' selected' ?>><?php echo $recipe_cat->name; ?> [<?php echo $recipe_cat->count; ?>]</option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
    </div>
    <div class="recipe-search__parts recipe-search__parts--tag">
      <div class="recipe-search__ttl">タグ</div>
      <div class="recipe-search__body">
        <div class="recipe-search__checkbox">
          <?php
            foreach($recipe_tags as $recipe_tag):
              if($recipe_tag->slug == 'tag-search') continue;
              $tag_children = get_terms('recipe_tag', array('parent' => $recipe_tag->term_id, 'orderby' => 'none'));
              if($tag_children): ?>
                <div class="recipe-search-tag">
                <?php foreach($tag_children as $tag_child):
                  $tag_child_children = get_terms('recipe_tag', array('child_of' => $tag_child->term_id, 'orderby' => 'none'));
                  if($tag_child_children): ?>
                    <div class="recipe-search-tag__inner">
                    <?php foreach($tag_child_children as $tag_child_child): ?>
                      <label><input type='checkbox' value='<?php echo $tag_child_child->slug; ?>' name='recipe_tag[]' <?php if($search_tag && in_array($tag_child_child->slug, $search_tag)) echo ' checked'; ?>><span><?php echo $tag_child_child->name; ?>[<?php echo $tag_child_child->count; ?>]</span></label>
                    <?php endforeach; ?>
                    </div>
                  <?php else: ?>
                    <label><input type='checkbox' value='<?php echo $tag_child->slug; ?>' name='recipe_tag[]' <?php if($search_tag && in_array($tag_child->slug, $search_tag)) echo ' checked'; ?>><span><?php echo $tag_child->name; ?>[<?php echo $tag_child->count; ?>]</span></label>
                  <?php endif; ?>
                <?php endforeach; ?>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
        </div>
      </div>
    </div>
    <div class="recipe-search__parts">
      <div class="recipe-search__ttl">フリーワード</div>
      <div class="recipe-search__body">
        <input type="text" name="s" placeholder="検索キーワードを入力" value="<?php echo esc_attr($search_query); ?>">
      </div>
    </div>
    <div class="recipe-search__btn">
      <button type="submit" class="l-button">レシピを絞り込む</button>
    </div>
    <input type="hidden" name="search_type" value="recipe">
  </form>
</section>
<script>
$(function(){
  $('.recipe-search__parts--tag .recipe-search__ttl').on("click", function() {
    $('.recipe-search__parts--tag .recipe-search__body').slideToggle();
    $('.recipe-search__parts--tag').toggleClass('--open');
  });
});
</script>