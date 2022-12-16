<?php
/*====================================================================================
single-recipe.php
====================================================================================*/
?>
<?php
  get_header();
  global $post;
  $post_id = get_the_ID();
  $thumbnail = get_the_post_thumbnail_url($post->ID,'medium');
  $category = get_the_terms($post_id, 'mec_category');
  $genre = get_the_terms($post_id, 'mec_label');
  $area = get_the_terms($post_id, 'mec_location');
  $mec_fields = get_post_meta($post_id, 'mec_fields');
  $mec_field = $mec_fields[0];
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
              <?php if($genre): ?>
              <i class="seminar_exhibition-label label-seminar"><?php echo $genre[0]->name; ?></i>
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
          <div class="l-txt u-mb-xs-20 u-mb-md-40">
            <?php the_content(); ?>
          </div>
          <?php if($category): ?>
          <div class="u-mb-xs-20 u-mb-md-40">
            <?php if($category[0]->slug == 'new-cooking' || $category[0]->slug == 'unox-live'): ?>
            <a href="/consulting/#01" class="l-button">セミナー講師紹介へ</a>
            <?php elseif($category[0]->slug != 'new-cooking' && $category[0]->slug != 'unox-live'): ?>
            <a href="/consulting/#02" class="l-button">セミナー講師紹介へ</a>
            <?php endif; ?>
          </div>
          <?php endif; ?>
          <?php if($mec_field[13]): $desc_list = explode(',', $mec_field[13]); ?>
          <h3 class="l-ttl-sm">セミナー内容</h3>
          <ul class="seminar_exhibition-about l-list-circle l-txt u-mb-xs-20 u-mb-md-40">
            <?php foreach($desc_list as $desc): ?>
              <li><?php echo $desc; ?></li>
            <?php endforeach; ?>
          </ul>
          <?php endif; ?>
          <table class="l-table-v1 l-td-left u-mb-xs-30 u-mb-md-60">
            <tbody>
              <?php if($mec_field[1]): ?>
              <tr>
                <th>参加料金</th>
                <td><?php echo $mec_field[1]; ?></td>
              </tr>
              <?php endif; ?>
              <?php if($mec_field[12]): ?>
              <tr>
                <th>対　象</th>
                <td><?php echo nl2br($mec_field[12]); ?></td>
              </tr>
              <?php endif; ?>
              <?php if($mec_field[3]): ?>
              <tr>
                <th>講習時間</th>
                <td><?php echo $mec_field[3]; ?></td>
              </tr>
              <?php endif; ?>
              <?php if($mec_field[4]): ?>
              <tr>
                <th>会　期</th>
                <td><?php echo $mec_field[4]; ?></td>
              </tr>
              <?php endif; ?>
              <?php if($mec_field[10]): ?>
              <tr>
                <th>会　場</th>
                <td><?php echo $mec_field[10]; ?></td>
              </tr>
              <?php endif; ?>
              <?php if($mec_field[6]): ?>
              <tr>
                <th>主　催</th>
                <td><?php echo $mec_field[6]; ?></td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
          <?php if($genre[0]->slug == 'seminar'): ?>
          <div class="u-mb-xs-20 u-mb-md-40">
          <?php if($mec_field[11] == '募集中' || $mec_field[11] == '残りわずか'): ?>
            <?php if($mec_field[7] == 'ジェラートセミナー'): ?>
            <a href="https://go.fmi.co.jp/fmi_gelato_seminar" target="_blank" class="l-button l-button--seminar l-button--textlg">セミナー申込み</a>
            <?php elseif($mec_field[7] == 'ジェラートステップアップセミナー'): ?>
            <a href="https://go.fmi.co.jp/fmi_gelato_stepup_seminar" target="_blank" class="l-button l-button--seminar l-button--textlg">セミナー申込み</a>
            <?php elseif($mec_field[7] == 'ソフトクリームセミナー'): ?>
            <a href="https://go.fmi.co.jp/fmi_softcream_seminar" target="_blank" class="l-button l-button--seminar l-button--textlg">セミナー申込み</a>
            <?php elseif($mec_field[7] == 'バリスタセミナー'): ?>
            <a href="https://go.fmi.co.jp/fmi_barista_seminar" target="_blank" class="l-button l-button--seminar l-button--textlg">セミナー申込み</a>
            <?php elseif($mec_field[7] == 'エスプレッソ/カプチーノ コーチングDAY（午前）'): ?>
            <a href="https://go.fmi.co.jp/fmi_espresso_cappuccino_coachingDay_AM" target="_blank" class="l-button l-button--seminar l-button--textlg">セミナー申込み</a>
            <?php elseif($mec_field[7] == 'エスプレッソ/カプチーノ コーチングDAY（午後）'): ?>
            <a href="https://go.fmi.co.jp/fmi_espresso_cappuccino_coachingDay_PM" target="_blank" class="l-button l-button--seminar l-button--textlg">セミナー申込み</a>
            <?php elseif($mec_field[7] == 'エスプレッソショートセミナー（午前）'): ?>
            <a href="https://go.fmi.co.jp/fmi_espresso_short_seminar_AM" target="_blank" class="l-button l-button--seminar l-button--textlg">セミナー申込み</a>
            <?php elseif($mec_field[7] == 'エスプレッソショートセミナー（午後）'): ?>
            <a href="https://go.fmi.co.jp/fmi_espresso_short_seminar_PM" target="_blank" class="l-button l-button--seminar l-button--textlg">セミナー申込み</a>
            <?php elseif($mec_field[7] == 'UNOX Live'): ?>
            <a href="https://go.fmi.co.jp/fmi_UNOX_Live" target="_blank" class="l-button l-button--seminar l-button--textlg">セミナー申込み</a>
            <?php endif; ?>
          <?php elseif($mec_field[11] == '募集終了' || $mec_field[11] == 'イベント終了'): ?>
            <a href="" class="l-button is-disabled l-button--textlg">お申込みは終了しました</a>
          <?php endif; ?>
          </div>
          <?php elseif($genre[0]->slug == 'exhibition'): ?>
          <p><a href="https://fmi.smktg.jp/public/application/add/365" target="_blank" class="l-link-ttl">お問い合わせへ</a></p>
          <?php endif; ?>
        </section>
      </div>
    </div>
  </main>
</div>
<?php get_footer(); ?>