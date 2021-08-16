<?php
/**
 * alert_masterテーブルのDBアクセス
 * 
 * @author kanda hirohide
 */
class AlertMasterAccessor extends Accessor {

	/**
	 * データ取得
	 */
	function getAll() {
		$con = DB :: connect($this->dsn);
		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		$sql = "SELECT * FROM alert_master ORDER BY alert_master_id ";
		$args = null;

		$result = $con->getAll($sql, $args, DB_FETCHMODE_ASSOC);
		if (DB :: isError($result)) {
			$con->disconnect();
			return "HTML取得時エラー:" . DB :: errorMessage($result);
		}

		$con->disconnect();

		return $result;
	}

	/**
	 * データ更新
	 */
	function update($id, $value) {
		$con = DB :: connect($this->dsn);
		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		$sql = "UPDATE alert_master SET set_value = ? WHERE alert_master_id = ? ";
		$args = array(
			$value,
			$id,
		);

		$result = $con->query($sql, $args);
		if (DB :: isError($result)) {
			$con->disconnect();
			if ($GLOBALS['debug']) echo $result;
			if ($GLOBALS['debug']) print_r( $result);
			return "データ更新時エラー:" . DB :: errorMessage($result) . ' ### '.$result->userinfo;
		}

		$con->disconnect();

		return null;
	}

}
?>
