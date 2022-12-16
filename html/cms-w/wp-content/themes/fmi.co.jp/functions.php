<?php
/*====================================================================================
functions.php
====================================================================================*/

/*********************************************************************
*　便利なもろもろ
*********************************************************************/
function my_after_setup_theme(){
    // タイトルタグ出力
    add_theme_support( 'title-tag' );

    // アイキャッチを有効に
    add_theme_support( 'post-thumbnails' );

    //【管理画面】ナビゲーションメニューを有効化
    add_theme_support( 'menus' );

    //【管理画面】投稿メニューを非表示
    function remove_menus () {
      global $menu;
      remove_menu_page( 'edit-comments.php' ); // コメント
      remove_menu_page( 'edit.php' ); // 投稿
    }
    add_action('admin_menu', 'remove_menus');

    //jqueryライブラリ読み込み
    wp_enqueue_script('jquery');

    /*
     WP関連のソースを消す
    */

    // generator
    remove_action( 'wp_head', 'wp_generator');

    // rel="shortlink"
    remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

    // WLW(Windows Live Writer) wlwmanifest.xml
    remove_action( 'wp_head', 'wlwmanifest_link');

    // RSD xmlrpc.php?rsd
    remove_action( 'wp_head', 'rsd_link');

    //JavaScriptやCSSに付加されるWordPressのバージョン番号(?ver=4.4.2など)を削除
    function remove_src_wp_ver( $dep ) {
        $dep->default_version = '';
    }
    add_action( 'wp_default_scripts', 'remove_src_wp_ver' );
    add_action( 'wp_default_styles', 'remove_src_wp_ver' );

    // 絵文字消す
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles' );
    remove_action('admin_print_styles', 'print_emoji_styles');

}
add_action( 'after_setup_theme', 'my_after_setup_theme' );

/*********************************************************************
*　カスタム投稿タイプの処理
*********************************************************************/
/*======================================================
カスタム投稿タイプ追加（お知らせ）
======================================================*/
add_action( 'init', 'create_posttype_news' );
function create_posttype_news() {
  register_post_type( 'news', [ // 投稿タイプ名の定義
    'labels' => [
      'name'          => '最新情報', // 管理画面上で表示する投稿タイプ名
      'singular_name' => 'news',    // カスタム投稿の識別名
    ],
    'public'        => true,  // 投稿タイプをpublicにするか
    'has_archive'   => true, // アーカイブ機能ON/OFF
    'menu_position' => 6,     // 管理画面上での配置場所
    'show_in_rest'  => true,  // REST_APIで有効に
    'supports'      => array(
      'title',
      'editor',
      'author',
      'thumbnail',
      'revisions',
    ),
    'rewrite' => true
  ]);
}

//カスタムタクソノミー（タグ）追加
add_action('init', 'add_taxonomy_news',100);
function add_taxonomy_news() {
  register_taxonomy('news_category','news',
    array(
      'labels' => array(
          'name'                => '最新情報_カテゴリ', // ラベルを指定。個別に指定したい場合は'labels'を使う
        ),
      'public'                  => true, // タクソノミーは（パブリックに）検索可能にするかどうか。
      'show_in_quick_edit'      => true, // 投稿のクイック編集でこのタクソノミーを表示するかどうか
      'show_admin_column'       => true, // 投稿一覧のテーブルにこのタクソノミーのカラムを表示するかどうか
      'show_in_rest'            => true,
      'hierarchical'            => true,
      'rewrite' => array('slug'=>'news')
    )
  );
}
/*======================================================
カスタム投稿タイプ追加（セミナー・展示会）
======================================================*/
add_action( 'init', 'create_posttype_seminar_exhibition' );
function create_posttype_seminar_exhibition() {
  register_post_type( 'seminar-exhibition', [ // 投稿タイプ名の定義
    'labels' => [
      'name'          => 'セミナー / 展示会情報', // 管理画面上で表示する投稿タイプ名
      'singular_name' => 'seminar-exhibition',    // カスタム投稿の識別名
    ],
    'public'        => true,  // 投稿タイプをpublicにするか
    'has_archive'   => true, // アーカイブ機能ON/OFF
    'menu_position' => 6,     // 管理画面上での配置場所
    'show_in_rest'  => true,  // REST_APIで有効に
    'supports'      => array(
      'title',
      'editor',
      'author',
      'thumbnail',
      'revisions',
    ),
    'rewrite' => true
  ]);
}

