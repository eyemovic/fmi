<?php
$args = array(
    'post_type' => 'news',
    'post_status' => 'publish',
    'posts_per_page' => 5,
);
$the_query = new WP_Query($args);
if ($the_query->have_posts()) :
?>
    <div class="news-contents">
        <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
        <article class="index-post">
            <a href="<?php the_permalink(); ?>">
                <div class="index-post-meta">
                    <i class="index-post-label label-exhibition">展示会</i>
                    <div class="index-post-time-wrap">
                        <time class="index-post-time"><?php the_time('Y.m.d'); ?></time>
                    </div>
                </div><!-- //meta -->
                <div class="index-post-title"><?php the_title(); ?></div>
            </a>
        </article><!-- index-post -->
        <?php endwhile; ?>
    </div>
<?php endif; ?>
<?php wp_reset_query(); ?>