<?php
/**
 * headquarterテーブルのDBアクセス
 * 
 * @author kanda hirohide
 */
class BusyoAccessor extends Accessor {

	/**
	 * 部署＋ライン情報一覧取得
	 */
	function getHeadquarterLineList() {
		$con = DB :: connect($this->dsn);

		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		// 部署一覧
		$sql = "SELECT * FROM headquarter WHERE headquarter_cd LIKE '82%' ORDER BY indication_order, headquarter_cd ";
		$args = null;

		$line_headquarters = $con->getAll($sql, $args, DB_FETCHMODE_ASSOC);
//print_r($line_headquarters);
//print_r($con);
		if (DB :: isError($line_headquarters)) {
			$con->disconnect();
			return "部署一覧取得時エラー:" . DB :: errorMessage($line_headquarters);
		}

		// ラインのメンバー一覧
		for ($i = 0; $i < count($line_headquarters); $i++) {
			$line_headquarter = $line_headquarters[$i];
			$line_headquarter["lines"] = array();
			
			if (!empty($line_headquarter["line"])) {
				$sql = "SELECT * FROM tbl_line WHERE control_number IN (".$line_headquarter["line"].") ORDER BY control_number";
				$args = null;

				$lines = $con->getAll($sql, $args, DB_FETCHMODE_ASSOC);
//print_r($con);
//print_r($lines);
				if (DB :: isError($lines)) {
					$con->disconnect();
					return "ラインのメンバー一覧取得時エラー:" . DB :: errorMessage($lines);
				}

				for ($j=0; $j<count($lines); $j++) {
					$line_headquarter["lines"][] = $lines[$j]["line_boss_name"];
				}
			}
			$line_headquarters[$i] = $line_headquarter;
		}
//print_r($con);
//print_r($line_headquarters);


		$con->disconnect();

		return $line_headquarters;
	}

	/**
	 * 部署情報取得
	 */
	function getHeadquarter($headquarter_cd) {
		$con = DB :: connect($this->dsn);

		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		// 部署一覧
		$sql = "SELECT * FROM headquarter WHERE headquarter_cd = ? ";
		$args = array($headquarter_cd);

		$data = $con->getRow($sql, $args, DB_FETCHMODE_ASSOC);
		if (DB :: isError($data)) {
			$con->disconnect();
			return "部署情報取得時エラー:" . DB :: errorMessage($data);
		}

		$con->disconnect();

		return $data;
	}

	/**
	 * 部署更新
	 */
	function updateHeadquarter($headquarter_cd, $data) {
		$con = DB :: connect($this->dsn);
		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		$sql = "
			UPDATE headquarter SET need_flag = ?, indication_order = ?, line = ?
			WHERE headquarter_cd = ? 
		";
		$args = array(
			$data['need_flag'],
			$data['indication_order'],
			$data['line'],
			$headquarter_cd,
		);

		$result = $con->query($sql, $args);
		if (DB :: isError($result)) {
			$con->disconnect();
			if ($GLOBALS['debug']) echo $result;
			if ($GLOBALS['debug']) print_r( $result);
			return "部署更新時エラー:" . DB :: errorMessage($result) . ' ### '.$result->userinfo;
		}

		$con->disconnect();

		return null;
	}



}
?>
