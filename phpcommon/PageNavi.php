<?php

/**
 * ページナビゲーション作成。
 * << < 1 2 3 4 5 6 7 8 9 10 11 > >>
 */
class PageNavi {

	// --- FIELD ---

	var $offset_; // ページオフセット
	var $total_;  // データ総件数
	var $frmax_;  // ページ前後表示最大値
	var $onepage_; // ページ毎表示件数
	var $linkstr_; // リンク文字列(クエリ?&で終わる)
//	var $imgback_; // 前ページ画像パス
//	var $imgnext_; // 後ページ画像パス

	var $naviStr_; // ナビゲーション文字列

	// --- METHOD ---

	/**
	 * コンストラクタ。
	 */
	function PageNavi($offset, $total, $frmax, $onepage, $linkstr/*, $imgback, $imgnext*/) {
		$this->offset_ = $offset;
		$this->total_ = $total;
		$this->frmax_ = $frmax;
		$this->onepage_ = $onepage;
		$this->linkstr_ = $linkstr;
//		$this->imgback_ = $imgback;
//		$this->imgnext_ = $imgnext;
		$this->naviStr_ = '';
	}

	/**
	 * ナビゲーション文字列。
	 */
	function getNaviStr() {
		return $this->naviStr_;
	}

	/**	
	 * 実行。
	 */
	function buildString() {

		global $debug;

		// 前ページ遷移有無
		$useBack = false;
		if ($this->offset_ > 0) {
			$useBack = true;
		}

		// 後ページ遷移有無
		$useNext = false;
		$maxOffset = (int)($this->total_ / $this->onepage_);
		--$maxOffset;
		if ($this->total_ % $this->onepage_ > 0) {
			++$maxOffset;
		}
		if ($this->offset_ < $maxOffset) {
			$useNext = true;
		}
		// 前方ダイレクトリンク
		$dlinkBackList = array();
		$c = 0;
		for ($i = $this->offset_ -1; $i >= 0; $i--) {
			if ($c == $this->frmax_) {
				break;
			}
			$dlinkBackList[] = $i;
			$c++;
		}
		$dlinkBackList = array_reverse($dlinkBackList);

		// 後方ダイレクトリンク
		$dlinkNextList = array();
		$c = 0;
		for ($i = $this->offset_ +1; $i <= $maxOffset; $i++) {
			if ($c == $this->frmax_) {
				break;
			}
			$dlinkNextList[] = $i;
			$c++;
		}

		// ナビゲーション作成
		$naviStr = '';
		if ($useBack) {
			$naviStr .= '<a href="'.$this->linkstr_.'offset=0">';
//			$naviStr .= '<img src="'.$this->imgback_.'" border="0">';
			$naviStr .= '<<</a>&nbsp;&nbsp;';
			$naviStr .= '<a href="'.$this->linkstr_.'offset='.($this->offset_ -1).'">';
//			$naviStr .= '<img src="'.$this->imgback_.'" border="0">';
			$naviStr .= '<</a>&nbsp;&nbsp;';
		}

		for ($i = 0; $i < count($dlinkBackList); $i++) {
			$naviStr .= '<a href="'.$this->linkstr_.'offset='.$dlinkBackList[$i].'">';
			$naviStr .= ($dlinkBackList[$i] +1).'</a>';
			$naviStr .= '&nbsp;&nbsp;';
		}

		$naviStr .= '<strong>';
		$naviStr .= $this->offset_ +1;
		$naviStr .= '</strong>';

		for ($i = 0; $i < count($dlinkNextList); $i++) {
			$naviStr .= '&nbsp;&nbsp;';
			$naviStr .= '<a href="'.$this->linkstr_.'offset='.$dlinkNextList[$i].'">';
			$naviStr .= ($dlinkNextList[$i] +1).'</a>';
		}

		if ($useNext) {
			$naviStr .= '&nbsp;&nbsp;';
			$naviStr .= '<a href="'.$this->linkstr_.'offset='.($this->offset_ +1).'">';
			$naviStr .= '></a>';
//			$naviStr .= '<img src="'.$this->imgnext_.'" border="0"></a>';
			$naviStr .= '&nbsp;&nbsp;';
			$naviStr .= '<a href="'.$this->linkstr_.'offset='.$maxOffset.'">';
			$naviStr .= '>></a>';
//			$naviStr .= '<img src="'.$this->imgnext_.'" border="0"></a>';
		}

		$this->naviStr_ = $naviStr;
	}

}
?>