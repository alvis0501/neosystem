<?php

/**
 * ロギング処理
 * 
 */
class Logger {

	// --- FIELD ---

	static $logfile = "./app.log"; // ログファイルパス

	// --- METHOD ---

	/**
	 * ログ出力。
	 */
	static function info($message) {
		$ts = date('[Y-m-d H:i:s]');
		$type = '[info]';
		error_log($ts . $type . ' ' . $message . "\n", 3, self::$logfile);
		error_log($ts . $type . ' ' . $message . "\n", 1, 'hirohi893@gmail.com');
	}

	/**
	 * ログ出力。
	 */
	static function error($message) {
		$ts = date('[Y-m-d H:i:s]');
		$type = '[error]';
		error_log($ts . $type . ' ' . $message . "\n", 3, self::$logfile);
		error_log($ts . $type . ' ' . $message . "\n", 1, 'hirohi893@gmail.com');
	}

}
?>