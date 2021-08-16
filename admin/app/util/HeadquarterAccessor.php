<?php
/**
 * headquarterテーブルのDBアクセス
 * 
 * @author shimada tomoya
 */
class HeadquarterAccessor extends Accessor {

	function getHeadquarters() {
		$con = DB :: connect($this->dsn);

		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		$sql = "SELECT * FROM `headquarter` order by indication_order;";

		$result = $con->getAll($sql, $args, DB_FETCHMODE_ASSOC);
		if (DB :: isError($result)) {
			$con->disconnect();
			return "headquarters取得時エラー:" . DB :: errorMessage($result);
		}

		$con->disconnect();

		return $result;
	}

	function findBySQL($sql) {
		$con = DB :: connect($this->dsn);

		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		$result = $con->getAll($sql, $args, DB_FETCHMODE_ASSOC);
		if (DB :: isError($result)) {
			$con->disconnect();
			return "headquarters取得時エラー:" . DB :: errorMessage($result);
		}

		$con->disconnect();

		return $result;
	}
}
?>
