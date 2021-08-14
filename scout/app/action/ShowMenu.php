<?php

/**
 * メニュー表示。
 */
class ShowMenu extends BaseAction {

	/**
	 * Action実行。
	 */
	function execute(){

		// 画面表示
		$this->smarty_->display("menu.html");

	}

}
?>