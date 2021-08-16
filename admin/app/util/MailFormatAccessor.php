<?php
/**
 * mail_informationテーブルのDBアクセス
 * 
 * @author kanda hirohide
 */
class MailFormatAccessor extends Accessor {

	/**
	 * メール一覧取得
	 */
	function getList() {
		$con = DB :: connect($this->dsn);
		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		// 部署一覧
		$sql = "SELECT * FROM mail_information ORDER BY display_order ";
		$args = null;

		$list = $con->getAll($sql, $args, DB_FETCHMODE_ASSOC);
//print_r($list);
//print_r($con);
		if (DB :: isError($list)) {
			$con->disconnect();
			return "メール一覧取得時エラー:" . DB :: errorMessage($list);
		}

		$con->disconnect();

		return $list;
	}

	/**
	 * メール情報取得
	 */
	function getMail($id) {
		$con = DB :: connect($this->dsn);

		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		// 部署一覧
		$sql = "SELECT * FROM mail_information WHERE mail_information_id LIKE ? ";
		$args = array($id);

		$data = $con->getRow($sql, $args, DB_FETCHMODE_ASSOC);
		if (DB :: isError($data)) {
			$con->disconnect();
			return "メール情報取得時エラー:" . DB :: errorMessage($data);
		}

		$con->disconnect();

		return $data;
	}

	/**
	 * メール更新
	 */
	function updateMail($id, $data) {
		$con = DB :: connect($this->dsn);
		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		$sql = "
			UPDATE mail_information SET mail_subject = ?, mail_body = ?
			WHERE mail_information_id = ? 
		";
		$args = array(
			$data['mail_subject'],
			$data['mail_body'],
			$id,
		);

		$result = $con->query($sql, $args);
//print_r($result);
//print_r($con);
		if (DB :: isError($result)) {
			$con->disconnect();
			if ($GLOBALS['debug']) echo $result;
			if ($GLOBALS['debug']) print_r( $result);
			return "メール更新時エラー:" . DB :: errorMessage($result) . ' ### '.$result->userinfo;
		}

		$con->disconnect();

		return null;
	}
















}
?>
