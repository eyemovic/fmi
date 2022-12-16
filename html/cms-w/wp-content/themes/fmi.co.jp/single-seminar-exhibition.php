<?php
/*====================================================================================
single-seminar-exhibition.php
====================================================================================*/
?>
<?php
  get_header();
  global $post;
  $post_id = get_the_ID();
  $thumbnail = get_the_post_thumbnail_url($post->ID,'medium');
  $category = get_the_terms($post_id, 'seminar-exhibition_category');
  $area = get_the_terms($post_id, 'seminar-exhibition_area');
  $genre = get_the_terms($post_id, 'seminar-exhibition_genre');
  $status = get_the_terms($post_id, 'seminar-exhibition_status');
  $metas = array('seminar_date_start','seminar_date_end','seminar_description','seminar_time','seminar_price','seminar_target','seminar_term','seminar_place','seminar_owner','seminar_btn');
  $meta = array();
  foreach($metas as $key){
    $meta[$key] = get_field($key, $post_id);
  }
  switch($category[0]->slug){
    case 'seminar':
      $cat_name = 'セミナー'; $cat_class="label-seminar";
      break;
    case 'exhibition':
      $cat_name = '展示会'; $cat_class="label-exhibition";
      break;
    case 'stored-seminar':
      $cat_name = 'セミナー'; $cat_class="label-seminar";
      break;
    case 'stored-exhibition':
      $cat_name = '展示会'; $cat_class="label-exhibition";
      break;
  }