//カスタムタクソノミー追加
add_action('init', 'add_taxonomy_seminar_exhibition',100);
function add_taxonomy_seminar_exhibition() {
  register_taxonomy('seminar-exhibition_category','seminar-exhibition',
    array(
      'labels' => array(
          'name'                => 'セミナー_カテゴリ', // ラベルを指定。個別に指定したい場合は'labels'を使う
        ),
      'public'                  => true, // タクソノミーは（パブリックに）検索可能にするかどうか。
      'show_in_quick_edit'      => true, // 投稿のクイック編集でこのタクソノミーを表示するかどうか
      'show_admin_column'       => true, // 投稿一覧のテーブルにこのタクソノミーのカラムを表示するかどうか
      'show_in_rest'            => true,
      'hierarchical'            => true,
      'rewrite' => array('slug'=>'seminar-exhibition')
    )
  );
  register_taxonomy('seminar-exhibition_genre','seminar-exhibition',
    array(
      'labels' => array(
          'name'                => 'セミナー_ジャンル', // ラベルを指定。個別に指定したい場合は'labels'を使う
        ),
      'public'                  => true, // タクソノミーは（パブリックに）検索可能にするかどうか。
      'show_in_quick_edit'      => true, // 投稿のクイック編集でこのタクソノミーを表示するかどうか
      'show_admin_column'       => true, // 投稿一覧のテーブルにこのタクソノミーのカラムを表示するかどうか
      'show_in_rest'            => true,
      'hierarchical'            => true,
      'rewrite' => array('slug'=>'seminar-exhibition/seminar')
    )
  );
  register_taxonomy('seminar-exhibition_area','seminar-exhibition',
    array(
      'labels' => array(
          'name'                => 'セミナー_開催地域', // ラベルを指定。個別に指定したい場合は'labels'を使う
        ),
      'public'                  => true, // タクソノミーは（パブリックに）検索可能にするかどうか。
      'show_in_quick_edit'      => true, // 投稿のクイック編集でこのタクソノミーを表示するかどうか
      'show_admin_column'       => true, // 投稿一覧のテーブルにこのタクソノミーのカラムを表示するかどうか
      'show_in_rest'            => true,
      'hierarchical'            => true,
    )
  );
  register_taxonomy('seminar-exhibition_status','seminar-exhibition',
    array(
      'labels' => array(
          'name'                => 'セミナー_ステータス', // ラベルを指定。個別に指定したい場合は'labels'を使う
        ),
      'public'                  => true, // タクソノミーは（パブリックに）検索可能にするかどうか。
      'show_in_quick_edit'      => true, // 投稿のクイック編集でこのタクソノミーを表示するかどうか
      'show_admin_column'       => true, // 投稿一覧のテーブルにこのタクソノミーのカラムを表示するかどうか
      'show_in_rest'            => true,
      'hierarchical'            => true,
    )
  );
}

//カスタムフィールドを記事一覧に追加
function add_custom_photos_columns_name_seminar($columns) {
  $columns['seminar_date_start'] = '開催日時';
  //array_splice($columns, 3, 0, array('seminar_date_start' => '開催日時'));
  unset($columns['author']);
  return $columns;
}
function add_custom_photos_columns_seminar($column, $post_id) {
  if ($column == 'seminar_date_start') echo get_post_meta($post_id, 'seminar_date_start', true);
}
add_filter('manage_edit-seminar-exhibition_columns', 'add_custom_photos_columns_name_seminar');
add_action('manage_seminar-exhibition_posts_custom_column', 'add_custom_photos_columns_seminar', 10, 2);

function custom_orderby_columns_seminar($vars) {
  if (isset($vars['orderby']) && 'seminar_date_start' == $vars['orderby']) {
      $vars = array_merge($vars, array(
          'meta_key' => 'seminar_date_start',
          'orderby' => 'meta_value',
          'type' => 'DATETIME'
      ));
  }
  return $vars;
}
function custom_sortable_columns_seminar($sortable_column) {
  $sortable_column['seminar_date_start'] = 'seminar_date_start';
  return $sortable_column;
}
add_filter('request', 'custom_orderby_columns_seminar');
add_filter('manage_edit-seminar-exhibition_sortable_columns', 'custom_sortable_columns_seminar');


