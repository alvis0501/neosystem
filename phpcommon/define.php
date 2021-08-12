<?php
// 可変設定項目 -----------------------------------------------------------

if ($_SERVER['HTTP_HOST'] == 'mupd.jp') { // テストサイト

	// include_path
	define('APP_INCLUDE_PATH', '.:/home/www/mupd.jp/htdocs/neosystem/extlib/pear');
	// メール送信実行フラグ
	define('MAIL_PERMISSION', true);

	// ◆DB接続情報

	// DBホスト名
	define('DB_HOST', 'localhost');
	// DBポート番号
	define('DB_PORT', '5432');
	// DB名
	define('DB_NAME', 'neosystem');
	// DBユーザ名
	define('DB_USER', 'neosystem');
	// DBパスワード
	define('DB_PASSWORD', 'neosystem');

}
else if ($_SERVER['HTTP_HOST'] == 'localhost') {

	// include_path
	define('APP_INCLUDE_PATH', 'E:/xampp53/xampp/htdocs/neosystem/extlib/pear');
	// メール送信実行フラグ
	define('MAIL_PERMISSION', false);

	// ◆DB接続情報

	// DBホスト名
	define('DB_HOST', 'localhost');
	// DBポート番号
	define('DB_PORT', '5432');
	// DB名
	define('DB_NAME', 'neosystem');
	// DBユーザ名
	define('DB_USER', 'postgres');
	// DBパスワード
	define('DB_PASSWORD', '123456');

} else if ($_SERVER['HTTP_HOST'] == 'neosystem.cdmn.jp') { // 共通開発環境

	// include_path
	define('APP_INCLUDE_PATH', '.:/www/neosystem.cdmn.jp/htdocs/extlib/pear');
	// メール送信実行フラグ
	define('MAIL_PERMISSION', false);

	// ◆DB接続情報

	// DBホスト名
	define('DB_HOST', 'localhost');
	// DBポート番号
	define('DB_PORT', '5432');
	// DB名
	define('DB_NAME', 'neosystem');
	// DBユーザ名
	define('DB_USER', 'neosystem');
	// DBパスワード
	define('DB_PASSWORD', 'neosystem');

} else if ($_SERVER['HTTP_HOST'] == 'neosystem_paku.cdmn.jp') { // pakuさん開発環境

	// include_path
	define('APP_INCLUDE_PATH', '.:/www/neosystem.cdmn.jp/htdocs/extlib/pear');
	// メール送信実行フラグ
	define('MAIL_PERMISSION', false);

	// ◆DB接続情報

	// DBホスト名
	define('DB_HOST', 'localhost');
	// DBポート番号
	define('DB_PORT', '5432');
	// DB名
	define('DB_NAME', 'neosystem_paku');
	// DBユーザ名
	define('DB_USER', 'neosystem_paku');
	// DBパスワード
	define('DB_PASSWORD', 'neosystem_paku');

} else if ($_SERVER['HTTP_HOST'] == 'neosystem_konishi.cdmn.jp') { // 小西さん開発環境

	// include_path
	define('APP_INCLUDE_PATH', '.:/www/neosystem_konishi.cdmn.jp/htdocs/extlib/pear');
	// メール送信実行フラグ
	define('MAIL_PERMISSION', false);

	// ◆DB接続情報

	// DBホスト名
	define('DB_HOST', 'localhost');
	// DBポート番号
	define('DB_PORT', '5432');
	// DB名
	define('DB_NAME', 'neosystem_konishi');
	// DBユーザ名
	define('DB_USER', 'neosystem_konishi');
	// DBパスワード
	define('DB_PASSWORD', 'neosystem_konishi');

} else { // 本番

	// include_path
	define('APP_INCLUDE_PATH', '.:/sitenfs/pia/public-folder/extlib/pear');
	// メール送信実行フラグ
	define('MAIL_PERMISSION', true);

	// ◆DB接続情報

	// DBホスト名
	define('DB_HOST', '10.160.97.49');
	// DBポート番号
	define('DB_PORT', '3306');
	// DB名
	define('DB_NAME', 'dtcdak322');
	// DBユーザ名
	define('DB_USER', 'dtcdak322');
	// DBパスワード
	define('DB_PASSWORD', 'hyn4sU]C');
}