?>
<div class="l-contents">
  <main class="l-main is-xs-noPad">
    <div class="l-main-inner">
      <nav class="l-bredNav">
        <ul class="l-bredNav-ul">
          <li class="l-bredNav-list"><a href="/" class="l-bredNav-link">TOP</a></li>
          <li class="l-bredNav-list"><a href="/seminar-exhibition/" class="l-bredNav-link">セミナー / 展示会情報</a></li>
          <li class="l-bredNav-list"><?php echo get_the_title(); ?></li>
        </ul>
      </nav>
      <h1 class="l-page-ttl">SEMINAR / EXHIBITION<span>セミナー / 展示会情報</span></h1>
      <div class="l-mainConts u-mb-xs-30 u-mb-md-40">
        <section>
          <div class="seminarDetail-header u-mb-xs-20 u-mb-md-30">
            <div class="seminar_exhibition-post-meta">
              <?php if($category && $category[0]->slug != 'spot'): ?>
              <i class="seminar_exhibition-label <?php echo $cat_class; ?>"><?php echo $cat_name; ?></i>
              <?php endif; ?>
              <?php if($area): ?>
              <i class="seminar_exhibition-area"><?php echo $area[0]->name; ?></i>
              <?php endif; ?>
            </div>
          </div>
          <h2 class="seminar-ttl-md u-mb-xs-20 u-mb-md-60"><?php echo get_the_title(); ?></h2>
          <?php if($thumbnail): ?>
          <p class="u-mb-xs-20 u-mb-md-35">
            <img src="<?php echo $thumbnail; ?>" alt="">
          </p>
          <?php endif; ?>
          <div class="seminar-content l-txt u-mb-xs-20 u-mb-md-40">
            <?php the_content(); ?>
          </div>
          <?php if($category[0]->slug == 'seminar' || $category[0]->slug == 'stored-seminar'): ?>
          <div class="u-mb-xs-20 u-mb-md-40">
            <?php if($genre[0]->slug == 'new-cooking' || $genre[0]->slug == 'unox-live'): ?>
            <a href="/consulting/#01" class="l-button">セミナー講師紹介へ</a>
            <?php elseif($genre[0]->slug != 'new-cooking' && $genre[0]->slug != 'unox-live'): ?>
            <a href="/consulting/#02" class="l-button">セミナー講師紹介へ</a>
            <?php endif; ?>
          </div>
          <?php endif; ?>
          <?php if($meta['seminar_description']): $desc_list = explode(',', $meta['seminar_description']); ?>
          <h3 class="l-ttl-sm"><?php echo $category[0]->name; ?>内容</h3>
          <ul class="seminar_exhibition-about l-list-circle l-txt u-mb-xs-20 u-mb-md-40">
            <?php foreach($desc_list as $desc): ?>
              <li><?php echo $desc; ?></li>
            <?php endforeach; ?>
          </ul>
          <?php endif; ?>
          <table class="l-table-v1 l-td-left u-mb-xs-30 u-mb-md-60 single-seminar-table">
            <tbody>
              <?php if($meta['seminar_price']): ?>
              <tr>
                <th>参加料金</th>
                <td><?php echo $meta['seminar_price']; ?></td>
              </tr>
              <?php endif; ?>
              <?php if($meta['seminar_target']): ?>
              <tr>
                <th>対　象</th>
                <td><?php echo $meta['seminar_target']; ?></td>
              </tr>
              <?php endif; ?>
              <?php if($meta['seminar_time']): ?>
              <tr>
                <th>講習時間</th>
                <td><?php echo $meta['seminar_time']; ?></td>
              </tr>
              <?php endif; ?>
              <?php if($meta['seminar_term']): ?>
              <tr>
                <th>会　期</th>
                <td><?php echo $meta['seminar_term']; ?></td>
              </tr>
              <?php endif; ?>
              <?php if($meta['seminar_place']): ?>
              <tr>
                <th>会　場</th>
                <td><?php echo $meta['seminar_place']; ?></td>
              </tr>
              <?php endif; ?>
              <?php if($meta['seminar_owner']): ?>
              <tr>
                <th>主　催</th>
                <td><?php echo $meta['seminar_owner']; ?></td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
          <?php if($category[0]->slug == 'seminar' || $category[0]->slug == 'stored-seminar'): ?>
          <div class="u-mb-xs-20 u-mb-md-40">
          <?php if($status[0]->slug == 'now' || $status[0]->slug == 'few'): ?>
            <?php if($meta['seminar_btn'] == 'ジェラートセミナー'): ?>
            <a href="https://fmi.smktg.jp/public/application/add/296" target="_blank" class="l-button l-button--seminar l-button--textlg">セミナー申込み</a>
            <?php elseif($meta['seminar_btn'] == 'ジェラートステップアップセミナー'): ?>
            <a href="https://fmi.smktg.jp/public/application/add/395" target="_blank" class="l-button l-button--seminar l-button--textlg">セミナー申込み</a>
            <?php elseif($meta['seminar_btn'] == 'ソフトクリームセミナー'): ?>
            <a href="https://fmi.smktg.jp/public/application/add/396" target="_blank" class="l-button l-button--seminar l-button--textlg">セミナー申込み</a>
            <?php elseif($meta['seminar_btn'] == 'バリスタセミナー'): ?>
            <a href="https://go.fmi.co.jp/fmi_barista_seminar" target="_blank" class="l-button l-button--seminar l-button--textlg">セミナー申込み</a>
            <?php elseif($meta['seminar_btn'] == 'エスプレッソ/カプチーノ コーチングDAY（午前）'): ?>
            <a href="https://fmi.smktg.jp/public/application/add/461" target="_blank" class="l-button l-button--seminar l-button--textlg">セミナー申込み</a>
            <?php elseif($meta['seminar_btn'] == 'エスプレッソ/カプチーノ コーチングDAY（午後）'): ?>
            <a href="https://fmi.smktg.jp/public/application/add/462" target="_blank" class="l-button l-button--seminar l-button--textlg">セミナー申込み</a>
            <?php elseif($meta['seminar_btn'] == 'エスプレッソショートセミナー（午前）'): ?>
            <a href="https://fmi.smktg.jp/public/application/add/463" target="_blank" class="l-button l-button--seminar l-button--textlg">セミナー申込み</a>
            <?php elseif($meta['seminar_btn'] == 'エスプレッソショートセミナー（午後）'): ?>
            <a href="https://fmi.smktg.jp/public/application/add/464" target="_blank" class="l-button l-button--seminar l-button--textlg">セミナー申込み</a>
            <?php elseif($meta['seminar_btn'] == 'UNOX Live'): ?>
            <a href="https://fmi.smktg.jp/public/application/add/397" target="_blank" class="l-button l-button--seminar l-button--textlg">セミナー申込み</a>
            <?php endif; ?>
          <?php elseif($status[0]->slug == 'finished' || $status[0]->slug == 'full'): ?>
            <a href="" class="l-button is-disabled l-button--textlg">お申込みは終了しました</a>
          <?php endif; ?>
          </div>
          <?php elseif($category[0]->slug == 'exhibition' || $category[0]->slug == 'stored-exhibition'): ?>
          <p><a href="https://fmi.smktg.jp/public/application/add/365" target="_blank" class="l-link-ttl">お問い合わせはこちら</a></p>
          <?php endif; ?>
        </section>
      </div>
    </div>
  </main>
</div>
<?php get_footer(); ?>