/*======================================================
カスタム投稿タイプ追加（製品情報）
======================================================*/
add_action( 'init', 'create_posttype_products' );
function create_posttype_products() {
  register_post_type( 'products', [ // 投稿タイプ名の定義
    'labels' => [
      'name'          => '製品情報', // 管理画面上で表示する投稿タイプ名
      'singular_name' => 'products',    // カスタム投稿の識別名
    ],
    'public'        => true,  // 投稿タイプをpublicにするか
    'has_archive'   => true, // アーカイブ機能ON/OFF
    'menu_position' => 6,     // 管理画面上での配置場所
    'show_in_rest'  => true,  // REST_APIで有効に
    'hierarchical' => true,
    'supports'      => array(
      'title',
      'editor',
      'author',
      'thumbnail',
      'revisions',
      'page-attributes'
    ),
    'rewrite' => true
  ]);
}

//カスタムタクソノミー（タグ）追加
add_action('init', 'add_taxonomy_products',100);
function add_taxonomy_products() {
  register_taxonomy('products_brand','products',
    array(
      'labels' => array(
          'name'                => 'ブランド', // ラベルを指定。個別に指定したい場合は'labels'を使う
        ),
      'public'                  => true, // タクソノミーは（パブリックに）検索可能にするかどうか。
      'show_in_quick_edit'      => true, // 投稿のクイック編集でこのタクソノミーを表示するかどうか
      'show_admin_column'       => true, // 投稿一覧のテーブルにこのタクソノミーのカラムを表示するかどうか
      'show_in_rest'            => true,
      'hierarchical'            => true,
    )
  );
  register_taxonomy('products_category','products',
    array(
      'labels' => array(
          'name'                => '業種', // ラベルを指定。個別に指定したい場合は'labels'を使う
        ),
      'public'                  => true, // タクソノミーは（パブリックに）検索可能にするかどうか。
      'show_in_quick_edit'      => false, // 投稿のクイック編集でこのタクソノミーを表示するかどうか
      'show_admin_column'       => false, // 投稿一覧のテーブルにこのタクソノミーのカラムを表示するかどうか
      'show_in_rest'            => true,
      'hierarchical'            => true,
    )
  );
  register_taxonomy('products_genre','products',
    array(
      'labels' => array(
          'name'                => '用途', // ラベルを指定。個別に指定したい場合は'labels'を使う
        ),
      'public'                  => true, // タクソノミーは（パブリックに）検索可能にするかどうか。
      'show_in_quick_edit'      => true, // 投稿のクイック編集でこのタクソノミーを表示するかどうか
      'show_admin_column'       => true, // 投稿一覧のテーブルにこのタクソノミーのカラムを表示するかどうか
      'show_in_rest'            => true,
      'hierarchical'            => true,
    )
  );
  register_taxonomy('products_option','products',
    array(
      'labels' => array(
          'name'                => '関連オプション', // ラベルを指定。個別に指定したい場合は'labels'を使う
        ),
      'public'                  => true, // タクソノミーは（パブリックに）検索可能にするかどうか。
      'show_in_quick_edit'      => false, // 投稿のクイック編集でこのタクソノミーを表示するかどうか
      'show_admin_column'       => false, // 投稿一覧のテーブルにこのタクソノミーのカラムを表示するかどうか
      'show_in_rest'            => true,
      'hierarchical'            => false,
    )
  );
}

/*======================================================
カスタム投稿タイプ追加（レシピ）
======================================================*/
add_action( 'init', 'create_posttype_recipe' );
function create_posttype_recipe() {
  register_post_type( 'recipe', [ // 投稿タイプ名の定義
    'labels' => [
      'name'          => 'レシピ', // 管理画面上で表示する投稿タイプ名
      'singular_name' => 'recipe',    // カスタム投稿の識別名
    ],
    'public'        => true,  // 投稿タイプをpublicにするか
    'has_archive'   => true, // アーカイブ機能ON/OFF
    'menu_position' => 6,     // 管理画面上での配置場所
    'show_in_rest'  => true,  // REST_APIで有効に
    'hierarchical' => true,
    'supports'      => array(
      'title',
      'editor',
      'author',
      'thumbnail',
      'revisions',
      'page-attributes'
    ),
    'rewrite' => true
  ]);
}

