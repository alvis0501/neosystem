<?php


/**
 * DBクエリ実行クラス。
 */
class DbQuery {

	// --- FIELD ---

	var $con_;
	var $sql_;
	var $errorManager_; // エラー管理オブジェクト

	// --- METHOD ---

	/**
	 * コンストラクタ。
	 */
	function DbQuery($con, $sql, $errorManager) {
		$this->con_ = $con;
		$this->sql_ = $sql;
		$this->errorManager_ = $errorManager;
	}

	/**
	 * DBに接続してクエリを発行する。
	 */
	function execute() {

		$result = pg_query($this->con_, $this->sql_);
		if ($result == FALSE) {
			$msg = 'クエリ実行に失敗しました。';
			$msg .= '致命的なエラーのため管理者に連絡してください。';
			$this->errorManager_->addError($msg, FATAL_ERROR);
			writeLog(FATAL, __FILE__, __LINE__, 'クエリ実行に失敗 URI='.$_SERVER['REQUEST_URI'].' SQL='.$this->sql_);
			return FALSE;
		}

		return $result;
	}

	/**
	 * エラー管理オブジェクト取得。
	 */
	function getErrorManager() {
		return $this->errorManager_;
	}

}
?>