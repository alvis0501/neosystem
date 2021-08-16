<?php
/**
 * html_masterテーブルのDBアクセス
 * 
 * @author kanda hirohide
 */
class HtmlMasterAccessor extends Accessor {

	/**
	 * HTML取得
	 */
	function getHtml($htmlName) {
		$con = DB :: connect($this->dsn);

		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		$sql = "SELECT * FROM html_master WHERE html_name = ? ";
		$args = array(
			$htmlName
		);

		$result = $con->getRow($sql, $args, DB_FETCHMODE_ASSOC);
		if (DB :: isError($result)) {
			$con->disconnect();
			return "HTML取得時エラー:" . DB :: errorMessage($result);
		}

		$con->disconnect();

		return $result;
	}

	/**
	 * HTML更新
	 */
	function updateHtml($htmlName, $html) {
		$con = DB :: connect($this->dsn);

		if (DB :: isError($con)) {
			return "DB接続エラー:" . DB :: errorMessage($con);
		}

		$sql = "UPDATE html_master SET html_value = ? WHERE html_name = ? ";
		$args = array(
			$html,
			$htmlName,
		);

		$result = $con->query($sql, $args);
		if (DB :: isError($result)) {
			$con->disconnect();
			if ($GLOBALS['debug']) echo $result;
			if ($GLOBALS['debug']) print_r( $result);
			return "HTML更新時エラー:" . DB :: errorMessage($result) . ' ### '.$result->userinfo;
		}

		$con->disconnect();

		return null;
	}

}
?>
