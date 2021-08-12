<?php

/**
 * 乱数生成。
 */
function build_random($length) {
	$i = 0;
	mt_srand(microtime()*1000000);
	$txt = '';
	while (++$i <= $length) {
		$n = mt_rand(0, 9);
		$txt .= $n;
	}
	return $txt;
}


/**
 * E-mail規定書式チェック
 */
function checkEmailFormat($txt) {

	$atmarkAppearance = false;
	$periodAppearance = false;

	for ($i = 0; $i < mb_strlen($txt); $i++) {
		$c = mb_substr($txt, $i, 1);

		// 全角不可
		if (mb_strwidth($c) > 1) {;
			return false;
		}

		// @の検査
		if ($c == '@') {
			if ($atmarkAppearance == true) {
				// 文字列中にすでに@が出現していたらエラー
				return false;
			}
			if ($i == 0) {
				// 1文字目が@ならエラー
				return false;
			}
			$atmarkAppearance = true;
		}

		// .の検査
		if ($c == '.') {
			if ($i < 3) {
				// .は4文字目以降でなければエラー
				return false;
			}
			$periodAppearance = true;
		}
	}
	if ($atmarkAppearance == false || $periodAppearance == false) {
		return false;
	}
	return true;
}


/**
 * 半角英数記号のみで構成されるかチェック。
 */
function printChara($txt) {
	for ($i = 0; $i < mb_strlen($txt); $i++) {
		$ret = mb_ereg('[[:print:]]', mb_substr($txt, $i, 1));
		if ($ret != 1) {
			return false;
		}
	}
	return true;
}

function isAction($obj) {
	return isset($obj->isAction);
}

/**
 * メール送信。
 */
function sendMail($to, $subject, $body, $addHeader, $from, $fromName = '') {
	mb_language('Japanese');
	mb_internal_encoding("EUC-JP");

//	$ret = mb_send_mail ($to, $subject, $body, $addHeader);

//echo $subject;

	$body = mb_convert_encoding($body, "ISO-2022-JP", 'EUC-JP');

	//$subject = mb_convert_encoding($subject, "ISO-2022-JP", 'EUC-JP');
	$subject = mb_encode_mimeheader($subject,"ISO-2022-JP");
	$fromName = mb_encode_mimeheader($fromName,"ISO-2022-JP");
//echo $subject;

//	$addHeader = "MIME-Version: 1.0\n";
//	$addHeader .= "Content-Type: text/plain; charset=ISO-2022-JP\n";
//	$addHeader .= "Content-Transfer-Encoding: 7bit\n";
//	$addHeader .= "To: ".$to."\n";
	$addHeader .= "From: ".$fromName.' <'.$from.'>';

	$ret = mail ($to, $subject, $body, $addHeader, '-f'.$from);
	return $ret;
}

/**
 * Replaces double line-breaks with paragraph elements.
 *
 * A group of regex replaces used to identify text formatted with newlines and
 * replace double line-breaks with HTML paragraph tags. The remaining
 * line-breaks after conversion become <<br />> tags, unless $br is set to '0'
 * or 'false'.
 *
 * @since 0.71
 *
 * @param string $pee The text which has to be formatted.
 * @param bool $br Optional. If set, this will convert all remaining line-breaks after paragraphing. Default true.
 * @return string Text which has been converted into correct paragraph tags.
 */
function wpautop($pee, $br = true) {
	$pre_tags = array();

	if ( trim($pee) === '' )
		return '';

	$pee = $pee . "\n"; // just to make things a little easier, pad the end

	if ( strpos($pee, '<pre') !== false ) {
		$pee_parts = explode( '</pre>', $pee );
		$last_pee = array_pop($pee_parts);
		$pee = '';
		$i = 0;

		foreach ( $pee_parts as $pee_part ) {
			$start = strpos($pee_part, '<pre');

			// Malformed html?
			if ( $start === false ) {
				$pee .= $pee_part;
				continue;
			}

			$name = "<pre wp-pre-tag-$i></pre>";
			$pre_tags[$name] = substr( $pee_part, $start ) . '</pre>';

			$pee .= substr( $pee_part, 0, $start ) . $name;
			$i++;
		}

		$pee .= $last_pee;
	}

	$pee = preg_replace('|<br />\s*<br />|', "\n\n", $pee);
	// Space things out a little
	$allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|option|form|map|area|blockquote|address|math|style|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary|img|input)';
	$pee = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $pee);
	$pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);
	$pee = str_replace(array("\r\n", "\r"), "\n", $pee); // cross-platform newlines
	if ( strpos($pee, '<object') !== false ) {
		$pee = preg_replace('|\s*<param([^>]*)>\s*|', "<param$1>", $pee); // no pee inside object/embed
		$pee = preg_replace('|\s*</embed>\s*|', '</embed>', $pee);
	}
	$pee = preg_replace("/\n\n+/", "\n\n", $pee); // take care of duplicates
	// make paragraphs, including one at the end
	$pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);
	$pee = '';
	foreach ( $pees as $tinkle )
		$pee .= '<p>' . trim($tinkle, "\n") . "</p>\n";
	$pee = preg_replace('|<p>\s*</p>|', '', $pee); // under certain strange conditions it could create a P of entirely whitespace
	$pee = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $pee);
	$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee); // don't pee all over a tag
	$pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee); // problem with nested lists
	$pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
	$pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);
	$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);
	$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);
	if ( $br ) {
		$pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', '_autop_newline_preservation_helper', $pee);
		$pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee); // optionally make line breaks
		$pee = str_replace('<WPPreserveNewline />', "\n", $pee);
	}
	$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
	$pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
	$pee = preg_replace( "|\n</p>$|", '</p>', $pee );

	if ( !empty($pre_tags) )
		$pee = str_replace(array_keys($pre_tags), array_values($pre_tags), $pee);

	return $pee;
}

/**
 * Newline preservation help function for wpautop
 *
 * @since 3.1.0
 * @access private
 * @param array $matches preg_replace_callback matches array
 * @returns string
 */
function _autop_newline_preservation_helper( $matches ) {
	return str_replace("\n", "<WPPreserveNewline />", $matches[0]);
}
?>
