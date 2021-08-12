<?php


/**
 * エラー管理クラス。
 * エラーメッセージとエラーレベルを管理する。
 * エラーレベル判定により重大なエラーメッセージを優先的に取得できる。
 */
class ErrorManager {

	var $errorMsg_; // エラーメッセージ配列
	var $errorLevel_; // エラーメッセージレベル配列

	/**
	 * コンストラクタ。
	 */
	function ErrorManager() {
		$this->errorMsg_ = array();
		$this->errorLevel_ = array();
	}

	/**
	 * エラーを追加する。
	 */
	function addError($errorMsg, $errorLevel) {
		array_push($this->errorMsg_, $errorMsg);
		array_push($this->errorLevel_, $errorLevel);
	}

	/**
	 * 最大エラーレベルを取得する。
	 */
	function getMaxErrorLevel() {
		$max = 0;
		foreach ($this->errorLevel_ as $level) {
			if ($level > $max) {
				$max = $level;
			}
		}
		return $max;
	}

	/**
	 * 指定レベルに属するエラーメッセージを取得する。
	 */
	function getErrorMsg($level) {

		global $debug;
		if ($debug) echo '$level='.$level.'<br>';

		$msgs = array();

		$sz = count($this->errorLevel_);

		if ($debug) echo '$sz='.$sz.'<br>';
		if ($debug) print_r($this->errorMsg_);
		if ($debug) print_r($this->errorLevel_);

		for ($i = 0; $i < $sz; $i++) {
			if ($this->errorLevel_[$i] == $level) {
				if ($debug) echo '$this->errorMsg_[$i]='.$this->errorMsg_[$i];
				if ($debug) echo '$this->errorLevel_[$i]='.$this->errorLevel_[$i];
				array_push($msgs, $this->errorMsg_[$i]);
			}
		}
		return $msgs;
	}

	/**
	 * 指定レベル以上のエラーメッセージを取得する。
	 */
	function getErrorMsgImportant($level) {
		$maxlevel = $this->getMaxErrorLevel();
		$msgs = array();
		for ($i = $maxlevel; $i >= $level; $i--) {
			array_push($msgs, $this->getErrorMsg($i));
		}
	}

	/**
	 * エラーが存在するか確認する。
	 * TRUE...存在する、FALSE...存在しない
	 */
	function existence() {
		$cnt = count($this->errorMsg_);
		if ($cnt > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * 
	 */
	function getAllMessage() {
		return $this->errorMsg_;
	}

	/**
	 * 
	 */
	function getAllLevel() {
		return $this->errorLevel_;
	}

	/**
	 * 
	 */
	function joinManager($emsgMng) {
		$this->errorMsg_ = array_merge($this->errorMsg_, $emsgMng->getAllMessage());
		$this->errorLevel_ = array_merge($this->errorLevel_, $emsgMng->getAllLevel());
	}

}
?>