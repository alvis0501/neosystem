<?php

date_default_timezone_set('Asia/Tokyo');

// PHPエラーレベル
error_reporting(0); // 0...出力なし、E_ALL...全出力
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_WARNING);
//error_reporting(E_ALL);

// php設定
ini_set('mbstring.internal_encoding', 'UTF-8');
ini_set('mbstring.encoding_translation', 'ON');
ini_set('mbstring.http_output', 'UTF-8');
ini_set('mbstring.language', 'Japanese');
ini_set('mbstring.output_handler', 'mb_output_handler');
ini_set('session.gc_probability', '100');
ini_set('session.gc_maxlifetime', '3600');
//ini_set('session.save_path', APP_BASE . '/mng/tmp');
ini_set('display_errors', true);

define("PHPCOMMON_DIR", "../phpcommon/");
define("EXTLIB_DIR", "../extlib/");

define("PIADB_UTILITY_DIR", "../piadb/app/util/");

define("APP_DIR", "app/");
define("ACTION_DIR", APP_DIR . "action/");
define("UTILITY_DIR", APP_DIR . "util/");
define("TEMPLATE_DIR", APP_DIR . "tpl/");
define("TEMPLATE_COMPILED_DIR", APP_DIR . "tpl_c/");

require_once (PHPCOMMON_DIR . "define.php");
require_once (PHPCOMMON_DIR . "common.php");
require_once (PHPCOMMON_DIR . "ErrorManager.php");
require_once (PHPCOMMON_DIR . "FatalErrorShow.php");
require_once (PHPCOMMON_DIR . "PageNavi.php");
require_once (PHPCOMMON_DIR . "PageNaviFront.php");
require_once (PHPCOMMON_DIR . "Logger.php");

require_once (EXTLIB_DIR . "smarty/libs/Smarty.class.php");

// DBアクセサ
require_once (UTILITY_DIR . "Accessor.php");
/*
require_once (UTILITY_DIR . "HtmlMasterAccessor.php");
require_once (UTILITY_DIR . "LineAccessor.php");
require_once (UTILITY_DIR . "BusyoAccessor.php");
require_once (UTILITY_DIR . "CategoryAdminAccessor.php");
require_once (UTILITY_DIR . "MailFormatAccessor.php");
require_once (UTILITY_DIR . "AlertMasterAccessor.php");
require_once (UTILITY_DIR . "HeadquarterAccessor.php");
require_once (UTILITY_DIR . "CommonBatchAccessor.php");
*/
require_once (UTILITY_DIR . "UserAccessor.php");
require_once (UTILITY_DIR . "ShopAccessor.php");

/*
require_once (PIADB_UTILITY_DIR . "ToiawaseAccessor.php");
require_once (PIADB_UTILITY_DIR . "ToiawaseTypeAccessor.php");
require_once (PIADB_UTILITY_DIR . "EmployeeAccessor.php");
require_once (PIADB_UTILITY_DIR . "FugiAccessor.php");
require_once (PIADB_UTILITY_DIR . "FugiDataUsageTypeAccessor.php");
require_once (PIADB_UTILITY_DIR . "CategoryAccessor.php");
require_once (PIADB_UTILITY_DIR . "FugiMinorChangeAccessor.php");
require_once (PIADB_UTILITY_DIR . "SfmAccessor.php");
*/

// 画面Action
require_once (ACTION_DIR . "BaseAction.php");
require_once (ACTION_DIR . "LoginAction.php");
require_once (ACTION_DIR . "ShowMenu.php");
require_once (ACTION_DIR . "ShopNew.php");


// Pearライブラリ一括読込用
ini_set('include_path', APP_INCLUDE_PATH);

require_once ("DB.php");

// 設定値「mbstring.output_handler」はini_set()では設定できないため
// ob_start()を使ってバッファリングを開始する
ob_start('mb_output_handler');

// デバッグフラグ
$debug = false;
//$debug = true;

session_cache_limiter('none');
session_start();

// Smartyオブジェクトを準備
$smarty = new Smarty();
$smarty->template_dir = TEMPLATE_DIR;
$smarty->compile_dir = TEMPLATE_COMPILED_DIR;

$smarty->debugging = false;
//$smarty->debugging = true;

// リクエスト値のダンプ
if ($debug) {
	$result = array(
		'$_GET' => $_GET,
		'$_POST' => $_POST,
		'$_SESSION' => $_SESSION,
	);
	print "<pre>"; print_r($result); print "</pre>";
}

// 次画面遷移情報を取得
$flow = $_REQUEST['flow'];

// 実行フラグ
$doExecute = true;

//print_r($_REQUEST);
//print_r($_SESSION);

if ($flow == '') {
	// ログイン画面
	$action = & new LoginAction($smarty);

} elseif (loginCheck()) {

	if ($flow == 'menu') {
		// メニュー画面表示
		$action = & new ShowMenu($smarty);

	} elseif ($flow == 'shop_new') {
		$action = & new ShopNew($smarty);

	} elseif ($flow == 'mob_new_article') {
		$action = & new MobNewArticle($smarty);
	}

} else {
	header("Location: index.php");

}




/*
if (!isset ($flow) || $flow == 'login') {
	// ログイン実行
	$action = & new LoginExec($smarty);
} elseif ($flow == 'logout') {
	session_destroy();
	$action = & new ShowHTML("logout.html", $smarty);
	$action->execute();
	exit ();
} elseif (loginCheck()) {
	if ($flow == 'menu') {
		// TOP画面表示
		$action = & new ShowMenu($smarty);
	} elseif ($flow == 'mob_article_list') {
		$action = & new MobArticleList($smarty);
	} elseif ($flow == 'mob_new_article') {
		$action = & new MobNewArticle($smarty);
	}
} else {
	header("Location: index.php");
}
*/

// アクションなら実行
if (isAction($action) && $doExecute) {
	$action->execute();
}

function loginCheck() {
	return (isset ($_SESSION['admin_user_id']));
}

?>
