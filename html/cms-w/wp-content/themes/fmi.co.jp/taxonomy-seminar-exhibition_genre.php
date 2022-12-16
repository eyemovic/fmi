<?php
/*====================================================================================
taxonomy-seminar-exhibition_category.php
====================================================================================*/
  get_header();
  global $wp_query;
  $page = get_query_var( 'paged' );
  $seminar_category = get_terms('seminar-exhibition_category',array('hide_empty' => false));
  $seminar_area = get_terms('seminar-exhibition_area',array('hide_empty' => false));
  $term = get_queried_object();
  if($term->slug == 'coffee-stepup'){
    $title = '<span class="small">エスプレッソ/カプチーノ</span>　コーチングDAY';
  }elseif($term->slug == 'unox-live'){
    $title = 'UNOX Live';
  }else{
    $title = $term->name . 'セミナー';
  }
  $metas = array('seminar_genre_title','seminar_genre_text','seminar_genre_mv','seminar_genre_instructor1','seminar_genre_instructor2','seminar_genre_instructor3','seminar_genre_content','seminar_genre_price','seminar_genre_target','seminar_genre_time','seminar_genre_capacity','seminar_genre_remarks','seminar_genre_place','seminar_genre_contact');
  $meta = array();
  foreach($metas as $key){
    $meta[$key] = get_field($key, $term->taxonomy.'_'.$term->term_id);
  }
  $date = array();
  $date['now']['year'] = wp_date('Y');
  $date['now']['month'] = wp_date('n');
  $date['now']['date'] = wp_date('Y-m-d');
  $date['m0']['first'] = wp_date('Y-m-01');
  $date['m0']['last'] = wp_date('Y-m-t');
  $date['m1']['year'] = wp_date('Y', strtotime($date['m0']['first'] . '+1 month'));
  $date['m1']['month'] = wp_date('n', strtotime($date['m0']['first'] . '+1 month'));
  $date['m1']['first'] = wp_date('Y-m-01', strtotime($date['m0']['first'] . '+1 month'));
  $date['m1']['last'] = wp_date('Y-m-t', strtotime($date['m0']['first'] . '+1 month'));
  $date['m2']['year'] = wp_date('Y', strtotime($date['m0']['first'] . '+2 month'));
  $date['m2']['month'] = wp_date('n', strtotime($date['m0']['first'] . '+2 month'));
  $date['m2']['first'] = wp_date('Y-m-01', strtotime($date['m0']['first'] . '+2 month'));
  $date['m2']['last'] = wp_date('Y-m-t', strtotime($date['m0']['first'] . '+2 month'));
  $args = array(
    'posts_per_page' => -1,
    'post_type' => 'seminar-exhibition',
    'post_status' => 'publish',
    'meta_key' => 'seminar_date_start',
    'orderby' => 'meta_value',
    'order' => 'ASC',
    'type' => 'DATE',
    'meta_query' => array(
      'relation' => 'AND',
      array(
        'key' => 'seminar_date_start',
        'compare' => '>=',
        'type' => 'DATE'
      ),
      array(
        'key' => 'seminar_date_end',
        'compare' => '<=',
        'type' => 'DATE'
      )
      ),
      'tax_query' => array(
        'relation' => 'AND',
        array(
          'taxonomy' => 'seminar-exhibition_area',
          'field' => 'slug'
        ),
        array(
          'taxonomy' => 'seminar-exhibition_genre',
          'field' => 'slug'
        )
      )
  );
