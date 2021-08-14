<?php
class Accessor {
	var $dsn;
	
	function Accessor($dsn = '') {
		if ($dsn == '') {
			$dsn = "pgsql://".DB_USER.":".DB_PASSWORD."@".DB_HOST.":".DB_PORT."/".DB_NAME;
		}
		$this->dsn = $dsn;
	}
}
?>
