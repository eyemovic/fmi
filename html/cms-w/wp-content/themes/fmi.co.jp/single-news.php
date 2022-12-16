<?php
/*====================================================================================
single-news.php
====================================================================================*/
?>
<?php
  get_header();
  the_post();
  $post_id = get_the_ID();
  $thumbnail = get_the_post_thumbnail_url($post->ID,'medium');
  $category = get_the_terms($post_id, 'news_category');
  $metas = array('news_flag_link','news_link_text','news_link_pdf','news_link_url','news_flag_blank');
  $meta = array();
  foreach($metas as $key){
    $meta[$key] = get_field($key, $post_id);
  }
?>
<div class="l-contents">
<main class="l-main is-xs-noPad">
  <div class="l-main-inner">
    <nav class="l-bredNav">
      <ul class="l-bredNav-ul">
        <li class="l-bredNav-list"><a href="/" class="l-bredNav-link">TOP</a></li>
        <li class="l-bredNav-list"><a href="/news/" class="l-bredNav-link">ニュース</a></li>
        <li class="l-bredNav-list"><?php echo get_the_title(); ?></li>
      </ul>
    </nav>
    <h1 class="l-page-ttl">NEWS<span>ニュース</span></h1>
    <div class="l-mainConts u-mb-xs-30 u-mb-md-40">
      <section>
        <div class="newsDetail-header u-mb-xs-20 u-mb-md-30">
          <div class="index-post-meta news-index-post-meta">
            <?php if($category): foreach($category as $cat):
      switch($cat->slug){
        case 'seminar': $cat_class=" label-seminar"; break;
        case 'exhibition': $cat_class=" label-exhibition"; break;
        default: $cat_class="";
      } ?>
              <i class="index-post-label<?php if($cat_class) echo $cat_class; ?>"><?php echo $cat->name; ?></i>
            <?php endforeach; endif; ?>
            <div class="index-post-time-wrap">
              <time class="index-post-time"><?php the_date('Y.m.d'); ?></time>
            </div>
          </div>
        </div>
        <h2 class="seminar-ttl-md u-mb-xs-20 u-mb-md-60"><?php echo get_the_title(); ?></h2>
        <p class="u-mb-xs-20 u-mb-md-35"><img src="<?php echo $thumbnail; ?>"></p>
        <div class="l-txt u-mb-xs-30 u-mb-md-40 news-content">
          <?php the_content(); ?>
        </div>
        <?php if($meta['news_flag_link'] == '1' && $meta['news_link_url']): ?>
        <p><a href="<?php echo $meta['news_link_url']; ?>"<?php if($meta['news_flag_blank']) echo ' target="_blank"'; ?> class="l-link-ttl"><?php echo $meta['news_link_text']; ?></a></p>
        <?php elseif($meta['news_flag_link'] == '2' && $meta['news_link_pdf']): ?>
        <p><a href="<?php echo $meta['news_link_pdf']; ?>"<?php if($meta['news_flag_blank']) echo ' target="_blank"'; ?> class="l-link-ttl"><?php echo $meta['news_link_text']; ?></a></p>
        <?php endif; ?>
      </section>
    </div>

    <p class="l-link-back-btn"><a href="/news/">ニュース一覧へもどる</a></p>
  </div>
</main>
<?php get_footer(); ?>