?>
<div class="l-contents">
  <main class="l-main is-xs-noPad">
    <div class="l-main-inner">
      <nav class="l-bredNav">
        <ul class="l-bredNav-ul">
          <li class="l-bredNav-list"><a href="/" class="l-bredNav-link">TOP</a></li>
          <li class="l-bredNav-list"><a href="/seminar-exhibition" class="l-bredNav-link">セミナー / 展示会情報</a></li>
          <li class="l-bredNav-list"><?php echo $title; ?></li>
        </ul>
      </nav>
      <h1 class="l-page-ttl-v2">SEMINAR / EXHIBITION<span><?php echo $title; ?></span></h1>
      <p class="u-mb-xs-20 u-mb-md-35"><img src="<?php echo $meta['seminar_genre_mv']; ?>" alt="<?php echo $term->name; ?>"></p>
      <section>
        <h2 class="seminar-ttl-md"><?php echo $meta['seminar_genre_title']; ?></h2>
        <p class="l-txt u-mb-xs-20 u-mb-md-40">
        <?php echo $meta['seminar_genre_text']; ?>
        </p>
        <div class="seminar-calender-wrapper" id="schedule">
          <div class="seminar-calender-heading">
            <div class="current-calender current-calender--long"><?php echo $term->name; ?>セミナースケジュール</div>
          </div>
          <div class="seminar-calender">
            <table>
              <tbody>
                <tr>
                  <th rowspan="2">開催地</th>
                  <?php if($date['m2']['year'] != $date['now']['year']): ?>
                  <td class="seminar-calender-year"><?php echo $date['now']['year']; ?>年</td>
                  <td colspan="2" class="seminar-calender-year"><?php echo $date['m2']['year']; ?>年</td>
                  <?php elseif($date['m1']['year'] != $date['now']['year']): ?>
                  <td class="seminar-calender-year"><?php echo $date['now']['year']; ?>年</td>
                  <td colspan="1" class="seminar-calender-year"><?php echo $date['m1']['year']; ?>年</td>
                  <?php else: ?>
                  <td colspan="3" class="seminar-calender-year"><?php echo $date['now']['year']; ?>年</td>
                  <?php endif; ?>
                </tr>
                <tr>
                  <td class="seminar-calender-month"><?php echo $date['now']['month']; ?>月</td>
                  <td class="seminar-calender-month"><?php echo $date['m1']['month']; ?>月</td>
                  <td class="seminar-calender-month"><?php echo $date['m2']['month']; ?>月</td>
                </tr>
                <?php foreach($seminar_area as $area): ?>
                <tr>
                  <th><?php echo $area->name; ?></th>
                  <td>
                    <ul class="semina-calender-list">
                      <?php
                        $args['meta_query'][0]['value'] = $date['now']['date'];
                        $args['meta_query'][1]['value'] = $date['m0']['last'];
                        $args['tax_query'][0]['terms'] = $area->slug;
                        $args['tax_query'][1]['terms'] = $term->slug;
                        include('parts/seminar-calendar-post.php');
                      ?>
                    </ul>
                  </td>
                  <td>
                    <ul class="semina-calender-list">
                      <?php
                        $args['meta_query'][0]['value'] = $date['m1']['first'];
                        $args['meta_query'][1]['value'] = $date['m1']['last'];
                        $args['tax_query'][0]['terms'] = $area->slug;
                        $args['tax_query'][1]['terms'] = $term->slug;
                        include('parts/seminar-calendar-post.php');
                      ?>
                    </ul>
                  </td>
                  <td>
                    <ul class="semina-calender-list">
                      <?php
                        $args['meta_query'][0]['value'] = $date['m2']['first'];
                        $args['meta_query'][1]['value'] = $date['m2']['last'];
                        $args['tax_query'][0]['terms'] = $area->slug;
                        $args['tax_query'][1]['terms'] = $term->slug;
                        include('parts/seminar-calendar-post.php');
                      ?>
                    </ul>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="l-mainConts">
          <?php if($meta['seminar_genre_instructor1']['flag'] && (!$meta['seminar_genre_instructor2']['flag'] && !$meta['seminar_genre_instructor3']['flag'])): ?>
          <p class="seminar-teacher-img u-mb-xs-10 u-mb-md-20">
            <?php if($meta['seminar_genre_instructor1']['image1']): ?><img src="<?php echo $meta['seminar_genre_instructor1']['image1']; ?>"><?php endif; ?><?php if($meta['seminar_genre_instructor1']['image2']): ?><img src="<?php echo $meta['seminar_genre_instructor1']['image2']; ?>"><?php endif; ?><?php if($meta['seminar_genre_instructor1']['image3']): ?><img src="<?php echo $meta['seminar_genre_instructor1']['image3']; ?>"><?php endif; ?>
          </p>
          <div class="seminar-teacher">
            <p class="seminar-teacher-position"><?php echo $meta['seminar_genre_instructor1']['position']; ?></p>
            <p class="seminar-teacher-name"><?php echo $meta['seminar_genre_instructor1']['name']; ?><span><?php echo $meta['seminar_genre_instructor1']['name_eng']; ?></span></p>
          </div>
          <?php else: ?>
          <div class="seminar-teacher-card-wrap u-mb-xs-40 u-mb-md-80" style="justify-content:center;">
            <?php if($meta['seminar_genre_instructor1']['flag']): ?>
            <div class="u-mb-xs-10 u-mb-md-0 seminar-teacher-card">
              <p><img src="<?php echo $meta['seminar_genre_instructor1']['image1']; ?>"></p>
              <div class="seminar-teacher">
                <p class="seminar-teacher-position"><?php echo $meta['seminar_genre_instructor1']['position']; ?></p>
                <p class="seminar-teacher-name"><?php echo $meta['seminar_genre_instructor1']['name']; ?><span><?php echo $meta['seminar_genre_instructor1']['name_eng']; ?></span></p>
              </div>
            </div>
            <?php endif; ?>
            <?php if($meta['seminar_genre_instructor2']['flag']): ?>
            <div class="<?php if(!$meta['seminar_genre_instructor3']['flag']) echo "u-mb-xs-10 u-mb-md-0 "; ?>seminar-teacher-card">
              <p><img src="<?php echo $meta['seminar_genre_instructor2']['image1']; ?>"></p>
              <div class="seminar-teacher">
                <p class="seminar-teacher-position"><?php echo $meta['seminar_genre_instructor2']['position']; ?></p>
                <p class="seminar-teacher-name"><?php echo $meta['seminar_genre_instructor2']['name']; ?><span><?php echo $meta['seminar_genre_instructor2']['name_eng']; ?></span></p>
              </div>
            </div>
            <?php endif; ?>
            <?php if($meta['seminar_genre_instructor3']['flag']): ?>
            <div class="seminar-teacher-card">
              <p><img src="<?php echo $meta['seminar_genre_instructor3']['image1']; ?>"></p>
              <div class="seminar-teacher">
                <p class="seminar-teacher-position"><?php echo $meta['seminar_genre_instructor3']['position']; ?></p>
                <p class="seminar-teacher-name"><?php echo $meta['seminar_genre_instructor3']['name']; ?><span><?php echo $meta['seminar_genre_instructor3']['name_eng']; ?></span></p>
              </div>
            </div>
            <?php endif; ?>
          </div>
          <?php endif; ?>
          <section>
            <?php echo $meta['seminar_genre_content']; ?>
            <table class="l-table-v1 l-td-left">
              <tbody>
                <?php if($meta['seminar_genre_price']): ?>
                <tr>
                  <th>参加料金</th>
                  <td><?php echo $meta['seminar_genre_price']; ?></td>
                </tr>
                <?php endif; ?>
                <?php if($meta['seminar_genre_target']): ?>
                <tr>
                  <th>対　　象</th>
                  <td><?php echo $meta['seminar_genre_target']; ?></td>
                </tr>
                <?php endif; ?>
                <?php if($meta['seminar_genre_time']): ?>
                <tr>
                  <th>講習時間</th>
                  <td><?php echo $meta['seminar_genre_time']; ?></td>
                </tr>
                <?php endif; ?>
                <?php if($meta['seminar_genre_capacity']): ?>
                <tr>
                  <th>定　　員</th>
                  <td><?php echo $meta['seminar_genre_capacity']; ?></td>
                </tr>
                <?php endif; ?>
                <?php if($meta['seminar_genre_remarks']): ?>
                <tr>
                  <th>備　　考</th>
                  <td><?php echo $meta['seminar_genre_remarks']; ?></td>
                </tr>
                <?php endif; ?>
                <?php if($meta['seminar_genre_place']): ?>
                <tr>
                  <th>開催日・場所</th>
                  <td><?php echo $meta['seminar_genre_place']; ?></td>
                </tr>
                <?php endif; ?>
                <?php if($meta['seminar_genre_contact']): ?>
                <tr>
                  <th>申込方法</th>
                  <td><?php echo $meta['seminar_genre_contact']; ?></td>
                </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </section>
        </div>
      </section>
    </div>
  </main>
</div>
<?php get_footer(); ?>