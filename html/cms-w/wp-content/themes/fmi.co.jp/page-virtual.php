<?php
/*====================================================================================
page-virtual.php
====================================================================================*/
  global $post;
  get_header();
?>
<div class="l-contents">
  <main class="l-main is-xs-noPad">
    <div class="l-main-inner l-main-inner--seminar-index">
      <nav class="l-bredNav">
        <ul class="l-bredNav-ul">
          <li class="l-bredNav-list"><a href="/" class="l-bredNav-link">TOP</a></li>
          <?php if($parent): ?>
          <li class="l-bredNav-list"><a href="/<?php echo $parent->post_name; ?>" class="l-bredNav-link"><?php echo $parent->post_title; ?></a></li>
          <?php endif; ?>
          <li class="l-bredNav-list"><?php the_title(); ?></li>
        </ul>
      </nav>
      <h1 class="l-page-ttl">VIRTUAL SHOWROOM<span>バーチャルショールーム</span></h1>
    </div>
    <section>
      <div class="l-virtual-inner">
        <h2 class="u-ta-center u-mb-xs-20 u-mb-md-20 virtualTit01">オンラインで体感できる<br class="br-sp">バーチャルショールームへようこそ！</h2>
        <p class="u-ta-center spAl u-mb-xs-20 u-mb-md-40 virtualTx01">まるで現地にいるかのようにショールーム内を回遊できる空間を演出しております！<br>さまざまなラインナップを同空間にご用意しておりますので、<br>設置レイアウトのイメージや新たな発見のご一助にもなれば幸いです。</p>
        <div class="iframe-wrapper u-mb-xs-20 u-mb-md-20">
          <iframe width="867" height="488" src="/virtual/nper0001/" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <div class="virtual-modal-link u-mb-xs-20 u-mb-md-20">
          <a href="">大きな画面で見る</a>
        </div>
        <div class="virturalBox01 u-mb-xs-20 u-mb-md-20">
        <h2 class="u-ta-center u-mb-xs-10 u-mb-md-20 virtualTit02">パノラマ画像の操作について</h2>
        <div class="virtualTxBox02">
        <p class="virtualTx02">画面上のマウス操作で画面を上下左右に動かすことが出来ます。<br>
        ＋／－マークをクリックするか、マウスのホイールを回転して画面を拡大・縮小することができます。<br>
        <img class="icoImg" src="/assets/virtual/virtural_ico01.png" alt="(i)">マークをクリックすると、展示内容をご覧いただけます。<br>
        <img class="icoImg" src="/assets/virtual/virtural_ico02.png" alt="上矢印">かFloor Mapの<img class="icoImg" src="/assets/virtual/virtural_ico03.png" alt="回転">をクリックすると、会場を移動できます。</p>
        </div>
        </div>
        <h2 class="u-ta-center u-mb-xs-20 u-mb-md-40 virtualTit02">実機を直接ご覧になりたい方は、<br>弊社ショールームへのご来場をお待ちしております。(予約制）</h2>
        <a href="https://fmi.smktg.jp/public/application/add/365" class="l-button l-button--blue2 u-mb-xs-20 u-mb-md-40">お問い合わせ</a>
        <p class="u-ta-center u-mb-xs-40 u-mb-md-60 virtualTx03">空間にない機種もございますので、”困りごと・お悩み”でのお問い合わせも是非お寄せください。</p>
      </div>
    </section>
  </main>
  <div class="virtual-modal">
    <div class="virtual-modal__inner">
      <div class="iframe-wrapper">
        <iframe width="867" height="488" src="/virtual/nper0001/" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
<script>
jQuery(function($){
  var target = $('.virtual-modal-link > a');
  var modal = $('.virtual-modal');
  target.on('click', function(e){
    e.preventDefault();
    modal.addClass('--show');
    return false;
  });
  modal.on('click', function(){
    $(this).removeClass('--show');
  });
});
</script>