//カスタムタクソノミー（タグ）追加
add_action('init', 'add_taxonomy_recipe',100);
function add_taxonomy_recipe() {
  register_taxonomy('recipe_category','recipe',
    array(
      'labels' => array(
          'name'                => 'レシピ_カテゴリー', // ラベルを指定。個別に指定したい場合は'labels'を使う
        ),
      'public'                  => true, // タクソノミーは（パブリックに）検索可能にするかどうか。
      'show_in_quick_edit'      => true, // 投稿のクイック編集でこのタクソノミーを表示するかどうか
      'show_admin_column'       => true, // 投稿一覧のテーブルにこのタクソノミーのカラムを表示するかどうか
      'show_in_rest'            => true,
      'hierarchical'            => true,
    )
  );
  register_taxonomy('recipe_tag','recipe',
    array(
      'labels' => array(
          'name'                => 'レシピ_タグ', // ラベルを指定。個別に指定したい場合は'labels'を使う
        ),
      'public'                  => true, // タクソノミーは（パブリックに）検索可能にするかどうか。
      'show_in_quick_edit'      => true, // 投稿のクイック編集でこのタクソノミーを表示するかどうか
      'show_admin_column'       => true, // 投稿一覧のテーブルにこのタクソノミーのカラムを表示するかどうか
      'show_in_rest'            => true,
      'hierarchical'            => true,
    )
  );
  register_taxonomy('recipe_brand','recipe',
    array(
      'labels' => array(
          'name'                => 'レシピ_ブランド', // ラベルを指定。個別に指定したい場合は'labels'を使う
        ),
      'public'                  => true, // タクソノミーは（パブリックに）検索可能にするかどうか。
      'show_in_quick_edit'      => true, // 投稿のクイック編集でこのタクソノミーを表示するかどうか
      'show_admin_column'       => true, // 投稿一覧のテーブルにこのタクソノミーのカラムを表示するかどうか
      'show_in_rest'            => true,
      'hierarchical'            => true,
    )
  );
  register_taxonomy('recipe_option','recipe',
    array(
      'labels' => array(
          'name'                => 'レシピ_関連製品', // ラベルを指定。個別に指定したい場合は'labels'を使う
        ),
      'public'                  => true, // タクソノミーは（パブリックに）検索可能にするかどうか。
      'show_in_quick_edit'      => false, // 投稿のクイック編集でこのタクソノミーを表示するかどうか
      'show_admin_column'       => false, // 投稿一覧のテーブルにこのタクソノミーのカラムを表示するかどうか
      'show_in_rest'            => true,
      'hierarchical'            => false,
    )
  );
}
/*======================================================
カスタム投稿タイプ追加（導入事例）
======================================================*/
add_action( 'init', 'create_posttype_casestudy' );
function create_posttype_casestudy() {
  register_post_type( 'casestudy', [ // 投稿タイプ名の定義
    'labels' => [
      'name'          => '導入事例', // 管理画面上で表示する投稿タイプ名
      'singular_name' => 'casestudy',    // カスタム投稿の識別名
    ],
    'public'        => true,  // 投稿タイプをpublicにするか
    'has_archive'   => true, // アーカイブ機能ON/OFF
    'menu_position' => 5,     // 管理画面上での配置場所
    'show_in_rest'  => true,  // REST_APIで有効に
    'supports'      => array(
      'title',
      'editor',
      'author',
      'thumbnail',
      'revisions',
    ),
    'rewrite' => true
  ]);
}

//カスタムタクソノミー（タグ）追加
add_action('init', 'add_taxonomy_casestudy',100);
function add_taxonomy_casestudy() {
  register_taxonomy('casestudy_category','casestudy',
    array(
      'labels' => array(
          'name'                => '導入事例_カテゴリ', // ラベルを指定。個別に指定したい場合は'labels'を使う
        ),
      'public'                  => true, // タクソノミーは（パブリックに）検索可能にするかどうか。
      'show_in_quick_edit'      => true, // 投稿のクイック編集でこのタクソノミーを表示するかどうか
      'show_admin_column'       => true, // 投稿一覧のテーブルにこのタクソノミーのカラムを表示するかどうか
      'show_in_rest'            => true,
      'hierarchical'            => true
    )
  );
}

