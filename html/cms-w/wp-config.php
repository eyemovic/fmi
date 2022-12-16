<?php
/**
 * WordPress の基本設定
 *
 * このファイルは、インストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さずにこのファイルを "wp-config.php" という名前でコピーして
 * 直接編集して値を入力してもかまいません。
 *
 * このファイルは、以下の設定を含みます。
 *
 * * MySQL 設定
 * * 秘密鍵
 * * データベーステーブル接頭辞
 * * ABSPATH
 *
 * @link http://wpdocs.osdn.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86
 *
 * @package WordPress
 */

// 注意:
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.osdn.jp/%E7%94%A8%E8%AA%9E%E9%9B%86#.E3.83.86.E3.82.AD.E3.82.B9.E3.83.88.E3.82.A8.E3.83.87.E3.82.A3.E3.82.BF 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - この情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define('DB_NAME', 'ad128e1q0f_wordpress');

/** MySQL データベースのユーザー名 */
define('DB_USER', 'ad128e1q0f');

/** MySQL データベースのパスワード */
define('DB_PASSWORD', '4bT2WKTD');

/** MySQL のホスト名 */
define('DB_HOST', '127.0.0.1:3307');

/** データベースのテーブルを作成する際のデータベースの文字セット */
define('DB_CHARSET', 'utf8mb4');

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define('DB_COLLATE', '');

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '~lBd,|RwvtO#<;nJ86zjG>[7HFlNT+vR2k>it~-+#|yHy*QC%9e~O{&USJ4iVX d');
define('SECURE_AUTH_KEY',  '`oaPVh_!k0wZ#om>6bIX897Cok1Z#l t{])*m:|2Eg(w;%m6=-8Hc=oIjgCR%*]R');
define('LOGGED_IN_KEY',    '@$t_)U)hP|{m`:yv!^4G6SGy[V8oR>r.ka9.(^B-gck>fiJA^D?fLu>{a<%&,Mnh');
define('NONCE_KEY',        '<df;Is)Op!vbiSY0fhF@r5 {CKL4H,@F*(-JATHB&:J4Z*w<$&LrswSmq9;zG@}r');
define('AUTH_SALT',        'jRYKXaHI%E<eBsLR6>4R<|RKgP*{m]q,AZw|[il#37M:~`&iV[M=8BI+Gbw;%*fS');
define('SECURE_AUTH_SALT', 'i6{L)]6 U(kAIu3$wp%c,T%BT,=0_!mU:9S$5P$CWhk*>rH=0p*R_|5XZnQa~><j');
define('LOGGED_IN_SALT',   '3Ho=y%YD=@o*gYm)1_R<g#JCda7 5vjbmymZMrwn`uT8qnhc%GC^_y]r#!Lq]2p@');
define('NONCE_SALT',       'Z/kqkwSIG.!2S9%txiCFiB%4.N2fT3z@Rd<#R$RQ:9v$aHWYy5%f7oNHh#O{-e>Z');

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix  = 'wp_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 *
 * その他のデバッグに利用できる定数については Codex をご覧ください。
 *
 * @link http://wpdocs.osdn.jp/WordPress%E3%81%A7%E3%81%AE%E3%83%87%E3%83%90%E3%83%83%E3%82%B0
 */
define('WP_DEBUG', false);

/* 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
