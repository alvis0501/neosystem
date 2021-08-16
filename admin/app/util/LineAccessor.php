<?php
/**
 * tbl_lineテーブルのDBアクセス
 * 
 * @author kanda hirohide
 */
class LineAccessor extends Accessor {

	/**
	 * ライン一覧取得
	 */
	function getList() {
		$con = DB :: connect($this->dsn);

		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		// ライン一覧
		$sql = "SELECT * FROM tbl_line WHERE type='AK' ORDER BY control_number ";
		$args = null;

		$line = $con->getAll($sql, $args, DB_FETCHMODE_ASSOC);
//print_r($line);
//print_r($con);
		if (DB :: isError($line)) {
			$con->disconnect();
			return "ライン一覧取得時エラー:" . DB :: errorMessage($line);
		}

		// ラインのメンバー一覧
		for ($i = 0; $i < count($line); $i++) {
			$member_emloyee = str_replace(",", "','", $line[$i]["line_member_employee_id"]);
			$member_emloyee = "'" . $member_emloyee . "'";
			$sql = "SELECT * FROM employee WHERE employee_cd IN ($member_emloyee) AND department_cd like '82217000%' ORDER BY employee_cd";
			$args = null;

			$members = $con->getAll($sql, $args, DB_FETCHMODE_ASSOC);
//print_r($members);
//print_r($con);
			if (DB :: isError($members)) {
				$con->disconnect();
				return "ラインのメンバー一覧取得時エラー:" . DB :: errorMessage($members);
			}

			$line[$i]["line_member"] = array();
			for ($j = 0; $j < count($members); $j++) {
				$line[$i]["line_member"][] = $members[$j]["family_name"]." ".$members[$j]["first_name"];
			}
			//$lines[$i] = $line;
		}
//print_r($line);


		$con->disconnect();

		return $line;
	}

	/**
	 * ライン一覧取得(所属メンバーの詳細情報も取得)
	 */
	function getListDetails() {
		$con = DB :: connect($this->dsn);

		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		// ライン一覧
		$sql = "SELECT * FROM tbl_line WHERE type='AK' ORDER BY control_number ";
		$args = null;

		$line = $con->getAll($sql, $args, DB_FETCHMODE_ASSOC);
//print_r($line);
//print_r($con);
		if (DB :: isError($line)) {
			$con->disconnect();
			return "ライン一覧取得時エラー:" . DB :: errorMessage($line);
		}

		// ラインのメンバー一覧
		for ($i = 0; $i < count($line); $i++) {
			$member_emloyee = str_replace(",", "','", $line[$i]["line_member_employee_id"]);
			$member_emloyee = "'" . $member_emloyee . "'";
			$sql = "SELECT * FROM employee WHERE employee_cd IN ($member_emloyee) AND department_cd like '82217000%' ORDER BY employee_cd";
			$args = null;

			$members = $con->getAll($sql, $args, DB_FETCHMODE_ASSOC);
//print_r($members);
//print_r($con);
			if (DB :: isError($members)) {
				$con->disconnect();
				return "ラインのメンバー一覧取得時エラー:" . DB :: errorMessage($members);
			}

			$line[$i]["line_member"] = $members;
		}
//print_r($line);


		$con->disconnect();

		return $line;
	}

	/**
	 * ライン一覧取得(ライン情報のみ)
	 */
	function getSimpleList() {
		$con = DB :: connect($this->dsn);
		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		// ライン一覧
		$sql = "SELECT * FROM tbl_line WHERE type='AK' ORDER BY control_number ";
		$args = null;

		$line_list = $con->getAll($sql, $args, DB_FETCHMODE_ASSOC);
//print_r($line_list);
//print_r($con);
		if (DB :: isError($line_list)) {
			$con->disconnect();
			return "ライン一覧取得時エラー:" . DB :: errorMessage($line_list);
		}

		$con->disconnect();

		return $line_list;
	}

	/**
	 * 指定ライン取得
	 */
	function getLineData($control_number) {
		$con = DB :: connect($this->dsn);

		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		// 指定ラインのデータを取得
		$sql = "SELECT * FROM tbl_line WHERE control_number = ?";
		$args = array($control_number);

		$data = $con->getRow($sql, $args, DB_FETCHMODE_ASSOC);
		if (DB :: isError($data)) {
			$con->disconnect();
			return "指定ラインのデータ取得時エラー:" . DB :: errorMessage($data);
		}

		$con->disconnect();

		return $data;
	}