/*======================================================
カスタム投稿タイプ追加（動画一覧）
======================================================*/
add_action( 'init', 'create_posttype_movie' );
function create_posttype_movie() {
  register_post_type( 'movie', [ // 投稿タイプ名の定義
    'labels' => [
      'name'          => '動画一覧', // 管理画面上で表示する投稿タイプ名
      'singular_name' => 'movie',    // カスタム投稿の識別名
    ],
    'public'        => false,  // 投稿タイプをpublicにするか
    'has_archive'   => false, // アーカイブ機能ON/OFF
    'menu_position' => 5,     // 管理画面上での配置場所
    'show_ui' => true,
    'show_in_rest'  => false,  // REST_APIで有効に
  ]);
}

//カスタムタクソノミー（タグ）追加
add_action('init', 'add_taxonomy_movie',100);
function add_taxonomy_movie() {
  register_taxonomy('movie_category','movie',
    array(
      'labels' => array(
          'name'                => '動画一覧_カテゴリ', // ラベルを指定。個別に指定したい場合は'labels'を使う
        ),
      'public'                  => false, // タクソノミーは（パブリックに）検索可能にするかどうか。
      'show_in_quick_edit'      => true, // 投稿のクイック編集でこのタクソノミーを表示するかどうか
      'show_admin_column'       => true, // 投稿一覧のテーブルにこのタクソノミーのカラムを表示するかどうか
      'show_ui'                 => true,
      'show_in_rest'            => true,
      'hierarchical'            => true
    )
  );
}

/*======================================================
カスタム投稿タイプ追加（コンサルティング）
======================================================*/
add_action( 'init', 'create_posttype_consulting' );
function create_posttype_consulting() {
  register_post_type( 'consulting', [ // 投稿タイプ名の定義
    'labels' => [
      'name'          => 'コンサルティング', // 管理画面上で表示する投稿タイプ名
      'singular_name' => 'consulting',    // カスタム投稿の識別名
    ],
    'public'        => true,  // 投稿タイプをpublicにするか
    'has_archive'   => true, // アーカイブ機能ON/OFF
    'menu_position' => 5,     // 管理画面上での配置場所
    'show_ui'       => true,
    'show_in_rest'  => false,  // REST_APIで有効に
  ]);
}

//カスタムタクソノミー（タグ）追加
add_action('init', 'add_taxonomy_consulting',100);
function add_taxonomy_consulting() {
  register_taxonomy('consulting_category','consulting',
    array(
      'labels' => array(
          'name'                => 'コンサルティング_カテゴリ', // ラベルを指定。個別に指定したい場合は'labels'を使う
        ),
      'public'                  => false, // タクソノミーは（パブリックに）検索可能にするかどうか。
      'show_in_quick_edit'      => true, // 投稿のクイック編集でこのタクソノミーを表示するかどうか
      'show_admin_column'       => true, // 投稿一覧のテーブルにこのタクソノミーのカラムを表示するかどうか
      'show_ui'                 => true,
      'show_in_rest'            => true,
      'hierarchical'            => true
    )
  );
}

/*======================================================
カスタム投稿タイプ追加（TOP_スライダー）
======================================================*/
add_action( 'init', 'create_posttype_slider' );
function create_posttype_slider() {
  register_post_type( 'slider', [ // 投稿タイプ名の定義
    'labels' => [
      'name'          => 'TOP_スライダー', // 管理画面上で表示する投稿タイプ名
      'singular_name' => 'slider',    // カスタム投稿の識別名
    ],
    'public'        => false,  // 投稿タイプをpublicにするか
    'has_archive'   => false, // アーカイブ機能ON/OFF
    'menu_position' => 5,     // 管理画面上での配置場所
    'show_ui' => true,
    'show_in_rest'  => false,  // REST_APIで有効に
  ]);
}

