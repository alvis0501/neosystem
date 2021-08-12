<?php


/**
 * DB非持続的接続クラス。
 */
class DbNpConnect {

	// --- FIELD ---

	var $result_;
	var $errorManager_; // エラー管理オブジェクト

	// --- METHOD ---

	/**
	 * コンストラクタ。
	 */
	function DbNpConnect($errorManager) {
		$this->errorManager_ = $errorManager;
	}

	/**
	 * DBに接続してクエリを発行する。
	 */
	function execute() {

		// DB接続・SQL実行
		$host = '';
		$tmp = DB_HOST;
		if (defined('DB_HOST') && $tmp != '') {
			$host = 'host=' . DB_HOST . ' ';
		}
		$port = '';
		$tmp = DB_PORT;
		if (defined('DB_PORT') && $tmp != '') {
			$port = 'port=' . DB_PORT . ' ';
		}
		$dbname = '';
		$tmp = DB_NAME;
		if (defined('DB_NAME') && $tmp != '') {
			$dbname = 'dbname=' . DB_NAME . ' ';
		}
		$user = '';
		$tmp = DB_USER;
		if (defined('DB_USER') && $tmp != '') {
			$user = 'user=' . DB_USER . ' ';
		}
		$password = '';
		$tmp = DB_PASSWORD;
		if (defined('DB_PASSWORD') && $tmp != '') {
			$password = 'password=' . DB_PASSWORD . ' ';
		}

		$ret = pg_connect($host . $port . $dbname . $user . $password);

		if ($ret == FALSE) {
			$msg = 'DB接続に失敗しました。';
			$msg .= '致命的なエラーのため管理者に連絡してください。';
			$this->errorManager_->addError($msg, FATAL_ERROR);
			writeLog(FATAL, __FILE__, __LINE__, 'DB接続に失敗 URI='.$_SERVER['REQUEST_URI']);
			return FALSE;
		}

		return $ret;
	}

	/**
	 * エラー管理オブジェクト取得。
	 */
	function getErrorManager() {
		return $this->errorManager_;
	}

}
?>