<?php
/*
Template Name: 会社概要ページ（英）
Template Post Type: page
*/
  get_header('en');
?>
<div class="l-contents">
  <main class="l-main is-xs-noPad">
    <div class="l-main-inner">
      <div id="content_area_b">
        <div id="content_area_c">
          <h1 class="en-ttl"><img src="/corporate_en/images/history_title.gif" alt="Corporate Information" width="544" height="39" /></h1>
<?php if(have_posts()): the_post(); the_content(); endif; ?>
        </div>
      </div>
    </div>
  </main>
</div>
<?php get_footer(); ?>