/*======================================================
カスタム投稿タイプ追加（TOP_主な取り扱いブランド）
======================================================*/
add_action( 'init', 'create_posttype_mainbrand' );
function create_posttype_mainbrand() {
  register_post_type( 'mainbrand', [ // 投稿タイプ名の定義
    'labels' => [
      'name'          => 'TOP_主要ブランド', // 管理画面上で表示する投稿タイプ名
      'singular_name' => 'mainbrand',    // カスタム投稿の識別名
    ],
    'public'        => false,  // 投稿タイプをpublicにするか
    'has_archive'   => false, // アーカイブ機能ON/OFF
    'menu_position' => 5,     // 管理画面上での配置場所
    'show_ui' => true,
    'show_in_rest'  => false,  // REST_APIで有効に
  ]);
}

/*======================================================
管理画面メニュー位置調整（カスタム投稿タイプが5件以上の場合）
======================================================*/
function customize_menus(){
  global $menu;
  $menu[19] = $menu[10];  //メディアの移動
  unset($menu[10]);
}
add_action( 'admin_menu', 'customize_menus' );

/*======================================================
カスタム投稿タイプのパーマリンク修正
======================================================*/
add_filter('post_type_link', 'generateCustomPostLink', 1, 2);
add_filter('rewrite_rules_array', 'addRewriteRules');
function generateCustomPostLink($link, $post){
  if($post->post_type === 'recipe'){
    return home_url('/recipe/'.$post->ID);
  } else {
    return $link;
  }
}
function addRewriteRules($rules){
  $new_rule = array(
    'recipe/([0-9]+)/?$' => 'index.php?post_type=recipe&p=$matches[1]',
    'recipe/page/([0-9]+)/?$' => 'index.php?post_type=recipe&paged=$matches[1]',
    'recipe/category/([^/]+)/?$' => 'index.php?recipe_category=$matches[1]',
    'recipe/category/([^/]+)/page/([0-9]+)/?$' => 'index.php?recipe_category=$matches[1]&paged=$matches[2]',
    'recipe/tag/([^/]+)/?$' => 'index.php?recipe_tag=$matches[1]',
    'recipe/tag/([^/]+)/page/([0-9]+)/?$' => 'index.php?recipe_tag=$matches[1]&paged=$matches[2]',
    'recipe/brand/([^/]+)/?$' => 'index.php?recipe_brand=$matches[1]',
    'recipe/brand/([^/]+)/page/([0-9]+)/?$' => 'index.php?recipe_brand=$matches[1]&paged=$matches[2]',
    'events/(seminar|exhibition|stored-seminar|stored-exhibition)/?$' => 'index.php?mec_label=$matches[1]',
    'events/(seminar|exhibition|stored-seminar|stored-exhibition)/page/([0-9]+)/?$' => 'index.php?mec_label=$matches[1]&paged=$matches[2]',
  );
  return $new_rule + $rules;
}

/*======================================================
カスタム投稿タイプの表示件数修正
======================================================*/
function change_posts_per_page($query) {
  if(is_admin() || !$query->is_main_query())
    return;
  if($query->is_post_type_archive('news') || $query->is_tax('news_category') ){
    $query->set('post_status', 'publish');
    $query->set('posts_per_page', '12');
    $query->set('orderby', 'date');
  }elseif($query->is_post_type_archive('recipe') || $query->is_tax('recipe_category') || $query->is_tax('recipe_tag') || $query->is_tax('recipe_brand')){
    $query->set('post_status', 'publish');
    $query->set('posts_per_page', '12');
  }elseif($query->is_post_type_archive('casestudy')){
    $query->set('post_status', 'publish');
    $query->set('posts_per_page', '-1');
  }elseif($query->is_post_type_archive('seminar-exhibition')){
    $query->set('post_status', 'publish');
    $query->set('posts_per_page', '12');
    $query->set('order', 'ASC');
    $query->set('orderby', 'date');
    // $query->set('orderby', 'meta_value');
    // $query->set('meta_key', 'seminar_date_start');
    // $query->set('type', 'DATEVALUE');
    $query->set('tax_query', array(
        array(
          'taxonomy' => 'seminar-exhibition_category',
          'field' => 'slug',
          'terms' => array('stored-seminar','stored-exhibition'),
          'operator' => 'NOT IN'
        )
      )
    );
  }elseif($query->is_tax('seminar-exhibition_category')){
    $query->set('post_status', 'publish');
    $query->set('posts_per_page', '12');
    $query->set('order', 'ASC');
    $query->set('orderby', 'date');
    // $query->set('orderby', 'meta_value');
    // $query->set('meta_key', 'seminar_date_start');
    // $query->set('type', 'DATEVALUE');
  }elseif($query->is_post_type_archive('mec-events')){
    $query->set('posts_per_page', '12');
    $query->set('orderby', 'meta_value');
    $query->set('order', 'ASC');
    $query->set('meta_key', 'mec_start_date');
    $query->set('type', 'DATEVALUE');
    $query->set('tax_query', array(
        array(
          'taxonomy' => 'mec_label',
          'field' => 'slug',
          'terms' => array('stored-seminar','stored-exhibition'),
          'operator' => 'NOT IN'
        )
      )
    );
  }elseif($query->is_tax('mec_label')){
    $query->set('posts_per_page', '12');
    $query->set('orderby', 'meta_value');
    $query->set('order', 'ASC');
    $query->set('meta_key', 'mec_start_date');
    $query->set('type', 'DATEVALUE');
  }
}
add_action( 'pre_get_posts', 'change_posts_per_page' );