	/**
	 * 法務部ライン長の一覧取得
	 */
	function getLineBossList($LINE_HOUMU_BOSS_CD) {
		$con = DB :: connect($this->dsn);

		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		// ライン長一覧
		$sql = "SELECT * FROM employee WHERE department_cd like '82217000%' AND position_cd IN (".join(",", array_keys($LINE_HOUMU_BOSS_CD)).") ORDER BY position_cd";
		$args = null;

		$line = $con->getAll($sql, $args, DB_FETCHMODE_ASSOC);
//print_r($line);
//print_r($con);
		if (DB :: isError($line)) {
			$con->disconnect();
			return "法務部ライン長の一覧取得時エラー:" . DB :: errorMessage($result);
		}

		$con->disconnect();

		return $line;
	}

	/**
	 * ライン未参加の法務部社員の一覧取得
	 */
	function getLineNotJoiningList() {
		$con = DB :: connect($this->dsn);

		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		// ライン参加中の法務部社員のid一覧（全ライン分のデータを取得）
		$sql = "SELECT line_member_employee_id FROM tbl_line WHERE type='AK'";
		$args = null;

		$lines = $con->getAll($sql, $args, DB_FETCHMODE_ASSOC);
//print_r($lines);
//print_r($con);
		if (DB :: isError($lines)) {
			$con->disconnect();
			return "ライン参加中社員のid一覧取得時エラー:" . DB :: errorMessage($lines);
		}


		// ライン未参加の法務部社員の一覧（法務部内のライン参加中の社員を除く一覧を取得）
		$not_in_condition = array();
		for($i = 0; $i<count($lines); $i++) {
			$not_in_condition[] = $lines[$i]["line_member_employee_id"];
		}
		$not_in = join(",", $not_in_condition);
		$not_in = str_replace(",", "','", $not_in);
		$sql = "SELECT * FROM employee WHERE department_cd LIKE '82217000%' AND employee_cd NOT IN ('".$not_in."')";
		$args = null;
		//echo $sql;
		$houmu_members = $con->getAll($sql, $args, DB_FETCHMODE_ASSOC);
//print_r($houmu_members);
//print_r($con);
		if (DB :: isError($line)) {
			$con->disconnect();
			return "ライン未参加の法務部社員の一覧取得時エラー:" . DB :: errorMessage($result);
		}

		$con->disconnect();

		return $houmu_members;
	}

	/**
	 * 指定ライン参加中の法務部社員の一覧取得
	 */
	function getLineJoiningListByTargetLine($control_number) {
		$con = DB :: connect($this->dsn);

		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		// 指定ラインのデータを取得
		$sql = "SELECT * FROM tbl_line WHERE control_number = ?";
		$args = array($control_number);

		$data = $con->getRow($sql, $args, DB_FETCHMODE_ASSOC);
//print_r($lines);
//print_r($con);
		if (DB :: isError($data)) {
			$con->disconnect();
			return "指定ラインのデータを取得時エラー:" . DB :: errorMessage($data);
		}

		// 検索用文字列生成
		$line_member_employee_id_joined = str_replace(",", "','", $data["line_member_employee_id"]);
		$line_member_employee_id_joined = "'" . $line_member_employee_id_joined . "'";


		// 指定ライン参加中の法務部社員の一覧取得
		$sql = "SELECT * FROM employee WHERE employee_cd IN (" . $line_member_employee_id_joined . ") AND department_cd LIKE '82217000%'";
		$args = null;

		$members = $con->getAll($sql, $args, DB_FETCHMODE_ASSOC);
		if (DB :: isError($members)) {
			$con->disconnect();
			return "指定ライン参加中の法務部社員の一覧取得時エラー:" . DB :: errorMessage($members);
		}

		$con->disconnect();

		return $members;
	}

