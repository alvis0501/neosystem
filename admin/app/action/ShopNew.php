<?php

/**
 * 店舗新規登録。
 */
class ShopNew extends BaseAction {

	/**
	 * Action実行。
	 */
	function execute(){

		// 初期表示
		if ($_REQUEST['type'] == '') {

			// 業種を取得
			$accessor = new ShopAccessor();
			$categories = $accessor->getShopCategoryList();
			if (!is_array($categories)) {
				$this->smarty_->assign("errors", $categories);
				$this->smarty_->display("error.html");
			}
print_r($categories);


			// 大エリアを取得
			$area_large = $accessor->getShopAreaLargeList();
			if (!is_array($area_large)) {
				$this->smarty_->assign("errors", $area_large);
				$this->smarty_->display("error.html");
			}
print_r($area_large);

			// smartyに変数を設定
			$this->smarty_->assign("categories", $categories);
			$this->smarty_->assign("area_large", $area_large);

			// 画面表示
			$this->smarty_->display("shop_new.html");






		// 新規登録実行
		} else if ($_REQUEST['type'] == 'exec') {

			$errors = array();

			if (strlen($_REQUEST['login_id']) == 0 || strlen($_REQUEST['password']) == 0) {
				$errors[] = "ユーザーID・パスワードを入力してください。";
			} else {
				$ma = new UserAccessor();

				$member = $ma->getUserByIdAndPw($_REQUEST['login_id'], $_REQUEST['password']);
				//print_r($member);
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