<?php
/**
 * バッチ処理用のDBアクセス
 * 
 * @author kanda hirohide
 */
class CommonBatchAccessor extends Accessor {

	var $con;

	/**
	 * クエリ実行
	 */
	function query($sql) {
		$con = DB :: connect($this->dsn);
		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		$result = $con->query($sql, null);
		if (DB :: isError($result)) {
			$con->disconnect();
			return "クエリ実行時エラー:" . DB :: errorMessage($result);
		}

		$con->disconnect();

		return null;
	}

	/**
	 * 全件取得
	 */
	function getAll($sql) {
		$con = DB :: connect($this->dsn);
		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		$result = $con->getAll($sql, null, DB_FETCHMODE_ASSOC);
		if (DB :: isError($result)) {
			$con->disconnect();
			return "クエリ実行時エラー:" . DB :: errorMessage($result);
		}

		$con->disconnect();

		return $result;
	}

	/**
	 * 1件取得
	 */
	function getRow($sql) {
		$con = DB :: connect($this->dsn);
		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		$result = $con->getRow($sql, null, DB_FETCHMODE_ASSOC);
		if (DB :: isError($result)) {
			$con->disconnect();
			return "クエリ実行時エラー:" . DB :: errorMessage($result);
		}

		$con->disconnect();

		return $result;
	}


	/**
	 * DB接続
	 */
	function connect() {
		$this->con = DB :: connect($this->dsn);
		if (DB :: isError($this->con)) {
			return "DB接続エラー:" . DB :: errorMessage($this->con);
		}
		return null;
	}

	/**
	 * クエリ実行
	 */
	function query_persitent($sql) {
		$ret = $this->con->query($sql, null);
		if (DB :: isError($ret)) {
			$this->con->disconnect();
			return "クエリ実行時エラー:" . DB :: errorMessage($ret);
		}
		return null;
	}

	/**
	 * DB切断
	 */
	function disconnect() {
		$this->con->disconnect();
		return null;
	}

}
?>