// ◆管理者メール
//define('ADMIN_MAIL', 'info@monthlysec.net'); // 本番設定
define('ADMIN_MAIL', 'kanda@codemonster.net');

// ◆代理店メール送信元
define('DAIRITEN_MAIL', 'no-reply@encount.net');


// ---------------------------------------------------------- /可変設定項目

$g_pref = array('北海道','青森県','岩手県','宮城県','秋田県','山形県','福島県','茨城県','栃木県',
'群馬県','埼玉県','千葉県','東京都','神奈川県','新潟県','富山県','石川県','福井県','山梨県','長野県',
'岐阜県','静岡県','愛知県','三重県','滋賀県','京都府','大阪府','兵庫県','奈良県','和歌山県','鳥取県',
'島根県','岡山県','広島県','山口県','徳島県','香川県','愛媛県','高知県','福岡県','佐賀県','長崎県',
'熊本県','大分県','宮崎県','鹿児島県','沖縄県');


// 年最小値
define('YEAR_MIN', 2000);
// 年最大値
define('YEAR_MAX', 2020);

// テーブル行数最小値
define('TABLE_ROWCNT_MIN', 0);
// 年最大値
define('TABLE_ROWCNT_MAX', 20);

// 有効化するタグ配列
$effectiveTags[] = 'a';
$effectiveTags[] = 'b';
$effectiveTags[] = 'strong';
$effectiveTags[] = 'font';
$effectiveTags[] = 'i';

// Javascript使用チェック配列
$scriptKeyword[] = 'script';
$scriptKeyword[] = 'onclick';
$scriptKeyword[] = 'ondblclick';
$scriptKeyword[] = 'onkeydown';
$scriptKeyword[] = 'onkeypress';
$scriptKeyword[] = 'onkeyup';
$scriptKeyword[] = 'onmousedown';
$scriptKeyword[] = 'onmouseup';
$scriptKeyword[] = 'onmouseover';
$scriptKeyword[] = 'onmouseout';
$scriptKeyword[] = 'onmousemove';
$scriptKeyword[] = 'onload';
$scriptKeyword[] = 'onunload';
$scriptKeyword[] = 'onfocus';
$scriptKeyword[] = 'onblur';
$scriptKeyword[] = 'onsubmit';
$scriptKeyword[] = 'onreset';
$scriptKeyword[] = 'onchange';
$scriptKeyword[] = 'onresize';
$scriptKeyword[] = 'onmove';
$scriptKeyword[] = 'ondragdrop';
$scriptKeyword[] = 'onabort';
$scriptKeyword[] = 'onerror';
$scriptKeyword[] = 'onselect';


// エラーログファイル指定
define('LOG_FILE', APP_BASE.'/log/error.log');

// ログファイル出力レベル(開発用)
// 1...DEBUG以上を出力
// 2...INFO以上を出力
// 3...WARNING以上を出力
// 4...ERROR以上を出力
// 5...FATAL以上を出力
define('LOG_LEVEL', 3);

// 時差補正値(秒)
define('TIME_DIFF', 0);

// エラー種別(共通)
define('NO_ERROR', 0);
define('ARTICLE_NOTHING', 1);
define('INPUT_ERROR', 1);
define('FATAL_ERROR', 2);

// ログレベル定義
define('DEBUG', 1);
define('INFO', 2);
define('WARNING', 3);
define('ERROR', 4);
define('FATAL', 5);

define('HOUMUSOUDAN_ENDPOINT', 'http://www.yahoo.co.jp/?id=');

?>