/*********************************************************************
検索
*********************************************************************/
function my_custom_search_url() {
	if ( is_search() && ! empty( $_GET['s'] && $_GET['search_type'] != 'recipe') ) {
		wp_safe_redirect( home_url( '/search/' ) . urlencode( get_query_var( 's' ) ) );
	  exit();
	}
}
add_action( 'template_redirect', 'my_custom_search_url' );

function custom_search_template($template){
  if ( is_search() ){
    $search_type = get_query_var('search_type');
    if($search_type == 'recipe') $templates['recipe'] = "search-recipe.php";
    $templates[] = 'search.php';
    $template = get_query_template('search',$templates);
  }
  return $template;
}
add_filter('template_include','custom_search_template');

function search_query_vars( $vars ) {
	$vars[] = 'search_type';
	return $vars;
}
add_filter( 'query_vars', 'search_query_vars' );

function custom_search_results_recipe($query) {
  $search_type = get_query_var('search_type');
  if(is_admin() || !$query->is_main_query() || !$query->is_search() ) return;
  if($search_type != 'recipe') return;
  $query->set('post_type', array('recipe'));
  $query->set('posts_per_page', '12');
}
add_action( 'pre_get_posts', 'custom_search_results_recipe' );

/*********************************************************************
MEC
*********************************************************************/
//既存のタグ・開催地域をカテゴリに
function update_mec_taxonomy_args( $args, $taxonomy_name ) {
  if ( 'mec_label' === $taxonomy_name ) {
    $args['public'] = true;
    $args['show_admin_column'] = true;
    $args['hierarchical'] = true;
  }
  if ( 'mec_location' === $taxonomy_name ) {
    $args['hierarchical'] = true;
    $args['show_admin_column'] = true;
  }
  return $args;
}
add_filter( 'register_taxonomy_args', 'update_mec_taxonomy_args', 10, 2 );
//カスタムフィールドを記事一覧に追加
function change_custom_columns_mec($columns) {
  unset($columns['location']);
  return $columns;
}
add_filter('manage_edit-mec-events_columns', 'change_custom_columns_mec');
//新しいカテゴリを設定
// function add_taxonomy_mec() {
//   register_taxonomy('events_new_category','mec-events',
//     array(
//       'labels' => array(
//           'name'                => 'MEC_新カテゴリ', // ラベルを指定。個別に指定したい場合は'labels'を使う
//         ),
//       'public'                  => false, // タクソノミーは（パブリックに）検索可能にするかどうか。
//       'show_in_quick_edit'      => true, // 投稿のクイック編集でこのタクソノミーを表示するかどうか
//       'show_admin_column'       => true, // 投稿一覧のテーブルにこのタクソノミーのカラムを表示するかどうか
//       'show_ui'                 => true,
//       'show_in_rest'            => true,
//       'hierarchical'            => true
//     )
//   );
//   register_taxonomy_for_object_type('events_new_category', 'mec-events');
// }
// add_action('init', 'add_taxonomy_mec',100);
/*********************************************************************
その他
*********************************************************************/
/*======================================================
Youtubeの埋め込み用URL出力
======================================================*/
function createVideoTag($param){
  //URLがyoutubeのURLであるかをチェック
  if(preg_match('#https?://www.youtube.com/.*#i',$param,$matches)){
    //parse_urlでhttps://www.youtube.com/watch以下のパラメータを取得
    $parse_url = parse_url($param);
    // 動画IDを取得
    if (preg_match('#v=([-\w]{11})#i', $parse_url['query'], $v_matches)) {
      $video_id = $v_matches[1];
    } else {
      // 万が一動画のIDの存在しないURLだった場合は埋め込みコードを生成しない。
      return false;
    }
    $v_param = '';
    // パラメータにt=XXmXXsがあった時の埋め込みコード用パラメータ設定
    // t=〜〜の部分を抽出する正規表現は記述を誤るとlist=〜〜の部分を抽出してしまうので注意
    if (preg_match('#t=([0-9ms]+)#i', $parse_url['query'], $t_maches)) {
        $time = 0;
        if (preg_match('#(\d+)m#i', $t_maches[1], $minute)) {
            // iframeでは正の整数のみ有効なのでt=XXmXXsとなっている場合は整形する必要がある。
            $time = $minute[1]*60;
        }
        if (preg_match('#(\d+)s#i', $t_maches[1], $second)) {
            $time = $time+$second[1];
        }
        if (!preg_match('#(\d+)m#i', $t_maches[1]) && !preg_match('#(\d+)s#i', $t_maches[1])) {
            // t=(整数)の場合はそのままの値をセット ※秒数になる
            $time = $t_maches[1];
        }
        $v_param .= '?start=' . $time;
    }
    // パラメータにlist=XXXXがあった時の埋め込みコード用パラメータ設定
    if (preg_match('#list=([-\w]+)#i', $parse_url['query'], $l_maches)) {
        if (!empty($v_param)) {
            // $v_paramが既にセットされていたらそれに続ける
            $v_param .= '&list=' . $l_maches[1];
        } else {
            // $v_paramが既にセットされていなかったら先頭のパラメータとしてセット
            $v_param .= '?list=' . $l_maches[1];
        }
    }
    // 埋め込みコードを返す
    return 'https://www.youtube.com/embed/' . $video_id . $v_param;
  }
  else if (!empty($param)) {
    return $param;
  }
  return false;
}

