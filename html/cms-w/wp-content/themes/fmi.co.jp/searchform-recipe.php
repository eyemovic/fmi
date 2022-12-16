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
  <form name="form-category">
    <div class="recipe-search__parts">
      <div class="recipe-search__ttl">使用機器から選ぶ</div>
      <div class="recipe-search__body recipe-search__body--category">
        <div class="recipe-search__selectbox">
          <select name="category" id="select_category">
            <option value="">選択してください</option>
            <?php foreach($recipe_categories as $recipe_cat): ?>
              <option value="<?php echo home_url('recipe/category/' . $recipe_cat->slug); ?>"<?php if($search_category && $search_category == $recipe_cat->slug) echo ' selected' ?>><?php echo $recipe_cat->name; ?> [<?php echo $recipe_cat->count; ?>]</option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="recipe-search__btn">
          <input class="l-button" type="button" accesskey="4" value="検索する" onclick="location.href=document.forms['form-category'].elements['category'].value">
        </div>
      </div>
    </div>
  </form>
</section>
<section class="recipe-search">
  <form name="form-tag">
    <div class="recipe-search__parts recipe-search__parts--tag">
      <div class="recipe-search__ttl">種類・食材・調理方法から選ぶ</div>
      <div class="recipe-search__body">
        <div class="recipe-search__checkbox">
          <?php
            foreach($recipe_tags as $recipe_tag):
              if($recipe_tag->slug == 'tag-search') continue;
              $tag_children = get_terms('recipe_tag', array('parent' => $recipe_tag->term_id, 'orderby' => 'none'));
              if($tag_children): ?>
          <div class="recipe-search-tag">
            <p class="recipe-search-tag__name"><?php if($recipe_tag->slug != 'tag-category') echo $recipe_tag->name; ?></p>
            <div class="recipe-search-tag__body">
                <?php foreach($tag_children as $tag_child):
                  $tag_child_children = get_terms('recipe_tag', array('child_of' => $tag_child->term_id, 'orderby' => 'none'));
                  if($tag_child_children): ?>
              <div class="recipe-search-tag__inner">
              <?php foreach($tag_child_children as $tag_child_child): ?>
                <label><input type='checkbox' value='<?php echo $tag_child_child->slug; ?>' name='recipe_tag[]' class="recipe_tag_checkbox" <?php if($search_tag && in_array($tag_child_child->slug, $search_tag)) echo ' checked'; ?>><span><?php echo $tag_child_child->name; ?>[<?php echo $tag_child_child->count; ?>]</span></label>
              <?php endforeach; ?>
              </div>
                  <?php else: ?>
              <label><input type='checkbox' value='<?php echo $tag_child->slug; ?>' name='recipe_tag[]' class="recipe_tag_checkbox" <?php if($search_tag && in_array($tag_child->slug, $search_tag)) echo ' checked'; ?>><span><?php echo $tag_child->name; ?>[<?php echo $tag_child->count; ?>]</span></label>
                  <?php endif; ?>
                <?php endforeach; ?>
            </div>
              <?php endif; ?>
          </div>
            <?php endforeach; ?>
        </div>
      </div>
    </div>
  </form>
</section>
<section class="recipe-search">
  <form method="GET" action="<?php echo home_url('/recipe'); ?>">
    <div class="recipe-search__parts recipe-search__parts--column">
      <div class="recipe-search__ttl">フリーワードで検索する</div>
      <div class="recipe-search__body">
        <input type="text" name="s" placeholder="レシピ名・材料名・機器名などを入力してください" value="<?php echo esc_attr($search_query); ?>">
      </div>
      <div class="recipe-search__btn">
        <button type="submit" class="l-button">検索する</button>
      </div>
    </div>
    <input type="hidden" name="search_type" value="recipe">
    <input type='hidden' value='8454' name='wpessid' />
  </form>
</section>
<script>
jQuery(function($){
  $('.recipe-search__parts--tag .recipe-search__ttl').on("click", function() {
    $('.recipe-search__parts--tag .recipe-search__body').slideToggle();
    $('.recipe-search__parts--tag').toggleClass('--open');
  });
});
jQuery(function($){
  let checkbox = $('.recipe_tag_checkbox');
  checkbox.click(function(){
    window.location.href = '<?php echo home_url('recipe/tag/'); ?>' + $(this).val();
  });
});
</script>