	/**
	 * ライン挿入
	 */
	function insertLine($data) {
		$con = DB :: connect($this->dsn);

		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		$sql = "
			INSERT INTO tbl_line (type, line_boss_name, line_boss_mail, line_boss_employee_id, line_member_employee_id, update_day) 
			VALUES (?,?,?,?,?,?)
		";
		$args = array(
			$data['type'],
			$data['line_boss_name'],
			$data['line_boss_mail'],
			$data['line_boss_employee_id'],
			$data['line_member_employee_id'],
			$data['update_day'],
		);

		$result = $con->query($sql, $args);
		if (DB :: isError($result)) {
			$con->disconnect();
			if ($GLOBALS['debug']) echo $result;
			if ($GLOBALS['debug']) print_r( $result);
			return "ライン挿入時エラー:" . DB :: errorMessage($result) . ' ### '.$result->userinfo;
		}

		$con->disconnect();

		return null;
	}

	/**
	 * ライン更新
	 */
	function updateLine($id, $data) {
		$con = DB :: connect($this->dsn);

		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		$sql = "
			UPDATE tbl_line SET line_boss_name = ?,  line_boss_mail = ?, line_boss_employee_id = ?, line_member_employee_id = ?, update_day = ?
			WHERE control_number = ? 
		";
		$args = array(
			$data['line_boss_name'],
			$data['line_boss_mail'],
			$data['line_boss_employee_id'],
			$data['line_member_employee_id'],
			$data['update_day'],
			$id,
		);

		$result = $con->query($sql, $args);
		if (DB :: isError($result)) {
			$con->disconnect();
			if ($GLOBALS['debug']) echo $result;
			if ($GLOBALS['debug']) print_r( $result);
			return "ライン更新時エラー:" . DB :: errorMessage($result) . ' ### '.$result->userinfo;
		}

		$con->disconnect();

		return null;
	}
	
	/**
	 * ライン削除
	 */
	function deleteLine($id) {
		$con = DB :: connect($this->dsn);

		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		$sql = "
			DELETE FROM tbl_line WHERE control_number = ? 
		";
		$args = array(
			$id,
		);

		$result = $con->query($sql, $args);
		if (DB :: isError($result)) {
			$con->disconnect();
			if ($GLOBALS['debug']) echo $result;
			if ($GLOBALS['debug']) print_r( $result);
			return "ライン削除時エラー:" . DB :: errorMessage($result) . ' ### '.$result->userinfo;
		}

		$con->disconnect();

		return null;
	}



	/**
	 * 指定ライン取得
	 */
	function getLineDataByLineBossEmployeeId($line_boss_employee_id) {
		$con = DB :: connect($this->dsn);

		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		// 指定ラインのデータを取得
		$sql = "SELECT * FROM tbl_line WHERE line_boss_employee_id = ?";
		$args = array($line_boss_employee_id);

		$data = $con->getRow($sql, $args, DB_FETCHMODE_ASSOC);
		if (DB :: isError($data)) {
			$con->disconnect();
			return "指定ラインのデータ取得時エラー:" . DB :: errorMessage($data);
		}

		$con->disconnect();

		return $data;
	}

	/**
	 * 指定ライン取得
	 */
	function getLineDataByLineMemberEmployeeId($line_member_employee_id) {
		$con = DB :: connect($this->dsn);

		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		// 指定ラインのデータを取得
		$sql = "SELECT * FROM tbl_line WHERE line_member_employee_id LIKE ?";
		$args = array('%'.$line_member_employee_id.'%');

		$data = $con->getRow($sql, $args, DB_FETCHMODE_ASSOC);
		if (DB :: isError($data)) {
			$con->disconnect();
			return "指定ラインのデータ取得時エラー:" . DB :: errorMessage($data);
		}

		$con->disconnect();

		return $data;
	}

	/**
	 * 指定ライン取得
	 */
	function getLineDataByLineBossName($line_boss_name) {
		$con = DB :: connect($this->dsn);

		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		// 指定ラインのデータを取得
		$sql = "SELECT * FROM tbl_line WHERE line_boss_name LIKE ?";
		$args = array($line_boss_name);

		$data = $con->getRow($sql, $args, DB_FETCHMODE_ASSOC);
		if (DB :: isError($data)) {
			$con->disconnect();
			return "指定ラインのデータ取得時エラー:" . DB :: errorMessage($data);
		}

		$con->disconnect();

		return $data;
	}

}
?>