/*======================================================
親ページのslugを判定
======================================================*/
function is_parent_slug() {
    global $post;
    if ($post->post_parent) {
        $post_data = get_post($post->post_parent);
        return $post_data->post_name;
    }
}

/*======================================================
slugから投稿オブジェクトを取得
======================================================*/
function get_page_by_slug( $slug = '' ) {
  $pages = get_posts(
      array(
        'post_type'      => 'page',
        'name'           => $slug,
        'posts_per_page' => 1
      )
  );
  return $pages ? $pages[0] : false;
}

/*======================================================
ページネーション出力
======================================================*/
function custom_the_posts_pagination( $template ) {
	$template = '
	<nav class="pager %1$s" role="navigation">
		%3$s
	</nav>';
	return $template;
}
add_filter( 'navigation_markup_template', 'custom_the_posts_pagination' );

/*======================================================
RS CSVImporterMediaアドオン
======================================================*/
add_filter('really_simple_csv_importer_media_ext2type', 'really_simple_csv_importer_media_ext2type');
function really_simple_csv_importer_media_ext2type( $types ) {
  return array(
    'image'       => array( 'jpg', 'jpeg', 'jpe', 'gif', 'png' ),
    'audio'       => array( 'mp3', 'ogg', 'wav', 'wma' ),
    'video'       => array( 'mov', 'mp4', 'mpeg', 'mpg', 'ogm', 'ogv', 'wmv' ),
    'document'    => array( 'doc', 'docx', 'odt', 'pages', 'pdf', 'psd' ),
    'spreadsheet' => array( 'ods', 'xls', 'xlsx' ),
    'interactive' => array( 'swf', 'key', 'ppt', 'pptx', 'odp' ),
    'text'        => array( 'asc', 'csv', 'tsv', 'txt' ),
    'archive'     => array( 'dmg', 'gz', 'rar', 'tar', 'tgz', 'zip'),
    'code'        => array( 'css', 'htm', 'html', 'php', 'js' ),
  );
}
?>