<?php
class ScoutAccessor extends Accessor {

	function getUserByIdAndPw($login_id, $password) {
		$con = DB :: connect($this->dsn);
		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		$sql = "SELECT * FROM scout_t WHERE login_id = ? AND login_pass = ? LIMIT 1";
		//print_r($sql);
		$result = $con->getRow($sql, array (
			$login_id,
			$password
		), DB_FETCHMODE_ASSOC);
		//print_r($result);
		if (DB :: isError($result)) {
			$con->disconnect();
			return "ユーザー取得時エラー:" . DB :: errorMessage($result);
		}

		$con->disconnect();

		return $result;
	}




	function getUser($id) {
		$con = DB :: connect($this->dsn);
		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		$sql = "SELECT * FROM user_t WHERE user_id = ?";
		$result = $con->getRow($sql, array (
			$id
		), DB_FETCHMODE_ASSOC);
		if (DB :: isError($result)) {
			$con->disconnect();
			return "ユーザー取得時エラー:" . DB :: errorMessage($result);
		}

		$con->disconnect();

		return $result;
	}

	function getUserList() {
		$con = DB :: connect($this->dsn);
		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		$sql = "SELECT * FROM user_t ORDER BY user_id";
		$result = $con->getAll($sql, null, DB_FETCHMODE_ASSOC);
		if (DB :: isError($result)) {
			$con->disconnect();
			return "ユーザー一覧取得時エラー:" . DB :: errorMessage($result);
		}

		$con->disconnect();

		return $result;
	}

	function updateUser($users) {
		$con = DB :: connect($this->dsn);
		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		foreach ($users as $user) {
			$sql = "UPDATE user_t SET login_id = ?, password = ?, admin = ?, " .
			"writer = ?, update_ts = now() WHERE user_id = ?";
			$result = $con->query($sql, array (
				$user['login_id'],
				$user['password'],
				 ($user['admin'] == "t"
			), ($user['writer'] == "t"), $user['user_id']));
			if (DB :: isError($result)) {
				$con->disconnect();
				return "ユーザー更新時エラー(ID=" . $user['login_id'] . "):" . DB :: errorMessage($result);
			}
		}

		$con->disconnect();

		return null;
	}

	function insertUser($user) {
		$con = DB :: connect($this->dsn);
		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		$sql = "INSERT INTO user_t (login_id, password, admin, writer, register_ts, update_ts) " .
		"VALUES (?, ?, ?, ?, now(), now())";
		$result = $con->query($sql, array (
			$user['login_id'],
			$user['password'],
			 ($user['admin'] == "t"
		), ($user['writer'] == "t")));
		if (DB :: isError($result)) {
			$con->disconnect();
			return "ユーザー挿入時エラー:" . DB :: errorMessage($result) . ' ### '.$result->userinfo;
		}

		$con->disconnect();

		return null;
	}
}
?>
