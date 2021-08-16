<?php

/**
 * TOPページ表示。
 */
class LoginAction extends BaseAction {

	/**
	 * Action実行。
	 */
	function execute(){

		// 初期表示
		if ($_REQUEST['type'] == '') {

			// 画面表示
			$this->smarty_->display("login.html");

		// ログイン実行
		} else if ($_REQUEST['type'] == 'login') {
			$errors = array();

			if (strlen($_REQUEST['login_id']) == 0 || strlen($_REQUEST['password']) == 0) {
				$errors[] = "ユーザーID・パスワードを入力してください。";
			} else {
				$ma = new UserAccessor();
				$member = $ma->getUserByIdAndPw($_REQUEST['login_id'], $_REQUEST['password']);
				print_r($_REQUEST);
				if (is_null($member)) {
					$errors[] = "ユーザーID・パスワードが間違っています。";
				} elseif (!is_array($member)) {
					$errors[] = $member;
				}
			}
			
			if (count($errors) > 0) {
				// エラー画面表示
				$this->smarty_->assign("errors", $errors);
				$this->smarty_->display("error.html");

			} else {

				// ログイン成功ならセッションに保存
				$_SESSION['admin_user_id'] = $member['admin_user_id'];

				// 画面表示
				$this->smarty_->display("menu.html");
			}

		}

	}

}
?>